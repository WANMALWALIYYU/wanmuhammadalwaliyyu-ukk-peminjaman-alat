<?php
// app/Http/Controllers/User/UserPengirimanController.php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Pengiriman;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserPengirimanController extends Controller
{
    use LogsActivity;

    /**
     * Show form to confirm receipt of goods
     */
    public function confirmForm($id)
    {
        $transaksi = Transaksi::with(['pengiriman', 'detailTransaksis.produk'])
            ->where('user_id', Auth::id())
            ->where('status', Transaksi::STATUS_DIKIRIM)
            ->findOrFail($id);

        return view('user.konfirmasi-penerimaan', compact('transaksi'));
    }

    /**
     * Process receipt confirmation from user
     * After confirmation, status changes to DIPINJAM (sedang dipinjam)
     */
    public function confirmReceipt(Request $request, $id)
    {
        $request->validate([
            'foto_barang_sampai' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'catatan_penerimaan' => 'nullable|string|max:500',
        ]);

        $transaksi = Transaksi::with(['pengiriman'])
            ->where('user_id', Auth::id())
            ->where('status', Transaksi::STATUS_DIKIRIM)
            ->findOrFail($id);

        $pengiriman = $transaksi->pengiriman;

        if (!$pengiriman) {
            return redirect()->back()->with('error', 'Data pengiriman tidak ditemukan');
        }

        DB::beginTransaction();

        try {
            // Upload foto barang sampai
            $fotoSampaiPath = null;
            if ($request->hasFile('foto_barang_sampai')) {
                $file = $request->file('foto_barang_sampai');
                $namaFile = time() . '_sampai_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
                $fotoSampaiPath = $file->storeAs('pengiriman/sampai', $namaFile, 'public');
            }

            // Update pengiriman record
            $pengiriman->update([
                'foto_barang_sampai' => $fotoSampaiPath,
                'catatan_penerimaan' => $request->catatan_penerimaan,
                'tanggal_sampai' => now(),
            ]);

            // Update transaksi status to DIPINJAM (sedang dipinjam)
            $transaksi->update(['status' => Transaksi::STATUS_DIPINJAM]);

            // Log activity
            $this->logActivity(
                'confirm_receipt',
                'pengiriman',
                $pengiriman->id,
                $transaksi->kode_transaksi,
                "User " . Auth::user()->name . " mengkonfirmasi penerimaan barang untuk transaksi {$transaksi->kode_transaksi}"
            );

            DB::commit();

            return redirect()->route('transaksi.riwayat')
                ->with('success', 'Penerimaan barang berhasil dikonfirmasi. Barang sedang Anda pinjam.');

        } catch (\Exception $e) {
            DB::rollBack();

            if (isset($fotoSampaiPath) && Storage::disk('public')->exists($fotoSampaiPath)) {
                Storage::disk('public')->delete($fotoSampaiPath);
            }

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * List of current loans (DIPINJAM status)
     */
    public function currentLoans()
    {
        $transaksis = Transaksi::with(['detailTransaksis.produk', 'pengiriman'])
            ->where('user_id', Auth::id())
            ->where('status', Transaksi::STATUS_DIPINJAM)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.pinjaman-aktif', compact('transaksis'));
    }
}
