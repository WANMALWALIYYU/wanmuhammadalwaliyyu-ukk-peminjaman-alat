@extends('index')
@section('pages', 'Detail Produk')
@section('content')

<style>
:root {
    --primary-color: #2563eb;
    --secondary-color: #3b82f6;
    --accent-color: #60a5fa;
    --dark-bg: #1e293b;
    --light-bg: #f8fafc;
    --success-color: #10b981;
    --warning-color: #f59e0b;
    --danger-color: #ef4444;
}

/* Modern Product Detail Styles */
.detail-produk-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    padding: 2rem 0;
}

.detail-produk-section .container {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 30px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    padding: 2rem;
}

/* Breadcrumb Modern */
.breadcrumb {
    background: transparent;
    padding: 0;
    margin-bottom: 2rem;
}

.breadcrumb-item a {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
}

.breadcrumb-item a:hover {
    color: var(--secondary-color);
    transform: translateX(-3px);
}

.breadcrumb-item.active {
    color: var(--dark-bg);
    font-weight: 600;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: "›";
    color: var(--primary-color);
    font-size: 1.2rem;
    line-height: 1;
}

/* Gallery Section Modern */
.detail-gambar {
    position: relative;
    overflow: hidden;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.detail-gambar:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
}

.detail-gambar img {
    width: 100%;
    height: auto;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.detail-gambar:hover img {
    transform: scale(1.05);
}

.no-image-detail {
    background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
    padding: 4rem 2rem;
    border-radius: 20px;
}

/* Badge Kondisi */
.badge-kondisi {
    display: inline-block;
    padding: 0.5rem 1.5rem;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.badge-kondisi.baru {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
}

.badge-kondisi.bekas {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
}

.badge-kondisi.rusak {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
}

/* Detail Title */
.detail-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--dark-bg);
    margin-bottom: 1rem;
    line-height: 1.2;
}

/* Code & Price */
.detail-code {
    display: inline-flex;
    align-items: center;
    background: #f1f5f9;
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-size: 0.9rem;
    color: #475569;
}

.detail-code i {
    margin-right: 0.5rem;
    color: var(--primary-color);
}

.detail-price {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    padding: 1.5rem;
    border-radius: 20px;
    border-left: 5px solid var(--primary-color);
}

.price-label {
    display: block;
    font-size: 0.9rem;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 0.5rem;
}

.price-value {
    font-size: 3rem;
    font-weight: 700;
    color: var(--primary-color);
    margin-bottom: 0.25rem;
    line-height: 1;
}

/* Info Cards */
.detail-stock,
.detail-status {
    background: white;
    padding: 1rem 1.5rem;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    border: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    transition: all 0.3s ease;
}

.detail-stock:hover,
.detail-status:hover {
    transform: translateX(5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    border-color: var(--primary-color);
}

.detail-stock i,
.detail-status i {
    font-size: 1.5rem;
    color: var(--primary-color);
}

/* Features & Description */
.detail-features,
.detail-description {
    background: white;
    padding: 1.5rem;
    border-radius: 20px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
}

.detail-features h4,
.detail-description h4 {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--dark-bg);
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
}

.detail-features h4::before,
.detail-description h4::before {
    content: '';
    width: 4px;
    height: 20px;
    background: var(--primary-color);
    border-radius: 2px;
    margin-right: 0.75rem;
}

.detail-features p,
.detail-description p {
    color: #475569;
    line-height: 1.7;
    margin-bottom: 0;
}

/* Action Buttons */
.detail-actions {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    margin-top: 2rem;
}

.btn-wa-detail {
    flex: 1;
    min-width: 200px;
    padding: 1rem 2rem;
    background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
    color: white;
    border: none;
    border-radius: 15px;
    font-weight: 600;
    font-size: 1.1rem;
    text-decoration: none;
    text-align: center;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(37, 211, 102, 0.3);
}

.btn-wa-detail:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(37, 211, 102, 0.4);
    color: white;
}

.btn-back {
    flex: 0 0 auto;
    padding: 1rem 2rem;
    background: white;
    color: var(--dark-bg);
    border: 2px solid #e2e8f0;
    border-radius: 15px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-back:hover {
    background: #f8fafc;
    border-color: var(--primary-color);
    color: var(--primary-color);
    transform: translateX(-3px);
}

/* Related Products Section */
.related-products-section {
    margin-top: 4rem;
    padding-top: 2rem;
    border-top: 2px dashed #e2e8f0;
}

.related-title {
    font-size: 1.75rem;
    font-weight: 600;
    color: var(--dark-bg);
    margin-bottom: 2rem;
    text-align: center;
}

.related-products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.related-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    text-decoration: none;
}

.related-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.related-card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.related-info {
    padding: 1rem;
}

.related-info h5 {
    font-size: 1rem;
    font-weight: 600;
    color: var(--dark-bg);
    margin-bottom: 0.5rem;
}

.related-price {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--primary-color);
}

