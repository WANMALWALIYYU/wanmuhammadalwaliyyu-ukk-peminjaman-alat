@extends('index')
@section('pages', 'Daftar Produk')
@section('content')

<style>
:root {
    --sidebar-width: 280px;
    --primary: #0b2c5d;
    --primary-light: #1f3c88;
    --primary-dark: #081f3f;
    --secondary: #3b82f6;
    --gray-light: #f8f9fa;
    --gray: #e9ecef;
    --text-color: #1d1d1f;
    --text-muted: #6c757d;
    --shadow-sm: 0 2px 8px rgba(0,0,0,0.05);
    --shadow-md: 0 5px 15px rgba(0,0,0,0.08);
    --transition: all 0.3s ease;
}

/* Breadcrumb */
.breadcrumb-section {
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    padding: 20px 0;
    border-bottom: 1px solid rgba(0,0,0,0.05);
}

.breadcrumb-custom {
    background: transparent;
    padding: 0;
    margin: 0;
}

.breadcrumb-custom .breadcrumb-item a {
    color: var(--primary);
    text-decoration: none;
    font-weight: 500;
}

.breadcrumb-custom .breadcrumb-item.active {
    color: var(--text-muted);
}

.breadcrumb-custom .breadcrumb-item + .breadcrumb-item::before {
    content: "›";
    font-size: 1.2rem;
    line-height: 1;
    color: var(--text-muted);
}

/* Main Layout */
.produk-list-section {
    padding: 40px 0 80px;
    background: #ffffff;
    min-height: 100vh;
}

.produk-layout {
    display: flex;
    gap: 30px;
    position: relative;
}

/* ===== SIDEBAR STYLES ===== */
.sidebar-kategori {
    width: var(--sidebar-width);
    flex-shrink: 0;
    position: sticky;
    top: 100px;
    height: fit-content;
    max-height: calc(100vh - 120px);
    overflow-y: auto;
    padding-right: 10px;
}

.sidebar-kategori::-webkit-scrollbar {
    width: 5px;
}

.sidebar-kategori::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.sidebar-kategori::-webkit-scrollbar-thumb {
    background: var(--primary-light);
    border-radius: 10px;
}

.sidebar-kategori::-webkit-scrollbar-thumb:hover {
    background: var(--primary);
}

.sidebar-card {
    background: white;
    border-radius: 16px;
    padding: 25px;
    box-shadow: var(--shadow-sm);
    border: 1px solid rgba(0,0,0,0.03);
    margin-bottom: 20px;
}

.sidebar-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--primary);
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid rgba(11, 44, 93, 0.1);
    position: relative;
}

.sidebar-title::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 50px;
    height: 2px;
    background: var(--primary);
}

/* Kategori List */
.kategori-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.kategori-item {
    margin-bottom: 10px;
}

.kategori-link {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 15px;
    background: var(--gray-light);
    border-radius: 12px;
    color: var(--text-color);
    text-decoration: none;
    transition: var(--transition);
    border: 1px solid transparent;
}

.kategori-link:hover {
    background: white;
    border-color: var(--primary-light);
    transform: translateX(5px);
    box-shadow: var(--shadow-sm);
}

.kategori-link.active {
    background: var(--primary);
    color: white;
}

.kategori-link.active .kategori-count {
    background: rgba(255,255,255,0.2);
    color: white;
}

.kategori-info {
    display: flex;
    align-items: center;
    gap: 10px;
}

.kategori-info i {
    width: 20px;
    color: var(--primary-light);
}

.kategori-link.active .kategori-info i {
    color: white;
}

.kategori-name {
    font-weight: 500;
    font-size: 0.95rem;
}

.kategori-count {
    background: white;
    padding: 2px 8px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--primary);
}

/* Filter Kondisi */
.filter-group {
    margin-bottom: 20px;
}

.filter-label {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 12px;
    font-weight: 600;
    color: var(--text-color);
    font-size: 0.95rem;
}

.filter-options {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.filter-checkbox {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    font-size: 0.9rem;
    color: var(--text-color);
    padding: 5px 0;
}

.filter-checkbox input[type="checkbox"] {
    width: 18px;
    height: 18px;
    accent-color: var(--primary);
    cursor: pointer;
}

.filter-checkbox:hover {
    color: var(--primary);
}

/* Search Box */
.search-box {
    position: relative;
    margin-bottom: 20px;
}

.search-input {
    width: 100%;
    padding: 12px 15px 12px 45px;
    border: 1px solid var(--gray);
    border-radius: 50px;
    font-size: 0.95rem;
    transition: var(--transition);
}

.search-input:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(11, 44, 93, 0.1);
}

