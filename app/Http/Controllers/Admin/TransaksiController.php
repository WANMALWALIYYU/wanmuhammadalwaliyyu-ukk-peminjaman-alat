<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\User;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    use LogsActivity;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Query untuk transaksi dengan eager loading relasi
        $mainQuery = Transaksi::with(['user', 'verifiedBy', 'detailTransaksis.produk'])
            ->whereNull('deleted_at');

        // Filter berdasarkan status menggunakan konstanta model
        if ($request->filled('status') && $request->status !== 'all') {
            $mainQuery->where('status', $request->status);
        }

        // Filter berdasarkan user/peminjam
        if ($request->filled('search')) {
            $search = $request->search;
            $mainQuery->where(function($q) use ($search) {
                $q->where('kode_transaksi', 'like', '%' . $search . '%')
                  ->orWhere('nama_lengkap', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('no_telepon', 'like', '%' . $search . '%')
                  ->orWhere('no_identitas', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        // Filter tanggal pengajuan
        if ($request->filled('start_date')) {
            $mainQuery->whereDate('tanggal_pengajuan', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $mainQuery->whereDate('tanggal_pengajuan', '<=', $request->end_date);
        }

        // Filter berdasarkan metode pembayaran menggunakan konstanta
        if ($request->filled('metode_pembayaran') && $request->metode_pembayaran !== 'all') {
            $mainQuery->where('metode_pembayaran', $request->metode_pembayaran);
        }

        $transaksis = $mainQuery->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        // Data untuk filter dropdown menggunakan konstanta dari model
        $statusList = [
            Transaksi::STATUS_MENUNGGU_PERSETUJUAN => 'Menunggu Persetujuan',
            Transaksi::STATUS_DISETUJUI => 'Disetujui',
            Transaksi::STATUS_DITOLAK => 'Ditolak',
            Transaksi::STATUS_DIKIRIM => 'Dikirim',
            Transaksi::STATUS_DIPINJAM => 'Dipinjam',
            Transaksi::STATUS_DIKEMBALIKAN => 'Dikembalikan',
            Transaksi::STATUS_SELESAI => 'Selesai',
            Transaksi::STATUS_DIBATALKAN => 'Dibatalkan'
        ];

        $metodePembayaranList = [
            Transaksi::METODE_TRANSFER => 'Transfer Bank',
            Transaksi::METODE_VA => 'Virtual Account',
            Transaksi::METODE_EWALLET => 'E-Wallet'
        ];

        if ($request->ajax()) {
            return view('admin.transaksi.table', compact('transaksis'))->render();
        }

        return view('admin.transaksi.index', compact(
            'transaksis',
            'statusList',
            'metodePembayaranList'
        ));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $transaksi = Transaksi::with([
            'user',
            'verifiedBy',
            'detailTransaksis.produk'
        ])->findOrFail($id);

        // Gunakan accessor dari model
        $subtotal = $transaksi->total_biaya;
        $sisaPembayaran = $transaksi->sisa_pembayaran;

        // Log activity
        $this->logActivity(
            'view',
            'transaksi',
            $transaksi->id,
            $transaksi->kode_transaksi,
            "Admin melihat detail transaksi {$transaksi->kode_transaksi}"
        );

        return view('admin.transaksi.show', compact(
            'transaksi',
            'subtotal',
            'sisaPembayaran'
        ));
    }

    /**
     * Get transaction statistics for dashboard
     */
    public function getStats(Request $request)
    {
        $stats = [
            'total' => Transaksi::count(),
            'menunggu' => Transaksi::where('status', Transaksi::STATUS_MENUNGGU_PERSETUJUAN)->count(),
            'disetujui' => Transaksi::where('status', Transaksi::STATUS_DISETUJUI)->count(),
            'dipinjam' => Transaksi::where('status', Transaksi::STATUS_DIPINJAM)->count(),
            'selesai' => Transaksi::where('status', Transaksi::STATUS_SELESAI)->count(),
            'dibatalkan' => Transaksi::where('status', Transaksi::STATUS_DIBATALKAN)->count(),
            'total_deposit' => Transaksi::sum('jumlah_deposit'),
            'pendapatan_selesai' => Transaksi::where('status', Transaksi::STATUS_SELESAI)
                ->join('detail_transaksis', 'transaksis.id', '=', 'detail_transaksis.transaksi_id')
                ->sum('detail_transaksis.subtotal'),
        ];

        // Data untuk chart bulanan
        $monthlyData = Transaksi::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('COUNT(*) as total'),
            DB::raw('SUM(jumlah_deposit) as total_deposit')
        )
        ->whereYear('created_at', date('Y'))
        ->groupBy('year', 'month')
        ->orderBy('month')
        ->get();

        return response()->json([
            'stats' => $stats,
            'monthly' => $monthlyData
        ]);
    }

    /**
     * Export transaksi ke Excel (Optional)
     */
    public function export(Request $request)
    {
        $query = Transaksi::with(['user', 'detailTransaksis.produk']);

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('tanggal_pengajuan', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('tanggal_pengajuan', '<=', $request->end_date);
        }

        $transaksis = $query->orderBy('created_at', 'desc')->get();

        // Implement export logic here if needed
        // You can use Laravel Excel package

        return redirect()->back()->with('info', 'Fitur export sedang dalam pengembangan');
    }
}
