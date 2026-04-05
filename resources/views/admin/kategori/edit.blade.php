@extends('admin.index')
@section('title', 'Edit Kategori')
@section('page-title', 'Kategori')
@section('breadcrumb', 'Edit Kategori')
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
        .current-image-wrapper {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
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
        .info-note {
            background-color: #e7f3ff;
            padding: 12px 15px;
            border-radius: 5px;
            margin: 15px 0;
            font-size: 14px;
        }
        .info-note i {
            color: #0d6efd;
            margin-right: 8px;
        }
        .hidden {
            display: none !important;
        }
        .badge-warning {
            background-color: #ffc107;
            color: #000;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            display: inline-block;
        }
        .section-title {
            font-weight: 600;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .section-title i {
            font-size: 18px;
        }
        .old-image-section {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .new-image-section {
            margin-top: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .replacement-indicator {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-top: 10px;
            padding: 10px;
            background-color: #fff3cd;
            border: 1px solid #ffe69c;
            border-radius: 5px;
            color: #856404;
        }
    </style>

    <form action="{{ route('kategori.update', $editKategori->id) }}"
          id="form-edit-kategori"
          class="kategori-edit-container p-5 rounded-4"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="kategori-create d-flex justify-content-between border-bottom mb-3">
            <div class="kategori-menu">
                <h4>Edit Kategori</h4>
                <p class="text-muted">Manage Your Category and Permissions</p>
            </div>
        </div>

        <div class="kategori-edit rounded-3 overflow-hidden border border-gray-200 p-5 mb-4 shadow-sm">
            <div class="row kategori-input">
                <div class="col-md-12">
                    <div class="kategori-input-box">
                        <span class="fst-italic text-black-50">
                            Nama kategori <span class="text-danger">*</span>
                        </span>
                        <div class="d-flex mb-3 border rounded-3">
                            <span class="p-2">
                                <i class="fa-solid fa-layer-group text-primary"></i>
                            </span>
                            <input type="text"
                                   class="form-control bg-transparent border-0 @error('nama-kate') is-invalid @enderror"
                                   name="nama-kate"
                                   value="{{ old('nama-kate', $editKategori->nama_kategori) }}"
                                   placeholder="Contoh: Sneaker"
                                   required>
                        </div>
                        @error('nama-kate')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row kategori-input">
                <div class="col-md-12">
                    <div class="kategori-input-box">
                        <span class="fst-italic text-black-50">
                            Deskripsi
                        </span>
                        <div class="d-flex mb-3 border rounded-3">
                            <span class="p-2">
                                <i class="fa-regular fa-clipboard text-primary"></i>
                            </span>
                            <textarea class="form-control autogrow bg-transparent border-0 @error('des-kate') is-invalid @enderror"
                                      name="des-kate"
                                      placeholder="Masukkan deskripsi kategori...">{{ old('des-kate', $editKategori->deskripsi_kategori) }}</textarea>
                        </div>
                        @error('des-kate')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row kategori-input">
                <div class="col-md-12">
                    <div class="kategori-input-box">
                        <!-- Bagian Gambar Lama -->
                        <div id="old-image-section" class="old-image-section">
                            <div class="section-title">
                                <i class="fa-solid fa-image text-danger"></i>
                                <span>Gambar Kategori Saat Ini</span>
                                <span id="will-be-replaced-badge" class="badge-warning ms-2 hidden">
                                    <i class="fa-solid fa-arrows-rotate"></i> Akan diganti
                                </span>
                            </div>

                            <!-- Container untuk menampilkan gambar lama -->
                            <div id="current-image-container" class="current-image-wrapper">
                                @if($editKategori->image)
                                    <div class="preview-item" id="current-image">
                                        <img src="{{ asset('storage/' . $editKategori->image) }}" alt="Current Image">
                                    </div>
                                    <div class="mt-2" id="current-image-info">
                                        <small class="text-muted">
                                            <i class="fa-regular fa-image me-1"></i>
                                            {{ basename($editKategori->image) }}
                                        </small>
                                    </div>
                                @else
                                    <div class="text-muted" id="no-image-message">
                                        <i class="fa-regular fa-image me-2"></i>
                                        Belum ada gambar untuk kategori ini
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Catatan informasi -->
                        <div class="info-note">
                            <i class="fa-solid fa-info-circle"></i>
                            <strong>Informasi:</strong> Gambar akan otomatis terganti jika Anda memilih foto baru di bawah ini.
                        </div>

                        <!-- Bagian Gambar Baru -->
                        <div id="new-image-section" class="new-image-section">
                            <div class="section-title">
                                <i class="fa-solid fa-image text-success"></i>
                                <span>Upload Gambar Baru</span>
                            </div>

                            <!-- Input untuk upload gambar baru -->
                            <div class="mt-2">
                                <div class="custom-file-input rounded-3 mb-3" onclick="document.getElementById('image-kate').click();">
                                    <i class="fa-regular fa-image fa-2x text-primary mb-2"></i>
                                    <p class="mb-1">Klik untuk memilih file gambar baru</p>
                                    <small class="text-muted">Format: JPG, PNG, GIF, WEBP (Max 2MB)</small>
                                </div>
                                <input type="file"
                                       id="image-kate"
                                       name="image-kate"
                                       accept="image/*"
                                       class="d-none @error('image-kate') is-invalid @enderror">
                                <div class="mt-2 text-center">
                                    <small class="text-dark">
                                        <i class="fa-regular fa-clock"></i>
                                        File yang dipilih: <span id="file-name" class="text-info">Tidak ada file dipilih</span>
                                    </small>
                                </div>
                            </div>

                            <!-- Preview untuk gambar baru -->
                            <div class="mt-4">
                                <label class="form-label fw-semibold">Preview Gambar Baru:</label>
                                <div class="preview-container rounded-3 p-3" id="new-image-preview">
                                    <span class="text-muted">
                                        <i class="fa-regular fa-image me-2"></i>
                                        Belum ada gambar baru dipilih
                                    </span>
                                </div>
                            </div>

                            @error('image-kate')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="save-or-back d-flex justify-content-between mx-5">
            <a href="{{ route('kategori.index') }}" class="btn btn-sm btn-dark btn-icon align-items-center me-2">
                <span class="text-white me-2">
                    <i class="fa-solid fa-arrow-left-long"></i>
                </span>
                <span class="text-white">Kembali</span>
            </a>
            <button type="submit" class="btn btn-sm btn-primary btn-icon align-items-center me-2">
                <span class="btn-inner--icon me-2">
                    <i class="fa-regular fa-floppy-disk fs-6"></i>
                </span>
                <span class="btn-inner--text">Simpan Perubahan</span>
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

        // Preview image ketika memilih file baru
        $('#image-kate').on('change', function(e) {
            const file = e.target.files[0];
            const fileName = $('#file-name');
            const newPreviewContainer = $('#new-image-preview');
            const currentImageContainer = $('#current-image-container');
            const currentImage = $('#current-image');
            const noImageMessage = $('#no-image-message');
            const currentImageInfo = $('#current-image-info');
            const willBeReplacedBadge = $('#will-be-replaced-badge');

            if (file) {
                fileName.text(file.name);

                // Hapus gambar lama dan infonya
                if (currentImage.length) {
                    currentImage.remove();
                }
                if (currentImageInfo.length) {
                    currentImageInfo.remove();
                }
                if (noImageMessage.length) {
                    noImageMessage.remove();
                }

                // Tampilkan badge
                willBeReplacedBadge.removeClass('hidden');

                const reader = new FileReader();
                reader.onload = function(e) {
                    const imageHTML = `
                        <div class="preview-item" id="current-image">
                            <img src="${e.target.result}" alt="Preview">
                        </div>
                        <div class="mt-2" id="current-image-info">
                            <small class="text-muted">
                                <i class="fa-regular fa-image me-1"></i>
                                ${file.name}
                            </small>
                        </div>
                    `;

                    // Tampilkan di preview gambar baru
                    newPreviewContainer.html(`
                        <div class="preview-item">
                            <img src="${e.target.result}" alt="Preview">
                        </div>
                    `);

                    // Tampilkan juga di gambar kategori saat ini
                    currentImageContainer.html(imageHTML);
                };
                reader.readAsDataURL(file);
            } else {
                fileName.text('Tidak ada file dipilih');
                newPreviewContainer.html(`
                    <span class="text-muted">
                        <i class="fa-regular fa-image me-2"></i>
                        Belum ada gambar baru dipilih
                    </span>
                `);
            }
        });
    });
    </script>
@endsection
