@extends('index')

@section('pages', 'Proses Pengembalian Barang')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="card-header bg-warning text-dark py-3">
                    <h4 class="mb-0">
                        <i class="fas fa-undo-alt me-2"></i>
                        Proses Pengembalian Barang
                    </h4>
                    <p class="mb-0 mt-2 small">
                        <i class="fas fa-info-circle me-1"></i>
                        Silakan isi data pengembalian barang dengan lengkap
                    </p>
                </div>

                <div class="card-body p-4">
                    <!-- Alert Peringatan -->
                    <div class="alert alert-warning border-0 rounded-4 mb-4">
                        <div class="d-flex">
                            <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                            <div>
                                <strong class="d-block mb-1">⚠️ Perhatian Penting!</strong>
                                <p class="mb-0 small">Pembayaran akan dilakukan setelah barang diterima dan dikonfirmasi oleh petugas.
                                Anda akan diminta melakukan pembayaran sisa tagihan + biaya tambahan (jika ada) setelah petugas
                                melakukan pemeriksaan barang.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Transaksi -->
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-receipt me-2"></i> Detail Transaksi</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="140">Kode Transaksi</td>
                                            <td>: <strong>{{ $transaksi->kode_transaksi }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal Pengajuan</td>
                                            <td>: {{ $transaksi->tanggal_pengajuan->format('d M Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <td>Status</td>
                                            <td>: {!! $transaksi->status_badge !!}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="140">Nama Peminjam</td>
                                            <td>: {{ $transaksi->nama_lengkap }}</td>
                                        </tr>
                                        <tr>
                                            <td>No. Telepon</td>
                                            <td>: {{ $transaksi->no_telepon }}</td>
                                        </tr>
                                        <tr>
                                            <td>Alamat</td>
                                            <td>: {{ $transaksi->alamat_lengkap }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Produk yang Dipinjam -->
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-box me-2"></i> Detail Produk yang Dipinjam</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Produk</th>
                                            <th>Jumlah</th>
                                            <th>Durasi</th>
                                            <th>Tanggal Sewa</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($transaksi->detailTransaksis as $detail)
                                        <tr>
                                            <td>
                                                <strong>{{ $detail->nama_produk }}</strong>
                                                <br>
                                                <small class="text-muted">Rp {{ number_format($detail->harga_per_hari, 0, ',', '.') }}/hari</small>
                                            </td>
                                            <td>{{ $detail->jumlah }} unit</td>
                                            <td>{{ $detail->durasi_hari }} hari</td>
                                            <td>{{ $detail->tanggal_mulai->format('d M Y') }} - {{ $detail->tanggal_selesai->format('d M Y') }}</td>
                                            <td class="fw-bold">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="table-light">
                                        <tr>
                                            <td colspan="4" class="text-end fw-bold">Total Subtotal</td>
                                            <td class="fw-bold text-primary">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Rincian Biaya -->
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-money-bill-wave me-2"></i> Rincian Pembayaran</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="bg-light p-3 rounded-4">
                                        <h6 class="fw-bold mb-3">Ringkasan Biaya</h6>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Total Subtotal Sewa</span>
                                            <span class="fw-bold">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2 text-success">
                                            <span><i class="fas fa-minus-circle"></i> Deposit (Dibayar)</span>
                                            <span class="fw-bold">Rp {{ number_format($deposit, 0, ',', '.') }}</span>
                                        </div>
                                        @if($dendaKeterlambatan > 0)
                                        <div class="d-flex justify-content-between mb-2 text-danger">
                                            <span><i class="fas fa-exclamation-triangle"></i> Denda Keterlambatan</span>
                                            <span class="fw-bold">Rp {{ number_format($dendaKeterlambatan, 0, ',', '.') }}</span>
                                        </div>
                                        @endif
                                        <hr>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="fw-bold">Sisa yang Harus Dibayar</span>
                                            <span class="fw-bold text-warning fs-5">Rp {{ number_format($sisaPembayaran, 0, ',', '.') }}</span>
                                        </div>
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle"></i>
                                            Sisa pembayaran akan ditambah biaya kerusakan (jika ada) setelah barang diperiksa petugas.
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="bg-info bg-opacity-10 p-3 rounded-4">
                                        <h6 class="fw-bold mb-3"><i class="fas fa-truck"></i> Informasi Pengiriman</h6>
                                        <p class="small mb-2">
                                            <strong>Alamat Pengiriman Kembali:</strong><br>
                                            MedikCareRent Center<br>
                                            Jl. Contoh Alamat No. 123<br>
                                            Kota Contoh, Provinsi Contoh<br>
                                            Kode Pos: 12345
                                        </p>
                                        <p class="small mb-0 text-muted">
                                            <i class="fas fa-phone-alt"></i> Kontak: 0812-3456-7890
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Pengembalian -->
                    <form action="{{ route('user.pengembalian.store', $transaksi->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="fas fa-upload me-2"></i> Form Pengembalian</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-truck"></i> Kurir Pengiriman
                                        </label>
                                        <input type="text" name="kurir" class="form-control"
                                               placeholder="Contoh: JNE, J&T, POS">
                                        <small class="text-muted">Opsional, bisa diisi nanti</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-barcode"></i> No. Resi Pengiriman
                                        </label>
                                        <input type="text" name="no_resi" class="form-control"
                                               placeholder="Masukkan nomor resi">
                                        <small class="text-muted">Opsional, bisa diisi nanti</small>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-camera"></i> Foto Barang yang Dikembalikan <span class="text-danger">*</span>
                                    </label>
                                    <div class="upload-area" onclick="document.getElementById('foto_barang').click()">
                                        <i class="fas fa-cloud-upload-alt fa-3x mb-2 text-primary"></i>
                                        <p class="mb-1">Klik untuk upload foto barang</p>
                                        <small class="text-muted">Format: JPG, PNG (Max. 2MB)</small>
                                    </div>
                                    <input type="file" id="foto_barang" name="foto_barang_dikembalikan"
                                           accept="image/*" class="d-none" required onchange="previewImage(this)">
                                    <div id="previewArea" class="preview-area mt-2" style="display: none;">
                                        <img id="previewImg" src="#" alt="Preview">
                                        <button type="button" class="btn-clear" onclick="clearPreview()">
                                            <i class="fas fa-times"></i> Hapus
                                        </button>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-note-sticky"></i> Catatan Tambahan
                                    </label>
                                    <textarea name="catatan_user" class="form-control" rows="3"
                                              placeholder="Tambahkan catatan jika ada (misal: kondisi barang, keluhan, dll)"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info border-0 rounded-4">
                            <div class="d-flex">
                                <i class="fas fa-info-circle fa-2x me-3"></i>
                                <div>
                                    <strong class="d-block mb-1">📋 Alur Setelah Pengajuan:</strong>
                                    <ol class="mb-0 small ps-3">
                                        <li>Barang akan dikirim ke alamat MedikCareRent</li>
                                        <li>Petugas akan melakukan pemeriksaan barang</li>
                                        <li>Jika ada kerusakan, akan ditambahkan biaya perbaikan</li>
                                        <li>Anda akan diminta melakukan pembayaran sisa tagihan + biaya tambahan</li>
                                        <li>Setelah pembayaran lunas, proses pengembalian selesai</li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('transaksi.riwayat') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-paper-plane me-1"></i> Kirim Pengembalian
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.upload-area {
    border: 2px dashed #cbd5e1;
    border-radius: 1rem;
    padding: 2rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s;
    background: #f8fafc;
}

.upload-area:hover {
    border-color: #0b2c5d;
    background: #f1f5f9;
}

.preview-area {
    border: 1px solid #e2e8f0;
    border-radius: 0.75rem;
    padding: 1rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    background: #f8fafc;
}

.preview-area img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 0.5rem;
}

.btn-clear {
    background: #fee2e2;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    color: #dc2626;
    font-size: 0.8rem;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-clear:hover {
    background: #fecaca;
}
</style>

<script>
function previewImage(input) {
    const preview = document.getElementById('previewArea');
    const previewImg = document.getElementById('previewImg');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'flex';
        }
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.style.display = 'none';
    }
}

function clearPreview() {
    document.getElementById('previewArea').style.display = 'none';
    document.getElementById('foto_barang').value = '';
}
</script>
@endsection
