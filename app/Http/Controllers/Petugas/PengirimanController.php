<?php
// app/Http/Controllers/Petugas/PengirimanController.php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Pengiriman;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PengirimanController extends Controller
{
    use LogsActivity;

    /**
     * Display list of transactions ready for delivery (status = disetujui)
     */
    public function index(Request $request)
    {
        $query = Transaksi::with(['user', 'detailTransaksis.produk', 'pengiriman'])
            ->where('status', Transaksi::STATUS_DISETUJUI)
            ->orderBy('created_at', 'desc');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kode_transaksi', 'like', "%{$search}%")
                  ->orWhere('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $transaksis = $query->paginate(10);

        return view('petugas.pengiriman.index', compact('transaksis'));
    }

    /**
     * Show form to create delivery for specific transaction
     */
    public function create($id)
    {
        $transaksi = Transaksi::with(['user', 'detailTransaksis.produk'])
            ->where('status', Transaksi::STATUS_DISETUJUI)
            ->findOrFail($id);

        // Check if delivery already exists
        $pengiriman = Pengiriman::where('transaksi_id', $id)->first();

        if ($pengiriman) {
            return redirect()->route('petugas.pengiriman.show', $pengiriman->id)
                ->with('info', 'Transaksi ini sudah memiliki data pengiriman.');
        }

        return view('petugas.pengiriman.create', compact('transaksi'));
    }

    /**
     * Store delivery data
     */
    public function store(Request $request, $id)
    {
        $transaksi = Transaksi::where('status', Transaksi::STATUS_DISETUJUI)
            ->findOrFail($id);

        $request->validate([
            'foto_barang_dikirim' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'catatan_pengiriman' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();

        try {
            // Upload foto barang dikirim
            $fotoDikirimPath = null;
            if ($request->hasFile('foto_barang_dikirim')) {
                $file = $request->file('foto_barang_dikirim');
                $namaFile = time() . '_dikirim_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
                $fotoDikirimPath = $file->storeAs('pengiriman/dikirim', $namaFile, 'public');
            }

            // Create pengiriman record
            $pengiriman = Pengiriman::create([
                'transaksi_id' => $transaksi->id,
                'petugas_id' => Auth::id(),
                'foto_barang_dikirim' => $fotoDikirimPath,
                'catatan_pengiriman' => $request->catatan_pengiriman,
                'tanggal_dikirim' => now(),
            ]);

            // Update transaksi status to "dikirim"
            $transaksi->markAsDikirim();

            // Log activity
            $this->logActivity(
                'create',
                'pengiriman',
                $pengiriman->id,
                $transaksi->kode_transaksi,
                "Petugas " . Auth::user()->name . " membuat pengiriman untuk transaksi {$transaksi->kode_transaksi}"
            );

            DB::commit();

            return redirect()->route('petugas.pengiriman.index')
                ->with('success', 'Data pengiriman berhasil dibuat. Status transaksi berubah menjadi "Dikirim".');

        } catch (\Exception $e) {
            DB::rollBack();

            // Delete uploaded file if exists
            if (isset($fotoDikirimPath) && Storage::disk('public')->exists($fotoDikirimPath)) {
                Storage::disk('public')->delete($fotoDikirimPath);
            }

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display delivery details
     */
    public function show($id)
    {
        $pengiriman = Pengiriman::with(['transaksi.user', 'transaksi.detailTransaksis.produk', 'petugas'])
            ->findOrFail($id);

        return view('petugas.pengiriman.show', compact('pengiriman'));
    }

    /**
     * List of deliveries in progress (already sent, waiting for confirmation)
     */
    public function inProgress(Request $request)
    {
        $query = Pengiriman::with(['transaksi.user'])
            ->whereNotNull('tanggal_dikirim')
            ->whereNull('tanggal_sampai')
            ->orderBy('tanggal_dikirim', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('transaksi', function($q) use ($search) {
                $q->where('kode_transaksi', 'like', "%{$search}%")
                  ->orWhere('nama_lengkap', 'like', "%{$search}%");
            });
        }

        $pengirimans = $query->paginate(10);

        return view('petugas.pengiriman.in-progress', compact('pengirimans'));
    }
}
