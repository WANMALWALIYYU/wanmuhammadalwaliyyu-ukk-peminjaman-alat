@extends('petugas.index')

@section('title', 'Dashboard Petugas')

@section('content')
<div class="container-fluid">
    <!-- Header with Stats Cards - SAME AS transaksi/riwayat -->
    <div class="dashboard-header">
        <h1>
            <i class="fas fa-chart-line"></i>
            Dashboard Petugas
        </h1>
        <p>
            <i class="fas fa-box"></i>
            <span>Statistik real-time semua peminjaman alat medis</span>
        </p>

        <div class="stats-cards">
            <div class="stat-card-modern">
                <div class="stat-icon-modern blue">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-info-modern">
                    <div class="stat-value-modern" id="stat-menunggu">{{ $total_menunggu ?? 0 }}</div>
                    <div class="stat-label-modern">Menunggu Persetujuan</div>
                    <small>Perlu verifikasi segera</small>
                </div>
            </div>

            <div class="stat-card-modern">
                <div class="stat-icon-modern green">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info-modern">
                    <div class="stat-value-modern" id="stat-disetujui">{{ $total_disetujui ?? 0 }}</div>
                    <div class="stat-label-modern">Disetujui</div>
                    <small>Menunggu pengiriman</small>
                </div>
            </div>

            <div class="stat-card-modern">
                <div class="stat-icon-modern primary">
                    <i class="fas fa-truck"></i>
                </div>
                <div class="stat-info-modern">
                    <div class="stat-value-modern" id="stat-dikirim">{{ $total_dikirim ?? 0 }}</div>
                    <div class="stat-label-modern">Dikirim</div>
                    <small>Dalam perjalanan</small>
                </div>
            </div>

            <div class="stat-card-modern">
                <div class="stat-icon-modern purple">
                    <i class="fas fa-hand-holding-medical"></i>
                </div>
                <div class="stat-info-modern">
                    <div class="stat-value-modern" id="stat-dipinjam">{{ $total_dipinjam ?? 0 }}</div>
                    <div class="stat-label-modern">Sedang Dipinjam</div>
                    <small>Aktif dipinjam</small>
                </div>
            </div>

            <div class="stat-card-modern">
                <div class="stat-icon-modern orange">
                    <i class="fas fa-undo-alt"></i>
                </div>
                <div class="stat-info-modern">
                    <div class="stat-value-modern" id="stat-dikembalikan">{{ $total_dikembalikan ?? 0 }}</div>
                    <div class="stat-label-modern">Dikembalikan</div>
                    <small>Menunggu pengecekan</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="card shadow-sm border-0" data-aos="fade-up" data-aos-delay="100">
        <div class="card-header bg-white border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-history text-primary me-2"></i>
                    Transaksi Terbaru
                </h5>
                <a href="{{ route('petugas.peminjaman') }}" class="btn btn-primary btn-modern">
                    Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-modern" id="recentTransactionsTable">
                    <thead>
                        <tr>
                            <th><i class="fas fa-barcode me-1"></i> Kode Transaksi</th>
                            <th><i class="fas fa-user me-1"></i> Peminjam</th>
                            <th><i class="fas fa-calendar me-1"></i> Tanggal</th>
                            <th><i class="fas fa-money-bill me-1"></i> Deposit</th>
                            <th><i class="fas fa-tag me-1"></i> Status</th>
                            <th><i class="fas fa-cog me-1"></i> Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="recentTransactionsBody">
                        @forelse($transaksi_terbaru ?? [] as $transaksi)
                        <tr data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}" data-transaksi-id="{{ $transaksi->id }}">
                            <td>
                                <span class="fw-bold text-primary">{{ $transaksi->kode_transaksi }}</span>
                                <br>
                                <small class="text-muted">{{ $transaksi->created_at->translatedFormat('d M Y H:i') }}</small>
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $transaksi->nama_lengkap }}</div>
                                <small class="text-muted">{{ $transaksi->email }}</small>
                            </td>
                            <td>{{ $transaksi->created_at->translatedFormat('d M Y') }}</td>
                            <td class="fw-bold text-success">Rp {{ number_format($transaksi->jumlah_deposit, 0, ',', '.') }}</td>
                            <td class="status-cell">{!! $transaksi->status_badge !!}</td>
                            <td>
                                <a href="{{ route('petugas.peminjaman.detail', $transaksi->id) }}"
                                    class="btn btn-sm btn-outline-primary btn-modern">
                                        <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">
                                <i class="fas fa-inbox fa-4x mb-3 d-block text-muted"></i>
                                <p class="mb-0">Belum ada transaksi</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    /* ===============================
       HEADER & STATS CARDS - EXACT SAME AS transaksi/riwayat
       =============================== */
    .dashboard-header {
        background: linear-gradient(145deg, #0b2c5d, #1f3c88);
        border-radius: 1.5rem;
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

    /* Stats Cards - EXACT SAME AS transaksi/riwayat */
    .stats-cards {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 1.5rem;
        position: relative;
        z-index: 2;
    }

    .stat-card-modern {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-radius: 1.5rem;
        padding: 1.5rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        gap: 1rem;
        position: relative;
        overflow: hidden;
    }

    .stat-card-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
        pointer-events: none;
    }

    .stat-card-modern::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background: linear-gradient(90deg, rgba(255,255,255,0.8), #10b981, rgba(255,255,255,0.8));
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.4s ease;
    }

    .stat-card-modern:hover::after {
        transform: scaleX(1);
    }

    .stat-card-modern:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
        background: rgba(255, 255, 255, 0.2);
        border-color: rgba(255, 255, 255, 0.35);
    }

    .stat-icon-modern {
        width: 60px;
        height: 60px;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        transition: transform 0.2s;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(4px);
    }

    .stat-card-modern:hover .stat-icon-modern {
        transform: scale(1.05);
    }

    .stat-icon-modern.blue {
        color: #90cdf4;
    }

    .stat-icon-modern.green {
        color: #6ee7b7;
    }

    .stat-icon-modern.orange {
        color: #fcd34d;
    }

    .stat-icon-modern.purple {
        color: #c4b5fd;
    }

    .stat-icon-modern.primary {
        color: #93c5fd;
    }

    .stat-info-modern {
        flex: 1;
    }

    .stat-value-modern {
        font-size: 1.9rem;
        font-weight: 800;
        color: white;
        line-height: 1.2;
        letter-spacing: -0.02em;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .stat-label-modern {
        font-size: 0.85rem;
        color: rgba(255, 255, 255, 0.9);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .stat-info-modern small {
        font-size: 0.7rem;
        color: rgba(255, 255, 255, 0.7);
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .stats-cards {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 768px) {
        .dashboard-header {
            padding: 1.5rem;
        }

        .dashboard-header h1 {
            font-size: 1.5rem;
        }

        .stats-cards {
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .stat-card-modern {
            padding: 1rem;
        }

        .stat-icon-modern {
            width: 50px;
            height: 50px;
            font-size: 1.4rem;
        }

        .stat-value-modern {
            font-size: 1.5rem;
        }

        .stat-label-modern {
            font-size: 0.7rem;
        }
    }

    @media (max-width: 480px) {
        .stats-cards {
            grid-template-columns: 1fr;
        }
    }

    /* Animation */
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

@push('scripts')
<script>
// Data sudah langsung tampil dari server, tidak perlu delay
// Hanya untuk real-time update (opsional)

let pollingInterval = null;
let isPageVisible = true;

// Function to update stats with smooth animation
function updateStatValue($element, newValue) {
    const currentValue = parseInt($element.text()) || 0;
    if (currentValue !== newValue) {
        $({ count: currentValue }).animate({ count: newValue }, {
            duration: 400,
            easing: 'swing',
            step: function() {
                $element.text(Math.floor(this.count));
            },
            complete: function() {
                $element.text(newValue);
            }
        });
    }
}

// Function to refresh dashboard stats (only for real-time updates)
function refreshDashboardStats() {
    if (!isPageVisible) return;

    $.ajax({
        url: '{{ route("petugas.dashboard.stats") }}',
        type: 'GET',
        dataType: 'json',
        timeout: 10000,
        success: function(response) {
            // Update stat values with animation only if changed
            if (response.total_menunggu !== undefined) {
                updateStatValue($('#stat-menunggu'), response.total_menunggu);
            }
            if (response.total_disetujui !== undefined) {
                updateStatValue($('#stat-disetujui'), response.total_disetujui);
            }
            if (response.total_dipinjam !== undefined) {
                updateStatValue($('#stat-dipinjam'), response.total_dipinjam);
            }
            if (response.total_dikembalikan !== undefined) {
                updateStatValue($('#stat-dikembalikan'), response.total_dikembalikan);
            }
            if (response.total_dikirim !== undefined) {
                updateStatValue($('#stat-dikirim'), response.total_dikirim);
            }
        },
        error: function(xhr) {
            console.error('Failed to refresh dashboard stats:', xhr);
        }
    });
}

// Start polling for real-time updates (every 15 seconds)
function startPolling() {
    if (pollingInterval) {
        clearInterval(pollingInterval);
    }
    pollingInterval = setInterval(() => {
        refreshDashboardStats();
    }, 15000);
}

// Stop polling
function stopPolling() {
    if (pollingInterval) {
        clearInterval(pollingInterval);
        pollingInterval = null;
    }
}

// Handle page visibility
document.addEventListener('visibilitychange', function() {
    isPageVisible = !document.hidden;
    if (isPageVisible) {
        // Refresh immediately when page becomes visible
        refreshDashboardStats();
        startPolling();
    } else {
        stopPolling();
    }
});

$(document).ready(function() {
    // Stats already displayed from server, no initial fetch needed

    // Start polling for real-time updates
    startPolling();

    // Cleanup on page unload
    $(window).on('beforeunload', function() {
        stopPolling();
    });
});
</script>
@endpush
@endsection
