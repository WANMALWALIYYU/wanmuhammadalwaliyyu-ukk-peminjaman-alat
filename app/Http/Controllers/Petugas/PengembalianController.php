<?php
// app/Http/Controllers/Petugas/PengembalianController.php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Pengembalian;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PengembalianController extends Controller
{
    use LogsActivity;

    /**
     * Display list of returns for petugas
     */
    public function index(Request $request)
    {
        $query = Pengembalian::with(['transaksi.user', 'transaksi.detailTransaksis.produk'])
            ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('transaksi', function($q) use ($search) {
                $q->where('kode_transaksi', 'like', "%{$search}%")
                  ->orWhere('nama_lengkap', 'like', "%{$search}%");
            });
        }

        $pengembalians = $query->paginate(10);

        // Stats
        $stats = [
            'dikirim' => Pengembalian::where('status', Pengembalian::STATUS_DIKIRIM)->count(),
            'sampai' => Pengembalian::where('status', Pengembalian::STATUS_SAMPAI)->count(),
            'diproses' => Pengembalian::where('status', Pengembalian::STATUS_DIPROSES)->count(),
        ];

        return view('petugas.pengembalian.index', compact('pengembalians', 'stats'));
    }

    /**
     * Show detail pengembalian
     */
    public function show($id)
    {
        $pengembalian = Pengembalian::with([
            'transaksi.user',
            'transaksi.detailTransaksis.produk',
            'user'
        ])->findOrFail($id);

        $subtotal = $pengembalian->transaksi->detailTransaksis->sum('subtotal');
        $deposit = $pengembalian->transaksi->jumlah_deposit;
        $sisaPembayaran = $subtotal - $deposit;

        return view('petugas.pengembalian.show', compact('pengembalian', 'subtotal', 'deposit', 'sisaPembayaran'));
    }

    /**
     * Mark as arrived (barang sampai)
     * Status changes from DIKIRIM to SAMPAI
     */
    public function markAsSampai(Request $request, $id)
    {
        $request->validate([
            'foto_barang_setelah_sampai' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $pengembalian = Pengembalian::where('status', Pengembalian::STATUS_DIKIRIM)
            ->findOrFail($id);

        DB::beginTransaction();

        try {
            $fotoPath = null;
            if ($request->hasFile('foto_barang_setelah_sampai')) {
                $file = $request->file('foto_barang_setelah_sampai');
                $namaFile = time() . '_arrived_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
                $fotoPath = $file->storeAs('pengembalian/petugas', $namaFile, 'public');
            }

            $pengembalian->markAsSampai($fotoPath);

            $this->logActivity(
                'mark_arrived',
                'pengembalian',
                $pengembalian->id,
                $pengembalian->transaksi->kode_transaksi,
                "Petugas " . Auth::user()->name . " mengkonfirmasi barang sampai untuk transaksi {$pengembalian->transaksi->kode_transaksi}"
            );

            DB::commit();

            return redirect()->route('petugas.pengembalian.show', $pengembalian->id)
                ->with('success', 'Barang telah sampai. Silakan lakukan pemeriksaan.');

        } catch (\Exception $e) {
            DB::rollBack();

            if (isset($fotoPath) && Storage::disk('public')->exists($fotoPath)) {
                Storage::disk('public')->delete($fotoPath);
            }

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Process inspection form
     */
    public function prosesPemeriksaan($id)
    {
        $pengembalian = Pengembalian::with(['transaksi.detailTransaksis.produk'])
            ->where('status', Pengembalian::STATUS_SAMPAI)
            ->findOrFail($id);

        $subtotal = $pengembalian->transaksi->detailTransaksis->sum('subtotal');
        $deposit = $pengembalian->transaksi->jumlah_deposit;
        $sisaPembayaran = $subtotal - $deposit;
        $dendaKeterlambatan = $pengembalian->transaksi->calculateDendaKeterlambatan();

        return view('petugas.pengembalian.pemeriksaan', compact(
            'pengembalian',
            'subtotal',
            'deposit',
            'sisaPembayaran',
            'dendaKeterlambatan'
        ));
    }

    /**
     * Store inspection result
     * Status changes from SAMPAI to DIPROSES
     */
    public function storePemeriksaan(Request $request, $id)
    {
        $request->validate([
            'kondisi_barang' => 'required|in:baik,rusak_ringan,rusak_berat',
            'deskripsi_kerusakan' => 'required_if:kondisi_barang,rusak_ringan,rusak_berat|nullable|string',
            'biaya_kerusakan' => 'nullable|numeric|min:0',
            'catatan_petugas' => 'nullable|string|max:500',
        ]);

        $pengembalian = Pengembalian::where('status', Pengembalian::STATUS_SAMPAI)
            ->findOrFail($id);

        DB::beginTransaction();

        try {
            $biayaKerusakan = $request->biaya_kerusakan ?? 0;
            $dendaKeterlambatan = $pengembalian->transaksi->calculateDendaKeterlambatan();

            $pengembalian->prosesPemeriksaan([
                'kondisi_barang' => $request->kondisi_barang,
                'deskripsi_kerusakan' => $request->deskripsi_kerusakan,
                'biaya_kerusakan' => $biayaKerusakan,
                'denda_keterlambatan' => $dendaKeterlambatan,
                'catatan_petugas' => $request->catatan_petugas,
            ]);

            $this->logActivity(
                'inspect',
                'pengembalian',
                $pengembalian->id,
                $pengembalian->transaksi->kode_transaksi,
                "Petugas " . Auth::user()->name . " melakukan pemeriksaan pengembalian untuk transaksi {$pengembalian->transaksi->kode_transaksi}"
            );

            DB::commit();

            return redirect()->route('petugas.pengembalian.show', $pengembalian->id)
                ->with('success', 'Pemeriksaan selesai. Status berubah menjadi "Diproses". Silakan klik tombol "Selesaikan Pengembalian" setelah pembayaran user selesai.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Complete the return process
     * Status changes from DIPROSES to SELESAI
     * This is called by petugas after user completes payment
     */
    public function complete($id)
    {
        $pengembalian = Pengembalian::where('status', Pengembalian::STATUS_DIPROSES)
            ->with(['transaksi.detailTransaksis.produk']) // Eager load detail transaksi dan produk
            ->findOrFail($id);

        DB::beginTransaction();

        try {
            // Tambahkan stok produk sesuai dengan jumlah yang dipinjam
            foreach ($pengembalian->transaksi->detailTransaksis as $detail) {
                $produk = Produk::find($detail->produk_id);
                if ($produk) {
                    // Tambah stok sesuai jumlah yang dipinjam
                    $produk->increment('stok', $detail->jumlah);

                    // Update status produk menjadi 'tersedia' jika stok > 0
                    if ($produk->stok > 0) {
                        $produk->update(['status' => 'tersedia']);
                    }
                }
            }

            // Selesaikan pengembalian
            $pengembalian->complete();

            // Update transaksi status menjadi SELESAI
            $pengembalian->transaksi->update(['status' => Transaksi::STATUS_SELESAI]);

            $this->logActivity(
                'complete',
                'pengembalian',
                $pengembalian->id,
                $pengembalian->transaksi->kode_transaksi,
                "Petugas " . Auth::user()->name . " menyelesaikan proses pengembalian untuk transaksi {$pengembalian->transaksi->kode_transaksi} dan mengembalikan stok produk"
            );

            DB::commit();

            return redirect()->route('petugas.pengembalian.show', $pengembalian->id)
                ->with('success', 'Proses pengembalian selesai. Stok produk telah dikembalikan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