/* Status Badge */
.status-badge-tersedia {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 600;
}

.status-badge-dipinjam {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 600;
}

/* Responsive Design */
@media (max-width: 768px) {
    .detail-produk-section .container {
        padding: 1rem;
    }

    .detail-title {
        font-size: 2rem;
    }

    .price-value {
        font-size: 2.5rem;
    }

    .detail-actions {
        flex-direction: column;
    }

    .btn-wa-detail,
    .btn-back {
        width: 100%;
    }
}

/* Animation */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.detail-info > * {
    animation: fadeInUp 0.5s ease forwards;
}

.detail-info > *:nth-child(1) { animation-delay: 0.1s; }
.detail-info > *:nth-child(2) { animation-delay: 0.2s; }
.detail-info > *:nth-child(3) { animation-delay: 0.3s; }
.detail-info > *:nth-child(4) { animation-delay: 0.4s; }
.detail-info > *:nth-child(5) { animation-delay: 0.5s; }
.detail-info > *:nth-child(6) { animation-delay: 0.6s; }
</style>

<section class="detail-produk-section py-5">
    <div class="container py-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('landing-page') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('produk.list') }}">Produk</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $produk->nama_produk }}</li>
            </ol>
        </nav>

        <div class="row g-5">
            <div class="col-lg-6">
                <div class="detail-gambar">
                    @if($produk->gambar)
                        <img src="{{ asset('storage/' . $produk->gambar) }}"
                             alt="{{ $produk->nama_produk }}"
                             class="img-fluid">
                    @else
                        <div class="no-image-detail text-center">
                            <i class="fa-regular fa-image fa-4x text-muted mb-3"></i>
                            <p class="text-muted">Tidak ada gambar</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-lg-6">
                <div class="detail-info">
                    <span class="badge-kondisi {{ $produk->kondisi }}">{{ ucfirst($produk->kondisi) }}</span>
                    <h1 class="detail-title mt-3">{{ $produk->nama_produk }}</h1>

                    <div class="detail-code mb-3">
                        <i class="fa-solid fa-barcode"></i>
                        <span>Kode: {{ $produk->kode_produk }}</span>
                    </div>

                    <div class="detail-price mb-4">
                        <span class="price-label">Harga Sewa</span>
                        <h2 class="price-value">{{ $produk->harga_formatted }}</h2>
                        <small class="text-muted">per hari</small>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="detail-stock">
                                <i class="fa-solid fa-cubes"></i>
                                <div class="ms-3">
                                    <small class="text-muted d-block">Stok Tersedia</small>
                                    <strong>{{ $produk->stok }} unit</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-status">
                                <i class="fa-solid fa-circle-info"></i>
                                <div class="ms-3">
                                    <small class="text-muted d-block">Status</small>
                                    {!! $produk->status_badge !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($produk->category)
                    <div class="mb-3">
                        <span class="badge bg-light text-dark p-2">
                            <i class="fa-regular fa-folder-open me-1"></i>
                            {{ $produk->category->nama_kategori }}
                        </span>
                    </div>
                    @endif

                    <div class="detail-features mb-4">
                        <h4>Fitur Produk</h4>
                        <p>{{ $produk->fitur }}</p>
                    </div>

                    <div class="detail-description mb-4">
                        <h4>Deskripsi Produk</h4>
                        <p>{{ $produk->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                    </div>

                    <div class="detail-actions">
                        <a href="https://wa.me/628132002611?text=Saya%20ingin%20menyewa%20{{ urlencode($produk->nama_produk) }}%20({{ $produk->kode_produk }})"
                           class="btn-wa-detail" target="_blank">
                            <i class="fab fa-whatsapp me-2"></i>
                            Sewa via WhatsApp
                        </a>
                        <a href="{{ url()->previous() }}" class="btn-back">
                            <i class="fas fa-arrow-left me-2"></i>
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        @if(isset($produkTerkait) && $produkTerkait->count() > 0)
        <div class="related-products-section">
            <h3 class="related-title">Produk Terkait</h3>
            <div class="related-products-grid">
                @foreach($produkTerkait as $terkait)
                <a href="{{ route('produk.detail', $terkait->id) }}" class="related-card">
                    @if($terkait->gambar)
                        <img src="{{ asset('storage/' . $terkait->gambar) }}" alt="{{ $terkait->nama_produk }}">
                    @else
                        <div class="no-image" style="height: 200px; background: #f3f4f6; display: flex; align-items: center; justify-content: center;">
                            <i class="fa-regular fa-image fa-3x text-muted"></i>
                        </div>
                    @endif
                    <div class="related-info">
                        <h5>{{ $terkait->nama_produk }}</h5>
                        <div class="related-price">{{ $terkait->harga_formatted }}</div>
                        <small class="text-muted">/hari</small>
                        <div class="mt-2">
                            <span class="badge-kondisi {{ $terkait->kondisi }}">{{ ucfirst($terkait->kondisi) }}</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>
@endsection
