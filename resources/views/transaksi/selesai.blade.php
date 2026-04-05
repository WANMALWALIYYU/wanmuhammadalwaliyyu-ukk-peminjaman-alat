@extends('index')
@section('pages', 'Transaksi Berhasil')
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
        --success: #2ecc71;
        --warning: #f39c12;
        --danger: #e74c3c;
        --info: #3498db;
        --text-muted: #6c757d;
        --shadow-sm: 0 4px 12px rgba(0,0,0,0.05);
        --shadow-md: 0 8px 24px rgba(27,76,140,0.12);
        --shadow-lg: 0 16px 48px rgba(27,76,140,0.18);
        --transition: all 0.3s ease;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
    }

    .success-wrapper {
        max-width: 700px;
        margin: 40px auto;
        padding: 20px;
        animation: fadeInUp 0.6s ease-out;
    }

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

    .success-card {
        background: white;
        border-radius: 32px;
        padding: 40px 30px;
        text-align: center;
        box-shadow: var(--shadow-lg);
        position: relative;
        overflow: hidden;
    }

    .success-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: linear-gradient(90deg, var(--success), var(--primary));
    }

    .success-icon {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, var(--success), var(--secondary-dark));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
            box-shadow: 0 0 0 0 rgba(46, 204, 113, 0.4);
        }
        50% {
            transform: scale(1.05);
            box-shadow: 0 0 0 15px rgba(46, 204, 113, 0);
        }
    }

    .success-icon i {
        font-size: 48px;
        color: white;
    }

    .success-title {
        font-size: 28px;
        font-weight: 800;
        color: var(--primary);
        margin-bottom: 10px;
    }

    .success-subtitle {
        color: var(--text-muted);
        margin-bottom: 30px;
        font-size: 14px;
    }

    .info-box {
        background: linear-gradient(135deg, #f8f9fa, #ffffff);
        border-radius: 20px;
        padding: 20px;
        margin: 20px 0;
        text-align: left;
        border: 1px solid rgba(0,0,0,0.05);
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #e9ecef;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        color: var(--text-muted);
        font-weight: 500;
        font-size: 14px;
    }

    .info-value {
        font-weight: 700;
        color: var(--primary);
        font-size: 14px;
    }

    /* Product List Styles */
    .product-list-selesai {
        margin: 15px 0;
    }

    .product-item-selesai {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px dashed #e9ecef;
    }

    .product-item-selesai:last-child {
        border-bottom: none;
    }

    .product-name-selesai {
        font-weight: 600;
        color: var(--primary);
        font-size: 14px;
    }

    .product-detail-selesai {
        font-size: 14px;
        font-weight: bold;
        color: var(--text-muted);
        margin-top: 4px;
    }

    .product-subtotal-selesai {
        font-weight: 700;
        color: var(--secondary);
        font-size: 14px;
        text-align: right;
    }

    .deposit-box {
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        border-radius: 20px;
        padding: 20px;
        margin: 20px 0;
        color: white;
        text-align: center;
    }

    .deposit-label {
        font-size: 14px;
        opacity: 0.9;
        margin-bottom: 5px;
    }

    .deposit-amount {
        font-size: 32px;
        font-weight: 800;
        margin-bottom: 5px;
    }

    .deposit-note {
        font-size: 12px;
        opacity: 0.8;
    }

    .sisa-box {
        background: #fff3e0;
        border-radius: 16px;
        padding: 15px;
        margin: 20px 0;
        text-align: center;
    }

    .sisa-label {
        font-size: 13px;
        color: #d97706;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .sisa-amount {
        font-size: 20px;
        font-weight: 800;
        color: #d97706;
    }

    .btn-group-success {
        display: flex;
        gap: 12px;
        margin-top: 25px;
        flex-wrap: wrap;
    }

    .btn-modern {
        flex: 1;
        padding: 14px 20px;
        border-radius: 16px;
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: var(--transition);
        border: none;
        cursor: pointer;
    }

    .btn-primary-modern {
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        color: white;
    }

    .btn-primary-modern:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        color: white;
    }

    .btn-outline-modern {
        background: transparent;
        border: 2px solid var(--primary);
        color: var(--primary);
    }

    .btn-outline-modern:hover {
        background: var(--primary);
        color: white;
        transform: translateY(-2px);
    }

    .btn-success-modern {
        background: linear-gradient(135deg, var(--success), var(--secondary-dark));
        color: white;
    }

    .btn-success-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(46, 204, 113, 0.3);
        color: white;
    }

    .code-box {
        background: var(--primary-soft);
        border-radius: 12px;
        padding: 12px;
        margin: 20px 0;
        font-family: monospace;
        font-size: 14px;
        font-weight: 700;
        color: var(--primary);
        display: inline-block;
        width: auto;
        cursor: pointer;
        transition: var(--transition);
    }

    .code-box:hover {
        background: var(--primary);
        color: white;
    }

    hr {
        margin: 20px 0;
        border: none;
        border-top: 1px solid #e9ecef;
    }

    .badge-count {
        background: var(--primary);
        color: white;
        padding: 2px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        margin-left: 8px;
    }

    @media (max-width: 576px) {
        .success-wrapper {
            margin: 20px auto;
            padding: 10px;
        }

        .success-card {
            padding: 25px 20px;
        }

        .deposit-amount {
            font-size: 24px;
        }

        .btn-modern {
            padding: 12px 16px;
            font-size: 13px;
        }

        .btn-group-success {
            flex-direction: column;
        }

        .product-item-selesai {
            flex-direction: column;
            text-align: left;
            align-items: flex-start;
            gap: 8px;
        }

        .product-subtotal-selesai {
            text-align: left;
        }
    }
