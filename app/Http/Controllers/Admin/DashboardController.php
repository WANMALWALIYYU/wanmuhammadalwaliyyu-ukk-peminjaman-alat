<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ========= STATISTIK PRODUK =========
        $totalProduk = Produk::count();
        $produkTersedia = Produk::where('status', 'tersedia')->count();
        $produkDipinjam = Produk::where('status', 'dipinjam')->count();

        // Statistik berdasarkan kondisi produk
        $produkBaru = Produk::where('kondisi', 'baru')->count();
        $produkBekas = Produk::where('kondisi', 'bekas')->count();
        $produkRusak = Produk::where('kondisi', 'rusak')->count();

        // Produk dengan stok menipis (stok <= 3)
        $produkStokMenipis = Produk::where('stok', '<=', 3)->where('stok', '>', 0)->count();
        $produkHabis = Produk::where('stok', 0)->count();

        // ========= STATISTIK TRANSAKSI =========
        $totalTransaksi = Transaksi::count();
        $transaksiMenunggu = Transaksi::where('status', 'menunggu_persetujuan')->count();
        $transaksiDisetujui = Transaksi::where('status', 'disetujui')->count();
        $transaksiDikirim = Transaksi::where('status', 'dikirim')->count();
        $transaksiDipinjam = Transaksi::where('status', 'dipinjam')->count();
        $transaksiDikembalikan = Transaksi::where('status', 'dikembalikan')->count();
        $transaksiSelesai = Transaksi::where('status', 'selesai')->count();
        $transaksiDitolak = Transaksi::where('status', 'ditolak')->count();
        $transaksiDibatalkan = Transaksi::where('status', 'dibatalkan')->count();

        // Transaksi aktif (belum selesai)
        $transaksiAktif = Transaksi::whereIn('status', ['menunggu_persetujuan', 'disetujui', 'dikirim', 'dipinjam', 'dikembalikan'])->count();

        // ========= STATISTIK KEUANGAN =========
        // Total deposit yang diterima
        $totalDeposit = Transaksi::whereIn('status', ['disetujui', 'dikirim', 'dipinjam', 'dikembalikan', 'selesai'])
            ->sum('jumlah_deposit');

        // Total pendapatan dari transaksi selesai
        $totalPendapatan = Transaksi::where('status', 'selesai')
            ->join('detail_transaksis', 'transaksis.id', '=', 'detail_transaksis.transaksi_id')
            ->sum('detail_transaksis.subtotal');

        // Deposit tertahan (transaksi dikembalikan menunggu pelunasan)
        $depositTertahan = Transaksi::where('status', 'dikembalikan')->sum('jumlah_deposit');

        // Pendapatan bulan ini - PERBAIKAN: tambahkan prefix tabel
        $pendapatanBulanIni = Transaksi::where('status', 'selesai')
            ->whereMonth('transaksis.created_at', now()->month)
            ->whereYear('transaksis.created_at', now()->year)
            ->join('detail_transaksis', 'transaksis.id', '=', 'detail_transaksis.transaksi_id')
            ->sum('detail_transaksis.subtotal');

        // Pendapatan bulan lalu - PERBAIKAN: tambahkan prefix tabel
        $pendapatanBulanLalu = Transaksi::where('status', 'selesai')
            ->whereMonth('transaksis.created_at', now()->subMonth()->month)
            ->whereYear('transaksis.created_at', now()->subMonth()->year)
            ->join('detail_transaksis', 'transaksis.id', '=', 'detail_transaksis.transaksi_id')
            ->sum('detail_transaksis.subtotal');

        // Persentase pertumbuhan pendapatan
        $pendapatanGrowth = $pendapatanBulanLalu > 0
            ? (($pendapatanBulanIni - $pendapatanBulanLalu) / $pendapatanBulanLalu) * 100
            : ($pendapatanBulanIni > 0 ? 100 : 0);

        // ========= STATISTIK PENGGUNA =========
        $totalUsers = User::count();
        $totalAdmin = User::where('level', 'admin')->count();
        $totalPetugas = User::where('level', 'petugas')->count();
        $totalCustomer = User::where('level', 'user')->count();

        // User online (last seen within 2 minutes)
        $usersOnline = User::where('last_seen', '>=', now()->subMinutes(2))->count();

        // User baru bulan ini
        $userBaruBulanIni = User::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // ========= DATA TERLAMBAT =========
        $transaksiTerlambat = 0;
        $transaksiDipinjamList = Transaksi::with('detailTransaksis')
            ->where('status', 'dipinjam')
            ->get();

        foreach ($transaksiDipinjamList as $transaksi) {
            foreach ($transaksi->detailTransaksis as $detail) {
                if ($detail->tanggal_selesai < now()->format('Y-m-d')) {
                    $transaksiTerlambat++;
                    break;
                }
            }
        }

        // ========= DATA TERBARU =========
        // Transaksi terbaru (10 terakhir)
        $transaksiTerbaru = Transaksi::with(['user', 'detailTransaksis'])
            ->latest()
            ->take(10)
            ->get();

        // Produk terpopuler berdasarkan jumlah peminjaman
        $produkTerpopuler = Produk::withCount('detailTransaksis')
            ->orderBy('detail_transaksis_count', 'desc')
            ->take(5)
            ->get();

        // User paling aktif (terbanyak transaksi)
        $userTeraktif = User::withCount('transaksis')
            ->orderBy('transaksis_count', 'desc')
            ->take(5)
            ->get();

        // ========= DATA CHART (7 HARI TERAKHIR) =========
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $chartData['labels'][] = $date->format('d M');

            // Transaksi per hari
            $chartData['transaksi'][] = Transaksi::whereDate('created_at', $date)->count();

            // Pendapatan per hari - PERBAIKAN: tambahkan prefix tabel
            $chartData['pendapatan'][] = Transaksi::where('status', 'selesai')
                ->whereDate('transaksis.created_at', $date)
                ->join('detail_transaksis', 'transaksis.id', '=', 'detail_transaksis.transaksi_id')
                ->sum('detail_transaksis.subtotal');
        }

        // ========= DATA CHART BULANAN (6 BULAN TERAKHIR) =========
        $monthlyChartData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthlyChartData['labels'][] = $month->format('M Y');

            $monthlyChartData['transaksi'][] = Transaksi::whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->count();

            $monthlyChartData['pendapatan'][] = Transaksi::where('status', 'selesai')
                ->whereMonth('transaksis.created_at', $month->month)
                ->whereYear('transaksis.created_at', $month->year)
                ->join('detail_transaksis', 'transaksis.id', '=', 'detail_transaksis.transaksi_id')
                ->sum('detail_transaksis.subtotal');
        }

        return view('admin.dashboard.index', compact(
            // Produk stats
            'totalProduk',
            'produkTersedia',
            'produkDipinjam',
            'produkBaru',
            'produkBekas',
            'produkRusak',
            'produkStokMenipis',
            'produkHabis',
            // Transaksi stats
            'totalTransaksi',
            'transaksiMenunggu',
            'transaksiDisetujui',
            'transaksiDikirim',
            'transaksiDipinjam',
            'transaksiDikembalikan',
            'transaksiSelesai',
            'transaksiDitolak',
            'transaksiDibatalkan',
            'transaksiAktif',
            'transaksiTerlambat',
            // Keuangan stats
            'totalDeposit',
            'totalPendapatan',
            'depositTertahan',
            'pendapatanBulanIni',
            'pendapatanBulanLalu',
            'pendapatanGrowth',
            // User stats
            'totalUsers',
            'totalAdmin',
            'totalPetugas',
            'totalCustomer',
            'usersOnline',
            'userBaruBulanIni',
            // Data lists
            'transaksiTerbaru',
            'produkTerpopuler',
            'userTeraktif',
            // Chart data
            'chartData',
            'monthlyChartData'
        ));
    }
}
