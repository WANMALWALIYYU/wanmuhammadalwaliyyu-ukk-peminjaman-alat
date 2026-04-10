@extends('index')
@section('pages', 'Riwayat Transaksi')
@section('content')

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

    .riwayat-container {
        max-width: 1400px;
        margin: 2rem auto;
        padding: 0 1.5rem;
    }

    /* ========= HEADER SECTION ========= */
    .riwayat-header {
        background: linear-gradient(145deg, var(--primary), var(--primary-light));
        border-radius: var(--radius-xl);
        padding: 2rem;
        margin-bottom: 2rem;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .riwayat-header::before {
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

    .riwayat-header h1 {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .riwayat-header p {
        font-size: 1rem;
        opacity: 0.9;
        position: relative;
        z-index: 1;
        margin-bottom: 1.5rem;
    }

    /* ========= STATS CARDS - 2 BARIS x 3 KOLOM ========= */
    .stats-grid {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        position: relative;
        z-index: 2;
    }

    .stats-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
    }

    .stat-card-modern {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(12px);
        border-radius: var(--radius-xl);
        padding: 1.5rem;
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
        transform: translateY(-6px);
        background: rgba(255, 255, 255, 0.2);
    }

    .stat-icon-modern {
        width: 60px;
        height: 60px;
        border-radius: var(--radius-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(4px);
    }

    .stat-icon-modern.blue { color: #90cdf4; }
    .stat-icon-modern.green { color: #6ee7b7; }
    .stat-icon-modern.orange { color: #fcd34d; }
    .stat-icon-modern.purple { color: #c4b5fd; }
    .stat-icon-modern.red { color: #fca5a5; }
    .stat-icon-modern.cyan { color: #67e8f9; }
    .stat-icon-modern.pink { color: #f9a8d4; }

    .stat-info-modern { flex: 1; }
    .stat-value-modern { font-size: 1.9rem; font-weight: 800; color: white; line-height: 1.2; }
    .stat-label-modern { font-size: 0.85rem; color: rgba(255, 255, 255, 0.9); font-weight: 600; text-transform: uppercase; }
    .stat-info-modern small { font-size: 0.7rem; color: rgba(255, 255, 255, 0.7); }

    /* ========= FILTER SECTION ========= */
    .filter-section {
        background: var(--background);
        border-radius: var(--radius-lg);
        padding: 1.25rem 1.5rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-md);
        border: 1px solid rgba(11, 44, 93, 0.08);
    }

    .filter-wrapper {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        align-items: flex-end;
    }

    .filter-group {
        flex: 1;
        min-width: 180px;
    }

    .filter-group label {
        display: block;
        font-size: 0.7rem;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }

    .filter-select-modern {
        width: 100%;
        padding: 0.7rem 1rem;
        border: 1px solid var(--gray-light);
        border-radius: var(--radius-md);
        font-size: 0.85rem;
        font-weight: 500;
        color: var(--text-color);
        background: var(--background-sec);
        cursor: pointer;
        transition: var(--transition);
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2364748b'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 1.2rem;
    }

    .filter-select-modern:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(11, 44, 93, 0.1);
    }

    .search-group {
        flex: 2;
        min-width: 250px;
    }

    .search-wrapper-modern {
        display: flex;
        gap: 0.5rem;
    }

    .search-wrapper-modern input {
        flex: 1;
        padding: 0.7rem 1rem;
        border: 1px solid var(--gray-light);
        border-radius: var(--radius-md);
        font-size: 0.85rem;
        background: var(--background-sec);
        transition: var(--transition);
    }

    .search-wrapper-modern input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(11, 44, 93, 0.1);
    }

    .btn-search-modern {
        padding: 0.7rem 1.5rem;
        background: var(--primary);
        border: none;
        border-radius: var(--radius-md);
        color: white;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
    }

    .btn-search-modern:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
    }

    .btn-reset-modern {
        padding: 0.7rem 1.2rem;
        background: #fef2f2;
        border: none;
        border-radius: var(--radius-md);
        color: var(--accent-red);
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
    }

    .btn-reset-modern:hover {
        background: var(--accent-red);
        color: white;
    }

    /* ========= TRANSACTION CARD ========= */
    .transaction-card {
        background: var(--background);
        border-radius: var(--radius-xl);
        margin-bottom: 1.5rem;
        overflow: hidden;
        box-shadow: var(--shadow-md);
        transition: var(--transition);
        border: 1px solid rgba(11, 44, 93, 0.08);
    }

    .transaction-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow-lg);
    }

    /* Card Header */
    .card-header-transaction {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.25rem 1.5rem;
        background: linear-gradient(145deg, var(--background-sec), var(--background));
        border-bottom: 2px solid var(--primary-soft);
        flex-wrap: wrap;
        gap: 1rem;
    }

    .transaction-info {
        display: flex;
        align-items: center;
        gap: 2rem;
        flex-wrap: wrap;
    }

    .transaction-code {
        font-weight: 800;
        font-size: 0.9rem;
        color: var(--primary);
        background: var(--primary-soft);
        padding: 0.4rem 1.2rem;
        border-radius: var(--radius-full);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-family: monospace;
    }

    .transaction-date {
        color: var(--text-muted);
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 500;
    }

    /* Status Badge */
    .status-badge {
        padding: 0.45rem 1.2rem;
        border-radius: var(--radius-full);
        font-size: 0.75rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .status-menunggu_persetujuan { background: #fffbeb; color: #b45309; border-left: 3px solid #f59e0b; }
    .status-disetujui { background: #eff6ff; color: #1e40af; border-left: 3px solid #3b82f6; }
    .status-ditolak { background: #fef2f2; color: #b91c1c; border-left: 3px solid #ef4444; }
    .status-dikirim { background: #fff7ed; color: #c2410c; border-left: 3px solid #f97316; }
    .status-dipinjam { background: #f5f3ff; color: #5b21b6; border-left: 3px solid #8b5cf6; }
    .status-dikembalikan { background: #ecfdf5; color: #047857; border-left: 3px solid #10b981; }
    .status-selesai { background: #ecfdf5; color: #047857; border-left: 3px solid #10b981; }
    .status-dibatalkan { background: #f8fafc; color: #475569; border-left: 3px solid #94a3b8; }

    /* Card Body - Layout Baru: FOTO KIRI, INFO KANAN */
    .card-body-transaction {
        padding: 1.5rem;
    }

    .product-item-row {
        display: flex;
        gap: 1.5rem;
        background: var(--background-sec);
        border-radius: var(--radius-lg);
        margin-bottom: 1.25rem;
        overflow: hidden;
        transition: var(--transition);
        border: 1px solid var(--gray-light);
    }

    .product-item-row:last-child {
        margin-bottom: 0;
    }

    .product-item-row:hover {
        transform: translateX(5px);
        box-shadow: var(--shadow-md);
        border-color: var(--primary-soft);
    }

    .product-image-wrapper {
        width: 180px;
        flex-shrink: 0;
        background: var(--gray-light);
        position: relative;
        overflow: hidden;
    }

    .product-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .product-item-row:hover .product-image-wrapper img {
        transform: scale(1.05);
    }


    @keyframes pulse {
        0%, 100% { opacity: 1; transform: scale(1); box-shadow: 0 0 0 0 rgba(239,68,68,0.4); }
        50% { opacity: 0.9; transform: scale(1.02); box-shadow: 0 0 0 6px rgba(239,68,68,0); }
    }

    .product-info-wrapper {
        flex: 1;
        padding: 1.25rem 1.25rem 1.25rem 0;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .product-title-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .product-title-row h3 {
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--text-color);
        margin: 0;
    }

    .product-code-badge {
        font-size: 0.65rem;
        color: var(--text-muted);
        background: var(--gray-light);
        padding: 0.2rem 0.6rem;
        border-radius: var(--radius-full);
        font-weight: 600;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.6rem;
        background: white;
        padding: 0.75rem;
        border-radius: var(--radius-md);
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.8rem;
    }

    .info-item i {
        width: 24px;
        color: var(--primary);
        font-size: 0.9rem;
    }

    .info-item .label {
        color: var(--text-muted);
        font-weight: 500;
    }

    .info-item .value {
        font-weight: 700;
        color: var(--text-color);
    }

    .date-range-row {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 1rem;
        background: var(--primary-soft);
        padding: 0.6rem 1rem;
        border-radius: var(--radius-md);
    }

    .date-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .date-item i {
        color: var(--primary);
    }

    .duration-pill {
        background: var(--primary);
        color: white;
        padding: 0.2rem 0.8rem;
        border-radius: var(--radius-full);
        font-size: 0.7rem;
        font-weight: 700;
        margin-left: auto;
    }

    .price-row {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        padding-top: 0.5rem;
        border-top: 2px dashed var(--gray-light);
    }

    .price-label {
        font-size: 0.75rem;
        color: var(--text-muted);
        font-weight: 500;
    }

    .price-total {
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--accent-green);
    }

    .late-warning-row {
        background: #fff0f0;
        border-left: 4px solid var(--accent-red);
        padding: 0.5rem 1rem;
        border-radius: var(--radius-sm);
        font-size: 0.7rem;
        font-weight: 600;
        color: #b91c1c;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        width: auto;
    }

    .status-chips {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .status-chip {
        padding: 0.2rem 0.75rem;
        border-radius: var(--radius-full);
        font-size: 0.7rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }

    .status-chip.borrowed {
        background: #ede9fe;
        color: #5b21b6;
    }

    .status-chip.late {
        background: #fee2e2;
        color: #b91c1c;
    }

    .card-footer-transaction {
        padding: 1rem 1.5rem;
        background: var(--background-sec);
        border-top: 1px solid var(--gray-light);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .total-amount {
        display: flex;
        align-items: baseline;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .total-amount .label {
        color: var(--text-muted);
        font-size: 0.85rem;
        font-weight: 500;
    }

    .total-amount .amount {
        font-size: 1.4rem;
        font-weight: 800;
        color: var(--primary);
    }

    .deposit-amount {
        background: var(--primary-soft);
        padding: 0.25rem 0.75rem;
        border-radius: var(--radius-full);
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--primary);
    }

    .action-buttons {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .btn-action {
        padding: 0.5rem 1.2rem;
        border-radius: var(--radius-md);
        font-size: 0.8rem;
        font-weight: 700;
        cursor: pointer;
        transition: var(--transition);
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-detail {
        background: var(--primary-soft);
        color: var(--primary);
    }

    .btn-detail:hover {
        background: var(--primary);
        color: white;
        transform: translateY(-2px);
    }

    .btn-cancel {
        background: #fee2e2;
        color: var(--accent-red);
    }

    .btn-cancel:hover {
        background: var(--accent-red);
        color: white;
    }

    .btn-reapply {
        background: #fffbeb;
        color: #d97706;
    }

    .btn-reapply:hover {
        background: #d97706;
        color: white;
    }

    .btn-track {
        background: #eef2ff;
        color: #2563eb;
    }

    .btn-track:hover {
        background: #2563eb;
        color: white;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: var(--background);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-md);
    }

    .empty-state i {
        font-size: 5rem;
        color: var(--primary-soft);
        margin-bottom: 1rem;
    }

    .empty-state h3 {
        font-size: 1.5rem;
        color: var(--text-color);
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: var(--text-muted);
        margin-bottom: 1.5rem;
    }

    .btn-primary-custom {
        background: var(--primary);
        color: white;
        padding: 0.75rem 2rem;
        border-radius: var(--radius-full);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        transition: var(--transition);
    }

    .btn-primary-custom:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
    }

    .pagination-container {
        margin-top: 2rem;
        display: flex;
        justify-content: center;
    }

    .pagination {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .pagination a, .pagination span {
        padding: 0.5rem 1rem;
        border-radius: var(--radius-md);
        background: var(--background);
        color: var(--text-color);
        text-decoration: none;
        transition: var(--transition);
        border: 1px solid var(--gray-light);
        font-weight: 500;
    }

    .pagination a:hover {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }

    .pagination .active span {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }

    /* Responsive */
    @media (max-width: 992px) {
        .stats-row {
            grid-template-columns: repeat(2, 1fr);
        }
        .product-image-wrapper {
            width: 140px;
        }
    }

    @media (max-width: 768px) {
        .riwayat-container {
            padding: 0 1rem;
        }
        .card-header-transaction {
            flex-direction: column;
            align-items: flex-start;
        }
        .card-footer-transaction {
            flex-direction: column;
            align-items: stretch;
        }
        .action-buttons {
            justify-content: center;
        }
        .filter-wrapper {
            flex-direction: column;
        }
        .filter-group, .search-group {
            width: 100%;
        }
        .stats-row {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        .stats-grid {
            gap: 1rem;
        }
        .product-item-row {
            flex-direction: column;
        }
        .product-image-wrapper {
            width: 100%;
            height: 200px;
        }
        .product-info-wrapper {
            padding: 1rem;
        }
        .info-grid {
            grid-template-columns: 1fr;
        }
        .date-range-row {
            flex-direction: column;
            align-items: flex-start;
        }
        .duration-pill {
            margin-left: 0;
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
    }

    @media (max-width: 480px) {
        .transaction-info {
            gap: 0.75rem;
        }
        .action-buttons {
            flex-wrap: wrap;
        }
        .btn-action {
            flex: 1;
            justify-content: center;
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

    .transaction-card {
        animation: fadeInUp 0.5s ease forwards;
    }

    .stat-card-modern {
        animation: fadeInUp 0.5s ease forwards;
    }

    .product-item-row {
        animation: fadeInUp 0.5s ease forwards;
    }
</style>

<div class="riwayat-container">
    <!-- Header -->
    <div class="riwayat-header">
        <h1>
            <i class="fas fa-history"></i>
            Riwayat Transaksi
        </h1>
        <p>
            <i class="fas fa-box"></i>
            <span>Statistik real-time semua peminjaman alat medis Anda</span>
        </p>

        <!-- Statistics Cards - 2 Baris x 3 Kolom -->
        @php
            $totalSemuaDipinjam = 0;
            $totalMenungguPersetujuan = 0;
            $totalDisetujuiPetugas = 0;
            $totalDikirim = 0;
            $totalSedangDipinjam = 0;
            $totalTerlambat = 0;

            foreach ($transaksis as $transaksi) {
                if (!in_array($transaksi->status, ['dibatalkan', 'ditolak'])) {
                    $totalSemuaDipinjam++;
                }
                if ($transaksi->status == 'menunggu_persetujuan') {
                    $totalMenungguPersetujuan++;
                }
                if ($transaksi->status == 'disetujui') {
                    $totalDisetujuiPetugas++;
                }
                if ($transaksi->status == 'dikirim') {
                    $totalDikirim++;
                }
                if ($transaksi->status == 'dipinjam') {
                    $totalSedangDipinjam++;
                    foreach ($transaksi->detailTransaksis as $detail) {
                        if ($detail->tanggal_selesai < now()->format('Y-m-d')) {
                            $totalTerlambat++;
                            break;
                        }
                    }
                }
            }
        @endphp

        <div class="stats-grid">
            <!-- Baris 1 -->
            <div class="stats-row">
                <div class="stat-card-modern">
                    <div class="stat-icon-modern blue">
                        <i class="fas fa-receipt"></i>
                    </div>
                    <div class="stat-info-modern">
                        <div class="stat-value-modern">{{ $totalSemuaDipinjam }}</div>
                        <div class="stat-label-modern">Total Transaksi</div>
                        <small>Semua peminjaman</small>
                    </div>
                </div>

                <div class="stat-card-modern">
                    <div class="stat-icon-modern orange">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-info-modern">
                        <div class="stat-value-modern">{{ $totalMenungguPersetujuan }}</div>
                        <div class="stat-label-modern">Menunggu Persetujuan</div>
                        <small>Verifikasi petugas</small>
                    </div>
                </div>

                <div class="stat-card-modern">
                    <div class="stat-icon-modern green">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-info-modern">
                        <div class="stat-value-modern">{{ $totalDisetujuiPetugas }}</div>
                        <div class="stat-label-modern">Disetujui Petugas</div>
                        <small>Menunggu dikirim</small>
                    </div>
                </div>
            </div>

            <!-- Baris 2 -->
            <div class="stats-row">
                <div class="stat-card-modern">
                    <div class="stat-icon-modern cyan">
                        <i class="fas fa-truck"></i>
                    </div>
                    <div class="stat-info-modern">
                        <div class="stat-value-modern">{{ $totalDikirim }}</div>
                        <div class="stat-label-modern">Dikirim</div>
                        <small>Dalam pengiriman</small>
                    </div>
                </div>

                <div class="stat-card-modern">
                    <div class="stat-icon-modern purple">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                    <div class="stat-info-modern">
                        <div class="stat-value-modern">{{ $totalSedangDipinjam }}</div>
                        <div class="stat-label-modern">Sedang Dipinjam</div>
                        <small>Barang dipinjam</small>
                    </div>
                </div>

                <div class="stat-card-modern">
                    <div class="stat-icon-modern red">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="stat-info-modern">
                        <div class="stat-value-modern">{{ $totalTerlambat }}</div>
                        <div class="stat-label-modern">Terlambat</div>
                        <small>Melewati batas waktu</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <div class="filter-wrapper">
            <div class="filter-group">
                <label><i class="fas fa-tag me-1"></i> Status Transaksi</label>
                <select class="filter-select-modern" id="statusFilter">
                    <option value="all">Semua Status</option>
                    <option value="menunggu_persetujuan">Menunggu Persetujuan</option>
                    <option value="disetujui">Disetujui</option>
                    <option value="dikirim">Dikirim</option>
                    <option value="dipinjam">Dipinjam</option>
                    <option value="dikembalikan">Dikembalikan</option>
                    <option value="selesai">Selesai</option>
                    <option value="dibatalkan">Dibatalkan</option>
                    <option value="ditolak">Ditolak</option>
                </select>
            </div>

            <div class="search-group">
                <label><i class="fas fa-search me-1"></i> Cari Transaksi</label>
                <div class="search-wrapper-modern">
                    <input type="text" id="searchInput" placeholder="Cari berdasarkan kode transaksi..." autocomplete="off">
                    <button class="btn-search-modern" onclick="filterTransactions()">
                        <i class="fas fa-search"></i> Cari
                    </button>
                    <button class="btn-reset-modern" onclick="resetFilters()">
                        <i class="fas fa-undo-alt"></i> Reset
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction List -->
    <div id="transactionList">
        @forelse($transaksis as $transaksi)
        <div class="transaction-card" data-status="{{ $transaksi->status }}" data-code="{{ strtolower($transaksi->kode_transaksi) }}">
            <!-- Card Header -->
            <div class="card-header-transaction">
                <div class="transaction-info">
                    <div class="transaction-code">
                        <i class="fas fa-receipt"></i>
                        {{ $transaksi->kode_transaksi }}
                    </div>
                    <div class="transaction-date">
                        <i class="far fa-calendar-alt"></i>
                        {{ \Carbon\Carbon::parse($transaksi->tanggal_pengajuan)->format('d M Y, H:i') }}
                    </div>
                    <div class="transaction-date">
                        <i class="fas fa-user"></i>
                        {{ $transaksi->nama_lengkap }}
                    </div>
                </div>
                {{-- <div class="status-badge status-{{ $transaksi->status && $transaksi->pengembalian }}">
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
                            'menunggu_persetujuan' => 'Menunggu Persetujuan',
                            'disetujui' => 'Disetujui Petugas',
                            'ditolak' => 'Ditolak',
                            'dikirim' => 'Dikirim',
                            'dipinjam' => 'Sedang Dipinjam',
                            'dikembalikan' => 'Dikembalikan',
                            'selesai' => 'Selesai',
                            'dibatalkan' => 'Dibatalkan'
                        ];
                    @endphp
                    <i class="fas {{ $statusIcon[$transaksi->status] ?? 'fa-info-circle' }}"></i>
                    {{ $statusText[$transaksi->status] ?? ucfirst(str_replace('_', ' ', $transaksi->status)) }}
                </div> --}}
                {{-- STATUS BADGE --}}
                @php
                    // Tentukan status yang akan ditampilkan
                    $displayStatus = $transaksi->status;
                    $badgeClass = '';

                    // Jika transaksi dalam proses pengembalian (status dikembalikan atau selesai)
                    if (in_array($transaksi->status, ['dikembalikan', 'selesai']) && $transaksi->pengembalian) {
                        // Gunakan status dari pengembalian untuk detail yang lebih akurat
                        $displayStatus = $transaksi->pengembalian->status;
                    }

                    // Mapping status ke class CSS
                    $badgeClassMap = [
                        'menunggu_persetujuan' => 'status-menunggu_persetujuan',
                        'disetujui' => 'status-disetujui',
                        'ditolak' => 'status-ditolak',
                        'dikirim' => 'status-dikirim',
                        'dipinjam' => 'status-dipinjam',
                        'dikembalikan' => 'status-dikembalikan',
                        'selesai' => 'status-selesai',
                        'dibatalkan' => 'status-dibatalkan',
                        // Status dari pengembalian
                        'menunggu_pengiriman' => 'status-menunggu_persetujuan',
                        'sampai' => 'status-disetujui',
                        'diproses' => 'status-dipinjam',
                    ];

                    $badgeClass = $badgeClassMap[$displayStatus] ?? 'status-menunggu_persetujuan';

                    // Mapping icon dan teks
                    $statusIconMap = [
                        'menunggu_persetujuan' => 'fa-clock',
                        'disetujui' => 'fa-check-circle',
                        'ditolak' => 'fa-ban',
                        'dikirim' => 'fa-truck',
                        'dipinjam' => 'fa-hand-holding-medical',
                        'dikembalikan' => 'fa-undo-alt',
                        'selesai' => 'fa-check-double',
                        'dibatalkan' => 'fa-times-circle',
                        // Status dari pengembalian
                        'menunggu_pengiriman' => 'fa-clock',
                        'sampai' => 'fa-box-open',
                        'diproses' => 'fa-clipboard-list',
                    ];

                    $statusTextMap = [
                        'menunggu_persetujuan' => 'Menunggu Persetujuan',
                        'disetujui' => 'Disetujui Petugas',
                        'ditolak' => 'Ditolak',
                        'dikirim' => 'Dikirim',
                        'dipinjam' => 'Sedang Dipinjam',
                        'dikembalikan' => 'Dikembalikan',
                        'selesai' => 'Selesai',
                        'dibatalkan' => 'Dibatalkan',
                        // Status dari pengembalian
                        'menunggu_pengiriman' => 'Menunggu Pengiriman',
                        'sampai' => 'Barang Sampai ke Petugas',
                        'diproses' => 'Sedang Diproses Petugas',
                    ];
                @endphp

                <div class="status-badge {{ $badgeClass }}">
                    <i class="fas {{ $statusIconMap[$displayStatus] ?? 'fa-info-circle' }}"></i>
                    {{ $statusTextMap[$displayStatus] ?? ucfirst(str_replace('_', ' ', $displayStatus)) }}
                </div>
            </div>

            <!-- Card Body -->
            <div class="card-body-transaction">
                @foreach($transaksi->detailTransaksis as $detail)
                @php
                    $isLate = false;
                    $lateDays = 0;
                    if ($transaksi->status == 'dipinjam' && $detail->tanggal_selesai < now()->format('Y-m-d')) {
                        $isLate = true;
                        $lateDays = \Carbon\Carbon::parse($detail->tanggal_selesai)->diffInDays(now());
                    }
                    $isBorrowed = ($transaksi->status == 'dipinjam' && !$isLate);
                @endphp
                <div class="product-item-row">
                    <div class="product-image-wrapper">
                        @if($detail->produk && $detail->produk->gambar)
                            <img src="{{ asset('storage/' . $detail->produk->gambar) }}"
                                 alt="{{ $detail->nama_produk }}"
                                 onerror="this.src='https://via.placeholder.com/180x180/0b2c5d/FFFFFF?text=MEDIK'">
                        @else
                            <img src="https://via.placeholder.com/180x180/0b2c5d/FFFFFF?text=MEDIK"
                                 alt="Product">
                        @endif
                    </div>

                    <div class="product-info-wrapper">
                        <div class="product-title-row">
                            <h3>{{ $detail->nama_produk }}</h3>
                            <span class="product-code-badge">
                                <i class="fas fa-barcode"></i> {{ $detail->produk->kode_produk ?? 'N/A' }}
                            </span>
                        </div>

                        <div class="status-chips">
                            @if($isBorrowed)
                                <span class="status-chip borrowed">
                                    <i class="fas fa-hand-holding-medical"></i> Sedang Dipinjam
                                </span>
                            @endif
                            @if($isLate)
                                <span class="status-chip late">
                                    <i class="fas fa-exclamation-triangle"></i> Terlambat {{ $lateDays }} Hari
                                </span>
                            @endif
                        </div>

                        <div class="info-grid">
                            <div class="info-item">
                                <i class="fas fa-boxes"></i>
                                <span class="label">Jumlah:</span>
                                <span class="value">{{ $detail->jumlah }} unit</span>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-tag"></i>
                                <span class="label">Harga Sewa:</span>
                                <span class="value">Rp {{ number_format($detail->harga_per_hari, 0, ',', '.') }} /hari</span>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-calendar-week"></i>
                                <span class="label">Durasi:</span>
                                <span class="value">{{ $detail->durasi_hari }} hari</span>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-chart-line"></i>
                                <span class="label">Subtotal:</span>
                                <span class="value">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="date-range-row">
                            <div class="date-item">
                                <i class="fas fa-calendar-alt"></i>
                                <span>Mulai: <strong>{{ \Carbon\Carbon::parse($detail->tanggal_mulai)->format('d M Y') }}</strong></span>
                            </div>
                            <div class="date-item">
                                <i class="fas fa-calendar-check"></i>
                                <span>Selesai: <strong>{{ \Carbon\Carbon::parse($detail->tanggal_selesai)->format('d M Y') }}</strong></span>
                            </div>
                            <div class="duration-pill">
                                <i class="fas fa-hourglass-half"></i> {{ $detail->durasi_hari }} Hari
                            </div>
                        </div>

                        @if($isLate)
                            <div class="late-warning-row">
                                <i class="fas fa-exclamation-circle"></i>
                                Telah melewati batas waktu pengembalian! Terlambat {{ $lateDays }} hari.
                            </div>
                        @endif

                        <div class="price-row">
                            <span class="price-label">Total Harga Produk</span>
                            <span class="price-total">
                                Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Card Footer -->
            <div class="card-footer-transaction">
                <div class="total-amount">
                    <span class="label"><i class="fas fa-receipt"></i> Total Transaksi:</span>
                    @php
                        $totalTransaksi = $transaksi->detailTransaksis->sum('subtotal');
                    @endphp
                    <span class="amount">Rp {{ number_format($totalTransaksi, 0, ',', '.') }}</span>
                    @if($transaksi->jumlah_deposit > 0)
                        <span class="deposit-amount">
                            <i class="fas fa-shield-alt"></i> Deposit: Rp {{ number_format($transaksi->jumlah_deposit, 0, ',', '.') }}
                        </span>
                    @endif
                </div>
                {{-- <div class="action-buttons">
                    @if($transaksi->status === 'dikirim')
                        <a href="{{ route('user.konfirmasi-penerimaan', $transaksi->id) }}"
                        class="btn-action btn-detail" style="background: #10b981; color: white;">
                            <i class="fas fa-check-circle me-1"></i> Konfirmasi Terima
                        </a>
                    @endif

                    @if($transaksi->status === 'dipinjam')
                        @php
                            $hasReturn = $transaksi->pengembalian && !in_array($transaksi->pengembalian->status, ['selesai', 'dibatalkan']);
                        @endphp

                        @if(!$hasReturn)
                            <a href="{{ route('user.pengembalian.create', $transaksi->id) }}"
                            class="btn-action btn-warning" style="background: #f59e0b; color: white;">
                                <i class="fas fa-undo-alt me-1"></i> Proses Pengembalian
                            </a>
                        @else
                            <a href="{{ route('user.pengembalian.show', $transaksi->pengembalian->id) }}"
                            class="btn-action btn-info" style="background: #0ea5e9; color: white;">
                                <i class="fas fa-truck me-1"></i> Lacak Pengembalian
                            </a>
                        @endif
                    @endif

                     @if($transaksi->status === 'dikembalikan')
                        <a href="{{ route('user.pengembalian.show', $transaksi->id) }}"
                        class="btn-action btn-detail" style="background: #1032b9; color: white;">
                            <i class="fas fa-check-circle me-1"></i> Lacak Pengembalian
                        </a>
                    @endif

                    @if($transaksi->status == 'dikembalikan' && $transaksi->pengembalian)
                        @php
                            $subtotal = $transaksi->detailTransaksis->sum('subtotal');
                            $deposit = $transaksi->jumlah_deposit;
                            $sisa = $subtotal - $deposit;
                            $denda = $transaksi->pengembalian?->total_biaya_tambahan ?? 0;
                            $totalBayar = $sisa + $denda;
                        @endphp

                        @if($transaksi->pengembalian->status == 'selesai' && $totalBayar > 0)
                            <a href="{{ route('user.payment.create', $transaksi->id) }}"
                            class="btn-action" style="background: #10b981; color: white;">
                                <i class="fas fa-credit-card me-1"></i>
                                Bayar Pelunasan
                                <small class="ms-1">(Rp {{ number_format($totalBayar, 0, ',', '.') }})</small>
                            </a>
                        @elseif($transaksi->pengembalian->status == 'selesai' && $totalBayar <= 0)
                            <span class="btn-action" style="background: #10b981; color: white; cursor: default;">
                                <i class="fas fa-check-circle me-1"></i> Lunas
                            </span>
                        @elseif(in_array($transaksi->pengembalian->status, ['dikirim', 'sampai', 'diproses']))
                            <span class="btn-action" style="background: #f59e0b; color: white; cursor: default;">
                                <i class="fas fa-spinner fa-spin me-1"></i> Menunggu Pemeriksaan Petugas
                            </span>
                        @endif
                    @endif

                    <a href="{{ route('transaksi.show', $transaksi->id) }}" class="btn-action btn-detail">
                        <i class="fas fa-eye"></i> Detail
                    </a>

                    @if($transaksi->status == 'menunggu_persetujuan')
                    <button onclick="cancelTransaction({{ $transaksi->id }})" class="btn-action btn-cancel">
                        <i class="fas fa-times"></i> Batalkan
                    </button>
                    @endif

                    @if($transaksi->status == 'ditolak')
                    <a href="{{ route('transaksi.reapply', $transaksi->id) }}" class="btn-action btn-reapply">
                        <i class="fas fa-redo-alt"></i> Ajukan Ulang
                    </a>
                    @endif

                    @if(in_array($transaksi->status, ['disetujui', 'dikirim', 'dipinjam']))
                    <button class="btn-action btn-track" onclick="trackTransaction('{{ $transaksi->kode_transaksi }}', '{{ $transaksi->status }}')">
                        <i class="fas fa-map-marker-alt"></i> Status
                    </button>
                    @endif
                </div> --}}
                {{-- ACTION BUTTONS --}}
                <div class="action-buttons">
                    {{-- KONFIRMASI TERIMA --}}
                    @if($transaksi->status === 'dikirim')
                        <a href="{{ route('user.konfirmasi-penerimaan', $transaksi->id) }}"
                        class="btn-action btn-detail" style="background: #10b981; color: white;">
                            <i class="fas fa-check-circle me-1"></i> Konfirmasi Terima
                        </a>
                    @endif

                    {{-- PROSES PENGEMBALIAN (SAAT STATUS DIPINJAM) --}}
                    @if($transaksi->status === 'dipinjam')
                        @php
                            $hasReturn = $transaksi->pengembalian && !in_array($transaksi->pengembalian->status, ['selesai', 'dibatalkan']);
                        @endphp

                        @if(!$hasReturn)
                            <a href="{{ route('user.pengembalian.create', $transaksi->id) }}"
                            class="btn-action" style="background: #f59e0b; color: white;">
                                <i class="fas fa-undo-alt me-1"></i> Buat Proses Pengembalian
                            </a>
                        @else
                            {{-- TAMPILKAN LACAK PENGEMBALIAN HANYA JIKA STATUS BELUM SELESAI --}}
                            @if($transaksi->pengembalian->status != 'selesai')
                                <a href="{{ route('user.pengembalian.show', $transaksi->pengembalian->id) }}"
                                class="btn-action" style="background: #143463; color: white;">
                                    <i class="fas fa-truck me-1"></i> Lacak Pengembalian
                                </a>
                            @endif
                        @endif
                    @endif

                    {{-- LACAK PENGEMBALIAN (SAAT STATUS DIKEMBALIKAN) --}}
                    @if($transaksi->status === 'dikembalikan')
                        @php
                            $returnStatus = $transaksi->pengembalian->status ?? null;
                        @endphp
                        {{-- TAMPILKAN LACAK PENGEMBALIAN HANYA JIKA STATUS BELUM SELESAI --}}
                        @if($returnStatus && $returnStatus != 'selesai')
                            <a href="{{ route('user.pengembalian.show', $transaksi->pengembalian->id ?? $transaksi->id) }}"
                            class="btn-action" style="background: #143463; color: white;">
                                <i class="fas fa-truck me-1"></i> Lacak Pengembalian
                            </a>
                        @endif
                    @endif

                    {{-- PEMBAYARAN PELUNASAN --}}
                    @if($transaksi->status == 'dikembalikan' && $transaksi->pengembalian)
                        @php
                            $subtotal = $transaksi->detailTransaksis->sum('subtotal');
                            $deposit = $transaksi->jumlah_deposit;
                            $sisa = $subtotal - $deposit;
                            $denda = $transaksi->pengembalian->total_biaya_tambahan ?? 0;
                            $totalBayar = $sisa + $denda;
                            $returnStatus = $transaksi->pengembalian->status;
                        @endphp

                        {{-- BUTTON BAYAR PELUNASAN MUNCUL SAAT STATUS PENGEMBALIAN ADALAH SELESAI --}}
                        @if($returnStatus == 'selesai')
                            @if($totalBayar > 0)
                                <a href="{{ route('user.payment.create', $transaksi->id) }}"
                                class="btn-action" style="background: #10b981; color: white;">
                                    <i class="fas fa-credit-card me-1"></i>
                                    Bayar Pelunasan
                                    <small class="ms-1">(Rp {{ number_format($totalBayar, 0, ',', '.') }})</small>
                                </a>
                            @else
                                <span class="btn-action" style="background: #10b981; color: white; cursor: default;">
                                    <i class="fas fa-check-circle me-1"></i> Lunas
                                </span>
                            @endif
                        @elseif(in_array($returnStatus, ['dikirim', 'sampai', 'diproses']))
                            <span class="btn-action" style="background: #f59e0b; color: white; cursor: default;">
                                <i class="fas fa-spinner fa-spin me-1"></i> Menunggu Pemeriksaan Petugas
                            </span>
                        @endif
                    @endif

                    {{-- DETAIL TRANSAKSI --}}
                    <a href="{{ route('transaksi.show', $transaksi->id) }}" class="btn-action btn-detail">
                        <i class="fas fa-eye"></i> Detail
                    </a>

                    {{-- BATALKAN TRANSAKSI --}}
                    @if($transaksi->status == 'menunggu_persetujuan')
                        <button onclick="cancelTransaction({{ $transaksi->id }})" class="btn-action btn-cancel">
                            <i class="fas fa-times"></i> Batalkan
                        </button>
                    @endif

                    {{-- AJUKAN ULANG --}}
                    @if($transaksi->status == 'ditolak')
                        <a href="{{ route('transaksi.reapply', $transaksi->id) }}" class="btn-action btn-reapply">
                            <i class="fas fa-redo-alt"></i> Ajukan Ulang
                        </a>
                    @endif

                    {{-- LACAK STATUS TRANSAKSI (TIDAK TERMASUK YANG SUDAH SELESAI) --}}
                    @if(in_array($transaksi->status, ['disetujui', 'dikirim', 'dipinjam']))
                        <button class="btn-action btn-track" onclick="trackTransaction('{{ $transaksi->kode_transaksi }}', '{{ $transaksi->status }}')">
                            <i class="fas fa-map-marker-alt"></i> Status
                        </button>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <h3>Belum Ada Transaksi</h3>
            <p>Anda belum melakukan peminjaman alat medis. Yuk, mulai pinjam alat medis sekarang!</p>
            <a href="{{ route('produk.list') }}" class="btn-primary-custom">
                <i class="fas fa-shopping-bag"></i>
                Lihat Produk
            </a>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($transaksis->hasPages())
    <div class="pagination-container">
        {{ $transaksis->links() }}
    </div>
    @endif
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function filterTransactions() {
        const status = document.getElementById('statusFilter').value;
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();

        const cards = document.querySelectorAll('.transaction-card');

        cards.forEach(card => {
            const cardStatus = card.dataset.status;
            const cardCode = card.dataset.code;

            let statusMatch = (status === 'all' || cardStatus === status);
            let searchMatch = (searchTerm === '' || cardCode.includes(searchTerm));

            if (statusMatch && searchMatch) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }

    function resetFilters() {
        document.getElementById('statusFilter').value = 'all';
        document.getElementById('searchInput').value = '';
        filterTransactions();
    }

    document.getElementById('statusFilter').addEventListener('change', function() {
        filterTransactions();
    });

    document.getElementById('searchInput').addEventListener('keyup', function(e) {
        if (e.key === 'Enter') {
            filterTransactions();
        }
    });

    function cancelTransaction(id) {
        Swal.fire({
            title: 'Batalkan Transaksi?',
            text: "Apakah Anda yakin ingin membatalkan transaksi ini? Stok produk akan dikembalikan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Batalkan!',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `{{ url('user/transaksi') }}/${id}/batal`;
                form.style.display = 'none';

                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';

                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'PUT';

                form.appendChild(csrfInput);
                form.appendChild(methodInput);
                document.body.appendChild(form);
                form.submit();
            }
        });
    }

    function trackTransaction(code, status) {
        let currentStep = 1;

        switch(status) {
            case 'disetujui':
                currentStep = 3;
                break;
            case 'dikirim':
                currentStep = 4;
                break;
            case 'dipinjam':
                currentStep = 5;
                break;
            default:
                currentStep = 1;
        }

        Swal.fire({
            title: 'Lacak Transaksi',
            html: `
                <div style="text-align: left;">
                    <p><strong>Kode Transaksi:</strong> ${code}</p>
                    <div style="margin: 1.5rem 0;">
                        <div style="display: flex; align-items: center; gap: 1rem; margin: 0.75rem 0; ${currentStep >= 1 ? 'opacity: 1;' : 'opacity: 0.5;'}">
                            <div style="width: 30px; height: 30px; border-radius: 50%; background: ${currentStep >= 1 ? '#10b981' : '#e2e8f0'}; display: flex; align-items: center; justify-content: center; color: white;">
                                <i class="fas fa-check"></i>
                            </div>
                            <span>Pesanan dibuat</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 1rem; margin: 0.75rem 0; ${currentStep >= 2 ? 'opacity: 1;' : 'opacity: 0.5;'}">
                            <div style="width: 30px; height: 30px; border-radius: 50%; background: ${currentStep >= 2 ? '#10b981' : '#e2e8f0'}; display: flex; align-items: center; justify-content: center; color: white;">
                                <i class="fas ${currentStep >= 2 ? 'fa-check' : 'fa-clock'}"></i>
                            </div>
                            <span>Menunggu verifikasi admin</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 1rem; margin: 0.75rem 0; ${currentStep >= 3 ? 'opacity: 1;' : 'opacity: 0.5;'}">
                            <div style="width: 30px; height: 30px; border-radius: 50%; background: ${currentStep >= 3 ? '#10b981' : '#e2e8f0'}; display: flex; align-items: center; justify-content: center; color: white;">
                                <i class="fas ${currentStep >= 3 ? 'fa-check' : 'fa-box'}"></i>
                            </div>
                            <span>Pesanan diproses & disetujui</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 1rem; margin: 0.75rem 0; ${currentStep >= 4 ? 'opacity: 1;' : 'opacity: 0.5;'}">
                            <div style="width: 30px; height: 30px; border-radius: 50%; background: ${currentStep >= 4 ? '#10b981' : '#e2e8f0'}; display: flex; align-items: center; justify-content: center; color: white;">
                                <i class="fas ${currentStep >= 4 ? 'fa-check' : 'fa-truck'}"></i>
                            </div>
                            <span>Dalam pengiriman</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 1rem; margin: 0.75rem 0; ${currentStep >= 5 ? 'opacity: 1;' : 'opacity: 0.5;'}">
                            <div style="width: 30px; height: 30px; border-radius: 50%; background: ${currentStep >= 5 ? '#10b981' : '#e2e8f0'}; display: flex; align-items: center; justify-content: center; color: white;">
                                <i class="fas ${currentStep >= 5 ? 'fa-check' : 'fa-hand-holding-medical'}"></i>
                            </div>
                            <span>Sedang dipinjam</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 1rem; margin: 0.75rem 0; ${currentStep >= 6 ? 'opacity: 1;' : 'opacity: 0.5;'}">
                            <div style="width: 30px; height: 30px; border-radius: 50%; background: ${currentStep >= 6 ? '#10b981' : '#e2e8f0'}; display: flex; align-items: center; justify-content: center; color: white;">
                                <i class="fas ${currentStep >= 6 ? 'fa-check' : 'fa-check-double'}"></i>
                            </div>
                            <span>Pesanan selesai</span>
                        </div>
                    </div>
                    <p style="font-size: 0.85rem; color: #64748b; margin-top: 1rem;">
                        <i class="fas fa-headset"></i> Hubungi customer service untuk info lebih lanjut
                    </p>
                </div>
            `,
            icon: 'info',
            confirmButtonText: 'Tutup',
            confirmButtonColor: '#0b2c5d',
            width: '500px'
        });
    }

    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        timer: 3000,
        showConfirmButton: false
    });
    @endif

    @if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: '{{ session('error') }}',
        timer: 3000,
        showConfirmButton: false
    });
    @endif
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

@endsection
