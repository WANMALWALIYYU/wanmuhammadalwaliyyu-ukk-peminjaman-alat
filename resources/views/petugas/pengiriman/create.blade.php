{{-- resources/views/petugas/pengiriman/create.blade.php --}}
@extends('petugas.index')

@section('title', 'Buat Pengiriman')

@section('content')
<div class="container-fluid">
    <div class="pengiriman-header">
        <h1>
            <i class="fas fa-truck"></i>
            Buat Pengiriman
        </h1>
        <p>
            <i class="fas fa-box"></i>
            <span>Isi data pengiriman untuk transaksi {{ $transaksi->kode_transaksi }}</span>
        </p>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="info-card">
                <h5><i class="fas fa-user me-2"></i> Data Peminjam</h5>
                <div class="info-row">
                    <span class="info-label">Nama Lengkap</span>
                    <span class="info-value">{{ $transaksi->nama_lengkap }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email</span>
                    <span class="info-value">{{ $transaksi->email }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">No. Telepon</span>
                    <span class="info-value">{{ $transaksi->no_telepon }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Alamat</span>
                    <span class="info-value">{{ $transaksi->alamat_lengkap }}, {{ $transaksi->kelurahan }}, {{ $transaksi->kecamatan }}, {{ $transaksi->kabupaten }}, {{ $transaksi->provinsi }}</span>
                </div>
            </div>

            <div class="info-card mt-3">
                <h5><i class="fas fa-box me-2"></i> Detail Produk</h5>
                @foreach($transaksi->detailTransaksis as $detail)
                <div class="product-row">
                    <div class="product-name">{{ $detail->nama_produk }}</div>
                    <div class="product-detail">
                        <span>{{ $detail->jumlah }} unit</span>
                        <span>•</span>
                        <span>{{ $detail->durasi_hari }} hari</span>
                        <span>•</span>
                        <span>{{ $detail->tanggal_mulai->format('d M Y') }} - {{ $detail->tanggal_selesai->format('d M Y') }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-card">
                <h5><i class="fas fa-camera me-2"></i> Form Pengiriman</h5>

                <form action="{{ route('petugas.pengiriman.store', $transaksi->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-image text-primary me-1"></i>
                            Foto Barang Saat Akan Dikirim <span class="text-danger">*</span>
                        </label>
                        <div class="upload-area" onclick="document.getElementById('foto_dikirim').click()">
                            <i class="fas fa-cloud-upload-alt fa-3x mb-2"></i>
                            <p class="mb-1">Klik untuk upload foto barang</p>
                            <small class="text-muted">Format: JPG, PNG (Max. 2MB)</small>
                        </div>
                        <input type="file" id="foto_dikirim" name="foto_barang_dikirim" accept="image/*" class="d-none" required onchange="previewImage(this, 'dikirimPreview')">
                        <div id="dikirimPreview" class="preview-area mt-2" style="display: none;">
                            <img id="dikirimPreviewImg" src="#" alt="Preview">
                            <button type="button" class="btn-clear" onclick="clearPreview('dikirimPreview', 'foto_dikirim')">
                                <i class="fas fa-times"></i> Hapus
                            </button>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-note-sticky me-1"></i>
                            Catatan Pengiriman
                        </label>
                        <textarea name="catatan_pengiriman" class="form-control" rows="3"
                                  placeholder="Tambahkan catatan untuk kurir atau peminjam..."></textarea>
                        <small class="text-muted">Opsional: Informasi tambahan seperti titik temu, ciri-ciri lokasi, dll.</small>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Informasi:</strong> Setelah pengiriman dibuat, status transaksi akan berubah menjadi "Dikirim" dan peminjam akan menerima notifikasi untuk mengkonfirmasi penerimaan barang.
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('petugas.pengiriman.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-truck me-1"></i> Buat Pengiriman
                        </button>
                    </div>
                </form>
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

.info-card, .form-card {
    background: white;
    border-radius: 1rem;
    padding: 1.5rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.info-card h5, .form-card h5 {
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

<script>
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    const previewImg = document.getElementById(previewId + 'Img');

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

function clearPreview(previewId, inputId) {
    document.getElementById(previewId).style.display = 'none';
    document.getElementById(inputId).value = '';
}
</script>
@endsection
