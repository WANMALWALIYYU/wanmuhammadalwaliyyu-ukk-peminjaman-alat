<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung total transaksi berdasarkan status
        $total_menunggu = Transaksi::where('status', Transaksi::STATUS_MENUNGGU_PERSETUJUAN)->count();
        $total_disetujui = Transaksi::where('status', Transaksi::STATUS_DISETUJUI)->count();
        $total_dikirim = Transaksi::where('status', Transaksi::STATUS_DIKIRIM)->count();
        $total_dipinjam = Transaksi::where('status', Transaksi::STATUS_DIPINJAM)->count();
        $total_dikembalikan = Transaksi::where('status', Transaksi::STATUS_DIKEMBALIKAN)->count();

        $transaksi_terbaru = Transaksi::with(['user', 'detailTransaksis.produk'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('petugas.dashboard', compact(
            'total_menunggu',
            'total_disetujui',
            'total_dikirim',
            'total_dipinjam',
            'total_dikembalikan',
            'transaksi_terbaru'
        ));
    }

    public function getDashboardStats()
    {
        return response()->json([
            'total_menunggu' => Transaksi::where('status', Transaksi::STATUS_MENUNGGU_PERSETUJUAN)->count(),
            'total_disetujui' => Transaksi::where('status', Transaksi::STATUS_DISETUJUI)->count(),
            'total_dikirim' => Transaksi::where('status', Transaksi::STATUS_DIKIRIM)->count(),
            'total_dipinjam' => Transaksi::where('status', Transaksi::STATUS_DIPINJAM)->count(),
            'total_dikembalikan' => Transaksi::where('status', Transaksi::STATUS_DIKEMBALIKAN)->count(),
        ]);
    }
}
