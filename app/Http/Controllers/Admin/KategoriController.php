<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    use LogsActivity; 

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Gunakan withCount untuk mendapatkan jumlah produk per kategori
        $mainQuery = Category::withCount('produks')->whereNull('deleted_at');

        if ($request->filled('search')) {
            $mainQuery->where(function ($q) use ($request) {
                $q->where('nama_kategori', 'like', '%' . $request->search . '%')
                ->orWhere('deskripsi_kategori', 'like', '%' . $request->search . '%')
                ->orWhere('kode_kategori', 'like', '%' . $request->search . '%');
            });
        }

        $getKategori = $mainQuery->latest()->paginate(10);

        $historyKategori = Category::onlyTrashed()
            ->withCount('produks') // Juga tampilkan count untuk history
            ->latest('deleted_at')
            ->take(5)
            ->get();

        if ($request->ajax()) {
            return view('admin.kategori.table', compact('getKategori'))->render();
        }

        return view('admin.kategori.index', compact('getKategori', 'historyKategori'));
    }

    /**
     * Restore kategori yang dihapus
     */
    public function restore(string $id)
    {
        $kategori = Category::withTrashed()->findOrFail($id);

        // Log restore activity
        $this->logRestore('kategori', $kategori);

        $kategori->restore();

        toast('Sukses mengembalikan kategori', 'success')
            ->timerProgressBar()
            ->autoClose(2000);

        return redirect()->route('kategori.index');
    }

    /**
     * Force delete (hapus permanen)
     */
    public function forceDelete(string $id)
    {
        $kategori = Category::withTrashed()->findOrFail($id);

        // Cek apakah kategori masih memiliki produk
        if ($kategori->produks()->count() > 0) {
            toast('Tidak dapat menghapus kategori yang masih memiliki produk', 'error')
                ->timerProgressBar()
                ->autoClose(2000);
            return redirect()->route('kategori.index');
        }

        // Log force delete activity
        $this->logForceDelete('kategori', $kategori);

        // Hapus gambar dari storage
        if ($kategori->image && Storage::disk('public')->exists($kategori->image)) {
            Storage::disk('public')->delete($kategori->image);
        }

        $kategori->forceDelete();

        toast('Sukses menghapus permanen kategori', 'success')
            ->timerProgressBar()
            ->autoClose(2000);

        return redirect()->route('kategori.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.kategori.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama-kate' => 'required|min:3',
            'des-kate' => 'nullable|min:3',
            'image-kate' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ],[
            'nama-kate.required' => 'Nama kategori wajib diisi',
            'nama-kate.min' => 'Minimal Karakter nama kategori adalah 3',
            'des-kate.min' => 'Minimal Karakter deskripsi kategori adalah 3',
            'image-kate.image' => 'File harus berupa gambar',
            'image-kate.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau webp',
            'image-kate.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        // Generate kode kategori unik
        do {
            $kodeKategori = 'MCR-KAT' . Str::upper(Str::random(5));
        } while (Category::where('kode_kategori', $kodeKategori)->exists());

        // Persiapkan data kategori
        $dataKategori = [
            'kode_kategori' => $kodeKategori,
            'nama_kategori' => $request->input('nama-kate'),
            'deskripsi_kategori' => $request->input('des-kate'),
            'slug' => Str::slug($request->input('nama-kate')),
        ];

        // Jika ada file image
        if ($request->hasFile('image-kate')) {
            $file = $request->file('image-kate');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('img-kategori', $namaFile, 'public');
            $dataKategori['image'] = $path; // simpan path ke kolom image
        }

        // Simpan kategori
        $kategori = Category::create($dataKategori);

        // Log create activity
        $this->logCreate('kategori', $kategori, 'kode_kategori');

        // Toast notifikasi
        toast('Sukses menambah kategori','success')
            ->timerProgressBar()
            ->autoClose(2000)
            ->width('400px')
            ->padding('10px');

        return redirect()->route('kategori.index');
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
        $editKategori = Category::findOrFail($id);
        return view('admin.kategori.edit', compact('editKategori'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama-kate' => 'required|min:3',
            'des-kate' => 'nullable|min:3',
            'image-kate' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'nama-kate.required' => 'Nama kategori wajib diisi',
            'nama-kate.min' => 'Minimal Karakter nama kategori adalah 3',
            'des-kate.min' => 'Minimal Karakter deskripsi kategori adalah 3',
            'image-kate.image' => 'File harus berupa gambar',
            'image-kate.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau webp',
            'image-kate.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        $updateKategori = Category::findOrFail($id);

        // Simpan data lama sebelum update
        $oldData = $updateKategori->replicate();

        // Data yang akan diupdate
        $dataKategori = [
            'nama_kategori' => $request->input('nama-kate'),
            'deskripsi_kategori' => $request->input('des-kate'),
            'slug' => Str::slug($request->input('nama-kate')),
        ];

        // Cek apakah ada request untuk hapus gambar (dari hidden input delete_image)
        if ($request->has('delete_image') && $request->delete_image == '1') {
            // Hapus file gambar dari storage
            if ($updateKategori->image && Storage::disk('public')->exists($updateKategori->image)) {
                Storage::disk('public')->delete($updateKategori->image);
            }
            $dataKategori['image'] = null;
        }

        // Jika ada file image baru (prioritas lebih tinggi dari delete_image)
        if ($request->hasFile('image-kate')) {
            // Hapus gambar lama jika ada
            if ($updateKategori->image && Storage::disk('public')->exists($updateKategori->image)) {
                Storage::disk('public')->delete($updateKategori->image);
            }

            // Upload gambar baru
            $file = $request->file('image-kate');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('img-kategori', $namaFile, 'public');
            $dataKategori['image'] = $path;
        }

        $updateKategori->update($dataKategori);

        // Log update activity
        $this->logUpdate('kategori', $updateKategori, $oldData, 'kode_kategori');

        toast('Sukses mengedit kategori', 'success')
            ->timerProgressBar()
            ->autoClose(2000)
            ->width('400px')
            ->padding('10px');

        return redirect()->route('kategori.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $destroyKategori = Category::findOrFail($id);

        // Log delete activity (soft delete)
        $this->logDelete('kategori', $destroyKategori, 'kode_kategori');

        $destroyKategori->delete();

        toast('Sukses menghapus kategori','success')
        ->timerProgressBar()
        ->autoClose(2000)
        ->width('380px')
        ->padding('10px');
        return redirect()->route('kategori.index');
    }
}
