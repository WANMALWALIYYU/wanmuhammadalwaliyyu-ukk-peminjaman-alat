@extends('admin.index')
@section('title', 'Detail Pengiriman')
@section('page-title', 'Detail Pengiriman')
@section('breadcrumb', 'Pengiriman')
@section('content-dashboard')

<div class="container-fluid pe-4">
    <div class="row">
        <div class="col-12">
            <div class="card border shadow-xs mb-4">
                <div class="card-header border-bottom pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="font-weight-semibold text-lg mb-0">
                                <i class="fas fa-truck text-primary me-2"></i>
                                Detail Pengiriman - {{ $pengiriman->transaksi->kode_transaksi ?? 'N/A' }}
                            </h6>
                            <p class="text-sm">Informasi lengkap pengiriman barang</p>
                        </div>
                        <a href="{{ route('admin.pengiriman.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- Status Banner -->
                    <div class="alert mb-4
                        @if($pengiriman->tanggal_sampai) alert-success
                        @elseif($pengiriman->tanggal_dikirim) alert-warning
                        @else alert-secondary @endif">
                        <div class="d-flex align-items-center">
                            <i class="fas
                                @if($pengiriman->tanggal_sampai) fa-check-circle
                                @elseif($pengiriman->tanggal_dikirim) fa-truck-moving
                                @else fa-clock @endif fa-2x me-3"></i>
                            <div>
                                <h5 class="mb-1">
                                    @if($pengiriman->tanggal_sampai)
                                        Pengiriman Selesai
                                    @elseif($pengiriman->tanggal_dikirim)
                                        Dalam Perjalanan
                                    @else
                                        Belum Dikirim
                                    @endif
                                </h5>
                                <p class="mb-0">
                                    @if($pengiriman->tanggal_sampai)
                                        Barang telah sampai pada {{ $pengiriman->tanggal_sampai->format('d M Y H:i') }}
                                    @elseif($pengiriman->tanggal_dikirim)
                                        Barang dikirim pada {{ $pengiriman->tanggal_dikirim->format('d M Y H:i') }}
                                    @else
                                        Pengiriman belum dilakukan
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Left Column - Delivery Info -->
                        <div class="col-md-6">
                            <div class="card border mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i> Informasi Pengiriman</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="180" class="fw-semibold">ID Pengiriman</td>
                                            <td>: #{{ $pengiriman->id }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">Kode Transaksi</td>
                                            <td>: <span class="fw-bold text-primary">{{ $pengiriman->transaksi->kode_transaksi ?? '-' }}</span></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">Petugas Pengirim</td>
                                            <td>: {{ $pengiriman->petugas->name ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">Tanggal Dikirim</td>
                                            <td>: {{ $pengiriman->tanggal_dikirim ? $pengiriman->tanggal_dikirim->format('d M Y H:i:s') : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">Tanggal Sampai</td>
                                            <td>: {{ $pengiriman->tanggal_sampai ? $pengiriman->tanggal_sampai->format('d M Y H:i:s') : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">Dibuat Pada</td>
                                            <td>: {{ $pengiriman->created_at->format('d M Y H:i:s') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <!-- Catatan Pengiriman -->
                            <div class="card border">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-note-sticky me-2"></i> Catatan Pengiriman</h6>
                                </div>
                                <div class="card-body">
                                    <p class="mb-0">
                                        {{ $pengiriman->catatan_pengiriman ?: 'Tidak ada catatan pengiriman' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Catatan Penerimaan -->
                            @if($pengiriman->catatan_penerimaan)
                            <div class="card border mt-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-file-alt me-2"></i> Catatan Penerimaan</h6>
                                </div>
                                <div class="card-body">
                                    <p class="mb-0">{{ $pengiriman->catatan_penerimaan }}</p>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Right Column - Customer & Product Info -->
                        <div class="col-md-6">
                            <div class="card border mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-user me-2"></i> Data Peminjam</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="140" class="fw-semibold">Nama Lengkap</td>
                                            <td>: {{ $transaksi->nama_lengkap ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">Email</td>
                                            <td>: {{ $transaksi->email ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">No Telepon</td>
                                            <td>: {{ $transaksi->no_telepon ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">No Identitas</td>
                                            <td>: {{ $transaksi->no_identitas ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">Alamat</td>
                                            <td>: {{ $transaksi->alamat_lengkap ?? '-' }}, {{ $transaksi->kelurahan ?? '-' }}, {{ $transaksi->kecamatan ?? '-' }}, {{ $transaksi->kabupaten ?? '-' }}, {{ $transaksi->provinsi ?? '-' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="card border">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-box me-2"></i> Detail Produk</h6>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-sm mb-0">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th>Produk</th>
                                                    <th class="text-center">Jumlah</th>
                                                    <th class="text-center">Durasi</th>
                                                    <th class="text-end">Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($transaksi->detailTransaksis as $detail)
                                                <tr>
                                                    <td>{{ $detail->nama_produk }}</td>
                                                    <td class="text-center">{{ $detail->jumlah }}</td>
                                                    <td class="text-center">{{ $detail->durasi_hari }} hari</td>
                                                    <td class="text-end">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot class="bg-gray-50">
                                                <tr>
                                                    <td colspan="3" class="fw-semibold text-end">Total Biaya Sewa:</td>
                                                    <td class="fw-bold text-end text-primary">Rp {{ number_format($totalBiaya ?? 0, 0, ',', '.') }}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" class="fw-semibold text-end">Deposit (25%):</td>
                                                    <td class="fw-bold text-end text-warning">Rp {{ number_format($transaksi->jumlah_deposit ?? 0, 0, ',', '.') }}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" class="fw-semibold text-end">Sisa Pembayaran:</td>
                                                    <td class="fw-bold text-end text-success">Rp {{ number_format($sisaPembayaran ?? 0, 0, ',', '.') }}</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Photo Gallery -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card border">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-images me-2"></i> Dokumentasi Foto</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="card h-100">
                                                <div class="card-header bg-primary text-white py-2">
                                                    <small class="fw-semibold"><i class="fas fa-camera me-1"></i> Foto Barang Dikirim</small>
                                                    <br>
                                                    <small class="opacity-75">(Diupload Petugas)</small>
                                                </div>
                                                <div class="card-body text-center p-3">
                                                    @if($pengiriman->foto_barang_dikirim)
                                                        <a href="{{ asset('storage/' . $pengiriman->foto_barang_dikirim) }}" target="_blank">
                                                            <img src="{{ asset('storage/' . $pengiriman->foto_barang_dikirim) }}"
                                                                 alt="Foto Barang Dikirim"
                                                                 class="img-fluid rounded"
                                                                 style="max-height: 200px; cursor: pointer;">
                                                        </a>
                                                    @else
                                                        <p class="text-muted mb-0">Tidak ada foto</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="card h-100">
                                                <div class="card-header bg-success text-white py-2">
                                                    <small class="fw-semibold"><i class="fas fa-check-circle me-1"></i> Foto Barang Sampai</small>
                                                    <br>
                                                    <small class="opacity-75">(Diupload Peminjam)</small>
                                                </div>
                                                <div class="card-body text-center p-3">
                                                    @if($pengiriman->foto_barang_sampai)
                                                        <a href="{{ asset('storage/' . $pengiriman->foto_barang_sampai) }}" target="_blank">
                                                            <img src="{{ asset('storage/' . $pengiriman->foto_barang_sampai) }}"
                                                                 alt="Foto Barang Sampai"
                                                                 class="img-fluid rounded"
                                                                 style="max-height: 200px; cursor: pointer;">
                                                        </a>
                                                    @else
                                                        <p class="text-muted mb-0">Belum ada foto konfirmasi penerimaan</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
</style>

@endsection
