{{-- resources/views/petugas/pengembalian/pemeriksaan.blade.php --}}
@extends('petugas.index')

@section('title', 'Pemeriksaan Barang')

@section('content')
<div class="container-fluid">
    <div class="pemeriksaan-header">
        <h1>
            <i class="fas fa-clipboard-list"></i>
            Pemeriksaan Barang
        </h1>
        <p>Kode Transaksi: <strong>{{ $pengembalian->transaksi->kode_transaksi }}</strong></p>
    </div>

    <div class="row">
        <div class="col-md-7">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-primary text-white rounded-top-4">
                    <h5 class="mb-0"><i class="fas fa-clipboard-check me-2"></i> Form Pemeriksaan</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('petugas.pengembalian.store-pemeriksaan', $pengembalian->id) }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Kondisi Barang <span class="text-danger">*</span></label>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="condition-card" data-condition="baik">
                                        <i class="fas fa-smile-wink fa-3x text-success"></i>
                                        <h6 class="mt-2 mb-0">Baik</h6>
                                        <small class="text-muted">Tidak ada kerusakan</small>
                                        <input type="radio" name="kondisi_barang" value="baik" class="d-none" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="condition-card" data-condition="rusak_ringan">
                                        <i class="fas fa-meh fa-3x text-warning"></i>
                                        <h6 class="mt-2 mb-0">Rusak Ringan</h6>
                                        <small class="text-muted">Kerusakan minor</small>
                                        <input type="radio" name="kondisi_barang" value="rusak_ringan" class="d-none">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="condition-card" data-condition="rusak_berat">
                                        <i class="fas fa-frown fa-3x text-danger"></i>
                                        <h6 class="mt-2 mb-0">Rusak Berat</h6>
                                        <small class="text-muted">Kerusakan signifikan</small>
                                        <input type="radio" name="kondisi_barang" value="rusak_berat" class="d-none">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4" id="kerusakanFields" style="display: none;">
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Informasi Kerusakan</strong>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Deskripsi Kerusakan</label>
                                <textarea name="deskripsi_kerusakan" class="form-control" rows="3"
                                          placeholder="Jelaskan kerusakan yang terjadi pada barang..."></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Biaya Kerusakan / Perbaikan</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="biaya_kerusakan" class="form-control"
                                           placeholder="0" min="0" step="5000">
                                </div>
                                <small class="text-muted">Biaya tambahan yang akan dibebankan kepada peminjam</small>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Catatan Petugas</label>
                            <textarea name="catatan_petugas" class="form-control" rows="3"
                                      placeholder="Tambahkan catatan penting..."></textarea>
                        </div>

                        <!-- Ringkasan Biaya -->
                        <div class="bg-light p-3 rounded-4 mb-4">
                            <h6 class="fw-bold mb-3">Ringkasan Biaya</h6>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Sisa Pembayaran Awal</span>
                                <span>Rp {{ number_format($sisaPembayaran, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2 text-danger" id="biayaKerusakanPreview" style="display: none;">
                                <span>+ Biaya Kerusakan</span>
                                <span class="fw-bold">Rp <span id="biayaKerusakanValue">0</span></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2 text-danger" id="dendaPreview">
                                <span>+ Denda Keterlambatan</span>
                                <span class="fw-bold">Rp {{ number_format($dendaKeterlambatan, 0, ',', '.') }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <strong class="fs-5">Total yang Harus Dibayar</strong>
                                <strong class="fs-5 text-success" id="totalBayarPreview">
                                    Rp {{ number_format($sisaPembayaran + $dendaKeterlambatan, 0, ',', '.') }}
                                </strong>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('petugas.pengembalian.show', $pengembalian->id) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Simpan Hasil Pemeriksaan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <!-- Detail Produk -->
            <div class="card shadow-sm border-0 rounded-4 mb-3">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0"><i class="fas fa-box me-2"></i> Detail Produk Dipinjam</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm mb-0">
                            @foreach($pengembalian->transaksi->detailTransaksis as $detail)
                            <tr>
                                <td>{{ $detail->nama_produk }}<br>
                                    <small class="text-muted">{{ $detail->jumlah }} unit × {{ $detail->durasi_hari }} hari</small>
                                </td>
                                <td class="text-end">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                            <tr class="table-light">
                                <td class="fw-bold">Total Subtotal</td>
                                <td class="text-end fw-bold">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td>Deposit (Dibayar)</td>
                                <td class="text-end text-success">- Rp {{ number_format($deposit, 0, ',', '.') }}</td>
                            </tr>
                            <tr class="border-top">
                                <td class="fw-bold">Sisa Pembayaran</td>
                                <td class="text-end fw-bold">Rp {{ number_format($sisaPembayaran, 0, ',', '.') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Catatan User -->
            @if($pengembalian->catatan_user)
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0"><i class="fas fa-comment me-2"></i> Catatan dari Peminjam</h6>
                </div>
                <div class="card-body">
                    {{ $pengembalian->catatan_user }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.pemeriksaan-header {
    background: linear-gradient(145deg, #0b2c5d, #1f3c88);
    border-radius: 1.5rem;
    padding: 2rem;
    margin-bottom: 2rem;
    color: white;
}
.pemeriksaan-header h1 {
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}
.condition-card {
    border: 2px solid #e2e8f0;
    border-radius: 1rem;
    padding: 1rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s;
}
.condition-card:hover {
    border-color: #0b2c5d;
    background: #f8fafc;
}
.condition-card.selected {
    border-color: #0b2c5d;
    background: #e8f0fe;
}
</style>

<script>
document.querySelectorAll('.condition-card').forEach(card => {
    card.addEventListener('click', function() {
        document.querySelectorAll('.condition-card').forEach(c => c.classList.remove('selected'));
        this.classList.add('selected');

        const radio = this.querySelector('input[type="radio"]');
        radio.checked = true;

        const condition = this.dataset.condition;
        const kerusakanFields = document.getElementById('kerusakanFields');

        if (condition === 'rusak_ringan' || condition === 'rusak_berat') {
            kerusakanFields.style.display = 'block';
        } else {
            kerusakanFields.style.display = 'none';
        }
    });
});

document.querySelector('input[name="biaya_kerusakan"]')?.addEventListener('input', function() {
    const biayaKerusakan = parseInt(this.value) || 0;
    const sisaBayar = {{ $sisaPembayaran }};
    const denda = {{ $dendaKeterlambatan }};
    const total = sisaBayar + denda + biayaKerusakan;

    const preview = document.getElementById('biayaKerusakanPreview');
    const biayaValue = document.getElementById('biayaKerusakanValue');
    const totalPreview = document.getElementById('totalBayarPreview');

    if (biayaKerusakan > 0) {
        preview.style.display = 'flex';
        biayaValue.textContent = biayaKerusakan.toLocaleString('id-ID');
    } else {
        preview.style.display = 'none';
    }

    totalPreview.textContent = 'Rp ' + total.toLocaleString('id-ID');
});
</script>
@endsection
