@extends('admin.index')
@section('title', 'Kategori')
@section('page-title', 'Kategori')
@section('breadcrumb', 'Kategori')
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
                popup: 'small-toast' // class khusus
            }
        });
    });
    </script>
@endif

<div class="container-fluid pe-4">
    <!-- TABEL UTAMA (Kategori Aktif) -->
    <div class="row">
        <div class="col-12">
            <div class="card border shadow-xs mb-4">
                <div class="card-header border-bottom pb-0">
                    <div>
                        <h6 class="font-weight-semibold text-lg mb-0">Kategori List</h6>
                        <p class="text-sm">Kelola kategori produk yang aktif</p>
                    </div>
                    <div class="ms-auto d-flex">
                        <a href="{{ route('kategori.create') }}" class="btn btn-sm btn-dark btn-icon d-flex align-items-center">
                            <span class="text-white me-2">
                                <i class="fa-solid fa-plus"></i>
                            </span>
                            <span class="text-white">Tambah Kategori</span>
                        </a>
                    </div>
                </div>

                <div class="card-body px-0 py-0">
                    <div class="border-bottom py-3 px-3 d-flex justify-content-between align-items-center">
                        <!-- Filter dan Search dibungkus bersama -->
                        <div class="d-flex align-items-center w-100 gap-2">
                            <!-- Filter Radio (menggunakan kategori dari database) -->
                            <div class="btn-group" role="group">
                                <input type="radio" class="btn-check" name="btnradiotable" id="btnradiotable1" value="all" autocomplete="off" checked>
                                <label class="btn btn-white px-3 mb-0" for="btnradiotable1">All</label>

                                @foreach($getKategori as $kategori)
                                <input type="radio" class="btn-check" name="btnradiotable"
                                    id="btnradiotable{{ $kategori->id }}" value="{{ $kategori->id }}"
                                    autocomplete="off">
                                <label class="btn btn-white px-3 mb-0" for="btnradiotable{{ $kategori->id }}">
                                    {{ $kategori->nama_kategori }}
                                </label>
                                @endforeach
                            </div>

                            <!-- Search -->
                            <div class="input-group ms-auto w-sm-25">
                                <span class="input-group-text text-body">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path>
                                    </svg>
                                </span>
                                <input type="text" id="search-input" class="form-control" placeholder="Cari kategori..." value="{{ request('search') }}">
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7">No / Kode</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7">Kategori</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7">Deskripsi</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7 text-center">Jml Produk</th>
                                    <th class="text-secondary text-center text-xs font-weight-semibold opacity-7">Action</th>
                                </tr>
                            </thead>
                            <tbody id="kategori-data">
                                @include('admin.kategori.table')
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="border-top py-3 px-3">
                        {{ $getKategori->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TABEL HISTORY (Kategori yang sudah dihapus) -->
    <div class="row">
        <div class="col-12">
            <div class="card border shadow-xs mb-4">
                <div class="card-header border-bottom pb-0">
                    <div class="d-sm-flex align-items-center mb-3">
                        <div>
                            <h6 class="font-weight-semibold text-lg mb-0">History Kategori Terhapus</h6>
                            <p class="text-sm mb-sm-0">Data kategori yang telah dihapus</p>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 py-0">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center justify-content-center mb-0">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7">No / Kode</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7">Kategori</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-0">Deskripsi</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Dihapus Pada</th>
                                    <th class="text-secondary text-center text-xs font-weight-semibold opacity-7">Action</th>
                                </tr>
                            </thead>
                            <tbody id="history-data">
                                @include('admin.kategori.history-table')
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(function () {
    let debounceTimer;

    function fetchKategori(url = "{{ route('kategori.index') }}") {
        let search = $('#search-input').val();
        let filter = $('input[name="btnradiotable"]:checked').val();

        $.ajax({
            url: url,
            type: "GET",
            data: {
                search: search,
                filter: filter
            },
            success: function (response) {
                $('#kategori-data').html(response);
            },
            error: function (xhr) {
                console.error(xhr.responseText);
            }
        });
    }

    // Debounce search tabel utama
    $('#search-input').on('keyup', function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => fetchKategori(), 400);
    });

    // Filter radio
    $('input[name="btnradiotable"]').on('change', function () {
        fetchKategori();
    });

    // Enter key
    $('#search-input').on('keypress', function(e) {
        if (e.which == 13) {
            e.preventDefault();
            fetchKategori();
        }
    });

    // Pagination AJAX
    $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();
        let url = $(this).attr('href');
        fetchKategori(url);
    });

    // SweetAlert untuk Soft Delete
    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();
        let form = $(this).closest('form');

        Swal.fire({
            title: 'Hapus Kategori?',
            text: "Kategori akan dipindahkan ke daftar terhapus",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    // SweetAlert untuk Force Delete
    $(document).on('click', '.btn-force-delete', function(e) {
        e.preventDefault();
        let form = $(this).closest('form');

        Swal.fire({
            title: 'Hapus Permanen?',
            text: "Data akan dihapus selamanya dan tidak dapat dikembalikan!",
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus Permanen!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    // SweetAlert untuk Restore
    $(document).on('click', '.btn-restore', function(e) {
        e.preventDefault();
        let form = $(this).closest('form');

        Swal.fire({
            title: 'Kembalikan Kategori?',
            text: "Kategori akan dikembalikan ke daftar aktif",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Kembalikan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>

@endsection
