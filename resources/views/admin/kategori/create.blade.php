@extends('admin.index')
@section('title', 'Create Kategori')
@section('page-title', 'Kategori')
@section('breadcrumb', 'Create Kategori')
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
        .preview-container{
            width: 100%;
            height: 250px;
            border: 1px solid #283C50;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f8f9fa;
        }
        #preview{
            max-width: 100%;
            max-height: 240px;
            display: none;
            object-fit: contain;
        }
        .custom-file-upload {
            border: 2px dashed #dee2e6;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            border-radius: 8px;
        }
        .custom-file-upload:hover {
            border-color: #0d6efd;
            background: #f0f7ff;
        }
    </style>

    <form action="{{ route('kategori.store') }}" class="kategori-edit-container p-5 rounded-4 shadow-sm" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="kategori-create d-flex justify-content-between border-bottom mb-3">
            <div class="kategori-menu">
                <h4>Tambah Kategori</h4>
                <p class="text-muted">Manage Your Category and Permissions</p>
            </div>
        </div>

        <div class="kategori-edit rounded-3 overflow-hidden border border-gray-200 p-5 mb-4">
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
                            <input type="text" class="form-control bg-transparent border-0 @error('nama-kate') is-invalid @enderror"
                                   name="nama-kate" value="{{ old('nama-kate') }}"
                                   placeholder="Contoh: Sneaker" required>
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
                                      placeholder="Masukkan deskripsi kategori...">{{ old('des-kate') }}</textarea>
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
                        <span class="fst-italic text-black-50">
                            Image
                        </span>
                        <div class="custom-file-upload mb-3" onclick="document.getElementById('image-kate').click();">
                            <i class="fa-regular fa-image fa-3x text-primary mb-2"></i>
                            <p class="mb-1">Klik untuk memilih file gambar</p>
                            <small class="text-muted">Format: JPG, PNG, GIF, WEBP (Max 2MB)</small>
                        </div>
                        <input type="file" id="image-kate" name="image-kate" accept="image/*" class="d-none">

                        <div class="preview-container rounded-3 mt-1">
                            <img id="preview" src="#" alt="Preview Foto">
                            <span id="preview-text" class="text-muted">
                                <i class="fa-regular fa-image me-2"></i>Belum ada gambar dipilih
                            </span>
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
                <span class="btn-inner--text">Simpan</span>
            </button>
        </div>
    </form>

    <script>
        // Auto-grow textarea
        document.querySelectorAll('textarea.autogrow').forEach(function (element) {
            element.style.height = element.scrollHeight + "px";
            element.addEventListener('input', function () {
                this.style.height = "auto";
                this.style.height = (this.scrollHeight) + "px";
            });
        });

        // Preview image
        document.getElementById("image-kate").addEventListener("change", function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById("preview");
            const previewText = document.getElementById("preview-text");

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = "block";
                    if (previewText) previewText.style.display = "none";
                };
                reader.readAsDataURL(file);
            } else {
                preview.src = "#";
                preview.style.display = "none";
                if (previewText) previewText.style.display = "inline";
            }
        });
    </script>
@endsection
