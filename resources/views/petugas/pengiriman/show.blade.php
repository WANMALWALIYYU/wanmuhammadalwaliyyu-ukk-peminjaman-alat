{{-- resources/views/petugas/pengiriman/show.blade.php --}}
@extends('petugas.index')

@section('title', 'Detail Pengiriman')

@section('content')
<div class="container-fluid">
    <div class="pengiriman-header">
        <h1>
            <i class="fas fa-info-circle"></i>
            Detail Pengiriman
        </h1>
        <p>
            <i class="fas fa-box"></i>
            <span>Informasi lengkap pengiriman transaksi {{ $pengiriman->transaksi->kode_transaksi }}</span>
        </p>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="info-card">
                <h5><i class="fas fa-truck me-2"></i> Informasi Pengiriman</h5>
                <div class="info-row">
                    <span class="info-label">Status Pengiriman</span>
                    <span class="info-value">{!! $pengiriman->status_pengiriman !!}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Petugas Pengirim</span>
                    <span class="info-value">{{ $pengiriman->petugas->name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tanggal Dikirim</span>
                    <span class="info-value">{{ $pengiriman->tanggal_dikirim ? $pengiriman->tanggal_dikirim->format('d M Y H:i') : '-' }}</span>
                </div>
                @if($pengiriman->tanggal_sampai)
                <div class="info-row">
                    <span class="info-label">Tanggal Sampai</span>
                    <span class="info-value">{{ $pengiriman->tanggal_sampai->format('d M Y H:i') }}</span>
                </div>
                @endif
                @if($pengiriman->catatan_pengiriman)
                <div class="info-row">
                    <span class="info-label">Catatan Pengiriman</span>
                    <span class="info-value">{{ $pengiriman->catatan_pengiriman }}</span>
                </div>
                @endif
                @if($pengiriman->catatan_penerimaan)
                <div class="info-row">
                    <span class="info-label">Catatan Penerimaan</span>
                    <span class="info-value">{{ $pengiriman->catatan_penerimaan }}</span>
                </div>
                @endif
            </div>

            <div class="info-card mt-3">
                <h5><i class="fas fa-user me-2"></i> Data Peminjam</h5>
                <div class="info-row">
                    <span class="info-label">Nama Lengkap</span>
                    <span class="info-value">{{ $pengiriman->transaksi->nama_lengkap }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email</span>
                    <span class="info-value">{{ $pengiriman->transaksi->email }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">No. Telepon</span>
                    <span class="info-value">{{ $pengiriman->transaksi->no_telepon }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Alamat</span>
                    <span class="info-value">{{ $pengiriman->transaksi->alamat_lengkap }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="info-card">
                <h5><i class="fas fa-camera me-2"></i> Dokumentasi Pengiriman</h5>
                <div class="row">
                    <div class="col-md-6">
                        <label class="fw-semibold mb-2">Foto Barang Dikirim</label>
                        @if($pengiriman->foto_barang_dikirim)
                            <a href="{{ $pengiriman->foto_dikirim_url }}" target="_blank">
                                <img src="{{ $pengiriman->foto_dikirim_url }}"
                                     alt="Foto Barang Dikirim"
                                     class="img-fluid rounded-3"
                                     style="max-height: 200px; width: 100%; object-fit: cover;">
                            </a>
                        @else
                            <div class="bg-light rounded-3 p-4 text-center text-muted">
                                <i class="fas fa-image fa-3x mb-2"></i>
                                <p>Belum ada foto</p>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <label class="fw-semibold mb-2">Foto Barang Sampai</label>
                        @if($pengiriman->foto_barang_sampai)
                            <a href="{{ $pengiriman->foto_sampai_url }}" target="_blank">
                                <img src="{{ $pengiriman->foto_sampai_url }}"
                                     alt="Foto Barang Sampai"
                                     class="img-fluid rounded-3"
                                     style="max-height: 200px; width: 100%; object-fit: cover;">
                            </a>
                        @else
                            <div class="bg-light rounded-3 p-4 text-center text-muted">
                                <i class="fas fa-clock fa-3x mb-2"></i>
                                <p>Menunggu konfirmasi penerimaan</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="info-card mt-3">
                <h5><i class="fas fa-box me-2"></i> Detail Produk</h5>
                @foreach($pengiriman->transaksi->detailTransaksis as $detail)
                <div class="product-row">
                    <div class="product-name">{{ $detail->nama_produk }}</div>
                    <div class="product-detail">
                        <span>{{ $detail->jumlah }} unit</span>
                        <span>•</span>
                        <span>{{ $detail->durasi_hari }} hari</span>
                        <span>•</span>
                        <span>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-3 d-flex gap-2">
                <a href="{{ route('petugas.pengiriman.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
                <a href="{{ route('petugas.pengiriman.in-progress') }}" class="btn btn-outline-primary">
                    <i class="fas fa-truck-moving me-1"></i> Lihat Semua Pengiriman
                </a>
                <a href="{{ route('petugas.peminjaman.detail', $pengiriman->transaksi->id) }}" class="btn btn-outline-info">
                    <i class="fas fa-file-alt me-1"></i> Detail Transaksi
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.pengiriman-header {
    background: linear-gradient(145deg, #0b2c5d, #1f3c88);
    border-radius: 1.5rem;
    padding: 2rem;
    margin-bottom: 2rem;
    color: white;
}

.pengiriman-header h1 {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.info-card {
    background: white;
    border-radius: 1rem;
    padding: 1.5rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.info-card h5 {
    font-size: 1rem;
    font-weight: 700;
    margin-bottom: 1.25rem;
    padding-bottom: 0.75rem;
    border-bottom: 1px solid #e2e8f0;
}

.info-row {
    display: flex;
    justify-content: space-between;
    padding: 0.75rem 0;
    border-bottom: 1px solid #f1f5f9;
}

.info-row:last-child {
    border-bottom: none;
}

.info-label {
    font-weight: 600;
    color: #64748b;
    font-size: 0.85rem;
}

.info-value {
    font-weight: 500;
    color: #0f172a;
    text-align: right;
    flex: 1;
    margin-left: 1rem;
}

.product-row {
    padding: 0.75rem 0;
    border-bottom: 1px solid #f1f5f9;
}

.product-row:last-child {
    border-bottom: none;
}

.product-name {
    font-weight: 600;
    color: #0b2c5d;
    margin-bottom: 0.25rem;
}

.product-detail {
    font-size: 0.8rem;
    color: #64748b;
}

@media (max-width: 768px) {
    .pengiriman-header h1 {
        font-size: 1.5rem;
    }

    .info-row {
        flex-direction: column;
        gap: 0.25rem;
    }

    .info-value {
        text-align: left;
        margin-left: 0;
    }
}
</style>
@endsection
