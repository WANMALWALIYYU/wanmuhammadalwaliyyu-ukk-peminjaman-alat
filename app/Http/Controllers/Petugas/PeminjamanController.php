<?php
// app/Http/Controllers/Petugas/PeminjamanController.php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Produk;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    use LogsActivity;

    public function index(Request $request)
    {
        $query = Transaksi::with(['user', 'detailTransaksis.produk', 'verifiedBy'])
            ->orderBy('created_at', 'desc');

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kode_transaksi', 'like', "%{$search}%")
                  ->orWhere('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('no_telepon', 'like', "%{$search}%");
            });
        }

        $transaksis = $query->paginate(10);

        if ($request->ajax()) {
            $data = $transaksis->map(function($transaksi) {
                return [
                    'id' => $transaksi->id,
                    'kode_transaksi' => $transaksi->kode_transaksi,
                    'nama_lengkap' => $transaksi->nama_lengkap,
                    'email' => $transaksi->email,
                    'no_telepon' => $transaksi->no_telepon,
                    'jumlah_deposit' => $transaksi->jumlah_deposit,
                    'metode_pembayaran_label' => $transaksi->metode_pembayaran_label,
                    'bukti_deposit' => $transaksi->bukti_deposit,
                    'status' => $transaksi->status,
                    'status_badge' => $transaksi->status_badge,
                    'created_at' => $transaksi->created_at,
                    'created_at_formatted' => $transaksi->created_at->translatedFormat('d M Y H:i'),
                    'detail_transaksis' => $transaksi->detailTransaksis->map(function($detail) {
                        return [
                            'id' => $detail->id,
                            'nama_produk' => $detail->nama_produk,
                            'jumlah' => $detail->jumlah,
                            'durasi_hari' => $detail->durasi_hari,
                            'tanggal_mulai' => $detail->tanggal_mulai->format('Y-m-d'),
                            'tanggal_selesai' => $detail->tanggal_selesai->format('Y-m-d'),
                            'subtotal' => $detail->subtotal,
                        ];
                    }),
                ];
            });

            return response()->json([
                'data' => $data,
                'current_page' => $transaksis->currentPage(),
                'last_page' => $transaksis->lastPage(),
                'per_page' => $transaksis->perPage(),
                'total' => $transaksis->total(),
                'links' => $transaksis->linkCollection()->toArray(),
            ]);
        }

        return view('petugas.peminjaman', compact('transaksis'));
    }

    /**
     * Display detail transaksi untuk petugas
     */
    public function detail($id)
    {
        $transaksi = Transaksi::with([
            'user',
            'verifiedBy',
            'detailTransaksis.produk',
            'pengiriman'
        ])->findOrFail($id);

        // Hitung total biaya dari detail transaksi
        $totalBiaya = $transaksi->detailTransaksis->sum('subtotal');
        $sisaPembayaran = $totalBiaya - $transaksi->jumlah_deposit;

        return view('petugas.detail-transaksi', compact('transaksi', 'totalBiaya', 'sisaPembayaran'));
    }

    public function approve(Request $request, $id)
    {
        $request->validate([
            'catatan' => 'nullable|string'
        ]);

        $transaksi = Transaksi::findOrFail($id);

        if ($transaksi->status !== Transaksi::STATUS_MENUNGGU_PERSETUJUAN) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Transaksi tidak dapat disetujui'], 400);
            }
            return redirect()->back()->with('error', 'Transaksi tidak dapat disetujui');
        }

        DB::beginTransaction();
        try {
            $transaksi->approve(Auth::id(), $request->catatan);

            $this->logActivity(
                'approve',
                'transaksi',
                $transaksi->id,
                $transaksi->kode_transaksi,
                "Petugas " . Auth::user()->name . " menyetujui transaksi {$transaksi->kode_transaksi}"
            );

            DB::commit();

            if ($request->ajax()) {
                return response()->json(['success' => "Transaksi {$transaksi->kode_transaksi} berhasil disetujui"]);
            }

            return redirect()->route('petugas.peminjaman')
                ->with('success', "Transaksi {$transaksi->kode_transaksi} berhasil disetujui");

        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->ajax()) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'catatan' => 'required|string|min:10'
        ]);

        $transaksi = Transaksi::findOrFail($id);

        if ($transaksi->status !== Transaksi::STATUS_MENUNGGU_PERSETUJUAN) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Transaksi tidak dapat ditolak'], 400);
            }
            return redirect()->back()->with('error', 'Transaksi tidak dapat ditolak');
        }

        DB::beginTransaction();
        try {
            $transaksi->reject(Auth::id(), $request->catatan);

            $this->logActivity(
                'reject',
                'transaksi',
                $transaksi->id,
                $transaksi->kode_transaksi,
                "Petugas " . Auth::user()->name . " menolak transaksi {$transaksi->kode_transaksi} dengan alasan: " . $request->catatan
            );

            DB::commit();

            if ($request->ajax()) {
                return response()->json(['success' => "Transaksi {$transaksi->kode_transaksi} berhasil ditolak"]);
            }

            return redirect()->route('petugas.peminjaman')
                ->with('success', "Transaksi {$transaksi->kode_transaksi} berhasil ditolak");

        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->ajax()) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Mark transaction as returned (dikembalikan)
     */
    public function markAsDikembalikan(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        if ($transaksi->status !== Transaksi::STATUS_DIPINJAM) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Status transaksi harus "Dipinjam" untuk dapat dikembalikan'], 400);
            }
            return redirect()->back()->with('error', 'Status transaksi harus "Dipinjam" untuk dapat dikembalikan');
        }

        DB::beginTransaction();
        try {
            $transaksi->markAsDikembalikan();

            $this->logActivity(
                'mark_returned',
                'transaksi',
                $transaksi->id,
                $transaksi->kode_transaksi,
                "Petugas " . Auth::user()->name . " menandai transaksi {$transaksi->kode_transaksi} sebagai Dikembalikan"
            );

            DB::commit();

            if ($request->ajax()) {
                return response()->json(['success' => "Transaksi {$transaksi->kode_transaksi} telah ditandai sebagai Dikembalikan"]);
            }

            return redirect()->back()->with('success', "Transaksi {$transaksi->kode_transaksi} telah ditandai sebagai Dikembalikan");

        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->ajax()) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Complete transaction (selesai)
     */
    public function completeTransaksi(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        if ($transaksi->status !== Transaksi::STATUS_DIKEMBALIKAN) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Status transaksi harus "Dikembalikan" untuk dapat diselesaikan'], 400);
            }
            return redirect()->back()->with('error', 'Status transaksi harus "Dikembalikan" untuk dapat diselesaikan');
        }

        DB::beginTransaction();
        try {
            $transaksi->complete();

            $this->logActivity(
                'complete',
                'transaksi',
                $transaksi->id,
                $transaksi->kode_transaksi,
                "Petugas " . Auth::user()->name . " menyelesaikan transaksi {$transaksi->kode_transaksi}"
            );

            DB::commit();

            if ($request->ajax()) {
                return response()->json(['success' => "Transaksi {$transaksi->kode_transaksi} telah selesai"]);
            }

            return redirect()->back()->with('success', "Transaksi {$transaksi->kode_transaksi} telah selesai");

        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->ajax()) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