.search-icon {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-muted);
}

/* Price Range */
.price-range {
    margin-top: 15px;
}

.price-inputs {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 10px;
}

.price-input {
    flex: 1;
    padding: 8px 12px;
    border: 1px solid var(--gray);
    border-radius: 8px;
    font-size: 0.9rem;
}

.price-input:focus {
    outline: none;
    border-color: var(--primary);
}

.price-separator {
    color: var(--text-muted);
    font-weight: 600;
}

.btn-apply-filter {
    width: 100%;
    padding: 10px;
    background: var(--primary);
    color: white;
    border: none;
    border-radius: 50px;
    font-weight: 600;
    margin-top: 15px;
    transition: var(--transition);
    cursor: pointer;
}

.btn-apply-filter:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

/* ===== MAIN CONTENT STYLES ===== */
.main-content {
    flex: 1;
    min-width: 0;
}

/* Header Produk */
.produk-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    flex-wrap: wrap;
    gap: 15px;
}

.produk-count {
    font-size: 1rem;
    color: var(--text-muted);
}

.produk-count strong {
    color: var(--primary);
    font-size: 1.2rem;
}

.produk-sort {
    display: flex;
    align-items: center;
    gap: 10px;
}

.sort-label {
    color: var(--text-muted);
    font-size: 0.9rem;
}

.sort-select {
    padding: 8px 15px;
    border: 1px solid var(--gray);
    border-radius: 50px;
    font-size: 0.9rem;
    color: var(--text-color);
    cursor: pointer;
    background: white;
}

.sort-select:focus {
    outline: none;
    border-color: var(--primary);
}

/* Grid Produk */
.produk-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 25px;
    margin-bottom: 40px;
}

/* Product Card - Modern dengan Hover Effect */
.produk-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    transition: var(--transition);
    border: 1px solid rgba(0,0,0,0.03);
    height: 100%;
    display: flex;
    flex-direction: column;
}

.produk-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-md);
}

/* Card Image Wrapper dengan Hover Effect */
.card-image-wrapper {
    position: relative;
    padding-top: 75%; /* 4:3 Aspect Ratio */
    overflow: hidden;
    background: #f8f9fa;
}

.card-image-link {
    display: block;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    text-decoration: none;
}

.card-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s ease, filter 0.3s ease;
}

.card-image-link:hover .card-image {
    transform: scale(1.1);
    filter: blur(2px) brightness(0.6);
}

/* Detail Icon - Muncul saat hover */
.card-detail-icon {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) scale(0.8);
    opacity: 0;
    color: white;
    background-color: rgba(0, 0, 0, 0.7);
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10;
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    pointer-events: none;
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
}

.card-image-link:hover .card-detail-icon {
    opacity: 1;
    transform: translate(-50%, -50%) scale(1);
}

.card-detail-icon i {
    color: white;
    font-size: 1.8rem;
}

