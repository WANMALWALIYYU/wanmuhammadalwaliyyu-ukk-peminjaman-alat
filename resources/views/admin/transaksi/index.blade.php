@extends('admin.index')
@section('title', 'Transaksi')
@section('page-title', 'Manajemen Transaksi')
@section('breadcrumb', 'Transaksi')
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
    :root {
        --primary: #0b2c5d;
        --primary-dark: #081f3f;
        --primary-light: #1f3c88;
        --accent-green: #10b981;
        --accent-blue: #3b82f6;
        --accent-orange: #f59e0b;
        --accent-red: #ef4444;
        --accent-purple: #8b5cf6;
        --background: #ffffff;
        --background-sec: #f8fafc;
        --text-color: #0f172a;
        --text-muted: #64748b;
        --gray-light: #e2e8f0;
        --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
        --radius-lg: 1rem;
        --radius-xl: 1.5rem;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .stat-card {
        background: linear-gradient(145deg, var(--background), var(--background-sec));
        border-radius: var(--radius-xl);
        padding: 1.25rem;
        transition: var(--transition);
        border: 1px solid rgba(11, 44, 93, 0.08);
        box-shadow: var(--shadow-sm);
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
        border-color: var(--primary-light);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: var(--radius-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--primary);
        line-height: 1.2;
    }

    .stat-label {
        font-size: 0.7rem;
        color: var(--text-muted);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .hover-shadow {
        transition: all 0.3s ease;
    }
    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
    .badge {
        font-size: 0.7rem;
        font-weight: 600;
        padding: 0.35rem 0.65rem;
        border-radius: 9999px;
    }
    .table-card {
        border-radius: var(--radius-xl);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
    }
    .table-card .card-header {
        background: linear-gradient(145deg, var(--background-sec), var(--background));
        border-bottom: 2px solid rgba(11, 44, 93, 0.1);
    }
</style>

<div class="container-fluid pe-4">
    <!-- Statistik Ringkas - 4 Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-label">Total Transaksi</div>
                        <div class="stat-value mt-1" id="stat-total">0</div>
                        <small class="text-muted">Semua transaksi</small>
                    </div>
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                        <i class="fas fa-receipt"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-label">Total Deposit</div>
                        <div class="stat-value mt-1 text-success" id="stat-deposit">0</div>
                        <small class="text-muted">Dari semua transaksi</small>
                    </div>
                    <div class="stat-icon bg-success bg-opacity-10 text-success">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-label">Sedang Dipinjam</div>
                        <div class="stat-value mt-1 text-info" id="stat-dipinjam">0</div>
                        <small class="text-muted">Transaksi aktif</small>
                    </div>
                    <div class="stat-icon bg-info bg-opacity-10 text-info">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-label">Pendapatan Selesai</div>
                        <div class="stat-value mt-1 text-primary" id="stat-pendapatan">0</div>
                        <small class="text-muted">Transaksi selesai</small>
                    </div>
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Transaksi -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 table-card">
                <div class="card-header border-bottom pb-0">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div>
                            <h6 class="fw-bold text-primary mb-0">
                                <i class="fas fa-list me-2"></i> Daftar Transaksi
                            </h6>
                            <p class="text-sm text-muted mt-1 mb-0">Kelola dan pantau semua transaksi peminjaman</p>
                        </div>
                        <div>
                            <button type="button" class="btn btn-sm btn-outline-primary" id="btn-export">
                                <i class="fas fa-download me-1"></i> Export Data
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body px-0 py-0">
                    <!-- Filter Section -->
                    <div class="border-bottom py-3 px-3 bg-light">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-2">
                                <label class="form-label text-xs fw-bold text-muted">Status</label>
                                <select name="status" id="filter-status" class="form-select form-select-sm">
                                    <option value="all">Semua Status</option>
                                    @foreach($statusList as $value => $label)
                                    <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label text-xs fw-bold text-muted">Metode</label>
                                <select name="metode_pembayaran" id="filter-metode" class="form-select form-select-sm">
                                    <option value="all">Semua Metode</option>
                                    @foreach($metodePembayaranList as $value => $label)
                                    <option value="{{ $value }}" {{ request('metode_pembayaran') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label text-xs fw-bold text-muted">Dari Tgl</label>
                                <input type="date" id="filter-start-date" class="form-control form-control-sm" value="{{ request('start_date') }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label text-xs fw-bold text-muted">Sampai Tgl</label>
                                <input type="date" id="filter-end-date" class="form-control form-control-sm" value="{{ request('end_date') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-xs fw-bold text-muted">Pencarian</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-white border-end-0">
                                        <i class="fas fa-search text-muted"></i>
                                    </span>
                                    <input type="text" id="search-input" class="form-control border-start-0 ps-0"
                                           placeholder="Cari kode, nama, email, telepon..."
                                           value="{{ request('search') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead class="bg-gray-100">
                                <tr class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    <th class="px-3">Kode Transaksi</th>
                                    <th class="px-3">Peminjam</th>
                                    <th class="px-3">Produk</th>
                                    <th class="px-3 text-end">Total</th>
                                    <th class="px-3 text-end">Deposit</th>
                                    <th class="px-3 text-center">Status</th>
                                    <th class="px-3 text-center">Tanggal</th>
                                    <th class="px-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="transaksi-data">
                                @include('admin.transaksi.table')
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="border-top py-3 px-3 bg-light">
                        <div class="d-flex justify-content-end">
                            {{ $transaksis->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Transaksi -->
<div class="modal fade" id="transaksiDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-file-invoice me-2"></i> Detail Transaksi
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal-transaksi-content">
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(function () {
    let debounceTimer;

    function loadStats() {
        $.ajax({
            url: "{{ route('admin.transaksi.stats') }}",
            type: "GET",
            success: function(response) {
                $('#stat-total').text(response.stats.total.toLocaleString('id-ID'));
                $('#stat-dipinjam').text(response.stats.dipinjam.toLocaleString('id-ID'));
                $('#stat-deposit').text('Rp ' + response.stats.total_deposit.toLocaleString('id-ID'));
                $('#stat-pendapatan').text('Rp ' + (response.stats.pendapatan_selesai || 0).toLocaleString('id-ID'));
            },
            error: function() {
                console.error('Failed to load stats');
            }
        });
    }

    function fetchTransaksi(url = "{{ route('admin.transaksi.index') }}") {
        let search = $('#search-input').val();
        let status = $('#filter-status').val();
        let metode = $('#filter-metode').val();
        let startDate = $('#filter-start-date').val();
        let endDate = $('#filter-end-date').val();

        $.ajax({
            url: url,
            type: "GET",
            data: {
                search: search,
                status: status,
                metode_pembayaran: metode,
                start_date: startDate,
                end_date: endDate
            },
            success: function (response) {
                $('#transaksi-data').html(response);
            },
            error: function (xhr) {
                console.error(xhr.responseText);
            }
        });
    }

    loadStats();

    $('#search-input').on('keyup', function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => fetchTransaksi(), 400);
    });

    $('#filter-status, #filter-metode, #filter-start-date, #filter-end-date').on('change', function () {
        fetchTransaksi();
    });

    $('#search-input').on('keypress', function(e) {
        if (e.which == 13) {
            e.preventDefault();
            fetchTransaksi();
        }
    });

    $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();
        let url = $(this).attr('href');
        fetchTransaksi(url);
    });

    $(document).on('click', '.btn-view-transaksi', function(e) {
        e.preventDefault();
        let url = $(this).data('url');

        $('#transaksiDetailModal').modal('show');

        $.ajax({
            url: url,
            type: "GET",
            success: function(response) {
                $('#modal-transaksi-content').html(response);
            },
            error: function() {
                $('#modal-transaksi-content').html(`
                    <div class="text-center py-5 text-danger">
                        <i class="fas fa-exclamation-circle fa-3x mb-3"></i>
                        <p>Gagal memuat data transaksi</p>
                    </div>
                `);
            }
        });
    });

    $('#btn-export').on('click', function() {
        let url = "{{ route('admin.transaksi.export') }}";
        let params = new URLSearchParams({
            status: $('#filter-status').val(),
            metode_pembayaran: $('#filter-metode').val(),
            start_date: $('#filter-start-date').val(),
            end_date: $('#filter-end-date').val(),
            search: $('#search-input').val()
        });
        window.location.href = url + '?' + params.toString();
    });
});
</script>
@endsection
