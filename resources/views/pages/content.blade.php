@extends('index')
@section('pages', 'Beranda')
@section('content')

    <section class="hero-section" id="home">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 hero-content text-start" data-aos="fade-right" data-aos-delay="400">
                    <h4 class="hero-name">Medik<span>Care</span>Rent</h4>
                    <h1 class="hero-title">Solusi<br>Peminjaman<br><span>Alat Medis Terpercaya</span></h1>
                    <p class="hero-deskripsi text-center mb-5">
                        Platform peminjaman alat medis yang memudahkan
                        pengguna dalam menyewa berbagai peralatan kesehatan secara online.
                        Menyediakan berbagai peralatan kesehatan dengan proses cepat,
                        aman, dan terpercaya untuk kebutuhan medis Anda.
                    </p>
                    <div class="">
                        <a href="../../pages/req-demo.html" class="btn-pinjam floating-element">
                            Pinjam Alat
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 text-end" data-aos="fade-left" data-aos-delay="400">
                    <div class="logo-icon">
                        <img src="{{ asset('assets/image/logo-mcr.png') }}" alt="SIMRS Interface"
                            class="img-fluid floating-element-2">
                    </div>
                    <div class="hero-prd">
                        <img src="{{ asset('assets/image/hero-sec.png') }}" class="img-fluid" alt="SIMRS Produk">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Trusted By Section -->
    <section class="trusted-section">
        <div class="trusted-container">
            <div class="trusted-header text-center" data-aos="fade-up">
                <h6 class="section-label">DIPERCAYA OLEH</h6>
                <h2 class="section-title">Rumah Sakit, Klinik, dan Tenaga Kesehatan</h2>
                <p class="section-subtitle">MedikCareRent dipercaya oleh berbagai
                    fasilitas kesehatan dalam menyediakan layanan peminjaman alat medis yang aman,
                    terstandar, dan mudah digunakan untuk mendukung kebutuhan pelayanan kesehatan.
                </p>
            </div>

            <div class="trusted-body">
                <div class="pengguna-slider position-relative overflow-hidden" data-aos="zoom-in" data-aos-delay="100">
                    <div class="pengguna-body d-flex gap-4">
                        <div class="move-img">
                            <img src="{{ asset('assets/image/logo-mcr.png') }}" class="img-fluid" alt>
                        </div>
                        <div class="move-img">
                            <img src="{{ asset('assets/image/logo-mcr.png') }}" class="img-fluid" alt>
                        </div>
                        <div class="move-img">
                            <img src="{{ asset('assets/image/logo-mcr.png') }}" class="img-fluid" alt>
                        </div>
                        <div class="move-img">
                            <img src="{{ asset('assets/image/logo-mcr.png') }}" class="img-fluid" alt>
                        </div>
                        <div class="move-img">
                            <img src="{{ asset('assets/image/logo-mcr.png') }}" class="img-fluid" alt>
                        </div>

                        <!-- 🔁 DUPLIKAT supaya animasi mulus -->
                        <div class="move-img">
                            <img src="{{ asset('assets/image/logo-mcr.png') }}" class="img-fluid" alt>
                        </div>
                        <div class="move-img">
                            <img src="{{ asset('assets/image/logo-mcr.png') }}" class="img-fluid" alt>
                        </div>
                        <div class="move-img">
                            <img src="{{ asset('assets/image/logo-mcr.png') }}" class="img-fluid" alt>
                        </div>
                        <div class="move-img">
                            <img src="{{ asset('assets/image/logo-mcr.png') }}" class="img-fluid" alt>
                        </div>
                        <div class="move-img">
                            <img src="{{ asset('assets/image/logo-mcr.png') }}" class="img-fluid" alt>
                        </div>
                    </div>
                </div>

                <div class="pengguna-slider-sec position-relative overflow-hidden" data-aos="zoom-in" data-aos-delay="100">
                    <div class="pengguna-body-sec d-flex gap-4">
                        <div class="move-img-sec">
                            <img src="{{ asset('assets/image/logo-mcr.png') }}" class="img-fluid" alt>
                        </div>
                        <div class="move-img-sec">
                            <img src="{{ asset('assets/image/logo-mcr.png') }}" class="img-fluid" alt>
                        </div>
                        <div class="move-img-sec">
                            <img src="{{ asset('assets/image/logo-mcr.png') }}" class="img-fluid" alt>
                        </div>
                        <div class="move-img-sec">
                            <img src="{{ asset('assets/image/logo-mcr.png') }}" class="img-fluid" alt>
                        </div>
                        <div class="move-img-sec">
                            <img src="{{ asset('assets/image/logo-mcr.png') }}" class="img-fluid" alt>
                        </div>

                        <!-- 🔁 DUPLIKAT supaya animasi mulus -->
                        <div class="move-img-sec">
                            <img src="{{ asset('assets/image/logo-mcr.png') }}" class="img-fluid" alt>
                        </div>
                        <div class="move-img-sec">
                            <img src="{{ asset('assets/image/logo-mcr.png') }}" class="img-fluid" alt>
                        </div>
                        <div class="move-img-sec">
                            <img src="{{ asset('assets/image/logo-mcr.png') }}" class="img-fluid" alt>
                        </div>
                        <div class="move-img-sec">
                            <img src="{{ asset('assets/image/logo-mcr.png') }}" class="img-fluid" alt>
                        </div>
                        <div class="move-img-sec">
                            <img src="{{ asset('assets/image/logo-mcr.png') }}" class="img-fluid" alt>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- PRODUCT SECTION - MENAMPILKAN PRODUK DARI DATABASE -->
    <section class="product-section" id="product-section">
        <div class="container">
            <div class="product-header text-center" data-aos="fade-up">
                <h6 class="section-label">PRODUK TERBARU</h6>
                <h2 class="section-title">Alat Kesehatan Tersedia</h2>
                <p class="section-subtitle">
                    Berbagai pilihan alat kesehatan berkualitas yang siap dipinjam
                    untuk kebutuhan medis Anda. Tersedia dalam kondisi baik dan siap pakai.
                </p>
            </div>

            @if($produkTersedia->isEmpty())
                <div class="text-center py-5">
                    <img src="{{ asset('assets/image/empty-product.png') }}" alt="Tidak ada produk" style="max-width: 200px; opacity: 0.5;">
                    <h4 class="mt-4 text-muted">Belum ada produk tersedia</h4>
                    <p class="text-muted">Produk akan segera hadir. Silakan cek kembali nanti.</p>
                </div>
            @else
                <div class="product-slider-container" data-aos="fade-up">
                    <button class="slider-nav prev" id="prevBtn">
                        <i class="fas fa-chevron-left"></i>
                    </button>

                    <div class="product-slider-wrapper">
                        <div class="product-slider" id="productSlider">
                            @foreach($produkTersedia as $produk)
                                <div class="product-slide">
                                    <div class="product-card shadow-sm">
                                        <div class="product-badge {{ $produk->kondisi }}">
                                            {{ ucfirst($produk->kondisi) }}
                                        </div>

                                        <div class="product-image-wrapper">
                                            <a href="{{ route('produk.detail', $produk->id) }}" class="product-image-link">
                                                <div class="product-detail-icon">
                                                    <i class="fa-regular fa-eye fa-2x"></i>
                                                </div>
                                                @if($produk->gambar)
                                                    <img src="{{ asset('storage/' . $produk->gambar) }}"
                                                        alt="{{ $produk->nama_produk }}"
                                                        class="product-image img-fluid">
                                                @else
                                                    <div class="no-image-placeholder">
                                                        <i class="fa-regular fa-image fa-3x"></i>
                                                        <p>Tidak ada gambar</p>
                                                    </div>
                                                @endif
                                            </a>
                                        </div>

                                        <div class="product-content">
                                            <h3 class="product-title">{{ $produk->nama_produk }}</h3>

                                            <div class="product-code">
                                                <i class="fa-solid fa-barcode"></i>
                                                <span>{{ $produk->kode_produk }}</span>
                                            </div>

                                            <p class="product-description">
                                                {{ Str::limit($produk->deskripsi ?? 'Tidak ada deskripsi', 60) }}
                                            </p>

                                            <div class="product-specs">
                                                <div class="spec-item">
                                                    {{-- <i class="fa-solid fa-cubes"></i>
                                                    <span>Stok: <strong>{{ $produk->stok }}</strong></span> --}}
                                                </div>
                                                <div class="spec-item">
                                                    <i class="fa-solid fa-tag"></i>
                                                    <span>{{ $produk->harga_formatted }} / hari</span>
                                                </div>
                                            </div>

                                            @if($produk->fitur)
                                                <div class="product-features">
                                                    <i class="fa-solid fa-star"></i>
                                                    <span>{{ Str::limit($produk->fitur, 40) }}</span>
                                                </div>
                                            @endif

                                            <div class="product-actions">
