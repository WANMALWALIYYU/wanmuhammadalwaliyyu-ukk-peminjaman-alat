<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengembalian;
use App\Models\Transaksi;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PengembalianController extends Controller
{
    use LogsActivity;

    /**
     * Display a listing of pengembalian.
     */
    public function index(Request $request)
    {
        // Main query with relations
        $mainQuery = Pengembalian::with(['transaksi.user', 'transaksi.detailTransaksis.produk', 'petugas'])
            ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->filled('status')) {
            $mainQuery->where('status', $request->status);
        }

        // Search by kode_transaksi or nama_lengkap
        if ($request->filled('search')) {
            $search = $request->search;
            $mainQuery->whereHas('transaksi', function ($q) use ($search) {
                $q->where('kode_transaksi', 'like', '%' . $search . '%')
                    ->orWhere('nama_lengkap', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $mainQuery->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $mainQuery->whereDate('created_at', '<=', $request->date_to);
        }

        $pengembalians = $mainQuery->paginate(10);

        // Stats for dashboard
        $stats = [
            'total' => Pengembalian::count(),
            'menunggu_pengiriman' => Pengembalian::where('status', Pengembalian::STATUS_MENUNGGU_PENGIRIMAN)->count(),
            'dikirim' => Pengembalian::where('status', Pengembalian::STATUS_DIKIRIM)->count(),
            'sampai' => Pengembalian::where('status', Pengembalian::STATUS_SAMPAI)->count(),
            'diproses' => Pengembalian::where('status', Pengembalian::STATUS_DIPROSES)->count(),
            'selesai' => Pengembalian::where('status', Pengembalian::STATUS_SELESAI)->count(),
            'dibatalkan' => Pengembalian::where('status', Pengembalian::STATUS_DIBATALKAN)->count(),
        ];

        // For AJAX table refresh
        if ($request->ajax()) {
            return view('admin.pengembalian.table', compact('pengembalians'))->render();
        }

        return view('admin.pengembalian.index', compact('pengembalians', 'stats'));
    }

    /**
     * Display the specified pengembalian.
     */
    public function show($id)
    {
        $pengembalian = Pengembalian::with([
            'transaksi.user',
            'transaksi.detailTransaksis.produk',
            'user',
            'petugas'
        ])->findOrFail($id);

        // Calculate financial details
        $transaksi = $pengembalian->transaksi;
        $detailTransaksis = $transaksi->detailTransaksis;

        $subtotal = $detailTransaksis->sum('subtotal');
        $deposit = $transaksi->jumlah_deposit;
        $sisaPembayaran = $subtotal - $deposit;

        // Calculate overdue days
        $tanggalSelesai = $detailTransaksis->max('tanggal_selesai');
        $hariTerlambat = 0;
        if ($tanggalSelesai && now()->gt($tanggalSelesai)) {
            $hariTerlambat = now()->diffInDays($tanggalSelesai);
        }

        return view('admin.pengembalian.show', compact(
            'pengembalian',
            'transaksi',
            'detailTransaksis',
            'subtotal',
            'deposit',
            'sisaPembayaran',
            'hariTerlambat'
        ));
    }

    /**
     * Export pengembalian data.
     */
    public function export(Request $request)
    {
        $query = Pengembalian::with(['transaksi.user']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $pengembalians = $query->get();

        // Generate CSV export
        $filename = 'pengembalian_export_' . date('Y-m-d_His') . '.csv';
        $handle = fopen('php://temp', 'w');

        // Add UTF-8 BOM for Excel compatibility
        fputs($handle, "\xEF\xBB\xBF");

        // Headers
        fputcsv($handle, [
            'ID',
            'Kode Transaksi',
            'Nama Peminjam',
            'Email',
            'No Telepon',
            'Status',
            'Kurir',
            'No Resi',
            'Tanggal Dikirim',
            'Tanggal Sampai',
            'Kondisi Barang',
            'Biaya Kerusakan',
            'Denda Keterlambatan',
            'Total Biaya Tambahan',
            'Catatan User',
            'Catatan Petugas',
            'Dibuat Pada',
        ]);

        // Data rows
        foreach ($pengembalians as $pengembalian) {
            fputcsv($handle, [
                $pengembalian->id,
                $pengembalian->transaksi->kode_transaksi ?? '-',
                $pengembalian->transaksi->nama_lengkap ?? '-',
                $pengembalian->transaksi->email ?? '-',
                $pengembalian->transaksi->no_telepon ?? '-',
                $this->getStatusLabel($pengembalian->status),
                $pengembalian->kurir_pengembalian ?? '-',
                $pengembalian->no_resi_pengembalian ?? '-',
                $pengembalian->tanggal_dikirim ? $pengembalian->tanggal_dikirim->format('Y-m-d H:i:s') : '-',
                $pengembalian->tanggal_sampai ? $pengembalian->tanggal_sampai->format('Y-m-d H:i:s') : '-',
                $this->getKondisiLabel($pengembalian->kondisi_barang),
                $pengembalian->biaya_kerusakan ?? 0,
                $pengembalian->denda_keterlambatan ?? 0,
                $pengembalian->total_biaya_tambahan ?? 0,
                $pengembalian->catatan_user ?? '-',
                $pengembalian->catatan_petugas ?? '-',
                $pengembalian->created_at ? $pengembalian->created_at->format('Y-m-d H:i:s') : '-',
            ]);
        }

        rewind($handle);
        $csvContent = stream_get_contents($handle);
        fclose($handle);

        return response($csvContent, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    /**
     * Get status label for export
     */
    private function getStatusLabel($status)
    {
        $labels = [
            'menunggu_pengiriman' => 'Menunggu Pengiriman',
            'dikirim' => 'Dalam Pengiriman',
            'sampai' => 'Barang Sampai',
            'diproses' => 'Sedang Diproses',
            'selesai' => 'Selesai',
            'dibatalkan' => 'Dibatalkan',
        ];
        return $labels[$status] ?? $status;
    }

    /**
     * Get kondisi label for export
     */
    private function getKondisiLabel($kondisi)
    {
        $labels = [
            'baik' => 'Baik',
            'rusak_ringan' => 'Rusak Ringan',
            'rusak_berat' => 'Rusak Berat',
        ];
        return $labels[$kondisi] ?? '-';
    }

    /**
     * Get stats for dashboard.
     */
    public function getStats()
    {
        $stats = [
            'total' => Pengembalian::count(),
            'menunggu_pengiriman' => Pengembalian::where('status', Pengembalian::STATUS_MENUNGGU_PENGIRIMAN)->count(),
            'dikirim' => Pengembalian::where('status', Pengembalian::STATUS_DIKIRIM)->count(),
            'sampai' => Pengembalian::where('status', Pengembalian::STATUS_SAMPAI)->count(),
            'diproses' => Pengembalian::where('status', Pengembalian::STATUS_DIPROSES)->count(),
            'selesai' => Pengembalian::where('status', Pengembalian::STATUS_SELESAI)->count(),
            'dibatalkan' => Pengembalian::where('status', Pengembalian::STATUS_DIBATALKAN)->count(),
        ];

        // Chart data for last 30 days
        $chartData = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $chartData[$date] = Pengembalian::whereDate('created_at', $date)->count();
        }

        return response()->json([
            'stats' => $stats,
            'chartData' => $chartData
        ]);
    }
}
