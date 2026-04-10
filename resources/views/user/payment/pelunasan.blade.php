<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/image/logo-mcr.png') }}" />
    <title>Pembayaran Pelunasan - MedikCareRent</title>

    <!-- Midtrans Snap (Sandbox) -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

    <!-- Font Awesome & Google Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f6f9fc 0%, #edf2f9 100%);
            min-height: 100vh;
            padding: 2rem;
        }

        .payment-container {
            max-width: 900px;
            margin: 0 auto;
        }

        .payment-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .payment-header h1 {
            font-size: 2rem;
            font-weight: 800;
            color: #1a2639;
            margin-bottom: 0.5rem;
        }

        .payment-header p {
            color: #64748b;
        }

        .sandbox-badge {
            background: #f59e0b;
            color: white;
            padding: 0.25rem 1rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
            margin-top: 0.5rem;
        }

        .payment-card {
            background: white;
            border-radius: 2rem;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        .card-section {
            padding: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .card-section:last-child {
            border-bottom: none;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.2rem;
            font-weight: 700;
            color: #0b2c5d;
            margin-bottom: 1.5rem;
        }

        .section-title i {
            width: 40px;
            height: 40px;
            background: #e8f0fe;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0b2c5d;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px dashed #e2e8f0;
        }

        .info-label {
            font-weight: 500;
            color: #64748b;
        }

        .info-value {
            font-weight: 600;
            color: #1a2639;
        }

        .price-highlight {
            font-size: 1.2rem;
            font-weight: 800;
            color: #10b981;
        }

        .total-row {
            background: #f0fdf4;
            padding: 1rem;
            border-radius: 1rem;
            margin-top: 1rem;
        }

        .btn-pay {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #0b2c5d, #1f3c88);
            color: white;
            border: none;
            border-radius: 1rem;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }

        .btn-pay:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(11,44,93,0.3);
        }

        .btn-back {
            width: 100%;
            padding: 0.75rem;
            background: transparent;
            border: 2px solid #e2e8f0;
            border-radius: 1rem;
            color: #64748b;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-back:hover {
            border-color: #0b2c5d;
            color: #0b2c5d;
        }

        .product-list {
            margin-top: 1rem;
        }

        .product-item {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .product-name {
            font-weight: 600;
        }

        .product-price {
            color: #10b981;
            font-weight: 700;
        }

        .denda-item {
            background: #fef2f2;
            padding: 0.75rem;
            border-radius: 0.75rem;
            margin-top: 0.5rem;
            color: #dc2626;
        }

        .payment-methods-info {
            background: #f8fafc;
            padding: 1rem;
            border-radius: 1rem;
            margin-top: 1rem;
        }

        .payment-methods-info h4 {
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
            color: #0b2c5d;
        }

        .payment-methods-info p {
            font-size: 0.8rem;
            color: #64748b;
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }
            .info-row {
                flex-direction: column;
                gap: 0.25rem;
            }
            .info-value {
                text-align: left;
            }
        }
    </style>
</head>
<body>
    <div class="payment-container">
        <div class="payment-header">
            <h1><i class="fas fa-credit-card"></i> Pelunasan Peminjaman</h1>
            <p>Lakukan pembayaran pelunasan untuk menyelesaikan transaksi Anda</p>
            <div class="sandbox-badge">
                <i class="fas fa-flask"></i> SANDBOX MODE - TESTING
            </div>
        </div>

        <div class="payment-card">
            <!-- Informasi Transaksi -->
            <div class="card-section">
                <div class="section-title">
                    <i class="fas fa-receipt"></i>
                    <span>Informasi Transaksi</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Kode Transaksi</span>
                    <span class="info-value">{{ $transaksi->kode_transaksi }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tanggal Pengajuan</span>
                    <span class="info-value">{{ $transaksi->tanggal_pengajuan->format('d M Y H:i') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Nama Peminjam</span>
                    <span class="info-value">{{ $transaksi->nama_lengkap }}</span>
                </div>
            </div>

            <!-- Detail Produk -->
            <div class="card-section">
                <div class="section-title">
                    <i class="fas fa-box"></i>
                    <span>Detail Produk</span>
                </div>
                <div class="product-list">
                    @foreach($transaksi->detailTransaksis as $detail)
                    <div class="product-item">
                        <div>
                            <div class="product-name">{{ $detail->nama_produk }}</div>
                            <small class="text-muted">{{ $detail->jumlah }} unit × {{ $detail->durasi_hari }} hari</small>
                        </div>
                        <div class="product-price">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Ringkasan Pembayaran -->
            <div class="card-section">
                <div class="section-title">
                    <i class="fas fa-calculator"></i>
                    <span>Ringkasan Pembayaran</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Total Subtotal</span>
                    <span class="info-value">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Deposit (Telah Dibayar)</span>
                    <span class="info-value" style="color: #dc2626;">- Rp {{ number_format($deposit, 0, ',', '.') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Sisa Pembayaran</span>
                    <span class="info-value">Rp {{ number_format($sisaPembayaran, 0, ',', '.') }}</span>
                </div>

                @if(isset($biayaTambahan) && $biayaTambahan > 0)
                <div class="denda-item">
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-exclamation-triangle"></i> Biaya Tambahan (Denda/Kerusakan)</span>
                        <span class="info-value" style="color: #dc2626;">+ Rp {{ number_format($biayaTambahan, 0, ',', '.') }}</span>
                    </div>
                    @if(isset($pengembalian) && $pengembalian && $pengembalian->deskripsi_kerusakan)
                    <small class="text-muted mt-2 d-block">{{ $pengembalian->deskripsi_kerusakan }}</small>
                    @endif
                </div>
                @endif

                <div class="total-row">
                    <div class="info-row">
                        <span class="info-label" style="font-weight: 800; font-size: 1.1rem;">Total Yang Harus Dibayar</span>
                        <span class="price-highlight">Rp {{ number_format($totalBayar, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Metode Pembayaran -->
            <div class="card-section">
                <div class="section-title">
                    <i class="fas fa-credit-card"></i>
                    <span>Metode Pembayaran</span>
                </div>

                <div class="payment-methods-info">
                    <h4><i class="fas fa-info-circle"></i> Informasi Penting</h4>
                    <p>Pembayaran diproses secara aman oleh Midtrans. Metode pembayaran yang tersedia:</p>
                    <ul style="margin-top: 0.5rem; margin-left: 1.5rem; color: #64748b; font-size: 0.85rem;">
                        <li>Transfer Bank (BCA, Mandiri, BRI, BNI, Permata)</li>
                        <li>Kartu Kredit (Visa, Mastercard, JCB)</li>
                        <li>E-Wallet (GoPay, OVO, Dana, ShopeePay)</li>
                        <li>QRIS (Scan QR Code)</li>
                        <li>Virtual Account (BCA, Mandiri, BRI, BNI, Permata)</li>
                    </ul>
                    <p class="mt-2" style="font-size: 0.75rem; color: #f59e0b;">
                        <i class="fas fa-flask"></i> Mode Sandbox - Gunakan kartu uji Midtrans untuk testing
                    </p>
                </div>

                <button class="btn-pay" id="payButton">
                    <i class="fas fa-credit-card"></i>
                    Bayar Sekarang
                </button>
                <a href="{{ route('transaksi.riwayat') }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Kembali ke Riwayat
                </a>
            </div>
        </div>
    </div>

    <script>
        const snapToken = "{{ $snapToken ?? '' }}";

        document.getElementById('payButton').addEventListener('click', function() {
            if (snapToken) {
                window.snap.pay(snapToken, {
                    onSuccess: function(result) {
                        console.log('Payment Success:', result);
                        window.location.href = "{{ route('user.payment.success') }}?order_id=" + result.order_id;
                    },
                    onPending: function(result) {
                        console.log('Payment Pending:', result);
                        window.location.href = "{{ route('user.payment.pending') }}?order_id=" + result.order_id;
                    },
                    onError: function(result) {
                        console.log('Payment Error:', result);
                        window.location.href = "{{ route('user.payment.error') }}?order_id=" + (result.order_id || '');
                    },
                    onClose: function() {
                        console.log('Payment popup closed');
                    }
                });
            } else {
                alert('Snap token tidak tersedia. Silakan refresh halaman atau hubungi admin.');
            }
        });

        // Log for debugging
        console.log('Snap Token available:', !!snapToken);
    </script>
</body>
</html>