<a href="{{ route('transaksi.index', [
    'produk_ids[]' => $produk->id,
    'jumlahs[]' => 1,
    'durasis[]' => 1
]) }}" class="btn-wa">
    <i class="fa-solid fa-cart-plus"></i>
    Sewa
</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <button class="slider-nav next" id="nextBtn">
                        <i class="fas fa-chevron-right"></i>
                    </button>

                    <div class="slider-dots" id="sliderDots">
                        <!-- Dots akan diisi oleh JavaScript -->
                    </div>
                </div>

                <div class="text-center mt-5" data-aos="fade-up">
                    <a href="{{ route('produk.list') }}" class="btn-lihat-semua">
                        Lihat Semua Produk
                        <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- STATISTIK SECTION (Optional) -->
    @if($totalProduk > 0)
    <section class="stats-section py-4" style="background: var(--gradient-primary); color: white;">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-4">
                    <div class="stat-item">
                        <i class="fa-solid fa-box-open fa-3x mb-3"></i>
                        <h3 class="stat-number">{{ $totalProduk }}</h3>
                        <p class="stat-label">Produk Tersedia</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-item">
                        <i class="fa-solid fa-tags fa-3x mb-3"></i>
                        <h3 class="stat-number">{{ $totalKategori }}</h3>
                        <p class="stat-label">Kategori</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-item">
                        <i class="fa-solid fa-hand-holding-heart fa-3x mb-3"></i>
                        <h3 class="stat-number">100%</h3>
                        <p class="stat-label">Steril & Siap Pakai</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif


    <section class="py-5" id="paket-peminjaman" style="background: #F9FAFB;">
        <div class="container py-5">
            <div class="paket-header text-center" data-aos="fade-up">
                <h1 class="section-title">Daftar Paket Sewa Alat Kesehatan</h1>
                <h6 class="section-subtitle">
                    Tersedia berbagai paket peminjaman alat kesehatan dengan durasi
                    harian, mingguan, hingga bulanan yang fleksibel dan sesuai kebutuhan.
                </h6>
            </div>

            <div class="row g-4 align-items-center">
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="product-card-modern">
                        <div class="card-image-wrapper">
                            <img src="assets/image/home-care.jpeg" alt="Klinik">
                        </div>
                        <div class="product-body-modern">
                            <h4>Paket Home Care</h4>
                            <p class="description">
                                Cocok untuk perawatan pasien di rumah dengan kebutuhan alat medis
                                dasar yang praktis dan mudah digunakan.
                            </p>
                            <ul class="feature-list">
                                <li><i class="fas fa-check-double"></i> Alat medis untuk perawatan di rumah</li>
                                <li><i class="fas fa-check-double"></i> Mudah digunakan oleh keluarga</li>
                                <li><i class="fas fa-check-double"></i> Durasi sewa harian & mingguan</li>
                                <li><i class="fas fa-check-double"></i> Steril dan siap pakai</li>
                                <li><i class="fas fa-check-double"></i> Antar jemput ke rumah pasien</li>
                            </ul>
                            <div class="price-box">
                                <span class="price-label">Mulai dari</span>
                                <div class="price-value">Rp.500.000</div>
                            </div>
                            <a href="https://api.whatsapp.com/send?phone=628132002611"
                                class="btn-primary-modern modern-btn">
                                Pinjam Sekarang
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="product-card-modern highlighted">
                        <div class="card-image-wrapper">
                            <img src="assets/image/rumah-sakit.jpeg" alt="RS Kecil">
                        </div>
                        <div class="product-body-modern">
                            <h4>Paket Rumah Sakit</h4>
                            <p class="description">
                                Paket peminjaman alat medis untuk rumah sakit dan fasilitas kesehatan
                                dengan kebutuhan alat yang beragam dan jumlah lebih besar.
                            </p>
                            <ul class="feature-list">
                                <li><i class="fas fa-check-double"></i> Alat medis sesuai standar rumah sakit</li>
                                <li><i class="fas fa-check-double"></i> Tersedia dalam jumlah besar</li>
                                <li><i class="fas fa-check-double"></i> Durasi sewa jangka menengah & panjang</li>
                                <li><i class="fas fa-check-double"></i> Maintenance & pengecekan berkala</li>
                                <li><i class="fas fa-check-double"></i> Dukungan teknis & penggantian unit</li>
                            </ul>
                            <div class="price-box">
                                <span class="price-label">Mulai dari</span>
                                <div class="price-value text-white">Rp.2.500.000</div>
                            </div>
                            <a href="https://api.whatsapp.com/send?phone=628132002611"
                                class="btn-primary-modern modern-btn">
                                Pinjam Sekarang
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="product-card-modern">
                        <div class="card-image-wrapper">
                            <img src="assets/image/klinik.jpeg" alt="RS Besar">
                        </div>
                        <div class="product-body-modern">
                            <h4>Paket Klinik</h4>
                            <p class="description">
                                Solusi peminjaman alat kesehatan untuk klinik dan praktik medis
                                dengan kebutuhan alat yang lebih lengkap dan siap pakai.
                            </p>
                            <ul class="feature-list">
                                <li><i class="fas fa-check-double"></i> Alat medis untuk praktik klinik</li>
                                <li><i class="fas fa-check-double"></i> Paket siap operasional</li>
                                <li><i class="fas fa-check-double"></i> Cocok untuk klinik baru & berkembang</li>
                                <li><i class="fas fa-check-double"></i> Steril dan terawat</li>
                                <li><i class="fas fa-check-double"></i> Antar jemput sesuai jadwal klinik</li>
                            </ul>
                            <div class="price-box">
                                <span class="price-label">Mulai dari</span>
                                <div class="price-value">Rp.1.500.000</div>
                            </div>
                            <a href="https://api.whatsapp.com/send?phone=628132002611"
                                class="btn-primary-modern modern-btn">
                                Pinjam Sekarang
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Feature Section Modern dengan Visual Berbeda -->
    <section class="feature-section">
        <div class="container">
            <div class="feature-header" data-aos="fade-up">
                <h2 class="section-title">Kenapa Harus Memilih MedikCareRent?</h2>
                <p class="section-subtitle">Solusi terpercaya penyewaan alat kesehatan untuk Rumah Sakit, Klinik,
                    dan Home Care dengan layanan profesional, cepat, dan sesuai standar medis.
                </p>
            </div>

            <div class="feature-container">
                <!-- Accordion Section -->
                <div class="accordion-container" data-aos="fade-right">
                    <div class="accordion" id="featureAccordion">
                        <div class="accordion-item" data-visual="phone">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                    <i class="fas fa-mobile-alt me-3"></i>
                                    Berpengalaman & Terpercaya
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                data-bs-parent="#featureAccordion">
                                <div class="accordion-body">
                                    <p>
                                        MedikCareRent telah berpengalaman melayani penyewaan alat kesehatan
                                        untuk Rumah Sakit, Klinik, dan perawatan Home Care dengan standar medis
                                        yang teruji dan proses yang profesional.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item" data-visual="laptop">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <i class="fas fa-laptop-medical me-3"></i>
                                    Alat Medis Berkualitas & Siap Pakai
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#featureAccordion">
                                <div class="accordion-body">
                                    <p>
                                        Seluruh alat kesehatan kami telah melalui proses pengecekan fungsi,
                                        kalibrasi, serta sterilisasi sebelum digunakan, sehingga aman dan siap
                                        langsung dipakai.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item" data-visual="video">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    <i class="fas fa-video me-3"></i>
                                    Konsultasi Gratis & Transparan
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                                data-bs-parent="#featureAccordion">
                                <div class="accordion-body">
                                    <p>
                                        Kami menyediakan konsultasi GRATIS untuk membantu Anda menentukan jenis
                                        dan jumlah alat kesehatan yang paling sesuai dengan kebutuhan dan anggaran.
                                        Tanpa komitmen.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item" data-visual="headset">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    <i class="fas fa-headset me-3"></i>
                                    Layanan Responsif & Siap Membantu
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                                data-bs-parent="#featureAccordion">
                                <div class="accordion-body">
                                    <p>
                                        Tim kami siap merespon permintaan sewa, pengiriman, maupun kendala teknis
                                        dengan cepat agar operasional medis Anda tetap berjalan tanpa hambatan.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item" data-visual="tablet">
                            <h2 class="accordion-header" id="headingFive">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    <i class="fas fa-tablet-alt me-3"></i>
                                    Fleksibel Sesuai Kebutuhan
                                </button>
                            </h2>
                            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
                                data-bs-parent="#featureAccordion">
                                <div class="accordion-body">
                                    <p>
                                        Durasi sewa harian, mingguan, hingga bulanan dapat disesuaikan.
                                        Kami juga menyediakan paket khusus sesuai kebutuhan Rumah Sakit,
                                        Klinik, maupun Home Care.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Visual Section -->
                <div class="feature-visual-container" id="featureVisual" data-aos="fade-left">
                    <div class="feature-visual">
                        <img src="assets/image/logo-name-mcr.png" alt="Mobile Health Application" class="feature-image"
                            data-type="phone">
                        <div class="visual-overlay">
                            <h4><i class="fas fa-mobile-alt"></i> Aplikasi
                                Mobile</h4>
                            <p>Akses sistem kami melalui smartphone untuk
                                monitoring real-time dari mana saja</p>
                        </div>
                        <div class="visual-indicator">
                            <i class="fas fa-mobile-alt"></i> Mobile Access
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="pinjam-section" id="cara-peminjaman">
        <div class="container">
            <!-- Header Section -->
            <div class="pinjam-header" data-aos="fade-up">
                <div class="row align-items-center">
                    <div class="col-lg-7">
                        <h6 class="section-label">PROSES MUDAH</h6>
                        <h2 class="section-title">Cara Peminjaman Alat Kesehatan</h2>
                        <p class="section-subtitle">
                            Nikmati kemudahan peminjaman alat kesehatan dengan proses yang cepat, aman, dan transparan.
                            Hanya dalam 4 langkah sederhana untuk mendapatkan alat yang Anda butuhkan.
                        </p>
                    </div>

                    <div class="col-lg-5">
                        <div class="process-highlight-card" data-aos="zoom-in" data-aos-delay="200">
                            <div class="highlight-content">
                                <div class="highlight-icon">
                                    <i class="fas fa-bolt"></i>
                                </div>
                                <h4 class="mb-2">Proses Cepat & Lengkap!</h4>
                                <p class="mb-0">Waktu pemrosesan hanya 2-4 jam setelah konfirmasi</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4 pinjam-body">
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="step-card">
                        <div class="step-number">01</div>
                        <div class="icon-box mb-4">
                            <img src="assets/image/free-consul.png" alt="Konsultasi">
                        </div>
                        <h3>Konsultasi Gratis</h3>
                        <p>Bebas bertanya mengenai kecocokan alat dengan keluhan medis dan rekomendasi dokter.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="step-card">
                        <div class="step-number">02</div>
                        <div class="icon-box mb-4">
                            <img src="assets/image/pilih-produk.png" alt="Produk">
                        </div>
                        <h3>Pemilihan Produk</h3>
                        <p>Pilih produk sesuai spesifikasi untuk menunjang kebutuhan homecare atau ICU.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="step-card">
                        <div class="step-number">03</div>
                        <div class="icon-box mb-4">
                            <img src="assets/image/formulir.png" alt="Formulir">
                        </div>
                        <h3>Lengkapi Formulir</h3>
                        <p>Isi data lengkap untuk memudahkan pengiriman. Tim kami akan segera konfirmasi.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="step-card highlight">
                        <div class="step-number">04</div>
                        <div class="icon-box mb-4">
                            <img src="assets/image/pembayaran.png" alt="COD">
                        </div>
                        <h3>Bayar di Tempat</h3>
                        <p>Barang diantar langsung ke rumah, pembayaran dilakukan aman saat alat tiba (COD).</p>
                    </div>
                </div>
            </div>

            <!-- CTA Section -->
            <div class="pinjam-cta" data-aos="fade-up" data-aos-delay="400">
                <div class="cta-card">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <h3>Siap Memulai Peminjaman?</h3>
                            <p class="mb-0">Hubungi kami sekarang dan dapatkan konsultasi gratis dari tim profesional
                                kami.</p>
                        </div>
                        <div class="col-lg-4 text-lg-end">
                            <a href="https://wa.me/62895352983076" class="btn-whatsapp-cta">
                                <i class="fab fa-whatsapp me-2"></i> Mulai Konsultasi via WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
