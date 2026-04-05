<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Category;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Traits\LogsActivity; //  trait
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TransaksiController extends Controller
{
    use LogsActivity; //  trait

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk melakukan transaksi');
        }

        // Ambil data dari request atau session
        $produkIds = $request->input('produk_ids', []);
        $jumlahs = $request->input('jumlahs', []);
        $durasis = $request->input('durasis', []);
        $tanggalMulais = $request->input('tanggal_mulai', []);
        $tanggalSelesais = $request->input('tanggal_selesai', []);

        Log::info('Transaksi Index - Request Parameters:', [
            'produk_ids' => $produkIds,
            'jumlahs' => $jumlahs,
            'durasis' => $durasis,
            'tanggal_mulai' => $tanggalMulais,
            'tanggal_selesai' => $tanggalSelesais
        ]);

        $transaksiItems = [];

        if (!empty($produkIds) && is_array($produkIds)) {
            foreach ($produkIds as $index => $produkId) {
                $produk = Produk::with('category')->find($produkId);

                if ($produk && $produk->status === 'tersedia' && $produk->stok > 0) {
                    $jumlah = isset($jumlahs[$index]) ? (int)$jumlahs[$index] : 1;
                    $durasi = isset($durasis[$index]) ? (int)$durasis[$index] : 1;
                    $tanggalMulai = isset($tanggalMulais[$index]) ? $tanggalMulais[$index] : now()->format('Y-m-d');
                    $tanggalSelesai = isset($tanggalSelesais[$index]) ? $tanggalSelesais[$index] : now()->addDays($durasi)->format('Y-m-d');

                    // Validasi jumlah tidak melebihi stok
                    $jumlah = min($jumlah, $produk->stok);

                    $transaksiItems[] = (object) [
                        'produk_id' => $produk->id,
                        'produk' => $produk,
                        'jumlah' => $jumlah,
                        'durasi' => $durasi,
                        'tanggal_mulai' => $tanggalMulai,
                        'tanggal_selesai' => $tanggalSelesai,
                    ];
                }
            }

            if (!empty($transaksiItems)) {
                session(['transaksi_items' => $transaksiItems]);
            }
        } else if (session()->has('transaksi_items')) {
            $transaksiItems = session('transaksi_items');
        }

        if (empty($transaksiItems)) {
            return redirect()->route('produk.list')
                ->with('error', 'Silakan pilih produk terlebih dahulu atau produk yang dipilih tidak tersedia');
        }

        // Hitung subtotal
        $subTotal = 0;
        foreach ($transaksiItems as $item) {
            $subTotal += $item->produk->harga * $item->jumlah * $item->durasi;
        }

        // Deposit 25% dari subtotal
        $deposit = max(25000, $subTotal * 0.25);

        // Format untuk tampilan
        $subTotalFormatted = number_format($subTotal, 0, ',', '.');
        $depositFormatted = number_format($deposit, 0, ',', '.');

        $kategoriList = Category::whereNull('deleted_at')->get();

        return view('transaksi.index', compact(
            'user',
            'transaksiItems',
            'subTotal',
            'deposit',
            'subTotalFormatted',
            'depositFormatted',
            'kategoriList'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_telepon' => 'required|string|max:20',
            'no_identitas' => 'required|string|max:50',
            'foto_ktp' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'provinsi' => 'required|string',
            'kabupaten' => 'required|string',
            'kecamatan' => 'required|string',
            'kelurahan' => 'required|string',
            'alamat_lengkap' => 'required|string',
            'metode_pembayaran' => 'required|in:transfer,va,ewallet',
            'bukti_deposit' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'terms_agree' => 'required|accepted',
            // Validasi untuk data produk dari request
            'produk_ids' => 'required|array',
            'produk_ids.*' => 'exists:produks,id',
            'jumlahs' => 'required|array',
            'jumlahs.*' => 'integer|min:1',
            'durasis' => 'required|array',
            'durasis.*' => 'integer|min:1',
            'tanggal_mulai' => 'required|array',
            'tanggal_mulai.*' => 'date|after_or_equal:today',
            'tanggal_selesai' => 'required|array',
            'tanggal_selesai.*' => 'date|after:tanggal_mulai.*',
        ]);

        $user = Auth::user();

        // Ambil data produk dari request, bukan dari session
        $produkIds = $request->input('produk_ids', []);
        $jumlahs = $request->input('jumlahs', []);
        $durasis = $request->input('durasis', []);
        $tanggalMulais = $request->input('tanggal_mulai', []);
        $tanggalSelesais = $request->input('tanggal_selesai', []);

        if (empty($produkIds)) {
            return redirect()->back()->with('error', 'Tidak ada produk yang dipilih untuk ditransaksikan');
        }

        // Hitung subtotal dari produk
        $subTotal = 0;
        $transaksiItems = [];

        foreach ($produkIds as $index => $produkId) {
            $produk = Produk::find($produkId);

            if (!$produk) {
                return redirect()->back()->with('error', 'Produk tidak ditemukan');
            }

            $jumlah = isset($jumlahs[$index]) ? (int)$jumlahs[$index] : 1;
            $durasi = isset($durasis[$index]) ? (int)$durasis[$index] : 1;
            $tanggalMulai = isset($tanggalMulais[$index]) ? $tanggalMulais[$index] : now()->format('Y-m-d');
            $tanggalSelesai = isset($tanggalSelesais[$index]) ? $tanggalSelesais[$index] : now()->addDays($durasi)->format('Y-m-d');

            // Validasi stok (hanya validasi, tidak mengurangi stok di sini)
            if ($produk->stok < $jumlah) {
                return redirect()->back()->with('error', "Stok produk {$produk->nama_produk} tidak mencukupi (tersedia: {$produk->stok}, diminta: {$jumlah})");
            }

            // Validasi tanggal
            if (strtotime($tanggalSelesai) <= strtotime($tanggalMulai)) {
                return redirect()->back()->with('error', "Tanggal selesai harus setelah tanggal mulai untuk produk {$produk->nama_produk}");
            }

            // Hitung ulang durasi dari tanggal
            $startDate = new \DateTime($tanggalMulai);
            $endDate = new \DateTime($tanggalSelesai);
            $durasiHitung = $startDate->diff($endDate)->days;

            if ($durasiHitung != $durasi) {
                $durasi = $durasiHitung;
            }

            $subtotalProduk = $produk->harga * $jumlah * $durasi;
            $subTotal += $subtotalProduk;

            $transaksiItems[] = [
                'produk' => $produk,
                'produk_id' => $produk->id,
                'jumlah' => $jumlah,
                'durasi' => $durasi,
                'tanggal_mulai' => $tanggalMulai,
                'tanggal_selesai' => $tanggalSelesai,
                'subtotal_produk' => $subtotalProduk
            ];
        }

        // Hitung deposit: 25% dari subtotal, minimal Rp 25.000
        $deposit = max(25000, $subTotal * 0.25);

        $kodeTransaksi = 'TRX-' . date('Ymd') . '-' . strtoupper(Str::random(6));

        DB::beginTransaction();

        try {
            // Upload foto KTP
            $fotoKtpPath = null;
            if ($request->hasFile('foto_ktp')) {
                $file = $request->file('foto_ktp');
                $namaFile = time() . '_ktp_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
                $fotoKtpPath = $file->storeAs('foto-ktp', $namaFile, 'public');
            }

            // Upload bukti deposit
            $buktiDepositPath = null;
            if ($request->hasFile('bukti_deposit')) {
                $file = $request->file('bukti_deposit');
                $namaFile = time() . '_deposit_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
                $buktiDepositPath = $file->storeAs('bukti-deposit', $namaFile, 'public');
            }

            // Buat transaksi - HANYA menyimpan deposit (25% dari subtotal)
            $transaksi = Transaksi::create([
                'user_id' => $user->id,
                'kode_transaksi' => $kodeTransaksi,
                'nama_lengkap' => $request->nama_lengkap,
                'email' => $request->email,
                'no_telepon' => $request->no_telepon,
                'no_identitas' => $request->no_identitas,
                'foto_ktp' => $fotoKtpPath,
                'provinsi' => $request->provinsi,
                'kabupaten' => $request->kabupaten,
                'kecamatan' => $request->kecamatan,
                'kelurahan' => $request->kelurahan,
                'alamat_lengkap' => $request->alamat_lengkap,
                'bukti_deposit' => $buktiDepositPath,
                'jumlah_deposit' => $deposit, // Hanya deposit 25% dari subtotal
                'tanggal_pengajuan' => now(),
                'status' => 'menunggu_persetujuan',
                'metode_pembayaran' => $request->metode_pembayaran,
            ]);

            // Buat detail transaksi
            $itemDetails = [];
            foreach ($transaksiItems as $item) {
                $detail = DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'produk_id' => $item['produk_id'],
                    'nama_produk' => $item['produk']->nama_produk,
                    'harga_per_hari' => $item['produk']->harga,
                    'jumlah' => $item['jumlah'],
                    'durasi_hari' => $item['durasi'],
                    'tanggal_mulai' => $item['tanggal_mulai'],
                    'tanggal_selesai' => $item['tanggal_selesai'],
                    'subtotal' => $item['subtotal_produk'],
                ]);
                $itemDetails[] = $detail;
            }

            // Log transaksi creation
            $this->logActivity(
                'create',
                'transaksi',
                $transaksi->id,
                $transaksi->kode_transaksi,
                "User {$user->name} membuat transaksi baru dengan kode {$transaksi->kode_transaksi}, total deposit Rp " . number_format($deposit, 0, ',', '.'),
                null,
                $transaksi,
                'success'
            );

            // Hapus session transaksi items
            session()->forget('transaksi_items');

            DB::commit();

            return redirect()->route('transaksi.selesai', $transaksi->id)
                ->with('success', 'Transaksi berhasil dibuat! Silakan tunggu konfirmasi dari admin.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Transaksi Store Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            // Log failed transaction
            $this->logActivity(
                'create',
                'transaksi',
                null,
                null,
                "User {$user->name} gagal membuat transaksi: " . $e->getMessage(),
                null,
                null,
                'failed',
                $e->getMessage()
            );

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = Auth::user();

        $transaksi = Transaksi::with(['detailTransaksis.produk', 'user', 'verifiedBy'])
            ->where('user_id', $user->id)
            ->findOrFail($id);

        // Log view transaction
        $this->logActivity(
            'view',
            'transaksi',
            $transaksi->id,
            $transaksi->kode_transaksi,
            "User {$user->name} melihat detail transaksi {$transaksi->kode_transaksi}"
        );

        return view('transaksi.detail', compact('transaksi'));
    }

    /**
     * Display success page after transaction.
     */
    public function selesai($id)
    {
        $user = Auth::user();

        $transaksi = Transaksi::with(['detailTransaksis.produk', 'user', 'verifiedBy'])
            ->where('user_id', $user->id)
            ->find($id);

        if (!$transaksi) {
            return redirect()->route('produk.list')
                ->with('error', 'Transaksi tidak ditemukan');
        }

        // Hitung ulang total dari detail transaksi
        $subtotal = $transaksi->detailTransaksis->sum('subtotal');

        // Deposit menggunakan nilai yang sudah disimpan di database
        $deposit = $transaksi->jumlah_deposit;

        // Sisa pembayaran setelah deposit (untuk pelunasan nanti)
        $sisaPembayaran = $subtotal - $deposit;

        return view('transaksi.selesai', compact(
            'transaksi',
            'subtotal',
            'deposit',
            'sisaPembayaran'
        ));
    }

    /**
     * Get list of user transactions
     */
    public function riwayat()
    {
        $user = Auth::user();

        $transaksis = Transaksi::with(['detailTransaksis.produk', 'verifiedBy'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('transaksi.riwayat', compact('transaksis'));
    }

    /**
     * Cancel transaction
     */
    public function batal($id)
    {
        $user = Auth::user();

        $transaksi = Transaksi::where('user_id', $user->id)
            ->where('status', 'menunggu_persetujuan')
            ->findOrFail($id);

        // Save old status for logging
        $oldStatus = $transaksi->status;

        DB::beginTransaction();

        try {
            foreach ($transaksi->detailTransaksis as $detail) {
                $produk = Produk::find($detail->produk_id);
                if ($produk) {
                    $produk->increment('stok', $detail->jumlah);
                    if ($produk->stok > 0) {
                        $produk->update(['status' => 'tersedia']);
                    }
                }
            }

            $transaksi->update(['status' => 'dibatalkan']);

            // Log cancellation
            $this->logActivity(
                'update',
                'transaksi',
                $transaksi->id,
                $transaksi->kode_transaksi,
                "User {$user->name} membatalkan transaksi {$transaksi->kode_transaksi}",
                ['status' => $oldStatus],
                ['status' => 'dibatalkan'],
                'success'
            );

            DB::commit();

            return redirect()->route('transaksi.riwayat')
                ->with('success', 'Transaksi berhasil dibatalkan');

        } catch (\Exception $e) {
            DB::rollBack();

            // Log failed cancellation
            $this->logActivity(
                'update',
                'transaksi',
                $transaksi->id,
                $transaksi->kode_transaksi,
                "User {$user->name} gagal membatalkan transaksi {$transaksi->kode_transaksi}: " . $e->getMessage(),
                null,
                null,
                'failed',
                $e->getMessage()
            );

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Reapply transaction (ajukan ulang transaksi yang ditolak)
     */
    public function reapply($id)
    {
        $user = Auth::user();

        $transaksi = Transaksi::where('user_id', $user->id)
            ->where('status', 'ditolak')
            ->with(['detailTransaksis.produk'])
            ->findOrFail($id);

        // Log reapply attempt
        $this->logActivity(
            'reapply',
            'transaksi',
            $transaksi->id,
            $transaksi->kode_transaksi,
            "User {$user->name} mengajukan ulang transaksi {$transaksi->kode_transaksi} yang ditolak"
        );

        $transaksiItems = [];
        foreach ($transaksi->detailTransaksis as $detail) {
            $produk = Produk::find($detail->produk_id);
            if ($produk && $produk->status === 'tersedia' && $produk->stok >= $detail->jumlah) {
                $transaksiItems[] = (object) [
                    'produk_id' => $produk->id,
                    'produk' => $produk,
                    'jumlah' => $detail->jumlah,
                    'durasi' => $detail->durasi_hari,
                    'tanggal_mulai' => $detail->tanggal_mulai->format('Y-m-d'),
                    'tanggal_selesai' => $detail->tanggal_selesai->format('Y-m-d'),
                ];
            }
        }

        if (empty($transaksiItems)) {
            return redirect()->route('produk.list')
                ->with('error', 'Produk yang dipilih tidak tersedia lagi. Silakan pilih produk baru.');
        }

        session(['transaksi_items' => $transaksiItems]);

        return redirect()->route('transaksi.index')
            ->with('success', 'Silakan lengkapi data transaksi ulang dengan memperhatikan catatan dari admin.');
    }
}
