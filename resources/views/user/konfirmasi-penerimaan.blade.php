{{-- resources/views/user/konfirmasi-penerimaan.blade.php --}}
@extends('index')

@section('pages', 'Konfirmasi Penerimaan Barang')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="mb-0">
                        <i class="fas fa-check-circle me-2"></i>
                        Konfirmasi Penerimaan Barang
                    </h4>
                </div>

                <div class="card-body p-4">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Informasi:</strong> Barang sudah sampai? Silakan upload foto barang yang Anda terima untuk mengkonfirmasi bahwa barang dalam kondisi baik.
                    </div>

                    <div class="mb-4">
                        <h5 class="fw-bold">Detail Transaksi</h5>
                        <table class="table table-borderless">
                            <tr>
                                <td width="150">Kode Transaksi</td>
                                <td>: <strong>{{ $transaksi->kode_transaksi }}</strong></td>
                            </tr>
                            <tr>
                                <td>Tanggal Pengajuan</td>
                                <td>: {{ $transaksi->tanggal_pengajuan->format('d M Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td>Alamat Pengiriman</td>
                                <td>: {{ $transaksi->alamat_lengkap }}, {{ $transaksi->kelurahan }}, {{ $transaksi->kecamatan }}, {{ $transaksi->kabupaten }}, {{ $transaksi->provinsi }}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="mb-4">
                        <h5 class="fw-bold">Produk yang Dikirim</h5>
                        @foreach($transaksi->detailTransaksis as $detail)
                        <div class="border rounded-3 p-3 mb-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $detail->nama_produk }}</strong><br>
                                    <small class="text-muted">{{ $detail->jumlah }} unit • {{ $detail->durasi_hari }} hari</small>
                                </div>
                                <div class="text-end">
                                    <small class="text-muted">Tanggal Sewa</small><br>
                                    <small>{{ $detail->tanggal_mulai->format('d M Y') }} - {{ $detail->tanggal_selesai->format('d M Y') }}</small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <form action="{{ route('user.konfirmasi-penerimaan.store', $transaksi->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-camera text-primary me-1"></i>
                                Foto Barang yang Diterima <span class="text-danger">*</span>
                            </label>
                            <div class="upload-area" onclick="document.getElementById('foto_sampai').click()">
                                <i class="fas fa-cloud-upload-alt fa-3x mb-2 text-primary"></i>
                                <p class="mb-1">Klik untuk upload foto barang yang diterima</p>
                                <small class="text-muted">Format: JPG, PNG (Max. 2MB)</small>
                            </div>
                            <input type="file" id="foto_sampai" name="foto_barang_sampai" accept="image/*" class="d-none" required onchange="previewImage(this)">
                            <div id="previewArea" class="preview-area mt-2" style="display: none;">
                                <img id="previewImg" src="#" alt="Preview">
                                <button type="button" class="btn-clear" onclick="clearPreview()">
                                    <i class="fas fa-times"></i> Hapus
                                </button>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-note-sticky me-1"></i>
                                Catatan Penerimaan (Opsional)
                            </label>
                            <textarea name="catatan_penerimaan" class="form-control" rows="3"
                                      placeholder="Tambahkan catatan jika ada kerusakan atau hal penting lainnya..."></textarea>
                        </div>

                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Perhatian:</strong> Dengan mengkonfirmasi penerimaan, Anda menyatakan bahwa barang diterima dalam kondisi baik. Jika ada kerusakan, silakan laporkan melalui catatan di atas.
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('transaksi.riwayat') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check-circle me-1"></i> Konfirmasi Penerimaan
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
    document.getElementById('foto_sampai').value = '';
}
</script>
@endsection
