@extends('admin.index')
@section('title', 'Transaksi')
@section('page-title', 'Manajemen Transaksi')
@section('breadcrumb', 'Transaksi')
@section('content-dashboard')

<style>
    /* ===============================
       VARIABLES & RESET - MODERN ENHANCED
       =============================== */
    :root {
        --primary: #0b2c5d;
        --primary-dark: #081f3f;
        --primary-light: #1f3c88;
        --primary-soft: #e8f0fe;
        --secondary: #1f3c88;
        --secondary-soft: #f0f5ff;
        --accent-green: #10b981;
        --accent-blue: #3b82f6;
        --accent-orange: #f59e0b;
        --accent-red: #ef4444;
        --accent-purple: #8b5cf6;
        --accent-teal: #14b8a6;
        --background: #ffffff;
        --background-sec: #f8fafc;
        --text-color: #0f172a;
        --text-color-sec: #334155;
        --text-muted: #64748b;
        --gray-light: #e2e8f0;
        --gray: #94a3b8;
        --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        --radius-sm: 0.5rem;
        --radius-md: 1rem;
        --radius-lg: 1.5rem;
        --radius-xl: 2rem;
        --radius-full: 9999px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .dashboard-container {
        padding: 0;
    }

    /* Header Section - Background Biru */
    .dashboard-header {
        background: linear-gradient(145deg, var(--primary), var(--primary-light));
        border-radius: var(--radius-xl);
        padding: 2rem;
        margin-bottom: 2rem;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .dashboard-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: rotate 20s linear infinite;
    }

    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .dashboard-header h1 {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .dashboard-header p {
        font-size: 1rem;
        opacity: 0.9;
        position: relative;
        z-index: 1;
        margin-bottom: 1.5rem;
    }

    /* Stats Cards - Row 1: 4 Columns */
    .stats-cards-row1 {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
        position: relative;
        z-index: 2;
        margin-bottom: 1.5rem;
    }

    /* Stats Cards - Row 2: 3 Columns */
    .stats-cards-row2 {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
        position: relative;
        z-index: 2;
    }

    .stat-card-modern {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-radius: var(--radius-xl);
        padding: 1.25rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        transition: var(--transition);
        border: 1px solid rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        gap: 1rem;
        position: relative;
        overflow: hidden;
    }

    .stat-card-modern::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background: linear-gradient(90deg, rgba(255,255,255,0.8), var(--accent-green), rgba(255,255,255,0.8));
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.4s ease;
    }

    .stat-card-modern:hover::after {
        transform: scaleX(1);
    }

    .stat-card-modern:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
        background: rgba(255, 255, 255, 0.25);
    }

    .stat-icon-modern {
        width: 56px;
        height: 56px;
        border-radius: var(--radius-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        background: rgba(255, 255, 255, 0.2);
        flex-shrink: 0;
    }

    .stat-info-modern {
        flex: 1;
    }

    .stat-value-modern {
        font-size: 1.8rem;
        font-weight: 800;
        color: white;
        line-height: 1.2;
        margin-bottom: 0.25rem;
    }

    .stat-label-modern {
        font-size: 0.75rem;
        color: rgba(255, 255, 255, 0.9);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.25rem;
    }

    .stat-info-modern small {
        font-size: 0.65rem;
        color: rgba(255, 255, 255, 0.7);
        display: block;
    }

    /* Financial Cards - khusus untuk baris ke-2 */
    .financial-card {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-radius: var(--radius-xl);
        padding: 1.25rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        transition: var(--transition);
        border: 1px solid rgba(255, 255, 255, 0.2);
        position: relative;
        overflow: hidden;
        text-align: center;
    }

    .financial-card::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background: linear-gradient(90deg, rgba(255,255,255,0.8), var(--accent-blue), rgba(255,255,255,0.8));
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.4s ease;
    }

    .financial-card:hover::after {
        transform: scaleX(1);
    }

    .financial-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
        background: rgba(255, 255, 255, 0.25);
    }

    .financial-card .label {
        font-size: 0.7rem;
        color: rgba(255, 255, 255, 0.8);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }

    .financial-card .value {
        font-size: 1.5rem;
        font-weight: 800;
        color: white;
        line-height: 1.2;
        margin-bottom: 0.25rem;
    }

    .financial-card .trend {
        font-size: 0.65rem;
        color: rgba(255, 255, 255, 0.7);
        margin-top: 0.5rem;
    }

    .trend-up { color: #4ade80; }
    .trend-down { color: #f87171; }

    /* Section Cards - untuk konten di bawah header */
    .section-card {
        background: var(--background);
        border-radius: var(--radius-xl);
        margin-bottom: 1.5rem;
        overflow: hidden;
        box-shadow: var(--shadow-md);
        border: 1px solid rgba(11, 44, 93, 0.08);
        transition: var(--transition);
    }

    .section-card:hover {
        box-shadow: var(--shadow-lg);
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.25rem 1.5rem;
        background: linear-gradient(145deg, var(--background-sec), var(--background));
        border-bottom: 2px solid var(--primary-soft);
        flex-wrap: wrap;
        gap: 1rem;
    }

    .section-header h3 {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--primary);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-body {
        padding: 1.5rem;
    }

    /* Stats Grid - 5 Columns for key metrics */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 1rem;
    }

    .stat-item {
        background: linear-gradient(145deg, var(--background-sec), var(--background));
        border-radius: var(--radius-lg);
        padding: 1rem;
        text-align: center;
        transition: var(--transition);
        border: 1px solid var(--gray-light);
    }

    .stat-item:hover {
        transform: translateY(-3px);
        border-color: var(--primary-soft);
        box-shadow: var(--shadow-md);
    }

    .stat-item-value {
        font-size: 1.6rem;
        font-weight: 800;
        color: var(--primary);
    }

    .stat-item-label {
        font-size: 0.7rem;
        color: var(--text-muted);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Status Badges */
    .status-badge {
        padding: 0.3rem 0.8rem;
        border-radius: var(--radius-full);
        font-size: 0.7rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }

    .status-menunggu_persetujuan { background: #fffbeb; color: #b45309; }
    .status-disetujui { background: #eff6ff; color: #1e40af; }
    .status-ditolak { background: #fef2f2; color: #b91c1c; }
    .status-dikirim { background: #fff7ed; color: #c2410c; }
    .status-dipinjam { background: #f5f3ff; color: #5b21b6; }
    .status-dikembalikan { background: #ecfdf5; color: #047857; }
    .status-selesai { background: #ecfdf5; color: #047857; }
    .status-dibatalkan { background: #f8fafc; color: #475569; }

    /* Responsive */
    @media (max-width: 1200px) {
        .stats-cards-row1 {
            grid-template-columns: repeat(2, 1fr);
        }
        .stats-cards-row2 {
            grid-template-columns: repeat(2, 1fr);
        }
        .stats-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 768px) {
        .dashboard-header {
            padding: 1.5rem;
        }
        .stats-cards-row1 {
            grid-template-columns: 1fr;
        }
        .stats-cards-row2 {
            grid-template-columns: 1fr;
        }
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .stat-value-modern {
            font-size: 1.4rem;
        }
        .financial-card .value {
            font-size: 1.3rem;
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .stat-card-modern,
    .financial-card {
        animation: fadeInUp 0.5s ease forwards;
    }

    /* Table Styles */
    .table-card {
        border-radius: var(--radius-xl);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
    }

    .table-card .card-header {
        background: linear-gradient(145deg, var(--background-sec), var(--background));
        border-bottom: 2px solid rgba(11, 44, 93, 0.1);
    }

    .table thead th {
        font-size: 0.65rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--text-muted);
        border-bottom: 1px solid var(--gray-light);
    }

    .btn-view-transaksi {
        transition: var(--transition);
    }

    .btn-view-transaksi:hover {
        transform: translateY(-2px);
    }
</style>

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

<div class="dashboard-container">
    <!-- HEADER DENGAN BACKGROUND BIRU - SEMUA CARD DI DALAMNYA -->
    <div class="dashboard-header">
        <h1>
            <i class="fas fa-receipt"></i>
            Manajemen Transaksi
        </h1>
        <p>
            <i class="fas fa-chart-simple"></i>
            <span>Kelola dan pantau semua transaksi peminjaman alat medis</span>
        </p>

        <!-- BARIS PERTAMA: 4 KOLOM (Total Transaksi, Menunggu Persetujuan, Sedang Dipinjam, Selesai) -->
        <div class="stats-cards-row1">
            <!-- Total Transaksi -->
            <div class="stat-card-modern">
                <div class="stat-icon-modern">
                    <i class="fas fa-receipt"></i>
                </div>
                <div class="stat-info-modern">
                    <div class="stat-value-modern" id="stat-total">0</div>
                    <div class="stat-label-modern">Total Transaksi</div>
                    <small>Semua transaksi</small>
                </div>
            </div>

            <!-- Menunggu Persetujuan -->
            <div class="stat-card-modern">
                <div class="stat-icon-modern">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-info-modern">
                    <div class="stat-value-modern" id="stat-menunggu">0</div>
                    <div class="stat-label-modern">Menunggu Persetujuan</div>
                    <small>Perlu verifikasi admin</small>
                </div>
            </div>

            <!-- Sedang Dipinjam -->
            <div class="stat-card-modern">
                <div class="stat-icon-modern">
                    <i class="fas fa-hand-holding-heart"></i>
                </div>
                <div class="stat-info-modern">
                    <div class="stat-value-modern" id="stat-dipinjam">0</div>
                    <div class="stat-label-modern">Sedang Dipinjam</div>
                    <small>Transaksi aktif</small>
                </div>
            </div>

            <!-- Selesai -->
            <div class="stat-card-modern">
                <div class="stat-icon-modern">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info-modern">
                    <div class="stat-value-modern" id="stat-selesai">0</div>
                    <div class="stat-label-modern">Selesai</div>
                    <small>Transaksi selesai</small>
                </div>
            </div>
        </div>

        <!-- BARIS KEDUA: 3 KOLOM (Total Deposit, Total Pendapatan, Deposit Tertahan) -->
        <div class="stats-cards-row2">
            <!-- Total Deposit Terkumpul -->
            <div class="financial-card">
                <div class="label">
                    <i class="fas fa-money-bill-wave me-1"></i> TOTAL DEPOSIT TERKUMPUL
                </div>
                <div class="value" id="stat-deposit">Rp 0</div>
                <div class="trend">
                    <i class="fas fa-database"></i> Dari semua transaksi
                </div>
            </div>

            <!-- Total Pendapatan -->
            <div class="financial-card">
                <div class="label">
                    <i class="fas fa-chart-line me-1"></i> TOTAL PENDAPATAN
                </div>
                <div class="value" id="stat-pendapatan">Rp 0</div>
                <div class="trend">
                    <i class="fas fa-check-circle"></i> Transaksi selesai
                </div>
            </div>

            <!-- Dibatalkan -->
            <div class="financial-card">
                <div class="label">
                    <i class="fas fa-ban me-1"></i> TRANSAKSI DIBATALKAN
                </div>
                <div class="value" id="stat-dibatalkan">0</div>
                <div class="trend">
                    <i class="fas fa-hourglass-half"></i> Perlu perhatian
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
                $('#stat-menunggu').text(response.stats.menunggu.toLocaleString('id-ID'));
                $('#stat-dipinjam').text(response.stats.dipinjam.toLocaleString('id-ID'));
                $('#stat-selesai').text(response.stats.selesai.toLocaleString('id-ID'));
                $('#stat-dibatalkan').text(response.stats.dibatalkan.toLocaleString('id-ID'));
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
        loadStats();
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
