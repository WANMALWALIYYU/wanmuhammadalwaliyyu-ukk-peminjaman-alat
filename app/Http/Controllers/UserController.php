<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Category;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display the landing page.
     */
    public function index()
    {
        // Ambil produk yang tersedia (status 'tersedia' dan stok > 0)
        // Maksimal 20 produk untuk ditampilkan di slider
        $produkTersedia = Produk::with('category') // Eager load category
            ->where('status', 'tersedia')
            ->where('stok', '>', 0)
            ->whereNull('deleted_at')
            ->latest()
            ->limit(20)
            ->get();

        // Hitung total produk untuk statistik
        $totalProduk = Produk::where('status', 'tersedia')
            ->where('stok', '>', 0)
            ->count();

        $totalKategori = Category::whereNull('deleted_at')->count();

        return view('pages.content', compact(
            'produkTersedia',
            'totalProduk',
            'totalKategori'
        ));
    }

    /**
     * Display all products page with category filter
     */
    public function produk(Request $request)
    {
        // Ambil semua kategori untuk sidebar dengan count produk
        $kategoriList = Category::withCount(['produks' => function($query) {
            $query->where('status', 'tersedia')
                  ->where('stok', '>', 0);
        }])->whereNull('deleted_at')->get();

        // Query produk dengan eager loading category
        $query = Produk::with('category')
            ->where('status', 'tersedia')
            ->where('stok', '>', 0)
            ->whereNull('deleted_at');

        // Filter berdasarkan kategori
        if ($request->filled('kategori')) {
            $query->where('category_id', $request->kategori);
        }

        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama_produk', 'like', '%' . $request->search . '%')
                ->orWhere('deskripsi', 'like', '%' . $request->search . '%')
                ->orWhere('fitur', 'like', '%' . $request->search . '%');
            });
        }

        // Filter berdasarkan kondisi
        if ($request->filled('kondisi') && $request->kondisi != 'all') {
            $query->where('kondisi', $request->kondisi);
        }

        // Sorting
        $sort = $request->get('sort', 'terbaru');
        switch($sort) {
            case 'termurah':
                $query->orderBy('harga', 'asc');
                break;
            case 'termahal':
                $query->orderBy('harga', 'desc');
                break;
            case 'nama_asc':
                $query->orderBy('nama_produk', 'asc');
                break;
            case 'nama_desc':
                $query->orderBy('nama_produk', 'desc');
                break;
            default: // terbaru
                $query->latest();
                break;
        }

        $produk = $query->paginate(12)->withQueryString();

        return view('pages.produk-list', compact('produk', 'kategoriList'));
    }

    /**
     * Display product detail.
     */
    public function detail($id)
    {
        $produk = Produk::with('category') // Eager load category
            ->where('status', 'tersedia')
            ->where('stok', '>', 0)
            ->findOrFail($id);

        // Produk terkait (kategori/kondisi sama)
        $produkTerkait = Produk::with('category')
            ->where('status', 'tersedia')
            ->where('stok', '>', 0)
            ->where('category_id', $produk->category_id)
            ->where('id', '!=', $produk->id)
            ->latest()
            ->take(4)
            ->get();

        return view('pages.produk-detail', compact('produk', 'produkTerkait'));
    }

    /**
     * API endpoint untuk mendapatkan produk (jika diperlukan untuk AJAX)
     */
    public function getProducts(Request $request)
    {
        $query = Produk::with('category')
            ->where('status', 'tersedia')
            ->where('stok', '>', 0)
            ->whereNull('deleted_at');

        // Filter berdasarkan kondisi
        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }

        // Limit untuk slider
        $limit = $request->get('limit', 20);
        $produk = $query->latest()->limit($limit)->get();

        // Format data untuk response
        $produk->transform(function($item) {
            return [
                'id' => $item->id,
                'nama_produk' => $item->nama_produk,
                'kode_produk' => $item->kode_produk,
                'deskripsi' => $item->deskripsi,
                'harga' => $item->harga,
                'harga_formatted' => 'Rp ' . number_format($item->harga, 0, ',', '.'),
                'stok' => $item->stok,
                'kondisi' => $item->kondisi,
                'fitur' => $item->fitur,
                'gambar' => $item->gambar ? asset('storage/' . $item->gambar) : null,
                'kategori' => $item->category ? $item->category->nama_kategori : null,
                'detail_url' => route('produk.detail', $item->id),
                'wa_link' => "https://wa.me/628132002611?text=Saya%20tertarik%20dengan%20" . urlencode($item->nama_produk) . "%20(" . $item->kode_produk . ")"
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $produk
        ]);
    }
}
