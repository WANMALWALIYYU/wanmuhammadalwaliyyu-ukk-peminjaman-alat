@extends('petugas.index')

@section('title', 'Manajemen Pengembalian')

@section('content')
<div class="container-fluid">
    <!-- Header - SAME STYLE AS DASHBOARD -->
    <div class="dashboard-header">
        <h1>
            <i class="fas fa-undo-alt"></i>
            Manajemen Pengembalian
        </h1>
        <p>
            <i class="fas fa-box"></i>
            <span>Kelola dan proses pengembalian barang dari peminjam</span>
        </p>

        <!-- Stats Cards - EXACT SAME AS DASHBOARD -->
        <div class="stats-cards">
            <div class="stat-card-modern">
                <div class="stat-icon-modern info">
                    <i class="fas fa-truck"></i>
                </div>
                <div class="stat-info-modern">
                    <div class="stat-value-modern">{{ $stats['dikirim'] ?? 0 }}</div>
                    <div class="stat-label-modern">Dalam Pengiriman</div>
                    <small>Barang sedang dikirim</small>
                </div>
            </div>

            <div class="stat-card-modern">
                <div class="stat-icon-modern primary">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stat-info-modern">
                    <div class="stat-value-modern">{{ $stats['sampai'] ?? 0 }}</div>
                    <div class="stat-label-modern">Barang Sampai</div>
                    <small>Menunggu pemeriksaan</small>
                </div>
            </div>

            <div class="stat-card-modern">
                <div class="stat-icon-modern secondary">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div class="stat-info-modern">
                    <div class="stat-value-modern">{{ $stats['diproses'] ?? 0 }}</div>
                    <div class="stat-label-modern">Diproses</div>
                    <small>Sedang diperiksa</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card shadow-sm border-0" data-aos="fade-up">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="mb-0 fw-bold">
                <i class="fas fa-filter text-primary me-2"></i>
                Filter Pengembalian
            </h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('petugas.pengembalian.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="dikirim" {{ request('status') == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                        <option value="sampai" {{ request('status') == 'sampai' ? 'selected' : '' }}>Sampai</option>
                        <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
                <div class="col-md-5">
                    <label class="form-label fw-semibold">Cari</label>
                    <input type="text" name="search" class="form-control" placeholder="Kode transaksi / Nama peminjam" value="{{ request('search') }}">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary btn-modern me-2">
                        <i class="fas fa-search me-1"></i> Filter
                    </button>
                    <a href="{{ route('petugas.pengembalian.index') }}" class="btn btn-secondary btn-modern">
                        <i class="fas fa-sync-alt me-1"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card shadow-sm border-0" data-aos="fade-up" data-aos-delay="100">
        <div class="card-header bg-white border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-list-alt text-primary me-2"></i>
                    Daftar Pengembalian
                </h5>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-modern" id="pengembalianTable">
                    <thead>
                        <tr>
                            <th><i class="fas fa-barcode me-1"></i> Kode Transaksi</th>
                            <th><i class="fas fa-user me-1"></i> Peminjam</th>
                            <th><i class="fas fa-calendar me-1"></i> Tgl Pengajuan</th>
                            <th><i class="fas fa-shipping-fast me-1"></i> Kurir/Resi</th>
                            <th><i class="fas fa-tag me-1"></i> Status</th>
                            <th><i class="fas fa-cog me-1"></i> Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengembalians as $pengembalian)
                        <tr data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                            <td>
                                <span class="fw-bold text-primary">{{ $pengembalian->transaksi->kode_transaksi }}</span>
                                <br>
                                <small class="text-muted">{{ $pengembalian->created_at->format('d M Y H:i') }}</small>
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $pengembalian->transaksi->nama_lengkap }}</div>
                                <small class="text-muted">{{ $pengembalian->transaksi->email }}</small>
                            </td>
                            <td>{{ $pengembalian->created_at->format('d M Y H:i') }}</td>
                            <td>
                                @if($pengembalian->kurir_pengembalian)
                                    <span class="fw-semibold">{{ $pengembalian->kurir_pengembalian }}</span>
                                    <br>
                                    <small class="text-muted">{{ $pengembalian->no_resi_pengembalian }}</small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="status-cell">{!! $pengembalian->status_badge !!}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('petugas.pengembalian.show', $pengembalian->id) }}"
                                       class="btn btn-sm btn-modern text-dark">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>

                                    @if($pengembalian->status == 'dikirim')
                                    <a href="{{ route('petugas.pengembalian.show', $pengembalian->id) }}"
                                       class="btn btn-sm btn-primary btn-modern">
                                        <i class="fas fa-check-double"></i> Terima
                                    </a>
                                    @endif

                                    @if($pengembalian->status == 'sampai')
                                    <a href="{{ route('petugas.pengembalian.pemeriksaan', $pengembalian->id) }}"
                                       class="btn btn-sm btn-warning btn-modern">
                                        <i class="fas fa-clipboard-check"></i> Periksa
                                    </a>
                                    @endif

                                    @if($pengembalian->status == 'diproses')
                                    <form action="{{ route('petugas.pengembalian.complete', $pengembalian->id) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menyelesaikan proses pengembalian? Pastikan sudah memeriksa barang pengembalian.')">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success btn-modern">
                                            <i class="fas fa-check-double"></i> Selesai
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">
                                <i class="fas fa-inbox fa-4x mb-3 d-block text-muted"></i>
                                <p class="mb-0">Belum ada data pengembalian</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 py-3">
            <div class="pagination-wrapper">
                {{ $pengembalians->links() }}
            </div>
        </div>
    </div>
</div>

<style>
    /* ===============================
       HEADER & STATS CARDS - EXACT SAME AS DASHBOARD
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

    /* Stats Cards - EXACT SAME AS DASHBOARD */
    .stats-cards {
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

    .stat-icon-modern.info {
        color: #6ee7b7;
    }

    .stat-icon-modern.primary {
        color: #93c5fd;
    }

    .stat-icon-modern.secondary {
        color: #c4b5fd;
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

    /* Table Modern Styles */
    .table-modern {
        width: 100%;
        border-collapse: collapse;
    }

    .table-modern th {
        padding: 1rem;
        background: #f8fafc;
        font-weight: 700;
        color: #475569;
        border-bottom: 2px solid #e2e8f0;
    }

    .table-modern td {
        padding: 1rem;
        border-bottom: 1px solid #e2e8f0;
        vertical-align: middle;
    }

    .table-modern tbody tr:hover {
        background-color: #f8fafc;
        transition: background-color 0.2s ease;
    }

    /* Button Modern */
    .btn-modern {
        border-radius: 0.5rem;
        padding: 0.375rem 0.75rem;
        transition: all 0.2s ease;
    }

    .btn-modern:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    /* Pagination */
    .pagination-wrapper {
        margin-top: 0;
        text-align: center;
    }

    .pagination-wrapper .pagination {
        justify-content: center;
        margin-bottom: 0;
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

        .btn-group {
            flex-direction: column;
            gap: 0.25rem;
        }
    }

    @media (max-width: 480px) {
        .stats-cards {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection
