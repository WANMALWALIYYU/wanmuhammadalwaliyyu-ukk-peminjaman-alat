{{-- resources/views/admin/pengembalian/index.blade.php --}}
@extends('admin.index')

@section('title', 'Pengembalian')
@section('page-title', 'Monitoring Pengembalian')
@section('breadcrumb', 'Pengembalian')

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

    /* Section Cards */
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

    .status-menunggu_pengiriman { background: #fffbeb; color: #b45309; }
    .status-dikirim { background: #eff6ff; color: #1e40af; }
    .status-sampai { background: #f5f3ff; color: #5b21b6; }
    .status-diproses { background: #fff7ed; color: #c2410c; }
    .status-selesai { background: #ecfdf5; color: #047857; }
    .status-dibatalkan { background: #f8fafc; color: #475569; }

    /* Button Styles */
    .btn-filter-white {
        background-color: white;
        border: 1px solid #dee2e6;
        transition: var(--transition);
    }

    .btn-filter-white:hover {
        background-color: var(--primary-light);
        color: white;
        border-color: var(--primary-light);
    }

    .btn-check:checked + .btn-filter-white {
        background-color: var(--primary);
        color: white;
        border-color: var(--primary);
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

    /* Responsive */
    @media (max-width: 1200px) {
        .stats-cards-row1 {
            grid-template-columns: repeat(2, 1fr);
        }
        .stats-cards-row2 {
            grid-template-columns: repeat(2, 1fr);
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
            <i class="fas fa-undo-alt"></i>
            Monitoring Pengembalian
        </h1>
        <p>
            <i class="fas fa-chart-simple"></i>
            <span>Kelola dan pantau semua pengembalian barang peminjaman alat medis</span>
        </p>

        <!-- BARIS PERTAMA: 4 KOLOM (Total, Menunggu Kirim, Dikirim, Barang Sampai) -->
        <div class="stats-cards-row1">
            <!-- Total Pengembalian -->
            <div class="stat-card-modern">
                <div class="stat-icon-modern">
                    <i class="fas fa-undo-alt"></i>
                </div>
                <div class="stat-info-modern">
                    <div class="stat-value-modern" id="stat-total">{{ $stats['total'] }}</div>
                    <div class="stat-label-modern">Total Pengembalian</div>
                    <small>Semua proses pengembalian</small>
                </div>
            </div>

            <!-- Menunggu Pengiriman -->
            <div class="stat-card-modern">
                <div class="stat-icon-modern">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-info-modern">
                    <div class="stat-value-modern" id="stat-menunggu">{{ $stats['menunggu_pengiriman'] }}</div>
                    <div class="stat-label-modern">Menunggu Pengiriman</div>
                    <small>Perlu konfirmasi resi</small>
                </div>
            </div>

            <!-- Dikirim -->
            <div class="stat-card-modern">
                <div class="stat-icon-modern">
                    <i class="fas fa-truck"></i>
                </div>
                <div class="stat-info-modern">
                    <div class="stat-value-modern" id="stat-dikirim">{{ $stats['dikirim'] }}</div>
                    <div class="stat-label-modern">Dalam Pengiriman</div>
                    <small>Barang sedang dikirim</small>
                </div>
            </div>

            <!-- Barang Sampai -->
            <div class="stat-card-modern">
                <div class="stat-icon-modern">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stat-info-modern">
                    <div class="stat-value-modern" id="stat-sampai">{{ $stats['sampai'] }}</div>
                    <div class="stat-label-modern">Barang Sampai</div>
                    <small>Menunggu pengecekan</small>
                </div>
            </div>
        </div>

        <!-- BARIS KEDUA: 3 KOLOM (Diproses, Selesai, Dibatalkan) -->
        <div class="stats-cards-row2">
            <!-- Diproses -->
            <div class="financial-card">
                <div class="label">
                    <i class="fas fa-clipboard-list me-1"></i> SEDANG DIPROSES
                </div>
                <div class="value" id="stat-diproses">{{ $stats['diproses'] }}</div>
                <div class="trend">
                    <i class="fas fa-spinner"></i> Pengecekan barang
                </div>
            </div>

            <!-- Selesai -->
            <div class="financial-card">
                <div class="label">
                    <i class="fas fa-check-circle me-1"></i> SELESAI
                </div>
                <div class="value" id="stat-selesai">{{ $stats['selesai'] }}</div>
                <div class="trend">
                    <i class="fas fa-check-double"></i> Pengembalian lengkap
                </div>
            </div>

            <!-- Dibatalkan -->
            <div class="financial-card">
                <div class="label">
                    <i class="fas fa-ban me-1"></i> DIBATALKAN
                </div>
                <div class="value" id="stat-dibatalkan">{{ $stats['dibatalkan'] }}</div>
                <div class="trend">
                    <i class="fas fa-hourglass-half"></i> Perlu perhatian
                </div>
            </div>
        </div>
    </div>

    <!-- TABEL UTAMA (Pengembalian Aktif) -->
    <div class="section-card">
        <div class="section-header">
            <h3><i class="fas fa-list me-2"></i> Daftar Pengembalian</h3>
            <a href="{{ route('admin.pengembalian.export') }}" class="btn btn-sm btn-success btn-icon d-flex align-items-center">
                <i class="fa-solid fa-download me-2"></i>
                <span>Export CSV</span>
            </a>
        </div>

        <div class="section-body p-0">
            <!-- Filter Section -->
            <div class="border-bottom py-3 px-4 bg-light">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <!-- Filter Status -->
                    <div class="btn-group flex-wrap" role="group">
                        <input type="radio" class="btn-check" name="statusFilter" id="statusAll" value="all" autocomplete="off" checked>
                        <label class="btn btn-filter-white px-3 mb-0" for="statusAll">Semua</label>

                        <input type="radio" class="btn-check" name="statusFilter" id="statusMenunggu" value="menunggu_pengiriman" autocomplete="off">
                        <label class="btn btn-filter-white px-3 mb-0" for="statusMenunggu">Menunggu Kirim</label>

                        <input type="radio" class="btn-check" name="statusFilter" id="statusDikirim" value="dikirim" autocomplete="off">
                        <label class="btn btn-filter-white px-3 mb-0" for="statusDikirim">Dikirim</label>

                        <input type="radio" class="btn-check" name="statusFilter" id="statusSampai" value="sampai" autocomplete="off">
                        <label class="btn btn-filter-white px-3 mb-0" for="statusSampai">Sampai</label>

                        <input type="radio" class="btn-check" name="statusFilter" id="statusDiproses" value="diproses" autocomplete="off">
                        <label class="btn btn-filter-white px-3 mb-0" for="statusDiproses">Diproses</label>

                        <input type="radio" class="btn-check" name="statusFilter" id="statusSelesai" value="selesai" autocomplete="off">
                        <label class="btn btn-filter-white px-3 mb-0" for="statusSelesai">Selesai</label>
                    </div>

                    <!-- Date Range -->
                    <div class="d-flex gap-2">
                        <input type="date" id="date_from" class="form-control form-control-sm" placeholder="Dari Tanggal" style="width: 140px;">
                        <input type="date" id="date_to" class="form-control form-control-sm" placeholder="Sampai Tanggal" style="width: 140px;">
                    </div>

                    <!-- Search -->
                    <div class="input-group" style="width: 280px;">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" id="search-input" class="form-control border-start-0"
                               placeholder="Cari transaksi / peminjam..."
                               value="{{ request('search') }}">
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="text-secondary text-xs font-weight-semibold opacity-7 px-3">No / Kode Transaksi</th>
                            <th class="text-secondary text-xs font-weight-semibold opacity-7 px-3">Peminjam</th>
                            <th class="text-secondary text-xs font-weight-semibold opacity-7 px-3">Tanggal Pengajuan</th>
                            <th class="text-secondary text-xs font-weight-semibold opacity-7 px-3">Kurir / Resi</th>
                            <th class="text-secondary text-xs font-weight-semibold opacity-7 px-3 text-center">Status</th>
                            <th class="text-secondary text-xs font-weight-semibold opacity-7 px-3 text-center">Biaya Tambahan</th>
                            <th class="text-secondary text-center text-xs font-weight-semibold opacity-7 px-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="pengembalian-data">
                        @include('admin.pengembalian.table')
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="border-top py-3 px-4 bg-light">
                <div class="d-flex justify-content-end">
                    {{ $pengembalians->appends(request()->query())->links() }}
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

    function fetchPengembalian(url = "{{ route('admin.pengembalian.index') }}") {
        let search = $('#search-input').val();
        let status = $('input[name="statusFilter"]:checked').val();
        let dateFrom = $('#date_from').val();
        let dateTo = $('#date_to').val();

        $.ajax({
            url: url,
            type: "GET",
            data: {
                search: search,
                status: status === 'all' ? '' : status,
                date_from: dateFrom,
                date_to: dateTo
            },
            success: function (response) {
                $('#pengembalian-data').html(response);
            },
            error: function (xhr) {
                console.error(xhr.responseText);
            }
        });
    }

    // Debounce search
    $('#search-input').on('keyup', function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => fetchPengembalian(), 400);
    });

    // Filter status
    $('input[name="statusFilter"]').on('change', function () {
        fetchPengembalian();
    });

    // Date range filter
    $('#date_from, #date_to').on('change', function () {
        fetchPengembalian();
    });

    // Enter key
    $('#search-input').on('keypress', function(e) {
        if (e.which == 13) {
            e.preventDefault();
            fetchPengembalian();
        }
    });

    // Pagination AJAX
    $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();
        let url = $(this).attr('href');
        fetchPengembalian(url);
    });
});
</script>
@endsection
