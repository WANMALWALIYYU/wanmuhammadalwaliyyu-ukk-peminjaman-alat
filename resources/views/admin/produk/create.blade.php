@extends('admin.index')
@section('title', 'Create Produk')
@section('page-title', 'Produk')
@section('breadcrumb', 'Create Produk')
@section('content-dashboard')

@if ($errors->any())
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
            toast: true,
            icon: 'error',
            title: "{{ $errors->first() }}",
            position: 'top-end',
            background: 'transparent',
            showCloseButton: true,
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            customClass: {
                popup: 'small-toast'
            }
        });
    });
    </script>
@endif

<style>
    .preview-container {
        width: 100%;
        min-height: 200px;
        border: 1px dashed #283C50;
        position: relative;
        background: #f8f9fa;
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        padding: 10px;
        justify-content: center;
        align-items: center;
    }
    .preview-item {
        position: relative;
        width: 150px;
        height: 150px;
        border: 1px solid #dee2e6;
        border-radius: 5px;
        overflow: hidden;
    }
    .preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .custom-file-input {
        border: 2px dashed #dee2e6;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        border-radius: 8px;
    }
    .custom-file-input:hover {
        border-color: #0d6efd;
        background: #f0f7ff;
    }
    .section-title {
        font-weight: 600;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .image-section {
        margin-bottom: 20px;
        padding: 15px;
        background-color: #f8f9fa;
        border-radius: 5px;
    }
</style>

<form action="{{ route('produk.store') }}" class="produk-edit-container p-5 rounded-4 shadow-sm" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="produk-create d-flex justify-content-between border-bottom mb-3">
        <div class="produk-menu">
            <h4>Tambah Produk</h4>
            <p class="text-muted">Tambahkan produk baru ke inventaris</p>
        </div>
    </div>

    <div class="produk-edit rounded-3 overflow-hidden border border-gray-200 p-5 mb-4">
        {{-- Kategori --}}
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="produk-input-box">
                    <span class="fst-italic text-black-50">
                        Kategori <span class="text-danger">*</span>
                    </span>
                    <div class="d-flex border rounded-3">
                        <span class="p-3">
                            <i class="fa-solid fa-layer-group text-primary"></i>
                        </span>
                        <select name="category_id" class="form-select bg-transparent border-0 @error('category_id') is-invalid @enderror" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoriList as $kategori)
                            <option value="{{ $kategori->id }}" {{ old('category_id') == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama_kategori }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    @error('category_id')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Nama Produk --}}
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="produk-input-box">
                    <span class="fst-italic text-black-50">
                        Nama Produk <span class="text-danger">*</span>
                    </span>
                    <div class="d-flex border rounded-3">
                        <span class="p-3">
                            <i class="fa-solid fa-box text-primary"></i>
                        </span>
                        <input type="text" class="form-control bg-transparent border-0 @error('nama-produk') is-invalid @enderror"
                               name="nama-produk" value="{{ old('nama-produk') }}"
                               placeholder="Contoh: Kamera DSLR" required>
                    </div>
                    @error('nama-produk')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Stok dan Harga --}}
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="produk-input-box">
                    <span class="fst-italic text-black-50">
                        Stok <span class="text-danger">*</span>
                    </span>
                    <div class="d-flex border rounded-3">
                        <span class="p-3">
                            <i class="fa-solid fa-cubes text-primary"></i>
                        </span>
                        <input type="number" class="form-control bg-transparent border-0 @error('stok') is-invalid @enderror"
                               name="stok" value="{{ old('stok', 1) }}" min="0" required>
                    </div>
                    @error('stok')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="produk-input-box">
                    <span class="fst-italic text-black-50">
                        Harga(per hari)<span class="text-danger">*</span>
                    </span>
                    <div class="d-flex border rounded-3">
                        <span class="p-3">
                            <i class="fa-solid fa-money-bill-wave text-primary"></i>
                        </span>
                        <input type="number" class="form-control bg-transparent border-0 @error('harga') is-invalid @enderror"
                               name="harga" value="{{ old('harga') }}" min="0" step="0.01" required>
                    </div>
                    @error('harga')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Kondisi dan Status --}}
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="produk-input-box">
                    <span class="fst-italic text-black-50">
                        Kondisi <span class="text-danger">*</span>
                    </span>
                    <div class="d-flex border rounded-3">
                        <span class="p-3">
                            <i class="fa-solid fa-clipboard-check text-primary"></i>
                        </span>
                        <select name="kondisi" class="form-select bg-transparent border-0 @error('kondisi') is-invalid @enderror" required>
                            <option value="">Pilih Kondisi</option>
                            <option value="baru" {{ old('kondisi') == 'baru' ? 'selected' : '' }}>Baru</option>
                            <option value="bekas" {{ old('kondisi') == 'bekas' ? 'selected' : '' }}>Bekas</option>
                            <option value="rusak" {{ old('kondisi') == 'rusak' ? 'selected' : '' }}>Rusak</option>
                        </select>
                    </div>
                    @error('kondisi')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">

            </div>
        </div>

        {{-- Fitur --}}
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="produk-input-box">
                    <span class="fst-italic text-black-50">
                        Fitur <span class="text-danger">*</span>
                    </span>
                    <div class="d-flex border rounded-3">
                        <span class="p-3">
                            <i class="fa-solid fa-star text-primary"></i>
                        </span>
                        <textarea class="form-control autogrow bg-transparent border-0 @error('fitur') is-invalid @enderror"
                                  name="fitur" placeholder="Contoh: 24MP, WiFi, 4K Video" required>{{ old('fitur') }}</textarea>
                    </div>
                    @error('fitur')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Deskripsi --}}
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="produk-input-box">
                    <span class="fst-italic text-black-50">
                        Deskripsi
                    </span>
                    <div class="d-flex border rounded-3">
                        <span class="p-3">
                            <i class="fa-regular fa-clipboard text-primary"></i>
                        </span>
                        <textarea class="form-control autogrow bg-transparent border-0 @error('deskripsi') is-invalid @enderror"
                                  name="deskripsi" placeholder="Masukkan deskripsi produk...">{{ old('deskripsi') }}</textarea>
                    </div>
                    @error('deskripsi')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Gambar --}}
        <div class="row">
            <div class="col-md-12">
                <div class="produk-input-box">
                    <!-- Upload Gambar -->
                    <div class="image-section">
                        <div class="section-title">
                            <i class="fa-solid fa-image text-success"></i>
                            <span>Upload Gambar</span>
                        </div>
                        <div class="custom-file-input rounded-3 mb-3" onclick="document.getElementById('gambar').click();">
                            <i class="fa-regular fa-image fa-2x text-primary mb-2"></i>
                            <p class="mb-1">Klik untuk memilih file gambar</p>
                            <small class="text-muted">Format: JPG, PNG, GIF, WEBP (Max 2MB)</small>
                        </div>
                        <input type="file" id="gambar" name="gambar" accept="image/*" class="d-none @error('gambar') is-invalid @enderror">

                        <div class="mt-2 text-center">
                            <small class="text-dark">
                                <i class="fa-regular fa-clock"></i>
                                File yang dipilih: <span id="file-name" class="text-info">Tidak ada file dipilih</span>
                            </small>
                        </div>

                        <!-- Preview Gambar -->
                        <div class="mt-4">
                            <label class="form-label fw-semibold">Preview Gambar:</label>
                            <div class="preview-container rounded-3" id="new-image-preview">
                                <span class="text-muted">
                                    <i class="fa-regular fa-image me-2"></i>
                                    Belum ada gambar dipilih
                                </span>
                            </div>
                        </div>

                        @error('gambar')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="save-or-back d-flex justify-content-between mx-5">
        <a href="{{ route('produk.index') }}" class="btn btn-sm btn-dark btn-icon align-items-center me-2">
            <span class="text-white me-2">
                <i class="fa-solid fa-arrow-left-long"></i>
            </span>
            <span class="text-white">Kembali</span>
        </a>
        <button type="submit" class="btn btn-sm btn-primary btn-icon align-items-center me-2">
            <span class="btn-inner--icon me-2">
                <i class="fa-regular fa-floppy-disk fs-6"></i>
            </span>
            <span class="btn-inner--text">Simpan</span>
        </button>
    </div>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Auto-grow textarea
    document.querySelectorAll('textarea.autogrow').forEach(function(element) {
        element.style.height = element.scrollHeight + "px";
        element.addEventListener('input', function() {
            this.style.height = "auto";
            this.style.height = (this.scrollHeight) + "px";
        });
    });

    // Preview image ketika memilih file
    $('#gambar').on('change', function(e) {
        const file = e.target.files[0];
        const fileName = $('#file-name');
        const previewContainer = $('#new-image-preview');

        if (file) {
            fileName.text(file.name);

            const reader = new FileReader();
            reader.onload = function(e) {
                const imageHTML = `
                    <div class="preview-item">
                        <img src="${e.target.result}" alt="Preview">
                    </div>
                `;
                previewContainer.html(imageHTML);
            };
            reader.readAsDataURL(file);
        } else {
            fileName.text('Tidak ada file dipilih');
            previewContainer.html(`
                <span class="text-muted">
                    <i class="fa-regular fa-image me-2"></i>
                    Belum ada gambar dipilih
                </span>
            `);
        }
    });
});
</script>

@endsection
