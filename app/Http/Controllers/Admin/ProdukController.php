<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Produk;
use App\Traits\LogsActivity; //  trait
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProdukController extends Controller
{
    use LogsActivity; //trait log aktivitas

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Query untuk tabel utama dengan eager loading
        $mainQuery = Produk::with('category')->whereNull('deleted_at');

        // Filter search untuk tabel utama
        if ($request->filled('search')) {
            $mainQuery->where(function($q) use ($request) {
                $q->where('nama_produk', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_produk', 'like', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->search . '%')
                  ->orWhereHas('category', function($categoryQuery) use ($request) {
                      $categoryQuery->where('nama_kategori', 'like', '%' . $request->search . '%');
                  });
            });
        }

        // Filter status
        if ($request->filled('status') && $request->status !== 'all') {
            $mainQuery->where('status', $request->status);
        }

        // Filter kondisi
        if ($request->filled('kondisi') && $request->kondisi !== 'all') {
            $mainQuery->where('kondisi', $request->kondisi);
        }

        // Filter kategori
        if ($request->filled('category') && $request->category !== 'all') {
            $mainQuery->where('category_id', $request->category);
        }

        $getProduk = $mainQuery->latest()->paginate(10)->withQueryString();

        // Query untuk history
        $historyProduk = Produk::onlyTrashed()
            ->with('category')
            ->latest('deleted_at')
            ->take(5)
            ->get();

        // Data untuk filter dropdown
        $statusList = ['tersedia', 'dipinjam'];
        $kondisiList = ['baru', 'bekas', 'rusak'];
        $categories = Category::whereNull('deleted_at')->get();

        if ($request->ajax()) {
            return view('admin.produk.table', compact('getProduk'))->render();
        }

        return view('admin.produk.index', compact(
            'getProduk',
            'historyProduk',
            'statusList',
            'kondisiList',
            'categories'
        ));
    }

    /**
     * Restore produk yang dihapus
     */
    public function restore(string $id)
    {
        $produk = Produk::withTrashed()->findOrFail($id);

        // Log restore activity
        $this->logRestore('produk', $produk, 'kode_produk');

        $produk->restore();

        toast('Sukses mengembalikan produk', 'success')
            ->timerProgressBar()
            ->autoClose(2000)
            ->width('400px')
            ->padding('10px');

        return redirect()->route('produk.index');
    }

    /**
     * Force delete (hapus permanen)
     */
    public function forceDelete(string $id)
    {
        $produk = Produk::withTrashed()->findOrFail($id);

        // Log force delete activity
        $this->logForceDelete('produk', $produk, 'kode_produk');

        // Hapus gambar dari storage jika ada
        if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
            Storage::disk('public')->delete($produk->gambar);
        }

        $produk->forceDelete();

        toast('Sukses menghapus permanen produk', 'success')
            ->timerProgressBar()
            ->autoClose(2000)
            ->width('400px')
            ->padding('10px');

        return redirect()->route('produk.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoriList = Category::whereNull('deleted_at')->get();

        // Jika tidak ada kategori, beri pesan
        if ($kategoriList->isEmpty()) {
            toast('Buat kategori terlebih dahulu sebelum menambah produk', 'warning')
                ->timerProgressBar()
                ->autoClose(3000);
            return redirect()->route('kategori.index');
        }

        return view('admin.produk.create', compact('kategoriList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input - HAPUS validasi status dari sini
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'nama-produk' => 'required|min:3',
            'deskripsi' => 'nullable|min:3',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'kondisi' => 'required|in:baru,bekas,rusak',
            'fitur' => 'required',
            // 'status' => 'required|in:tersedia,dipinjam', // HAPUS baris ini
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'nama-prok.required' => 'Nama produk wajib diisi',
            'nama-produk.min' => 'Minimal karakter nama produk adalah 3',
            'deskripsi.min' => 'Minimal karakter deskripsi adalah 3',
            'stok.required' => 'Stok wajib diisi',
            'stok.integer' => 'Stok harus berupa angka',
            'stok.min' => 'Stok tidak boleh negatif',
            'harga.required' => 'Harga wajib diisi',
            'harga.numeric' => 'Harga harus berupa angka',
            'harga.min' => 'Harga tidak boleh negatif',
            'kondisi.required' => 'Kondisi wajib dipilih',
            'fitur.required' => 'Fitur wajib diisi',
            // Hapus pesan error status
            'gambar.image' => 'File harus berupa gambar',
            'gambar.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau webp',
            'gambar.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        // Generate kode produk unik
        do {
            $kodeProduk = 'PRD-' . strtoupper(Str::random(8));
        } while (Produk::where('kode_produk', $kodeProduk)->exists());

        // Persiapkan data produk - HAPUS status dari array
        $dataProduk = [
            'category_id' => $request->input('category_id'),
            'kode_produk' => $kodeProduk,
            'nama_produk' => $request->input('nama-produk'),
            'deskripsi' => $request->input('deskripsi'),
            'stok' => $request->input('stok'),
            'harga' => $request->input('harga'),
            'kondisi' => $request->input('kondisi'),
            'fitur' => $request->input('fitur'),
            // 'status' => $request->input('status'), // HAPUS baris ini - status akan diatur otomatis oleh model
        ];

        // Jika ada file gambar
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('img-produk', $namaFile, 'public');
            $dataProduk['gambar'] = $path;
        }

        // Simpan produk (status akan diatur otomatis oleh booted method)
        $produk = Produk::create($dataProduk);

        // Log create activity
        $this->logCreate('produk', $produk, 'kode_produk');

        toast('Sukses menambah produk', 'success')
            ->timerProgressBar()
            ->autoClose(2000)
            ->width('400px')
            ->padding('10px');

        return redirect()->route('produk.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $editProduk = Produk::findOrFail($id);
        $kategoriList = Category::whereNull('deleted_at')->get();

        return view('admin.produk.edit', compact('editProduk','kategoriList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'nama-produk' => 'required|min:3',
            'deskripsi' => 'nullable|min:3',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'kondisi' => 'required|in:baru,bekas,rusak',
            'fitur' => 'required',
            // 'status' => 'required|in:tersedia,dipinjam', // HAPUS baris ini
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'nama-produk.required' => 'Nama produk wajib diisi',
            'nama-produk.min' => 'Minimal karakter nama produk adalah 3',
            'deskripsi.min' => 'Minimal karakter deskripsi adalah 3',
            'stok.required' => 'Stok wajib diisi',
            'stok.integer' => 'Stok harus berupa angka',
            'stok.min' => 'Stok tidak boleh negatif',
            'harga.required' => 'Harga wajib diisi',
            'harga.numeric' => 'Harga harus berupa angka',
            'harga.min' => 'Harga tidak boleh negatif',
            'kondisi.required' => 'Kondisi wajib dipilih',
            'fitur.required' => 'Fitur wajib diisi',
            // Hapus pesan error status
            'gambar.image' => 'File harus berupa gambar',
            'gambar.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau webp',
            'gambar.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        $updateProduk = Produk::findOrFail($id);

        // Simpan data lama sebelum update
        $oldData = $updateProduk->replicate();

        // Data yang akan diupdate - HAPUS status dari array
        $dataProduk = [
            'category_id' => $request->input('category_id'),
            'nama_produk' => $request->input('nama-produk'),
            'deskripsi' => $request->input('deskripsi'),
            'stok' => $request->input('stok'),
            'harga' => $request->input('harga'),
            'kondisi' => $request->input('kondisi'),
            'fitur' => $request->input('fitur'),
            // 'status' => $request->input('status'), // HAPUS baris ini
        ];

        // Cek apakah ada request untuk hapus gambar
        if ($request->has('delete_gambar') && $request->delete_gambar == '1') {
            if ($updateProduk->gambar && Storage::disk('public')->exists($updateProduk->gambar)) {
                Storage::disk('public')->delete($updateProduk->gambar);
            }
            $dataProduk['gambar'] = null;
        }

        // Jika ada file gambar baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($updateProduk->gambar && Storage::disk('public')->exists($updateProduk->gambar)) {
                Storage::disk('public')->delete($updateProduk->gambar);
            }

            // Upload gambar baru
            $file = $request->file('gambar');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('img-produk', $namaFile, 'public');
            $dataProduk['gambar'] = $path;
        }

        // Update produk (status akan diatur otomatis oleh booted method)
        $updateProduk->update($dataProduk);

        // Log update activity
        $this->logUpdate('produk', $updateProduk, $oldData, 'kode_produk');

        toast('Sukses mengedit produk', 'success')
            ->timerProgressBar()
            ->autoClose(2000)
            ->width('400px')
            ->padding('10px');

        return redirect()->route('produk.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $destroyProduk = Produk::findOrFail($id);

        // Log delete activity (soft delete)
        $this->logDelete('produk', $destroyProduk, 'kode_produk');

        $destroyProduk->delete();

        toast('Sukses menghapus produk', 'success')
            ->timerProgressBar()
            ->autoClose(2000)
            ->width('380px')
            ->padding('10px');

        return redirect()->route('produk.index');
    }
}
