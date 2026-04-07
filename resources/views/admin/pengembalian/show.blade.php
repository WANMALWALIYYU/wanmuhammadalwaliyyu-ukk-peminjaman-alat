{{-- resources/views/admin/pengembalian/show.blade.php --}}
@extends('admin.index')

@section('title', 'Detail Pengembalian')
@section('page-title', 'Detail Pengembalian')
@section('breadcrumb', 'Pengembalian')

@section('content-dashboard')

<style>
.card-header.bg-light {
    background-color: #f8f9fa !important;
}
.bg-gray-50 {
    background-color: #f8fafc;
}
.table-borderless td, .table-borderless th {
    padding: 0.5rem 0;
}
.photo-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.photo-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}
.photo-card .card-header {
    border-bottom: none;
    font-weight: 600;
}
.photo-img {
    max-height: 200px;
    width: auto;
    max-width: 100%;
    object-fit: cover;
    cursor: pointer;
    transition: transform 0.3s ease;
}
.photo-img:hover {
    transform: scale(1.02);
}
</style>

<div class="container-fluid pe-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border shadow-xs">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-undo-alt me-2"></i>
                            Detail Pengembalian - {{ $pengembalian->transaksi->kode_transaksi ?? '-' }}
                        </h5>
                        <a href="{{ route('admin.pengembalian.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left Column -->
        <div class="col-lg-8">
            <!-- Informasi Transaksi -->
            <div class="card border shadow-xs mb-4">
                <div class="card-header border-bottom pb-0">
                    <h6 class="font-weight-semibold text-lg mb-0">
                        <i class="fas fa-receipt me-2"></i>Informasi Transaksi
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="140" class="text-secondary">Kode Transaksi</td>
                                    <td class="fw-semibold">{{ $transaksi->kode_transaksi ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-secondary">Status Transaksi</td>
                                    <td>{!! $transaksi->status_badge ?? '-' !!}</td>
                                </tr>
                                <tr>
                                    <td class="text-secondary">Tanggal Pengajuan</td>
                                    <td>{{ $transaksi->tanggal_pengajuan ? $transaksi->tanggal_pengajuan->format('d M Y H:i') : '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-secondary">Metode Pembayaran</td>
                                    <td>{{ $transaksi->metode_pembayaran ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-secondary">Jumlah Deposit</td>
                                    <td class="text-success">Rp {{ number_format($deposit, 0, ',', '.') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="140" class="text-secondary">Nama Peminjam</td>
                                    <td class="fw-semibold">{{ $transaksi->nama_lengkap ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-secondary">Email</td>
                                    <td>{{ $transaksi->email ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-secondary">No. Telepon</td>
                                    <td>{{ $transaksi->no_telepon ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-secondary">No. Identitas (KTP)</td>
                                    <td>{{ $transaksi->no_identitas ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alamat Pengiriman -->
            <div class="card border shadow-xs mb-4">
                <div class="card-header border-bottom pb-0">
                    <h6 class="font-weight-semibold text-lg mb-0">
                        <i class="fas fa-map-marker-alt me-2"></i>Alamat Pengiriman
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Provinsi:</strong> {{ $transaksi->provinsi ?? '-' }}</p>
                            <p class="mb-1"><strong>Kabupaten:</strong> {{ $transaksi->kabupaten ?? '-' }}</p>
                            <p class="mb-1"><strong>Kecamatan:</strong> {{ $transaksi->kecamatan ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Kelurahan:</strong> {{ $transaksi->kelurahan ?? '-' }}</p>
                            <p class="mb-1"><strong>Alamat Lengkap:</strong> {{ $transaksi->alamat_lengkap ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Produk yang Dipinjam -->
            <div class="card border shadow-xs mb-4">
                <div class="card-header border-bottom pb-0">
                    <h6 class="font-weight-semibold text-lg mb-0">
                        <i class="fas fa-box me-2"></i>Detail Produk yang Dipinjam
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="text-secondary text-xs">Produk</th>
                                    <th class="text-secondary text-xs text-center">Jumlah</th>
                                    <th class="text-secondary text-xs text-center">Durasi</th>
                                    <th class="text-secondary text-xs text-center">Tanggal Sewa</th>
                                    <th class="text-secondary text-xs text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($detailTransaksis as $detail)
                                <tr>
                                    <td>
                                        <strong>{{ $detail->nama_produk }}</strong>
                                        <br>
                                        <small class="text-muted">Rp {{ number_format($detail->harga_per_hari, 0, ',', '.') }}/hari</small>
                                    </td>
                                    <td class="text-center">{{ $detail->jumlah }} unit</td>
                                    <td class="text-center">{{ $detail->durasi_hari }} hari</td>
                                    <td class="text-center">{{ $detail->tanggal_mulai->format('d M Y') }} - {{ $detail->tanggal_selesai->format('d M Y') }}</td>
                                    <td class="text-end fw-bold">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-light">
                                <tr>
                                    <td colspan="4" class="text-end fw-bold">Total Subtotal</td>
                                    <td class="text-end fw-bold text-primary">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- DOKUMENTASI FOTO - DITARUH DI BAWAH DETAIL PRODUK (SEJAJAR KANAN-KIRI) -->
            <div class="card border shadow-xs mb-4">
                <div class="card-header border-bottom pb-0">
                    <h6 class="font-weight-semibold text-lg mb-0">
                        <i class="fas fa-images me-2"></i>Dokumentasi Foto Pengembalian
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Foto Barang Dikembalikan (User) - Kiri -->
                        <div class="col-md-6 mb-3 mb-md-0">
                            <div class="card photo-card h-100 border">
                                <div class="card-header bg-primary text-white py-2">
                                    <small class="fw-semibold">
                                        <i class="fas fa-camera me-1"></i> Foto Barang Dikembalikan
                                    </small>
                                    <br>
                                    <small class="opacity-75">(Diupload Peminjam)</small>
                                </div>
                                <div class="card-body text-center p-3">
                                    @if($pengembalian->foto_barang_dikembalikan)
                                        <a href="{{ asset('storage/' . $pengembalian->foto_barang_dikembalikan) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $pengembalian->foto_barang_dikembalikan) }}"
                                                 alt="Foto Barang Dikembalikan"
                                                 class="photo-img rounded">
                                        </a>
                                    @else
                                        <div class="text-muted py-4">
                                            <i class="fas fa-image fa-3x mb-2 d-block"></i>
                                            <p class="mb-0">Tidak ada foto</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Foto Barang Setelah Sampai (Petugas) - Kanan -->
                        <div class="col-md-6">
                            <div class="card photo-card h-100 border">
                                <div class="card-header bg-success text-white py-2">
                                    <small class="fw-semibold">
                                        <i class="fas fa-check-circle me-1"></i> Foto Barang Setelah Sampai
                                    </small>
                                    <br>
                                    <small class="opacity-75">(Dokumentasi Petugas)</small>
                                </div>
                                <div class="card-body text-center p-3">
                                    @if($pengembalian->foto_barang_setelah_sampai)
                                        <a href="{{ asset('storage/' . $pengembalian->foto_barang_setelah_sampai) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $pengembalian->foto_barang_setelah_sampai) }}"
                                                 alt="Foto Barang Setelah Sampai"
                                                 class="photo-img rounded">
                                        </a>
                                    @else
                                        <div class="text-muted py-4">
                                            <i class="fas fa-image fa-3x mb-2 d-block"></i>
                                            <p class="mb-0">Belum ada foto konfirmasi</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="col-lg-4">
            <!-- Status Pengembalian -->
            <div class="card border shadow-xs mb-4">
                <div class="card-header border-bottom pb-0">
                    <h6 class="font-weight-semibold text-lg mb-0">
                        <i class="fas fa-info-circle me-2"></i>Status Pengembalian
                    </h6>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        {!! $pengembalian->status_badge !!}
                    </div>
                    <div class="mt-3">
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i>
                            Terakhir update: {{ $pengembalian->updated_at ? $pengembalian->updated_at->format('d M Y H:i') : '-' }}
                        </small>
                    </div>
                </div>
            </div>

            <!-- Informasi Pengiriman Kembali -->
            <div class="card border shadow-xs mb-4">
                <div class="card-header border-bottom pb-0">
                    <h6 class="font-weight-semibold text-lg mb-0">
                        <i class="fas fa-truck me-2"></i>Informasi Pengiriman Kembali
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-secondary mb-1">Kurir</label>
                        <p class="fw-semibold mb-0">{{ $pengembalian->kurir_pengembalian ?? '-' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-secondary mb-1">No. Resi</label>
                        <p class="fw-semibold mb-0">{{ $pengembalian->no_resi_pengembalian ?? '-' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-secondary mb-1">Tanggal Dikirim</label>
                        <p class="mb-0">{{ $pengembalian->tanggal_dikirim ? $pengembalian->tanggal_dikirim->format('d M Y H:i') : '-' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-secondary mb-1">Tanggal Sampai</label>
                        <p class="mb-0">{{ $pengembalian->tanggal_sampai ? $pengembalian->tanggal_sampai->format('d M Y H:i') : '-' }}</p>
                    </div>
                    @if($pengembalian->catatan_user)
                    <div class="mt-3 p-2 bg-light rounded">
                        <label class="text-secondary mb-1">
                            <i class="fas fa-comment me-1"></i>Catatan Peminjam
                        </label>
                        <p class="mb-0 small">{{ $pengembalian->catatan_user }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Ringkasan Biaya -->
            <div class="card border shadow-xs mb-4">
                <div class="card-header border-bottom pb-0">
                    <h6 class="font-weight-semibold text-lg mb-0">
                        <i class="fas fa-money-bill-wave me-2"></i>Ringkasan Biaya
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-secondary">Total Subtotal Sewa</span>
                        <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-secondary">Deposit Dibayar</span>
                        <span class="text-success">Rp {{ number_format($deposit, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-secondary">Sisa Pembayaran</span>
                        <span>Rp {{ number_format($sisaPembayaran, 0, ',', '.') }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-secondary">Kondisi Barang</span>
                        <span>{!! $pengembalian->kondisi_badge !!}</span>
                    </div>
                    @if($pengembalian->biaya_kerusakan > 0)
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-secondary">Biaya Kerusakan</span>
                        <span class="text-danger">Rp {{ number_format($pengembalian->biaya_kerusakan, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    @if($pengembalian->denda_keterlambatan > 0)
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-secondary">Denda Keterlambatan</span>
                        <span class="text-danger">Rp {{ number_format($pengembalian->denda_keterlambatan, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    <hr>
                    <div class="d-flex justify-content-between">
                        <strong>Total Biaya Tambahan</strong>
                        <strong class="text-primary">Rp {{ number_format($pengembalian->total_biaya_tambahan, 0, ',', '.') }}</strong>
                    </div>
                    @if($hariTerlambat > 0)
                    <div class="alert alert-warning mt-3 mb-0 py-2 small">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        Terlambat {{ $hariTerlambat }} hari dari jadwal sewa
                    </div>
                    @endif
                </div>
            </div>

            <!-- Informasi Petugas -->
            @if($pengembalian->petugas)
            <div class="card border shadow-xs mb-4">
                <div class="card-header border-bottom pb-0">
                    <h6 class="font-weight-semibold text-lg mb-0">
                        <i class="fas fa-user-check me-2"></i>Diproses Oleh
                    </h6>
                </div>
                <div class="card-body">
                    <p class="mb-1"><strong>{{ $pengembalian->petugas->name }}</strong></p>
                    <p class="mb-0 text-muted small">{{ $pengembalian->petugas->email }}</p>
                    @if($pengembalian->catatan_petugas)
                    <div class="mt-2 p-2 bg-light rounded">
                        <label class="text-secondary mb-1">Catatan Petugas</label>
                        <p class="mb-0 small">{{ $pengembalian->catatan_petugas }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection
