<?php

namespace App\Http\Controllers\Admin;

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
     * Display a listing of all deliveries (all statuses)
     */
    public function index(Request $request)
    {
        $mainQuery = Pengiriman::with(['transaksi.user', 'petugas'])
            ->orderBy('created_at', 'desc');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $mainQuery->whereHas('transaksi', function($q) use ($search) {
                $q->where('kode_transaksi', 'like', "%{$search}%")
                  ->orWhere('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            if ($request->status == 'sent') {
                $mainQuery->whereNotNull('tanggal_dikirim')->whereNull('tanggal_sampai');
            } elseif ($request->status == 'delivered') {
                $mainQuery->whereNotNull('tanggal_sampai');
            }
        }

        $pengirimans = $mainQuery->paginate(10);

        if ($request->ajax()) {
            return view('admin.pengiriman.table', compact('pengirimans'))->render();
        }

        return view('admin.pengiriman.index', compact('pengirimans'));
    }

    /**
     * Display details of a specific delivery
     */
    public function show($id)
    {
        $pengiriman = Pengiriman::with([
            'transaksi.user',
            'transaksi.detailTransaksis.produk',
            'transaksi.verifiedBy',
            'petugas'
        ])->findOrFail($id);

        // Get related data for additional info
        $transaksi = $pengiriman->transaksi;

        // Calculate total rental cost
        $totalBiaya = $transaksi->detailTransaksis->sum('subtotal');

        // Calculate remaining payment
        $sisaPembayaran = $totalBiaya - $transaksi->jumlah_deposit;

        return view('admin.pengiriman.show', compact('pengiriman', 'transaksi', 'totalBiaya', 'sisaPembayaran'));
    }

    /**
     * Get statistics for dashboard
     */
    public function getStats()
    {
        $totalPengiriman = Pengiriman::count();

        $inProgress = Pengiriman::whereNotNull('tanggal_dikirim')
            ->whereNull('tanggal_sampai')
            ->count();

        $completed = Pengiriman::whereNotNull('tanggal_sampai')->count();

        $todayPengiriman = Pengiriman::whereDate('tanggal_dikirim', today())->count();

        // Recent deliveries for widget
        $recentPengiriman = Pengiriman::with(['transaksi.user'])
            ->latest()
            ->take(5)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'total' => $totalPengiriman,
                'in_progress' => $inProgress,
                'completed' => $completed,
                'today' => $todayPengiriman,
                'recent' => $recentPengiriman
            ]
        ]);
    }

    /**
     * Export deliveries data
     */
    public function export(Request $request)
    {
        $query = Pengiriman::with(['transaksi.user', 'petugas'])
            ->orderBy('created_at', 'desc');

        if ($request->filled('status')) {
            if ($request->status == 'sent') {
                $query->whereNotNull('tanggal_dikirim')->whereNull('tanggal_sampai');
            } elseif ($request->status == 'delivered') {
                $query->whereNotNull('tanggal_sampai');
            }
        }

        $pengirimans = $query->get();

        // Log export activity
        $this->logActivity(
            'export',
            'pengiriman',
            null,
            null,
            "Admin " . Auth::user()->name . " mengekspor data pengiriman"
        );

        // Generate CSV export
        $filename = 'pengiriman_' . date('Y-m-d_His') . '.csv';
        $handle = fopen('php://temp', 'w+');

        // Headers
        fputcsv($handle, [
            'ID', 'Kode Transaksi', 'Nama Peminjam', 'Email', 'No Telepon',
            'Tanggal Kirim', 'Tanggal Sampai', 'Petugas', 'Status'
        ]);

        foreach ($pengirimans as $pengiriman) {
            fputcsv($handle, [
                $pengiriman->id,
                $pengiriman->transaksi->kode_transaksi ?? '-',
                $pengiriman->transaksi->nama_lengkap ?? '-',
                $pengiriman->transaksi->email ?? '-',
                $pengiriman->transaksi->no_telepon ?? '-',
                $pengiriman->tanggal_dikirim ? $pengiriman->tanggal_dikirim->format('Y-m-d H:i:s') : '-',
                $pengiriman->tanggal_sampai ? $pengiriman->tanggal_sampai->format('Y-m-d H:i:s') : '-',
                $pengiriman->petugas->name ?? '-',
                $pengiriman->tanggal_sampai ? 'Selesai' : ($pengiriman->tanggal_dikirim ? 'Dalam Perjalanan' : 'Belum Dikirim')
            ]);
        }

        rewind($handle);
        $csvContent = stream_get_contents($handle);
        fclose($handle);

        return response($csvContent, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    }

    /**
     * Get delivery statistics chart data
     */
    public function chartData()
    {
        // Last 7 days deliveries
        $last7Days = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $last7Days->put($date->format('Y-m-d'), [
                'date' => $date->format('d M'),
                'sent' => 0,
                'delivered' => 0
            ]);
        }

        $pengirimans = Pengiriman::where('tanggal_dikirim', '>=', now()->subDays(6)->startOfDay())
            ->get();

        foreach ($pengirimans as $pengiriman) {
            $dateKey = $pengiriman->tanggal_dikirim->format('Y-m-d');
            if ($last7Days->has($dateKey)) {
                $current = $last7Days->get($dateKey);
                $current['sent']++;
                $last7Days->put($dateKey, $current);
            }

            if ($pengiriman->tanggal_sampai) {
                $deliveryDateKey = $pengiriman->tanggal_sampai->format('Y-m-d');
                if ($last7Days->has($deliveryDateKey)) {
                    $current = $last7Days->get($deliveryDateKey);
                    $current['delivered']++;
                    $last7Days->put($deliveryDateKey, $current);
                }
            }
        }

        return response()->json([
            'success' => true,
            'data' => $last7Days->values()
        ]);
    }
}