/* Card Badge */
.card-badge {
    position: absolute;
    top: 12px;
    right: 12px;
    padding: 6px 15px;
    border-radius: 25px;
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    z-index: 5;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.card-badge.baru {
    background: linear-gradient(135deg, #4caf50, #45a049);
    color: white;
}

.card-badge.bekas {
    background: linear-gradient(135deg, #ff9800, #f57c00);
    color: white;
}

.card-badge.rusak {
    background: linear-gradient(135deg, #f44336, #d32f2f);
    color: white;
}

/* No Image Placeholder */
.no-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #adb5bd;
    background: #f8f9fa;
}

.no-image i {
    margin-bottom: 10px;
}

.no-image span {
    font-size: 0.8rem;
}

/* Card Content */
.card-content {
    padding: 20px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.card-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--primary);
    margin-bottom: 8px;
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.card-code {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.75rem;
    color: var(--text-muted);
    margin-bottom: 10px;
}

.card-code i {
    color: var(--primary-light);
}

.card-description {
    font-size: 0.85rem;
    color: var(--text-muted);
    line-height: 1.5;
    margin-bottom: 15px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.card-specs {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-top: 1px solid #f0f0f0;
    border-bottom: 1px solid #f0f0f0;
    margin-bottom: 15px;
    font-size: 0.85rem;
}

.card-spec {
    display: flex;
    align-items: center;
    gap: 5px;
}

.card-spec i {
    color: var(--primary-light);
}

.card-price {
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--primary);
    margin-bottom: 15px;
}

.card-price small {
    font-size: 0.8rem;
    font-weight: normal;
    color: var(--text-muted);
}

.card-actions {
    display: flex;
    gap: 8px;
    margin-top: auto;
}

.btn-detail-card {
    flex: 1;
    padding: 8px 0;
    background: var(--gray-light);
    color: var(--text-color);
    text-decoration: none;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    transition: var(--transition);
}

.btn-detail-card:hover {
    background: var(--primary);
    color: white;
}

.btn-wa-card {
    flex: 1;
    padding: 8px 0;
    background: var(--primary);
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    transition: var(--transition);
}

.btn-wa-card:hover {
    background: var(--primary-light);
    transform: translateY(-2px);
}

/* Pagination */
.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 40px;
}

.pagination-custom {
    display: flex;
    gap: 5px;
    list-style: none;
    padding: 0;
}

.pagination-custom .page-item .page-link {
    padding: 8px 15px;
    border: 1px solid var(--gray);
    border-radius: 8px;
    color: var(--text-color);
    text-decoration: none;
    transition: var(--transition);
}

.pagination-custom .page-item.active .page-link {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
}

.pagination-custom .page-item .page-link:hover {
    background: var(--primary-light);
    color: white;
    border-color: var(--primary-light);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 60px 20px;
    background: var(--gray-light);
    border-radius: 20px;
}

.empty-state img {
    max-width: 200px;
    margin-bottom: 20px;
    opacity: 0.5;
}

.empty-state h3 {
    color: var(--text-color);
    margin-bottom: 10px;
}

.empty-state p {
    color: var(--text-muted);
    margin-bottom: 20px;
}

.btn-lihat-semua {
    display: inline-flex;
    align-items: center;
    padding: 12px 30px;
    background: var(--primary);
    color: white;
    text-decoration: none;
    border-radius: 50px;
    font-weight: 500;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(11, 44, 93, 0.2);
    border: none;
    cursor: pointer;
}

.btn-lihat-semua:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(11, 44, 93, 0.3);
}

/* Responsive */
@media (max-width: 1200px) {
    .produk-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 992px) {
    .produk-layout {
        flex-direction: column;
    }

    .sidebar-kategori {
        width: 100%;
        position: static;
        max-height: none;
        overflow-y: visible;
    }

    .sidebar-card {
        padding: 20px;
    }
}

@media (max-width: 768px) {
    .produk-grid {
        grid-template-columns: 1fr;
    }

    .produk-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .produk-sort {
        width: 100%;
    }

    .sort-select {
        flex: 1;
    }

    .card-detail-icon {
        width: 50px;
        height: 50px;
    }

    .card-detail-icon i {
        font-size: 1.5rem;
    }
}
</style>

<!-- Breadcrumb -->
<section class="breadcrumb-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-custom">
                <li class="breadcrumb-item"><a href="{{ route('landing-page') }}"><i class="fas fa-home me-1"></i>Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Produk</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Main Content -->
<section class="produk-list-section">
    <div class="container">
        <div class="produk-layout">
            <!-- SIDEBAR KATEGORI (STICKY) -->
            <aside class="sidebar-kategori">
                <!-- Search Box -->
                <div class="sidebar-card">
                    <h3 class="sidebar-title">Cari Produk</h3>
                    <form action="{{ route('produk.list') }}" method="GET" id="searchForm">
                        @if(request('sort'))
                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                        @endif
                        <div class="search-box">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text"
                                   name="search"
                                   class="search-input"
                                   placeholder="Cari nama atau fitur..."
                                   value="{{ request('search') }}">
                        </div>
                    </form>
                </div>

                <!-- Kategori -->
                <div class="sidebar-card">
                    <h3 class="sidebar-title">Kategori Produk</h3>
                    <ul class="kategori-list">
                        <li class="kategori-item">
                            <a href="{{ route('produk.list', array_merge(request()->except(['kategori', 'page']), ['kategori' => ''])) }}"
                               class="kategori-link {{ !request('kategori') ? 'active' : '' }}">
                                <span class="kategori-info">
                                    <i class="fas fa-box"></i>
                                    <span class="kategori-name">Semua Produk</span>
                                </span>
                                <span class="kategori-count">{{ $produk->total() }}</span>
                            </a>
                        </li>
                        <li class="kategori-item">
                            <a href="{{ route('produk.list', array_merge(request()->except(['kategori', 'page']), ['kategori' => 'baru'])) }}"
                               class="kategori-link {{ request('kategori') == 'baru' ? 'active' : '' }}">
                                <span class="kategori-info">
                                    <i class="fas fa-star"></i>
                                    <span class="kategori-name">Baru</span>
                                </span>
                                <span class="kategori-count">{{ $kategoriCount['baru'] ?? 0 }}</span>
                            </a>
                        </li>
                        <li class="kategori-item">
                            <a href="{{ route('produk.list', array_merge(request()->except(['kategori', 'page']), ['kategori' => 'bekas'])) }}"
                               class="kategori-link {{ request('kategori') == 'bekas' ? 'active' : '' }}">
                                <span class="kategori-info">
                                    <i class="fas fa-rotate"></i>
                                    <span class="kategori-name">Bekas</span>
                                </span>
                                <span class="kategori-count">{{ $kategoriCount['bekas'] ?? 0 }}</span>
                            </a>
                        </li>
                        <li class="kategori-item">
                            <a href="{{ route('produk.list', array_merge(request()->except(['kategori', 'page']), ['kategori' => 'rusak'])) }}"
                               class="kategori-link {{ request('kategori') == 'rusak' ? 'active' : '' }}">
                                <span class="kategori-info">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <span class="kategori-name">Rusak (Servis)</span>
                                </span>
                                <span class="kategori-count">{{ $kategoriCount['rusak'] ?? 0 }}</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Filter Kondisi -->
                <div class="sidebar-card">
                    <h3 class="sidebar-title">Filter Kondisi</h3>
                    <form action="{{ route('produk.list') }}" method="GET" id="filterForm">
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        @if(request('kategori'))
                            <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                        @endif
                        @if(request('sort'))
                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                        @endif

                        <div class="filter-options">
                            <label class="filter-checkbox">
                                <input type="checkbox" name="kondisi" value="baru"
                                    {{ request('kondisi') == 'baru' ? 'checked' : '' }}
                                    onchange="this.form.submit()">
                                <span>Baru</span>
                            </label>
                            <label class="filter-checkbox">
                                <input type="checkbox" name="kondisi" value="bekas"
                                    {{ request('kondisi') == 'bekas' ? 'checked' : '' }}
                                    onchange="this.form.submit()">
                                <span>Bekas</span>
                            </label>
                            <label class="filter-checkbox">
                                <input type="checkbox" name="kondisi" value="rusak"
                                    {{ request('kondisi') == 'rusak' ? 'checked' : '' }}
                                    onchange="this.form.submit()">
                                <span>Rusak (Servis)</span>
                            </label>
                        </div>

                        @if(request('kondisi'))
                            <a href="{{ route('produk.list', array_merge(request()->except(['kondisi', 'page']))) }}"
                               class="btn-apply-filter" style="background: #dc3545; margin-top: 10px;">
                                <i class="fas fa-times me-2"></i>Hapus Filter
                            </a>
                        @endif
                    </form>
                </div>

                <!-- Informasi Tambahan -->
                <div class="sidebar-card">
                    <h3 class="sidebar-title">Info Penting</h3>
                    <div class="info-content">
                        <p><i class="fas fa-check-circle text-success me-2"></i> Semua alat steril & siap pakai</p>
                        <p><i class="fas fa-truck text-primary me-2"></i> Gratis antar jemput</p>
                        <p><i class="fas fa-headset text-info me-2"></i> Konsultasi gratis 24/7</p>
                        <p><i class="fas fa-shield-alt text-warning me-2"></i> Garansi kerusakan</p>
                    </div>
                    <hr>
                    <div class="text-center">
                        <small class="text-muted">Butuh bantuan?</small><br>
                        <a href="https://wa.me/628132002611" class="btn-wa-card d-inline-flex px-4 py-2 mt-2" style="display: inline-flex !important;">
                            <i class="fab fa-whatsapp me-2"></i>Hubungi Kami
                        </a>
                    </div>
                </div>
            </aside>

            <!-- MAIN CONTENT (PRODUK GRID) -->
            <main class="main-content">
                <!-- Header Produk -->
                <div class="produk-header">
                    <div class="produk-count">
                        Menampilkan <strong>{{ $produk->firstItem() ?? 0 }}</strong> -
                        <strong>{{ $produk->lastItem() ?? 0 }}</strong> dari
                        <strong>{{ $produk->total() }}</strong> produk
                    </div>

                    <div class="produk-sort">
                        <span class="sort-label">Urutkan:</span>
                        <select class="sort-select" onchange="window.location.href=this.value">
                            <option value="{{ route('produk.list', array_merge(request()->except(['sort', 'page']), ['sort' => 'terbaru'])) }}"
                                {{ request('sort', 'terbaru') == 'terbaru' ? 'selected' : '' }}>
                                Terbaru
                            </option>
                            <option value="{{ route('produk.list', array_merge(request()->except(['sort', 'page']), ['sort' => 'termurah'])) }}"
                                {{ request('sort') == 'termurah' ? 'selected' : '' }}>
                                Harga Termurah
                            </option>
                            <option value="{{ route('produk.list', array_merge(request()->except(['sort', 'page']), ['sort' => 'termahal'])) }}"
                                {{ request('sort') == 'termahal' ? 'selected' : '' }}>
                                Harga Termahal
                            </option>
                            <option value="{{ route('produk.list', array_merge(request()->except(['sort', 'page']), ['sort' => 'nama_asc'])) }}"
                                {{ request('sort') == 'nama_asc' ? 'selected' : '' }}>
                                Nama A-Z
                            </option>
                            <option value="{{ route('produk.list', array_merge(request()->except(['sort', 'page']), ['sort' => 'nama_desc'])) }}"
                                {{ request('sort') == 'nama_desc' ? 'selected' : '' }}>
                                Nama Z-A
                            </option>
                        </select>
                    </div>
                </div>

                <!-- Grid Produk -->
                @if($produk->isEmpty())
                    <div class="empty-state">
                        <img src="{{ asset('assets/image/empty-product.png') }}" alt="Tidak ada produk">
                        <h3>Produk Tidak Ditemukan</h3>
                        <p>Maaf, tidak ada produk yang sesuai dengan filter Anda.</p>
                        <a href="{{ route('produk.list') }}" class="btn-lihat-semua">
                            <i class="fas fa-sync-alt me-2"></i>Reset Filter
                        </a>
                    </div>
                @else
                    <div class="produk-grid">
                        @foreach($produk as $item)
                            <div class="produk-card">
                                <div class="card-image-wrapper">
                                    <a href="{{ route('produk.detail', $item->id) }}" class="card-image-link">
                                        <!-- Detail Icon - Muncul saat hover -->
                                        <div class="card-detail-icon">
                                            <i class="fa-regular fa-eye"></i>
                                        </div>

                                        @if($item->gambar)
                                            <img src="{{ asset('storage/' . $item->gambar) }}"
                                                 alt="{{ $item->nama_produk }}"
                                                 class="card-image">
                                        @else
                                            <div class="no-image">
                                                <i class="fa-regular fa-image fa-3x mb-2"></i>
                                                <span class="text-muted">Tidak ada gambar</span>
                                            </div>
                                        @endif
                                    </a>
                                    <span class="card-badge {{ $item->kondisi }}">{{ ucfirst($item->kondisi) }}</span>
                                </div>

                                <div class="card-content">
                                    <h3 class="card-title">{{ $item->nama_produk }}</h3>

                                    <div class="card-code">
                                        <i class="fa-solid fa-barcode"></i>
                                        <span>{{ $item->kode_produk }}</span>
                                    </div>

                                    <p class="card-description">
                                        {{ Str::limit($item->deskripsi ?? 'Tidak ada deskripsi', 60) }}
                                    </p>

                                    <div class="card-specs">
                                        <div class="card-spec">
                                            <i class="fa-solid fa-cubes"></i>
                                            <span>Stok: {{ $item->stok }}</span>
                                        </div>
                                        <div class="card-spec">
                                            <i class="fa-solid fa-tag"></i>
                                            <span>{{ $item->harga_formatted }}</span>
                                        </div>
                                    </div>

                                    <div class="card-price">
                                        {{ $item->harga_formatted }}<small>/hari</small>
                                    </div>

                                    <div class="card-actions">
                                        <a href="https://wa.me/628132002611?text=Saya%20ingin%20menyewa%20{{ urlencode($item->nama_produk) }}%20({{ $item->kode_produk }})"
                                           class="btn-wa-card" target="_blank">
                                            <i class="fab fa-whatsapp"></i>
                                            Sewa
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="pagination-wrapper">
                        {{ $produk->links('pagination::bootstrap-4') }}
                    </div>
                @endif
            </main>
        </div>
    </div>
</section>

<!-- Auto-submit script untuk search (debounce) -->
<script>
let searchTimeout;
document.querySelector('.search-input')?.addEventListener('keyup', function(e) {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        if (this.value.length >= 2 || this.value.length === 0) {
            document.getElementById('searchForm').submit();
        }
    }, 500);
});
</script>

@endsection
