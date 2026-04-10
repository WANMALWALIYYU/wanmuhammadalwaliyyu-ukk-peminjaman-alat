<?php
// app/Http/Controllers/User/PengembalianController.php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Pengembalian;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PengembalianController extends Controller
{
    use LogsActivity;

    /**
     * Show form for return process
     */
    public function create($id)
    {
        $transaksi = Transaksi::with(['detailTransaksis.produk', 'pengembalian'])
            ->where('user_id', Auth::id())
            ->where('status', Transaksi::STATUS_DIPINJAM)
            ->findOrFail($id);

        // Check if return already exists
        if ($transaksi->pengembalian && in_array($transaksi->pengembalian->status, [
            Pengembalian::STATUS_DIKIRIM,
            Pengembalian::STATUS_SAMPAI,
            Pengembalian::STATUS_DIPROSES,
            Pengembalian::STATUS_SELESAI
        ])) {
            return redirect()->route('user.pengembalian.show', $transaksi->pengembalian->id)
                ->with('info', 'Proses pengembalian sudah dimulai. Silakan cek status.');
        }

        // Calculate financial details
        $subtotal = $transaksi->detailTransaksis->sum('subtotal');
        $deposit = $transaksi->jumlah_deposit;
        $sisaPembayaran = $subtotal - $deposit;
        $dendaKeterlambatan = $transaksi->calculateDendaKeterlambatan();

        return view('user.pengembalian.create', compact(
            'transaksi',
            'subtotal',
            'deposit',
            'sisaPembayaran',
            'dendaKeterlambatan'
        ));
    }

    /**
     * Store return request - status langsung DIKIRIM
     */
    public function store(Request $request, $id)
    {
        $request->validate([
            'foto_barang_dikembalikan' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'catatan_user' => 'nullable|string|max:500',
            'no_resi' => 'required|string|max:50',
            'kurir' => 'required|string|max:100',
        ]);

        $transaksi = Transaksi::where('user_id', Auth::id())
            ->where('status', Transaksi::STATUS_DIPINJAM)
            ->findOrFail($id);

        DB::beginTransaction();

        try {
            // Upload foto barang dikembalikan
            $fotoPath = null;
            if ($request->hasFile('foto_barang_dikembalikan')) {
                $file = $request->file('foto_barang_dikembalikan');
                $namaFile = time() . '_return_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
                $fotoPath = $file->storeAs('pengembalian/user', $namaFile, 'public');
            }

            // Create pengembalian record with status DIKIRIM
            $pengembalian = Pengembalian::create([
                'transaksi_id' => $transaksi->id,
                'user_id' => Auth::id(),
                'status' => Pengembalian::STATUS_DIKIRIM,
                'no_resi_pengembalian' => $request->no_resi,
                'kurir_pengembalian' => $request->kurir,
                'foto_barang_dikembalikan' => $fotoPath,
                'catatan_user' => $request->catatan_user,
                'tanggal_dikirim' => now(),
            ]);

            // Update transaksi status to DIKEMBALIKAN
            $transaksi->update(['status' => Transaksi::STATUS_DIKEMBALIKAN]);

            // Log activity
            $this->logActivity(
                'create',
                'pengembalian',
                $pengembalian->id,
                $transaksi->kode_transaksi,
                "User " . Auth::user()->name . " memulai proses pengembalian untuk transaksi {$transaksi->kode_transaksi}"
            );

            DB::commit();

            return redirect()->route('user.pengembalian.show', $pengembalian->id)
                ->with('success', 'Pengembalian berhasil dikirim. Silakan tunggu konfirmasi dari petugas.');

        } catch (\Exception $e) {
            DB::rollBack();

            if (isset($fotoPath) && Storage::disk('public')->exists($fotoPath)) {
                Storage::disk('public')->delete($fotoPath);
            }

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Update shipping info (resi) - Untuk update resi jika diperlukan
     */
    public function updateShipping(Request $request, $id)
    {
        $request->validate([
            'no_resi' => 'required|string|max:50',
            'kurir' => 'required|string|max:100',
        ]);

        $pengembalian = Pengembalian::whereHas('transaksi', function($q) {
                $q->where('user_id', Auth::id());
            })
            ->where('status', Pengembalian::STATUS_MENUNGGU_PENGIRIMAN)
            ->findOrFail($id);

        DB::beginTransaction();

        try {
            $pengembalian->update([
                'no_resi_pengembalian' => $request->no_resi,
                'kurir_pengembalian' => $request->kurir,
                'status' => Pengembalian::STATUS_DIKIRIM,
                'tanggal_dikirim' => now(),
            ]);

            // Update transaksi status
            $pengembalian->transaksi->update(['status' => Transaksi::STATUS_DIKEMBALIKAN]);

            $this->logActivity(
                'update',
                'pengembalian',
                $pengembalian->id,
                $pengembalian->transaksi->kode_transaksi,
                "User " . Auth::user()->name . " mengupdate resi pengembalian untuk transaksi {$pengembalian->transaksi->kode_transaksi}"
            );

            DB::commit();

            return redirect()->route('user.pengembalian.show', $pengembalian->id)
                ->with('success', 'Resi pengiriman berhasil diupdate.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Show return status
     */
    public function show($id)
    {
        $pengembalian = Pengembalian::with(['transaksi.detailTransaksis.produk', 'petugas'])
            ->whereHas('transaksi', function($q) {
                $q->where('user_id', Auth::id());
            })
            ->findOrFail($id);

        $subtotal = $pengembalian->transaksi->detailTransaksis->sum('subtotal');
        $deposit = $pengembalian->transaksi->jumlah_deposit;
        $sisaPembayaran = $subtotal - $deposit;

        return view('user.pengembalian.show', compact('pengembalian', 'subtotal', 'deposit', 'sisaPembayaran'));
    }

    /**
     * List of returns
     */
    public function index()
    {
        $pengembalians = Pengembalian::with(['transaksi'])
            ->whereHas('transaksi', function($q) {
                $q->where('user_id', Auth::id());
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.pengembalian.index', compact('pengembalians'));
    }
}
