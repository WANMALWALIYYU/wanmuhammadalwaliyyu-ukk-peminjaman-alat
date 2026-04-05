@extends('index')
@section('pages', 'Detail Transaksi')
@section('content')

<style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap");

    :root {
        --primary: #1B4C8C;
        --primary-dark: #0f3a6b;
        --primary-light: #2d6eb0;
        --primary-soft: #e1ebfa;
        --secondary: #2ECC71;
        --secondary-dark: #27ae60;
        --secondary-light: #a3e4b7;
        --success: #2ecc71;
        --warning: #f39c12;
        --danger: #e74c3c;
        --danger-dark: #c0392b;
        --info: #3498db;
        --gray-light: #f8f9fa;
        --text-muted: #6c757d;
        --shadow-sm: 0 4px 12px rgba(0,0,0,0.05);
        --shadow-md: 0 8px 24px rgba(27,76,140,0.12);
        --shadow-lg: 0 16px 48px rgba(27,76,140,0.18);
        --transition: all 0.3s ease;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #f6f9fc 0%, #edf2f9 100%);
        min-height: 100vh;
    }

    /* Header Section */
    .detail-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        padding: 2rem 0;
        position: relative;
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .detail-header::before {
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

    .header-content {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem;
        position: relative;
        z-index: 2;
    }

    .header-content h1 {
        color: white;
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .header-content p {
        color: rgba(255,255,255,0.9);
        margin-bottom: 0;
    }

    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: white;
        text-decoration: none;
        margin-bottom: 1rem;
        transition: var(--transition);
    }

    .back-button:hover {
        transform: translateX(-5px);
        color: white;
    }

    /* Main Container */
    .detail-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem 2rem;
    }

    /* Status Card */
    .status-card {
        background: white;
        border-radius: 20px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-sm);
        border-left: 5px solid var(--warning);
        transition: var(--transition);
    }

    .status-card.status-menunggu_persetujuan {
        border-left-color: var(--warning);
        background: linear-gradient(135deg, #fff8e7 0%, #ffffff 100%);
    }

    .status-card.status-disetujui {
        border-left-color: var(--info);
        background: linear-gradient(135deg, #e7f3ff 0%, #ffffff 100%);
    }

    .status-card.status-ditolak {
        border-left-color: var(--danger);
        background: linear-gradient(135deg, #ffe7e7 0%, #ffffff 100%);
    }

    .status-card.status-dikirim {
        border-left-color: var(--primary);
        background: linear-gradient(135deg, #e7ecff 0%, #ffffff 100%);
    }

    .status-card.status-dipinjam {
        border-left-color: var(--secondary);
        background: linear-gradient(135deg, #e7fff0 0%, #ffffff 100%);
    }

    .status-card.status-selesai {
        border-left-color: var(--success);
        background: linear-gradient(135deg, #e7fff0 0%, #ffffff 100%);
    }

    .status-badge-large {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1rem;
    }

    .status-menunggu_persetujuan .status-badge-large {
        background: var(--warning);
        color: white;
    }

    .status-disetujui .status-badge-large {
        background: var(--info);
        color: white;
    }

    .status-ditolak .status-badge-large {
        background: var(--danger);
        color: white;
    }

    .status-dikirim .status-badge-large {
        background: var(--primary);
        color: white;
    }

    .status-dipinjam .status-badge-large {
        background: var(--secondary);
        color: white;
    }

    .status-selesai .status-badge-large {
        background: var(--success);
        color: white;
    }

    /* Modern Cards */
    .info-card {
        background: white;
        border-radius: 24px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        border: 1px solid rgba(0,0,0,0.05);
    }

    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-md);
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid var(--primary-soft);
    }

    .card-title i {
        font-size: 1.5rem;
        color: var(--primary);
    }

    /* Detail Grid */
    .detail-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }

    .detail-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px dashed #e9ecef;
    }

    .detail-item.full-width {
        grid-column: span 2;
    }

    .detail-label {
        color: var(--text-muted);
        font-weight: 500;
        font-size: 0.9rem;
    }

    .detail-value {
        font-weight: 600;
        color: var(--primary);
        text-align: right;
    }

    /* Product List */
    .product-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .product-item-detail {
        display: flex;
        gap: 1.5rem;
        padding: 1rem;
        background: var(--gray-light);
        border-radius: 16px;
        transition: var(--transition);
    }

    .product-item-detail:hover {
        background: var(--primary-soft);
        transform: translateX(5px);
    }

    .product-image {
        width: 100px;
        height: 100px;
        border-radius: 12px;
        overflow: hidden;
        flex-shrink: 0;
        background: #f0f0f0;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-info {
        flex: 1;
    }

    .product-name {
        font-weight: 700;
        color: var(--primary);
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
    }

    .product-details {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-top: 0.5rem;
    }

    .product-detail-badge {
        background: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        color: var(--primary);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .product-price {
        margin-top: 0.5rem;
        text-align: right;
        font-weight: 700;
        color: var(--secondary);
        font-size: 1.1rem;
    }

    /* Timeline */
    .timeline {
        position: relative;
        padding-left: 2rem;
    }

    .timeline-item {
        position: relative;
        padding-bottom: 2rem;
        padding-left: 1.5rem;
        border-left: 2px solid #e9ecef;
    }

    .timeline-item:last-child {
        padding-bottom: 0;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: -0.5rem;
        top: 0;
        width: 1rem;
        height: 1rem;
        border-radius: 50%;
        background: var(--gray-light);
        border: 2px solid var(--primary);
    }

    .timeline-item.completed::before {
        background: var(--success);
        border-color: var(--success);
    }

    .timeline-item.active::before {
        background: var(--primary);
        border-color: var(--primary);
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
        0%, 100% {
            box-shadow: 0 0 0 0 rgba(27,76,140,0.4);
        }
        50% {
            box-shadow: 0 0 0 8px rgba(27,76,140,0);
        }
    }

    .timeline-title {
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 0.25rem;
    }

    .timeline-date {
        font-size: 0.8rem;
        color: var(--text-muted);
    }

    .timeline-desc {
        font-size: 0.85rem;
        color: var(--text-muted);
        margin-top: 0.25rem;
    }

    /* Verification Notes */
    .verification-notes {
        background: #fff3e0;
        border-radius: 16px;
        padding: 1rem;
        margin-top: 1rem;
        border-left: 4px solid var(--warning);
    }

    .verification-notes h6 {
        color: var(--warning);
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        margin-top: 1.5rem;
        flex-wrap: wrap;
    }

    .btn-modern {
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        border: none;
    }

    .btn-outline {
        background: transparent;
        border: 2px solid var(--primary);
        color: var(--primary);
    }

    .btn-outline:hover {
        background: var(--primary);
        color: white;
        transform: translateY(-2px);
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        color: white;
    }

    .btn-danger {
        background: linear-gradient(135deg, var(--danger) 0%, var(--danger-dark) 100%);
        color: white;
    }

    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(231, 76, 60, 0.3);
        color: white;
    }

    .btn-success {
        background: linear-gradient(135deg, var(--success) 0%, var(--secondary-dark) 100%);
        color: white;
    }

    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(46, 204, 113, 0.3);
        color: white;
    }

    /* Modal */
    .modal-custom {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        backdrop-filter: blur(5px);
        z-index: 1000;
        justify-content: center;
        align-items: center;
    }

    .modal-custom.show {
        display: flex;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .modal-content-custom {
        background: white;
        border-radius: 24px;
        max-width: 500px;
        width: 90%;
        padding: 2rem;
        animation: slideUp 0.3s ease;
    }

    @keyframes slideUp {
        from {
            transform: translateY(50px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .detail-container {
            padding: 0 1rem 1rem;
        }

        .detail-grid {
            grid-template-columns: 1fr;
        }

        .detail-item.full-width {
            grid-column: span 1;
        }

        .product-item-detail {
            flex-direction: column;
        }

        .product-image {
            width: 100%;
            height: 150px;
        }

        .action-buttons {
            justify-content: center;
        }

        .timeline {
            padding-left: 1rem;
        }
    }
</style>

<div class="detail-header">
    <div class="header-content">
        <a href="{{ route('transaksi.riwayat') }}" class="back-button">
            <i class="fas fa-arrow-left"></i>
            Kembali ke Riwayat
        </a>
        <h1>Detail Transaksi</h1>
        <p>Informasi lengkap peminjaman Anda</p>
    </div>
</div>

<div class="detail-container">
    @if($transaksi)
        <!-- Status Card -->
        <div class="status-card status-{{ $transaksi->status }}">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <div class="status-badge-large">
                        @if($transaksi->status == 'menunggu_persetujuan')
                            <i class="fas fa-hourglass-half"></i>
                            Menunggu Persetujuan Petugas
                        @elseif($transaksi->status == 'disetujui')
                            <i class="fas fa-check-circle"></i>
                            Disetujui oleh Petugas
                        @elseif($transaksi->status == 'ditolak')
                            <i class="fas fa-times-circle"></i>
                            Ditolak oleh Petugas
                        @elseif($transaksi->status == 'dikirim')
                            <i class="fas fa-truck"></i>
                            Dalam Pengiriman
                        @elseif($transaksi->status == 'dipinjam')
                            <i class="fas fa-hand-holding-heart"></i>
                            Sedang Dipinjam
                        @elseif($transaksi->status == 'dikembalikan')
                            <i class="fas fa-undo-alt"></i>
                            Menunggu Pengecekan
                        @elseif($transaksi->status == 'selesai')
                            <i class="fas fa-check-double"></i>
                            Selesai
                        @elseif($transaksi->status == 'dibatalkan')
                            <i class="fas fa-ban"></i>
                            Dibatalkan
                        @endif
                    </div>
                    <div class="mt-2">
                        <small class="text-muted">
                            <i class="fas fa-barcode me-1"></i>
                            Kode Transaksi: <strong>{{ $transaksi->kode_transaksi }}</strong>
                        </small>
                    </div>
                </div>
                <div>
                    <small class="text-muted">
                        <i class="fas fa-calendar me-1"></i>
                        Diajukan: {{ \Carbon\Carbon::parse($transaksi->tanggal_pengajuan)->translatedFormat('d F Y H:i') }}
                    </small>
                </div>
            </div>
        </div>

        <!-- Jika ditolak, tampilkan pesan dan tombol ajukan ulang -->
        @if($transaksi->status == 'ditolak')
        <div class="info-card" style="background: linear-gradient(135deg, #ffe7e7 0%, #ffffff 100%); border-left: 4px solid var(--danger);">
            <div class="d-flex align-items-start gap-3">
                <i class="fas fa-exclamation-triangle fa-3x" style="color: var(--danger);"></i>
                <div>
                    <h5 style="color: var(--danger); font-weight: 700;">Transaksi Ditolak</h5>
                    <p>Transaksi Anda ditolak oleh petugas dengan alasan:</p>
                    <div class="verification-notes">
                        <h6><i class="fas fa-comment-dots"></i> Catatan dari Admin:</h6>
                        <p class="mb-0">{{ $transaksi->catatan_verifikasi ?? 'Tidak ada catatan' }}</p>
                    </div>
                    <div class="mt-3">
                        <button onclick="showReapplyModal()" class="btn-modern btn-primary">
                            <i class="fas fa-redo-alt"></i>
                            Ajukan Ulang Transaksi
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Jika disetujui, tampilkan pesan -->
        @if($transaksi->status == 'disetujui')
        <div class="info-card" style="background: linear-gradient(135deg, #e7f3ff 0%, #ffffff 100%); border-left: 4px solid var(--info);">
            <div class="d-flex align-items-start gap-3">
                <i class="fas fa-check-circle fa-3x" style="color: var(--info);"></i>
                <div>
                    <h5 style="color: var(--info); font-weight: 700;">Transaksi Disetujui</h5>
                    <p class="mb-0">Selamat! Transaksi Anda telah disetujui oleh petugas. Pesanan akan segera diproses dan dikirim ke alamat Anda.</p>
                    @if($transaksi->tanggal_verifikasi)
                    <small class="text-muted mt-2 d-block">
                        <i class="fas fa-user-check me-1"></i>
                        Diverifikasi oleh petugas pada {{ \Carbon\Carbon::parse($transaksi->tanggal_verifikasi)->translatedFormat('d F Y H:i') }}
                    </small>
                    @endif
                </div>
            </div>
        </div>
        @endif

        <!-- Data Peminjam -->
        <div class="info-card">
            <div class="card-title">
                <i class="fas fa-user-circle"></i>
                Data Peminjam
            </div>
            <div class="detail-grid">
                <div class="detail-item">
                    <span class="detail-label">Nama Lengkap</span>
                    <span class="detail-value">{{ $transaksi->nama_lengkap }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Email</span>
                    <span class="detail-value">{{ $transaksi->email }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">No. Telepon</span>
                    <span class="detail-value">{{ $transaksi->no_telepon }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">No. Identitas (KTP)</span>
                    <span class="detail-value">{{ $transaksi->no_identitas }}</span>
                </div>
                @if($transaksi->foto_ktp)
                <div class="detail-item full-width">
                    <span class="detail-label">Foto KTP</span>
                    <span class="detail-value">
                        <a href="{{ asset('storage/' . $transaksi->foto_ktp) }}" target="_blank" class="btn-modern btn-outline" style="padding: 0.25rem 1rem; font-size: 0.8rem;">
                            <i class="fas fa-eye"></i>
                            Lihat Foto KTP
                        </a>
                    </span>
                </div>
                @endif
            </div>
        </div>

        <!-- Alamat Pengiriman -->
        <div class="info-card">
            <div class="card-title">
                <i class="fas fa-map-marked-alt"></i>
                Alamat Pengiriman
            </div>
            <div class="detail-grid">
                <div class="detail-item">
                    <span class="detail-label">Provinsi</span>
                    <span class="detail-value">{{ $transaksi->provinsi }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Kabupaten/Kota</span>
                    <span class="detail-value">{{ $transaksi->kabupaten }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Kecamatan</span>
                    <span class="detail-value">{{ $transaksi->kecamatan }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Kelurahan/Desa</span>
                    <span class="detail-value">{{ $transaksi->kelurahan }}</span>
                </div>
                <div class="detail-item full-width">
                    <span class="detail-label">Alamat Lengkap</span>
                    <span class="detail-value">{{ $transaksi->alamat_lengkap }}</span>
                </div>
            </div>
        </div>

        <!-- Produk yang Dipinjam -->
        <div class="info-card">
            <div class="card-title">
                <i class="fas fa-boxes"></i>
                Produk yang Dipinjam
            </div>
            <div class="product-list">
                @foreach($transaksi->detailTransaksis as $detail)
                <div class="product-item-detail">
                    <div class="product-image">
                        @if($detail->produk && $detail->produk->gambar)
                            <img src="{{ asset('storage/' . $detail->produk->gambar) }}"
                                 alt="{{ $detail->nama_produk }}"
                                 onerror="this.src='https://via.placeholder.com/100x100/1B4C8C/FFFFFF?text=MEDIK'">
                        @else
                            <img src="https://via.placeholder.com/100x100/1B4C8C/FFFFFF?text=MEDIK" alt="Product">
                        @endif
                    </div>
                    <div class="product-info">
                        <div class="product-name">{{ $detail->nama_produk }}</div>
                        <div class="product-details">
                            <span class="product-detail-badge">
                                <i class="fas fa-box"></i>
                                {{ $detail->jumlah }} unit
                            </span>
                            <span class="product-detail-badge">
                                <i class="fas fa-clock"></i>
                                {{ $detail->durasi_hari }} hari
                            </span>
                            <span class="product-detail-badge">
                                <i class="fas fa-calendar-alt"></i>
                                {{ \Carbon\Carbon::parse($detail->tanggal_mulai)->format('d/m/Y') }} -
                                {{ \Carbon\Carbon::parse($detail->tanggal_selesai)->format('d/m/Y') }}
                            </span>
                        </div>
                        <div class="product-price">
                            Rp {{ number_format($detail->harga_per_hari, 0, ',', '.') }} / hari × {{ $detail->jumlah }} × {{ $detail->durasi_hari }} hari
                            <br>
                            <strong>Subtotal: Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</strong>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Ringkasan Pembayaran -->
        <div class="info-card">
            <div class="card-title">
                <i class="fas fa-calculator"></i>
                Ringkasan Pembayaran
            </div>
            @php
                $subtotal = $transaksi->detailTransaksis->sum('subtotal');
                $deposit = $transaksi->jumlah_deposit;
                $sisaPembayaran = $subtotal - $deposit;
            @endphp
            <div class="detail-grid">
                <div class="detail-item">
                    <span class="detail-label">Subtotal Produk</span>
                    <span class="detail-value">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Deposit Dibayarkan</span>
                    <span class="detail-value" style="color: var(--success);">Rp {{ number_format($deposit, 0, ',', '.') }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Metode Pembayaran</span>
                    <span class="detail-value">
                        @if($transaksi->metode_pembayaran == 'transfer')
                            Transfer Bank
                        @elseif($transaksi->metode_pembayaran == 'va')
                            Virtual Account
                        @elseif($transaksi->metode_pembayaran == 'ewallet')
                            E-Wallet
                        @endif
                    </span>
                </div>
                @if($transaksi->bukti_deposit)
                <div class="detail-item full-width">
                    <span class="detail-label">Bukti Deposit</span>
                    <span class="detail-value">
                        <a href="{{ asset('storage/' . $transaksi->bukti_deposit) }}" target="_blank" class="btn-modern btn-outline" style="padding: 0.25rem 1rem; font-size: 0.8rem;">
                            <i class="fas fa-eye"></i>
                            Lihat Bukti Deposit
                        </a>
                    </span>
                </div>
                @endif
                <div class="detail-item full-width" style="border-top: 2px solid var(--primary-soft); margin-top: 0.5rem; padding-top: 1rem;">
                    <span class="detail-label"><strong>Sisa Pembayaran (Pelunasan)</strong></span>
                    <span class="detail-value"><strong>Rp {{ number_format($sisaPembayaran, 0, ',', '.') }}</strong></span>
                </div>
                <div class="detail-item full-width">
                    <small class="text-muted">
                        <i class="fas fa-info-circle"></i>
                        Sisa pembayaran akan dilunasi setelah barang dikembalikan dalam kondisi baik.
                    </small>
                </div>
            </div>
        </div>

        <!-- Timeline Status -->
        <div class="info-card">
            <div class="card-title">
                <i class="fas fa-chart-line"></i>
                Timeline Status
            </div>
            <div class="timeline">
                <div class="timeline-item {{ $transaksi->created_at ? 'completed' : '' }}">
                    <div class="timeline-title">
                        <i class="fas fa-file-invoice"></i> Transaksi Dibuat
                    </div>
                    @if($transaksi->created_at)
                        <div class="timeline-date">{{ \Carbon\Carbon::parse($transaksi->created_at)->translatedFormat('d F Y H:i') }}</div>
                        <div class="timeline-desc">Transaksi berhasil dibuat dan menunggu verifikasi admin</div>
                    @endif
                </div>

                <div class="timeline-item {{ in_array($transaksi->status, ['disetujui', 'dikirim', 'dipinjam', 'dikembalikan', 'selesai']) ? 'completed' : ($transaksi->status == 'menunggu_persetujuan' ? 'active' : '') }}">
                    <div class="timeline-title">
                        <i class="fas fa-user-check"></i> Verifikasi Petugas
                    </div>
                    @if($transaksi->tanggal_verifikasi && in_array($transaksi->status, ['disetujui', 'dikirim', 'dipinjam', 'dikembalikan', 'selesai']))
                        <div class="timeline-date">{{ \Carbon\Carbon::parse($transaksi->tanggal_verifikasi)->translatedFormat('d F Y H:i') }}</div>
                        <div class="timeline-desc">Transaksi disetujui oleh petugas</div>
                    @elseif($transaksi->status == 'menunggu_persetujuan')
                        <div class="timeline-desc">Menunggu konfirmasi dari petugas</div>
                    @elseif($transaksi->status == 'ditolak')
                        <div class="timeline-desc" style="color: var(--danger);">Transaksi ditolak oleh petugas</div>
                    @endif
                </div>

                <div class="timeline-item {{ in_array($transaksi->status, ['dikirim', 'dipinjam', 'dikembalikan', 'selesai']) ? 'completed' : ($transaksi->status == 'disetujui' ? 'active' : '') }}">
                    <div class="timeline-title">
                        <i class="fas fa-truck"></i> Pengiriman Barang
                    </div>
                    @if(in_array($transaksi->status, ['dikirim', 'dipinjam', 'dikembalikan', 'selesai']))
                        <div class="timeline-desc">Barang dalam perjalanan menuju alamat Anda</div>
                    @elseif($transaksi->status == 'disetujui')
                        <div class="timeline-desc">Menunggu proses pengiriman</div>
                    @endif
                </div>

                <div class="timeline-item {{ in_array($transaksi->status, ['dipinjam', 'dikembalikan', 'selesai']) ? 'completed' : ($transaksi->status == 'dikirim' ? 'active' : '') }}">
                    <div class="timeline-title">
                        <i class="fas fa-hand-holding-heart"></i> Sedang Dipinjam
                    </div>
                    @if(in_array($transaksi->status, ['dipinjam', 'dikembalikan', 'selesai']))
                        <div class="timeline-desc">Barang sedang Anda gunakan</div>
                    @elseif($transaksi->status == 'dikirim')
                        <div class="timeline-desc">Barang dalam perjalanan</div>
                    @endif
                </div>

                <div class="timeline-item {{ in_array($transaksi->status, ['dikembalikan', 'selesai']) ? 'completed' : ($transaksi->status == 'dipinjam' ? 'active' : '') }}">
                    <div class="timeline-title">
                        <i class="fas fa-undo-alt"></i> Pengembalian Barang
                    </div>
                    @if(in_array($transaksi->status, ['dikembalikan', 'selesai']))
                        <div class="timeline-desc">Barang telah dikembalikan, menunggu pengecekan admin</div>
                    @elseif($transaksi->status == 'dipinjam')
                        <div class="timeline-desc">Harap kembalikan barang tepat waktu</div>
                    @endif
                </div>

                <div class="timeline-item {{ $transaksi->status == 'selesai' ? 'completed' : ($transaksi->status == 'dikembalikan' ? 'active' : '') }}">
                    <div class="timeline-title">
                        <i class="fas fa-check-double"></i> Transaksi Selesai
                    </div>
                    @if($transaksi->status == 'selesai')
                        <div class="timeline-desc">Transaksi selesai, terima kasih telah menggunakan layanan kami!</div>
                    @elseif($transaksi->status == 'dikembalikan')
                        <div class="timeline-desc">Menunggu konfirmasi pelunasan dari admin</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Respon Petugas / Catatan Verifikasi -->
        @if($transaksi->catatan_verifikasi && $transaksi->status != 'ditolak')
        <div class="info-card">
            <div class="card-title">
                <i class="fas fa-comment-dots"></i>
                Catatan dari Petugas
            </div>
            <div class="verification-notes" style="background: var(--primary-soft); border-left-color: var(--primary);">
                <p class="mb-0">{{ $transaksi->catatan_verifikasi }}</p>
                @if($transaksi->verified_by)
                <small class="text-muted mt-2 d-block">
                    <i class="fas fa-user-check me-1"></i>
                    Diverifikasi oleh: Admin
                </small>
                @endif
            </div>
        </div>
        @endif

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="{{ route('transaksi.riwayat') }}" class="btn-modern btn-outline">
                <i class="fas fa-history"></i>
                Kembali ke Riwayat
            </a>

            @if($transaksi->status == 'menunggu_persetujuan')
            <button onclick="showCancelModal()" class="btn-modern btn-danger">
                <i class="fas fa-times-circle"></i>
                Batalkan Transaksi
            </button>
            @endif

            @if(in_array($transaksi->status, ['disetujui', 'dikirim', 'dipinjam']))
            <a href="https://wa.me/62895352983076?text=Halo%20Admin%2C%20saya%20ingin%20menanyakan%20status%20transaksi%20dengan%20kode%20{{ $transaksi->kode_transaksi }}"
               class="btn-modern btn-success" target="_blank">
                <i class="fab fa-whatsapp"></i>
                Hubungi Admin
            </a>
            @endif
        </div>
    @else
        <div class="info-card text-center">
            <i class="fas fa-search fa-4x" style="color: var(--primary-soft); margin-bottom: 1rem;"></i>
            <h5>Transaksi tidak ditemukan</h5>
            <p>Maaf, transaksi yang Anda cari tidak ditemukan.</p>
            <a href="{{ route('transaksi.riwayat') }}" class="btn-modern btn-primary">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Riwayat
            </a>
        </div>
    @endif
</div>

<!-- Modal Konfirmasi Batalkan -->
<div id="cancelModal" class="modal-custom">
    <div class="modal-content-custom">
        <div style="text-align: center; margin-bottom: 1.5rem;">
            <i class="fas fa-exclamation-triangle fa-4x" style="color: var(--warning);"></i>
            <h5 class="mt-3">Batalkan Transaksi?</h5>
            <p class="text-muted">Apakah Anda yakin ingin membatalkan transaksi ini? Tindakan ini tidak dapat dibatalkan.</p>
        </div>
        <div class="d-flex gap-2 justify-content-center">
            <button onclick="closeCancelModal()" class="btn-modern btn-outline">Tidak</button>
            <form action="{{ route('transaksi.batal', $transaksi->id ?? '') }}" method="POST" style="display: inline;">
                @csrf
                @method('PUT')
                <button type="submit" class="btn-modern btn-danger">Ya, Batalkan</button>
            </form>
        </div>
    </div>
</div>

<!-- Modal Ajukan Ulang -->
<div id="reapplyModal" class="modal-custom">
    <div class="modal-content-custom">
        <div style="text-align: center; margin-bottom: 1.5rem;">
            <i class="fas fa-redo-alt fa-4x" style="color: var(--primary);"></i>
            <h5 class="mt-3">Ajukan Ulang Transaksi</h5>
            <p class="text-muted">Anda akan membuat transaksi baru dengan data yang sama. Apakah Anda ingin melanjutkan?</p>
            <div class="alert-modern" style="background: #fff3e0; padding: 1rem; border-radius: 12px; margin-top: 1rem;">
                <i class="fas fa-info-circle"></i>
                <small>Harap perhatikan catatan dari admin untuk mengajukan ulang transaksi.</small>
            </div>
        </div>
        <div class="d-flex gap-2 justify-content-center">
            <button onclick="closeReapplyModal()" class="btn-modern btn-outline">Kembali</button>
            <form action="{{ route('transaksi.reapply', $transaksi->id ?? '') }}" method="GET" style="display: inline;">
                <button type="submit" class="btn-modern btn-primary">Ya, Ajukan Ulang</button>
            </form>
        </div>
    </div>
</div>

<script>
    function showCancelModal() {
        document.getElementById('cancelModal').classList.add('show');
    }

    function closeCancelModal() {
        document.getElementById('cancelModal').classList.remove('show');
    }

    function showReapplyModal() {
        document.getElementById('reapplyModal').classList.add('show');
    }

    function closeReapplyModal() {
        document.getElementById('reapplyModal').classList.remove('show');
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        const cancelModal = document.getElementById('cancelModal');
        const reapplyModal = document.getElementById('reapplyModal');
        if (event.target === cancelModal) {
            closeCancelModal();
        }
        if (event.target === reapplyModal) {
            closeReapplyModal();
        }
    }
</script>

@endsection
