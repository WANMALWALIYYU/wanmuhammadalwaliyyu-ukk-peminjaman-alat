@extends('admin.index')
@section('title', 'Produk')
@section('page-title', 'Produk')
@section('breadcrumb', 'Produk')
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

<div class="container-fluid pe-4">

    <!-- TABEL UTAMA (Produk Aktif) -->
    <div class="row">
        <div class="col-12">
            <div class="card border shadow-xs mb-4">
                <div class="card-header border-bottom pb-0">
                    <div>
                        <h6 class="font-weight-semibold text-lg mb-0">Daftar Produk</h6>
                        <p class="text-sm">Kelola produk yang tersedia</p>
                    </div>
                    <div class="ms-auto d-flex">
                        <a href="{{ route('produk.create') }}" class="btn btn-sm btn-dark btn-icon d-flex align-items-center">
                            <span class="text-white me-2">
                                <i class="fa-solid fa-plus"></i>
                            </span>
                            <span class="text-white">Tambah Produk</span>
                        </a>
                    </div>
                </div>

                <div class="card-body px-0 py-0">
                    <div class="border-bottom py-3 px-3 d-flex justify-content-between align-items-center">
                        <!-- Filter dan Search -->
                        <div class="d-flex align-items-center w-100 gap-2 flex-wrap">
                            <!-- Filter Status -->
                            <div class="btn-group" role="group">
                                <input type="radio" class="btn-check" name="btnradioStatus" id="status-all" value="all"
                                    {{ request('filter', 'all') === 'all' ? 'checked' : '' }} autocomplete="off">
                                <label class="btn btn-white px-3 mb-0" for="status-all">Semua</label>

                                @foreach($statusList as $status)
                                <input type="radio" class="btn-check" name="btnradioStatus"
                                    id="status-{{ $status }}" value="{{ $status }}"
                                    {{ request('filter') === $status ? 'checked' : '' }} autocomplete="off">
                                <label class="btn btn-white px-3 mb-0" for="status-{{ $status }}">
                                    {{ ucfirst($status) }}
                                </label>
                                @endforeach
                            </div>

                            <!-- Filter Kondisi -->
                            <select name="kondisi" id="filter-kondisi" class="form-select form-select-sm w-auto">
                                <option value="all">Semua Kondisi</option>
                                @foreach($kondisiList as $kondisi)
                                <option value="{{ $kondisi }}" {{ request('kondisi') == $kondisi ? 'selected' : '' }}>
                                    {{ ucfirst($kondisi) }}
                                </option>
                                @endforeach
                            </select>

                            <!-- Filter Kategori -->
                            <select name="category" id="filter-category" class="form-select form-select-sm w-auto">
                                <option value="all">Semua Kategori</option>
                                @foreach($categories ?? [] as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->nama_kategori }}
                                </option>
                                @endforeach
                            </select>

                            <!-- Search -->
                            <div class="input-group ms-auto w-sm-25">
                                <span class="input-group-text text-body">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path>
                                    </svg>
                                </span>
                                <input type="text" id="search-input" class="form-control" placeholder="Cari produk..." value="{{ request('search') }}">
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7">No / Kode</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7">Kategori</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7">Nama Produk</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7">Harga</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7">Status</th>
                                    <th class="text-secondary text-center text-xs font-weight-semibold opacity-7">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="produk-data">
                                @include('admin.produk.table')
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="border-top py-3 px-3">
                        {{ $getProduk->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TABEL HISTORY (Produk yang sudah dihapus) -->
    <div class="row">
        <div class="col-12">
            <div class="card border shadow-xs mb-4">
                <div class="card-header border-bottom pb-0">
                    <div class="d-sm-flex align-items-center mb-3">
                        <div>
                            <h6 class="font-weight-semibold text-lg mb-0">History Produk Terhapus</h6>
                            <p class="text-sm mb-sm-0">Data produk yang telah dihapus</p>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 py-0">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center justify-content-center mb-0">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7">No / Kode</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7">Nama Produk</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7">Harga</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7">Dihapus Pada</th>
                                    <th class="text-secondary text-center text-xs font-weight-semibold opacity-7">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="history-data">
                                @include('admin.produk.history-table')
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODALS DETAIL PRODUK --}}
@foreach ($getProduk as $produk)
<div class="modal fade" id="viewModal{{ $produk->id }}" tabindex="-1" aria-hidden="true" style="z-index: 9999;">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    {{-- Gambar Produk --}}
                    <div class="col-md-5 text-center">
                        @if($produk->gambar)
                            <img src="{{ asset('storage/' . $produk->gambar) }}"
                                 alt="{{ $produk->nama_produk }}"
                                 class="img-fluid rounded shadow-sm"
                                 style="max-height: 250px; object-fit: cover;">
                        @else
                            <div class="border rounded py-5 text-muted">
                                <i class="fa-regular fa-image fa-3x"></i>
                                <p class="mt-2">Tidak ada gambar</p>
                            </div>
                        @endif
                    </div>

                    {{-- Info Produk --}}
                    <div class="col-md-7">
                        <div class="mb-3">
                            <div class="row mb-2">
                                <div class="col-5 fw-bold">Kode Produk:</div>
                                <div class="col-7">{{ $produk->kode_produk }}</div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-5 fw-bold">Nama Produk:</div>
                                <div class="col-7">{{ $produk->nama_produk }}</div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-5 fw-bold">Kategori:</div>
                                <div class="col-7">
                                    <span class="badge bg-secondary">{{ $produk->category->nama_kategori ?? 'Tanpa Kategori' }}</span>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-5 fw-bold">Harga:</div>
                                <div class="col-7 text-primary fw-bold">{{ $produk->harga_formatted }}</div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-5 fw-bold">Status:</div>
                                <div class="col-7">{!! $produk->status_badge !!}</div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-5 fw-bold">Kondisi:</div>
                                <div class="col-7">
                                    @if($produk->kondisi)
                                        <span class="badge bg-info">{{ ucfirst($produk->kondisi) }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-5 fw-bold">Stok:</div>
                                <div class="col-7">{{ $produk->stok ?? 0 }}</div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-5 fw-bold">Berat:</div>
                                <div class="col-7">{{ $produk->berat ?? 0 }} gr</div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-5 fw-bold">Dibuat:</div>
                                <div class="col-7">{{ $produk->created_at ? $produk->created_at->format('d-m-Y H:i') : '-' }}</div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-5 fw-bold">Diperbarui:</div>
                                <div class="col-7">{{ $produk->updated_at ? $produk->updated_at->format('d-m-Y H:i') : '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Deskripsi --}}
                <hr class="my-3">
                <div>
                    <label class="fw-bold mb-2">Deskripsi:</label>
                    <p class="text-secondary">{{ $produk->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <a href="{{ route('produk.edit', $produk->id) }}" class="btn btn-primary">
                    <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                </a>
            </div>
        </div>
    </div>
</div>
@endforeach

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(function () {
    let debounceTimer;

    function fetchProduk(url = "{{ route('produk.index') }}") {
        let search = $('#search-input').val();
        let filter = $('input[name="btnradioStatus"]:checked').val();
        let kondisi = $('#filter-kondisi').val();
        let category = $('#filter-category').val();

        $.ajax({
            url: url,
            type: "GET",
            data: {
                search: search,
                filter: filter,
                kondisi: kondisi,
                category: category
            },
            success: function (response) {
                $('#produk-data').html(response);
            },
            error: function (xhr) {
                console.error(xhr.responseText);
            }
        });
    }

    // Debounce search
    $('#search-input').on('keyup', function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => fetchProduk(), 400);
    });

    // Filter radio status
    $('input[name="btnradioStatus"]').on('change', function () {
        fetchProduk();
    });

    // Filter kondisi
    $('#filter-kondisi').on('change', function () {
        fetchProduk();
    });

    // Filter kategori
    $('#filter-category').on('change', function () {
        fetchProduk();
    });

    // Enter key
    $('#search-input').on('keypress', function(e) {
        if (e.which == 13) {
            e.preventDefault();
            fetchProduk();
        }
    });

    // Pagination AJAX
    $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();
        let url = $(this).attr('href');
        fetchProduk(url);
    });

    // SweetAlert untuk Soft Delete
    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();
        let form = $(this).closest('form');

        Swal.fire({
            title: 'Hapus Produk?',
            text: "Produk akan dipindahkan ke daftar terhapus",
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
            title: 'Kembalikan Produk?',
            text: "Produk akan dikembalikan ke daftar aktif",
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