</style>

<div class="success-wrapper">
    <div class="success-card">
        <!-- Icon Sukses -->
        <div class="success-icon">
            <i class="fas fa-check-circle"></i>
        </div>

        <!-- Title -->
        <h2 class="success-title">Transaksi Berhasil!</h2>
        <p class="success-subtitle">Deposit Anda sedang diverifikasi oleh admin</p>

        <!-- Kode Transaksi (Click to Copy) -->
        <div class="code-box" onclick="copyToClipboard('{{ $transaksi->kode_transaksi }}')">
            <i class="fas fa-receipt"></i> {{ $transaksi->kode_transaksi }}
            <small style="font-size: 10px;">(klik untuk salin)</small>
        </div>

        <!-- Informasi Ringkas -->
        <div class="info-box">
            <div class="info-row">
                <span class="info-label"><i class="fas fa-user"></i> Peminjam</span>
                <span class="info-value">{{ $transaksi->nama_lengkap }}</span>
            </div>
            <div class="info-row">
                <span class="info-label"><i class="fas fa-box"></i> Jumlah Produk</span>
                <span class="info-value">{{ $transaksi->detailTransaksis->count() }} item</span>
            </div>
        </div>

        <!-- Daftar Produk yang Dipinjam -->
        <div class="info-box">
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 15px;">
                <i class="fas fa-list" style="color: var(--primary);"></i>
                <strong style="color: var(--primary);">Daftar Produk</strong>
                <span class="badge-count">{{ $transaksi->detailTransaksis->count() }} produk</span>
            </div>
            <div class="product-list-selesai">
                @foreach($transaksi->detailTransaksis as $detail)
                <div class="product-item-selesai">
                    <div>
                        <div class="product-name-selesai">
                            <i class="fas fa-cube" style="color: var(--primary); margin-right: 8px;"></i>
                            {{ $detail->nama_produk }}
                        </div>
                        <div class="product-detail-selesai">
                            {{ $detail->jumlah }} unit × {{ $detail->durasi_hari }} hari
                            @if(!$loop->last)
                            <br>
                            @endif
                        </div>
                    </div>
                    <div class="product-subtotal-selesai">
                        Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Total Subtotal -->
            <div style="margin-top: 15px; padding-top: 12px; border-top: 2px solid #e9ecef;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-weight: 600; color: var(--primary);">Total Subtotal:</span>
                    <span style="font-weight: 800; color: var(--secondary); font-size: 18px;">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Deposit yang Dibayar -->
        <div class="deposit-box">
            <div class="deposit-label">Deposit yang Dibayarkan</div>
            <div class="deposit-amount">Rp {{ number_format($deposit, 0, ',', '.') }}</div>
            <div class="deposit-note">(25% dari total harga sewa)</div>
        </div>

        <!-- Sisa Pembayaran -->
        <div class="sisa-box">
            <div class="sisa-label">Sisa Pembayaran (Pelunasan)</div>
            <div class="sisa-amount">Rp {{ number_format($sisaPembayaran, 0, ',', '.') }}</div>
            <div style="font-size: 11px; color: #b45309; margin-top: 5px;">
                <i class="fas fa-info-circle"></i> Akan dilunasi setelah barang dikembalikan
            </div>
        </div>

        <hr>

        <!-- Informasi Penting -->
        <div style="text-align: left; background: #f0f9ff; border-radius: 16px; padding: 15px; margin: 15px 0;">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                <i class="fas fa-clock" style="color: var(--primary);"></i>
                <strong style="font-size: 14px; color: var(--primary);">Status Saat Ini</strong>
            </div>
            <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 5px;">
                Transaksi Anda sedang <strong>menunggu verifikasi petugas</strong>.
                Setelah deposit dikonfirmasi, pesanan akan segera diproses.
            </p>
        </div>

        <!-- Tombol Aksi -->
        <div class="btn-group-success">
            <a href="{{ route('produk.list') }}" class="btn-modern btn-primary-modern">
                <i class="fas fa-shopping-bag"></i> Belanja Lagi
            </a>
            <a href="{{ route('transaksi.riwayat') }}" class="btn-modern btn-outline-modern">
                <i class="fas fa-history"></i> Riwayat Peminjaman
            </a>
            <a href="https://wa.me/62895352983076?text=Halo%20Admin%2C%20saya%20ingin%20menanyakan%20status%20transaksi%20dengan%20kode%20{{ $transaksi->kode_transaksi }}"
               class="btn-modern btn-success-modern" target="_blank">
                <i class="fab fa-whatsapp"></i> Hubungi Admin
            </a>
        </div>
    </div>
</div>

<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            // Tampilkan notifikasi sederhana
            const toast = document.createElement('div');
            toast.innerHTML = `
                <div style="position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%); background: var(--success); color: white; padding: 10px 20px; border-radius: 12px; z-index: 9999; font-size: 14px; animation: fadeInUp 0.3s ease;">
                    <i class="fas fa-check-circle"></i> Kode transaksi disalin!
                </div>
            `;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 2000);
        });
    }
</script>

@endsection
