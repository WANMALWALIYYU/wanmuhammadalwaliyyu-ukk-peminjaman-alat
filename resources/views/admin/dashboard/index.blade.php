@extends('admin.index')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('breadcrumb', 'Dashboard')
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

    /* Product & User List Items */
    .list-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.75rem 0;
        border-bottom: 1px solid var(--gray-light);
    }

    .list-item:last-child {
        border-bottom: none;
    }

    .item-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .item-avatar {
        width: 40px;
        height: 40px;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--primary-soft);
        color: var(--primary);
    }

    .item-name {
        font-weight: 600;
        font-size: 0.85rem;
        color: var(--text-color);
    }

    .item-sub {
        font-size: 0.7rem;
        color: var(--text-muted);
    }

    .item-count {
        font-weight: 700;
        color: var(--primary);
        font-size: 0.85rem;
    }

    /* Button */
    .btn-link-custom {
        color: var(--primary);
        text-decoration: none;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        transition: var(--transition);
    }

    .btn-link-custom:hover {
        color: var(--primary-dark);
        transform: translateX(3px);
    }

    /* 3 Columns Layout */
    .dashboard-three-columns {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

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
        .dashboard-three-columns {
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
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .dashboard-three-columns {
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

    .section-card {
        animation: fadeInUp 0.5s ease forwards;
        animation-delay: 0.2s;
    }
</style>

<div class="dashboard-container">
    <!-- HEADER DENGAN BACKGROUND BIRU - SEMUA CARD DI DALAMNYA -->
    <div class="dashboard-header">
        <h1>
            <i class="fas fa-chart-line"></i>
            Admin Dashboard
        </h1>
        <p>
            <i class="fas fa-chart-simple"></i>
            <span>Ringkasan data real-time sistem peminjaman alat medis</span>
        </p>

        <!-- BARIS PERTAMA: 4 KOLOM (Total Produk, Total Transaksi, Sedang Dipinjam, Total Pengguna) -->
        <div class="stats-cards-row1">
            <!-- Total Produk -->
            <div class="stat-card-modern">
                <div class="stat-icon-modern">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stat-info-modern">
                    <div class="stat-value-modern">{{ $totalProduk }}</div>
                    <div class="stat-label-modern">Total Produk</div>
                    <small>Tersedia: {{ $produkTersedia }} | Dipinjam: {{ $produkDipinjam }}</small>
                </div>
            </div>

            <!-- Total Transaksi -->
            <div class="stat-card-modern">
                <div class="stat-icon-modern">
                    <i class="fas fa-file-invoice"></i>
                </div>
                <div class="stat-info-modern">
                    <div class="stat-value-modern">{{ $totalTransaksi }}</div>
                    <div class="stat-label-modern">Total Transaksi</div>
                    <small>Aktif: {{ $transaksiAktif }} | Selesai: {{ $transaksiSelesai }}</small>
                </div>
            </div>

            <!-- Sedang Dipinjam -->
            <div class="stat-card-modern">
                <div class="stat-icon-modern">
                    <i class="fas fa-hand-holding-heart"></i>
                </div>
                <div class="stat-info-modern">
                    <div class="stat-value-modern">{{ $transaksiDipinjam }}</div>
                    <div class="stat-label-modern">Sedang Dipinjam</div>
                    <small>Terlambat: {{ $transaksiTerlambat }}</small>
                </div>
            </div>

            <!-- Total Pengguna -->
            <div class="stat-card-modern">
                <div class="stat-icon-modern">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info-modern">
                    <div class="stat-value-modern">{{ $totalUsers }}</div>
                    <div class="stat-label-modern">Total Pengguna</div>
                    <small>Online: {{ $usersOnline }} | Baru: {{ $userBaruBulanIni }}</small>
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
                <div class="value">Rp {{ number_format($totalDeposit, 0, ',', '.') }}</div>
                <div class="trend">
                    <i class="fas fa-database"></i> Dari semua transaksi aktif
                </div>
            </div>

            <!-- Total Pendapatan -->
            <div class="financial-card">
                <div class="label">
                    <i class="fas fa-chart-line me-1"></i> TOTAL PENDAPATAN
                </div>
                <div class="value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                <div class="trend">
                    @if($pendapatanGrowth > 0)
                        <span class="trend-up"><i class="fas fa-arrow-up"></i> +{{ number_format($pendapatanGrowth, 1) }}%</span>
                    @elseif($pendapatanGrowth < 0)
                        <span class="trend-down"><i class="fas fa-arrow-down"></i> {{ number_format($pendapatanGrowth, 1) }}%</span>
                    @else
                        <span><i class="fas fa-minus"></i> 0%</span>
                    @endif
                    dari bulan lalu
                </div>
            </div>

            <!-- Deposit Tertahan -->
            <div class="financial-card">
                <div class="label">
                    <i class="fas fa-clock me-1"></i> DEPOSIT TERTAHAN
                </div>
                <div class="value">Rp {{ number_format($depositTertahan, 0, ',', '.') }}</div>
                <div class="trend">
                    <i class="fas fa-hourglass-half"></i> Menunggu pelunasan
                </div>
            </div>
        </div>
    </div>

    <!-- KONTEN DI BAWAH HEADER (Card Putih) -->

    <!-- Stats Grid - Produk Details -->
    <div class="section-card">
        <div class="section-header">
            <h3><i class="fas fa-boxes"></i> Detail Produk</h3>
            <a href="{{ route('produk.index') }}" class="btn-link-custom">
                Lihat Semua <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        <div class="section-body">
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-item-value">{{ $produkBaru }}</div>
                    <div class="stat-item-label">Produk Baru</div>
                </div>
                <div class="stat-item">
                    <div class="stat-item-value">{{ $produkBekas }}</div>
                    <div class="stat-item-label">Produk Bekas</div>
                </div>
                <div class="stat-item">
                    <div class="stat-item-value">{{ $produkRusak }}</div>
                    <div class="stat-item-label">Produk Rusak</div>
                </div>
                <div class="stat-item">
                    <div class="stat-item-value">{{ $produkStokMenipis }}</div>
                    <div class="stat-item-label">Stok Menipis (≤3)</div>
                </div>
                <div class="stat-item">
                    <div class="stat-item-value">{{ $produkHabis }}</div>
                    <div class="stat-item-label">Stok Habis</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid - Transaksi Status Details -->
    <div class="section-card">
        <div class="section-header">
            <h3><i class="fas fa-chart-pie"></i> Detail Status Transaksi</h3>
            <a href="{{ route('admin.transaksi.index') }}" class="btn-link-custom">
                Kelola Transaksi <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        <div class="section-body">
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-item-value">{{ $transaksiDisetujui }}</div>
                    <div class="stat-item-label">Disetujui</div>
                </div>
                <div class="stat-item">
                    <div class="stat-item-value">{{ $transaksiDikirim }}</div>
                    <div class="stat-item-label">Dikirim</div>
                </div>
                <div class="stat-item">
                    <div class="stat-item-value">{{ $transaksiDipinjam }}</div>
                    <div class="stat-item-label">Dipinjam</div>
                </div>
                <div class="stat-item">
                    <div class="stat-item-value">{{ $transaksiDikembalikan }}</div>
                    <div class="stat-item-label">Dikembalikan</div>
                </div>
                <div class="stat-item">
                    <div class="stat-item-value">{{ $transaksiSelesai }}</div>
                    <div class="stat-item-label">Selesai</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="section-card">
        <div class="section-header">
            <h3><i class="fas fa-chart-line"></i> Statistik Transaksi & Pendapatan (7 Hari Terakhir)</h3>
        </div>
        <div class="section-body">
            <canvas id="transactionChart" height="300"></canvas>
        </div>
    </div>

    <!-- 3 Columns Layout -->
    <div class="dashboard-three-columns">
        <!-- Produk Terpopuler -->
        <div class="section-card">
            <div class="section-header">
                <h3><i class="fas fa-fire"></i> Produk Terpopuler</h3>
                <a href="{{ route('produk.index') }}" class="btn-link-custom">
                    Lihat Semua <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="section-body">
                @forelse($produkTerpopuler as $produk)
                <div class="list-item">
                    <div class="item-info">
                        @if($produk->gambar)
                            <img src="{{ asset('storage/' . $produk->gambar) }}" class="item-avatar" style="object-fit: cover;" alt="{{ $produk->nama_produk }}">
                        @else
                            <div class="item-avatar">
                                <i class="fas fa-box"></i>
                            </div>
                        @endif
                        <div>
                            <div class="item-name">{{ $produk->nama_produk }}</div>
                            <div class="item-sub">{{ $produk->kode_produk }}</div>
                        </div>
                    </div>
                    <div class="item-count">
                        {{ $produk->detail_transaksis_count }}x dipinjam
                    </div>
                </div>
                @empty
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-inbox fa-2x mb-2"></i>
                    <p>Belum ada data produk</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- User Teraktif -->
        <div class="section-card">
            <div class="section-header">
                <h3><i class="fas fa-users"></i> User Teraktif</h3>
                <a href="{{ route('user.index') }}" class="btn-link-custom">
                    Kelola User <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="section-body">
                @forelse($userTeraktif as $user)
                <div class="list-item">
                    <div class="item-info">
                        <div class="item-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <div class="item-name">{{ $user->name }}</div>
                            <div class="item-sub">{{ $user->email }}</div>
                        </div>
                    </div>
                    <div class="item-count">
                        {{ $user->transaksis_count }} transaksi
                    </div>
                </div>
                @empty
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-inbox fa-2x mb-2"></i>
                    <p>Belum ada data user</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Transaksi Terbaru -->
        <div class="section-card">
            <div class="section-header">
                <h3><i class="fas fa-history"></i> Transaksi Terbaru</h3>
                <a href="{{ route('admin.transaksi.index') }}" class="btn-link-custom">
                    Lihat Semua <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="section-body">
                @forelse($transaksiTerbaru->take(5) as $transaksi)
                <div class="list-item">
                    <div class="item-info">
                        <div class="item-avatar">
                            <i class="fas fa-receipt"></i>
                        </div>
                        <div>
                            <div class="item-name">{{ $transaksi->kode_transaksi }}</div>
                            <div class="item-sub">{{ $transaksi->nama_lengkap }}</div>
                        </div>
                    </div>
                    <div>
                        <span class="status-badge status-{{ $transaksi->status }}">
                            @php
                                $statusIcon = [
                                    'menunggu_persetujuan' => 'fa-clock',
                                    'disetujui' => 'fa-check-circle',
                                    'ditolak' => 'fa-ban',
                                    'dikirim' => 'fa-truck',
                                    'dipinjam' => 'fa-hand-holding-medical',
                                    'dikembalikan' => 'fa-undo-alt',
                                    'selesai' => 'fa-check-double',
                                    'dibatalkan' => 'fa-times-circle'
                                ];
                                $statusText = [
                                    'menunggu_persetujuan' => 'Menunggu',
                                    'disetujui' => 'Disetujui',
                                    'ditolak' => 'Ditolak',
                                    'dikirim' => 'Dikirim',
                                    'dipinjam' => 'Dipinjam',
                                    'dikembalikan' => 'Dikembalikan',
                                    'selesai' => 'Selesai',
                                    'dibatalkan' => 'Dibatalkan'
                                ];
                            @endphp
                            <i class="fas {{ $statusIcon[$transaksi->status] ?? 'fa-info-circle' }}"></i>
                            {{ $statusText[$transaksi->status] ?? ucfirst(str_replace('_', ' ', $transaksi->status)) }}
                        </span>
                    </div>
                </div>
                @empty
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-inbox fa-2x mb-2"></i>
                    <p>Belum ada transaksi</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('transactionChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartData['labels']) !!},
            datasets: [
                {
                    label: 'Jumlah Transaksi',
                    data: {!! json_encode($chartData['transaksi']) !!},
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true,
                    yAxisID: 'y'
                },
                {
                    label: 'Pendapatan (Rp)',
                    data: {!! json_encode($chartData['pendapatan']) !!},
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.4,
                    fill: true,
                    yAxisID: 'y1'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
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
                            if (context.dataset.label === 'Pendapatan (Rp)') {
                                return label + ': Rp ' + value.toLocaleString('id-ID');
                            }
                            return label + ': ' + value + ' transaksi';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah Transaksi',
                        font: { weight: 'bold' }
                    }
                },
                y1: {
                    position: 'right',
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Pendapatan (Rp)',
                        font: { weight: 'bold' }
                    },
                    ticks: {
                        callback: function(value) {
                            if (value >= 1000000) {
                                return 'Rp ' + (value / 1000000).toFixed(1) + 'jt';
                            }
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    },
                    grid: {
                        drawOnChartArea: false
                    }
                }
            }
        }
    });
});
</script>
@endpush

@endsection
