@extends('admin.index')
@section('title', 'Pengiriman')
@section('page-title', 'Pengiriman')
@section('breadcrumb', 'Pengiriman')
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

    .status-sent {
        background: #fff7ed;
        color: #c2410c;
    }

    .status-delivered {
        background: #ecfdf5;
        color: #047857;
    }

    /* Table Styles */
    .table-card {
        border-radius: var(--radius-xl);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
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
    }

    @media (max-width: 768px) {
        .dashboard-header {
            padding: 1.5rem;
        }
        .stats-cards-row1 {
            grid-template-columns: 1fr;
        }
        .stat-value-modern {
            font-size: 1.4rem;
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

    .stat-card-modern {
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
            <i class="fas fa-truck"></i>
            Manajemen Pengiriman
        </h1>
        <p>
            <i class="fas fa-chart-simple"></i>
            <span>Kelola dan pantau semua pengiriman barang peminjaman alat medis</span>
        </p>

        <!-- BARIS PERTAMA: 4 KOLOM -->
        <div class="stats-cards-row1">
            <!-- Total Pengiriman -->
            <div class="stat-card-modern">
                <div class="stat-icon-modern">
                    <i class="fas fa-truck"></i>
                </div>
                <div class="stat-info-modern">
                    <div class="stat-value-modern" id="total-pengiriman">-</div>
                    <div class="stat-label-modern">Total Pengiriman</div>
                    <small>Semua proses pengiriman</small>
                </div>
            </div>

            <!-- Dalam Perjalanan -->
            <div class="stat-card-modern">
                <div class="stat-icon-modern">
                    <i class="fas fa-truck-moving"></i>
                </div>
                <div class="stat-info-modern">
                    <div class="stat-value-modern" id="in-progress">-</div>
                    <div class="stat-label-modern">Dalam Perjalanan</div>
                    <small>Barang sedang dikirim</small>
                </div>
            </div>

            <!-- Selesai -->
            <div class="stat-card-modern">
                <div class="stat-icon-modern">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info-modern">
                    <div class="stat-value-modern" id="completed">-</div>
                    <div class="stat-label-modern">Selesai</div>
                    <small>Pengiriman selesai</small>
                </div>
            </div>

            <!-- Hari Ini -->
            <div class="stat-card-modern">
                <div class="stat-icon-modern">
                    <i class="fas fa-calendar-day"></i>
                </div>
                <div class="stat-info-modern">
                    <div class="stat-value-modern" id="today">-</div>
                    <div class="stat-label-modern">Pengiriman Hari Ini</div>
                    <small>Dikirim hari ini</small>
                </div>
            </div>
        </div>
    </div>

    <!-- GRAFIK PENGIRIMAN -->
    <div class="section-card">
        <div class="section-header">
            <h3><i class="fas fa-chart-line me-2"></i> Grafik Pengiriman (7 Hari Terakhir)</h3>
        </div>
        <div class="section-body">
            <canvas id="deliveryChart" style="height: 300px; width: 100%;"></canvas>
        </div>
    </div>

    <!-- TABEL UTAMA -->
    <div class="section-card">
        <div class="section-header">
            <h3><i class="fas fa-list me-2"></i> Daftar Pengiriman</h3>
            <button type="button" class="btn btn-sm btn-success btn-icon d-flex align-items-center" id="export-btn">
                <i class="fa-solid fa-download me-2"></i>
                <span>Export CSV</span>
            </button>
        </div>

        <div class="section-body p-0">
            <!-- Filter Section -->
            <div class="border-bottom py-3 px-4 bg-light">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <!-- Filter Status -->
                    <div class="d-flex align-items-center gap-2">
                        <label class="form-label text-xs fw-bold text-muted mb-0">Status:</label>
                        <select id="status-filter" class="form-select form-select-sm" style="width: 180px;">
                            <option value="">Semua Status</option>
                            <option value="sent">Dalam Perjalanan</option>
                            <option value="delivered">Selesai</option>
                        </select>
                    </div>

                    <!-- Search -->
                    <div class="input-group" style="width: 300px;">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" id="search-input" class="form-control border-start-0"
                               placeholder="Cari kode transaksi / nama..."
                               value="{{ request('search') }}">
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="text-secondary text-xs font-weight-semibold opacity-7 px-3">ID / Kode</th>
                            <th class="text-secondary text-xs font-weight-semibold opacity-7 px-3">Peminjam</th>
                            <th class="text-secondary text-xs font-weight-semibold opacity-7 px-3">Tanggal Kirim</th>
                            <th class="text-secondary text-xs font-weight-semibold opacity-7 px-3">Tanggal Sampai</th>
                            <th class="text-secondary text-xs font-weight-semibold opacity-7 px-3">Petugas</th>
                            <th class="text-secondary text-xs font-weight-semibold opacity-7 px-3 text-center">Status</th>
                            <th class="text-secondary text-center text-xs font-weight-semibold opacity-7 px-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="pengiriman-data">
                        @include('admin.pengiriman.table')
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="border-top py-3 px-4 bg-light">
                <div class="d-flex justify-content-end">
                    {{ $pengirimans->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(function () {
    let debounceTimer;
    let deliveryChart;

    // Load statistics
    function loadStats() {
        $.ajax({
            url: "{{ route('admin.pengiriman.stats') }}",
            type: "GET",
            success: function(response) {
                if (response.success) {
                    $('#total-pengiriman').text(response.data.total);
                    $('#in-progress').text(response.data.in_progress);
                    $('#completed').text(response.data.completed);
                    $('#today').text(response.data.today);
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    }

    // Load chart data
    function loadChart() {
        $.ajax({
            url: "{{ route('admin.pengiriman.chart') }}",
            type: "GET",
            success: function(response) {
                if (response.success) {
                    const labels = response.data.map(item => item.date);
                    const sentData = response.data.map(item => item.sent);
                    const deliveredData = response.data.map(item => item.delivered);

                    if (deliveryChart) {
                        deliveryChart.destroy();
                    }

                    const ctx = document.getElementById('deliveryChart').getContext('2d');
                    deliveryChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [
                                {
                                    label: 'Dikirim',
                                    data: sentData,
                                    borderColor: '#f59e0b',
                                    backgroundColor: 'rgba(245, 158, 11, 0.1)',
                                    tension: 0.4,
                                    fill: true,
                                    pointBackgroundColor: '#f59e0b',
                                    pointBorderColor: '#fff',
                                    pointBorderWidth: 2,
                                    pointRadius: 4,
                                    pointHoverRadius: 6
                                },
                                {
                                    label: 'Selesai',
                                    data: deliveredData,
                                    borderColor: '#10b981',
                                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                                    tension: 0.4,
                                    fill: true,
                                    pointBackgroundColor: '#10b981',
                                    pointBorderColor: '#fff',
                                    pointBorderWidth: 2,
                                    pointRadius: 4,
                                    pointHoverRadius: 6
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'top',
                                    labels: {
                                        usePointStyle: true,
                                        boxWidth: 10
                                    }
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            let label = context.dataset.label || '';
                                            let value = context.raw;
                                            return label + ': ' + value + ' pengiriman';
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        stepSize: 1,
                                        precision: 0
                                    },
                                    title: {
                                        display: true,
                                        text: 'Jumlah Pengiriman',
                                        font: { weight: 'bold', size: 12 }
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Tanggal',
                                        font: { weight: 'bold', size: 12 }
                                    }
                                }
                            }
                        }
                    });
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    }

    // Fetch table data
    function fetchPengiriman(url = "{{ route('admin.pengiriman.index') }}") {
        let search = $('#search-input').val();
        let status = $('#status-filter').val();

        $.ajax({
            url: url,
            type: "GET",
            data: {
                search: search,
                status: status
            },
            success: function(response) {
                $('#pengiriman-data').html(response);
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    }

    // Debounce search
    $('#search-input').on('keyup', function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => fetchPengiriman(), 400);
    });

    // Status filter change
    $('#status-filter').on('change', function () {
        fetchPengiriman();
    });

    // Enter key
    $('#search-input').on('keypress', function(e) {
        if (e.which == 13) {
            e.preventDefault();
            fetchPengiriman();
        }
    });

    // Pagination AJAX
    $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();
        let url = $(this).attr('href');
        fetchPengiriman(url);
    });

    // Export button
    $('#export-btn').on('click', function() {
        let status = $('#status-filter').val();
        let url = "{{ route('admin.pengiriman.export') }}";
        if (status) {
            url += '?status=' + status;
        }
        window.location.href = url;
    });

    // View detail
    $(document).on('click', '.btn-view', function(e) {
        e.preventDefault();
        let url = $(this).data('url');
        if (url) {
            window.location.href = url;
        }
    });

    // Initial load
    loadStats();
    loadChart();
    fetchPengiriman();
});
</script>
@endsection
