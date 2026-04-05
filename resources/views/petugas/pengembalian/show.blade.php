{{-- resources/views/petugas/pengembalian/show.blade.php --}}
@extends('petugas.index')

@section('title', 'Detail Pengembalian')

@section('content')
<div class="container-fluid">
    <div class="detail-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1>
                    <i class="fas fa-undo-alt"></i>
                    Detail Pengembalian
                </h1>
                <p class="mb-0">Kode Transaksi: <strong>{{ $pengembalian->transaksi->kode_transaksi }}</strong></p>
            </div>
            <div>
                {!! $pengembalian->status_badge !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <!-- Data Peminjam -->
            <div class="info-card">
                <h5><i class="fas fa-user me-2"></i> Data Peminjam</h5>
                <div class="info-row">
                    <span class="info-label">Nama Lengkap</span>
                    <span class="info-value">{{ $pengembalian->transaksi->nama_lengkap }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email</span>
                    <span class="info-value">{{ $pengembalian->transaksi->email }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">No. Telepon</span>
                    <span class="info-value">{{ $pengembalian->transaksi->no_telepon }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Alamat</span>
                    <span class="info-value">{{ $pengembalian->transaksi->alamat_lengkap }}</span>
                </div>
            </div>

            <!-- Detail Produk -->
            <div class="info-card mt-3">
                <h5><i class="fas fa-box me-2"></i> Detail Produk Dipinjam</h5>
                @foreach($pengembalian->transaksi->detailTransaksis as $detail)
                <div class="product-item">
                    <div class="d-flex justify-content-between">
                        <strong>{{ $detail->nama_produk }}</strong>
                        <span class="text-primary">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="small text-muted">
                        {{ $detail->jumlah }} unit × {{ $detail->durasi_hari }} hari
                        ({{ $detail->tanggal_mulai->format('d M Y') }} - {{ $detail->tanggal_selesai->format('d M Y') }})
                    </div>
                </div>
                @endforeach
                <div class="total-row">
                    <strong>Total Subtotal</strong>
                    <strong class="text-primary">Rp {{ number_format($subtotal, 0, ',', '.') }}</strong>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <!-- Informasi Pengiriman -->
            <div class="info-card">
                <h5><i class="fas fa-truck me-2"></i> Informasi Pengiriman</h5>
                <div class="info-row">
                    <span class="info-label">Kurir</span>
                    <span class="info-value">{{ $pengembalian->kurir_pengembalian ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">No. Resi</span>
                    <span class="info-value">{{ $pengembalian->no_resi_pengembalian ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tanggal Dikirim</span>
                    <span class="info-value">{{ $pengembalian->tanggal_dikirim ? $pengembalian->tanggal_dikirim->format('d M Y H:i') : '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tanggal Sampai</span>
                    <span class="info-value">{{ $pengembalian->tanggal_sampai ? $pengembalian->tanggal_sampai->format('d M Y H:i') : '-' }}</span>
                </div>
                @if($pengembalian->catatan_user)
                <div class="info-row">
                    <span class="info-label">Catatan User</span>
                    <span class="info-value">{{ $pengembalian->catatan_user }}</span>
                </div>
                @endif
            </div>

            <!-- Foto Barang -->
            <div class="info-card mt-3">
                <h5><i class="fas fa-camera me-2"></i> Dokumentasi</h5>
                <div class="row">
                    @if($pengembalian->foto_barang_dikembalikan)
                    <div class="col-6">
                        <label class="form-label fw-semibold">Foto Barang Dikirim</label>
                        <img src="{{ asset('storage/' . $pengembalian->foto_barang_dikembalikan) }}"
                             class="img-fluid rounded-3" style="cursor: pointer;"
                             onclick="window.open(this.src)">
                    </div>
                    @endif
                    @if($pengembalian->foto_barang_setelah_sampai)
                    <div class="col-6">
                        <label class="form-label fw-semibold">Foto Setelah Sampai</label>
                        <img src="{{ asset('storage/' . $pengembalian->foto_barang_setelah_sampai) }}"
                             class="img-fluid rounded-3" style="cursor: pointer;"
                             onclick="window.open(this.src)">
                    </div>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="info-card mt-3">
                @if($pengembalian->status == 'dikirim')
                <form action="{{ route('petugas.pengembalian.mark-sampai', $pengembalian->id) }}"
                      method="POST" enctype="multipart/form-data" id="formSampai">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Foto Barang Setelah Sampai <span class="text-danger">*</span></label>
                        <input type="file" name="foto_barang_setelah_sampai" class="form-control" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-check-circle me-1"></i> Konfirmasi Barang Sampai
                    </button>
                </form>
                @endif

                @if($pengembalian->status == 'sampai')
                <a href="{{ route('petugas.pengembalian.pemeriksaan', $pengembalian->id) }}"
                   class="btn btn-warning w-100">
                    <i class="fas fa-clipboard-list me-1"></i> Proses Pemeriksaan
                </a>
                @endif

                <a href="{{ route('petugas.pengembalian.index') }}" class="btn btn-secondary w-100 mt-2">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.detail-header {
    background: linear-gradient(145deg, #0b2c5d, #1f3c88);
    border-radius: 1.5rem;
    padding: 2rem;
    margin-bottom: 2rem;
    color: white;
}
.detail-header h1 {
    font-size: 1.8rem;
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
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #e2e8f0;
}
.info-row {
    display: flex;
    justify-content: space-between;
    padding: 0.5rem 0;
    border-bottom: 1px solid #f1f5f9;
}
.info-label {
    font-weight: 600;
    color: #64748b;
}
.info-value {
    font-weight: 500;
    text-align: right;
}
.product-item {
    padding: 0.75rem 0;
    border-bottom: 1px solid #f1f5f9;
}
.total-row {
    display: flex;
    justify-content: space-between;
    padding: 1rem 0 0;
    margin-top: 0.5rem;
    border-top: 2px solid #e2e8f0;
    font-size: 1.1rem;
}
</style>
@endsection
