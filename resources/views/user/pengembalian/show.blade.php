{{-- resources/views/user/pengembalian/show.blade.php --}}
@extends('index')

@section('pages', 'Status Pengembalian')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="card-header" style="background: linear-gradient(135deg, #0b2c5d, #1f3c88); color: white;">
                    <h4 class="mb-0">
                        <i class="fas fa-truck-moving me-2"></i>
                        Status Pengembalian
                    </h4>
                    <p class="mb-0 mt-2 small opacity-75">
                        Kode Transaksi: {{ $pengembalian->transaksi->kode_transaksi }}
                    </p>
                </div>

                <div class="card-body p-4">
                    <!-- Progress Steps -->
                    <div class="progress-steps mb-5">
                        @php
                            $steps = [
                                'menunggu_pengiriman' => ['icon' => 'fa-clock', 'label' => 'Menunggu Pengiriman', 'desc' => 'Menunggu barang dikirim'],
                                'dikirim' => ['icon' => 'fa-truck', 'label' => 'Dalam Pengiriman', 'desc' => 'Barang sedang dalam perjalanan'],
                                'sampai' => ['icon' => 'fa-box', 'label' => 'Barang Sampai', 'desc' => 'Barang sudah sampai di petugas'],
                                'diproses' => ['icon' => 'fa-clipboard-list', 'label' => 'Sedang Diproses', 'desc' => 'Petugas memeriksa barang'],
                                'selesai' => ['icon' => 'fa-check-circle', 'label' => 'Selesai', 'desc' => 'Proses pengembalian selesai']
                            ];
                            $currentStep = $pengembalian->status;
                            $stepIndex = array_search($currentStep, array_keys($steps));
                        @endphp

                        <div class="position-relative">
                            <div class="progress-line" style="height: 4px; background: #e2e8f0; position: absolute; top: 30px; left: 0; right: 0; z-index: 1;"></div>
                            <div class="progress-line-fill" style="height: 4px; background: linear-gradient(90deg, #10b981, #0b2c5d); position: absolute; top: 30px; left: 0; width: {{ ($stepIndex / (count($steps) - 1)) * 100 }}%; z-index: 2; transition: width 0.5s ease;"></div>

                            <div class="row position-relative" style="z-index: 3;">
                                @foreach($steps as $key => $step)
                                <div class="col text-center">
                                    <div class="step-circle {{ $loop->index <= $stepIndex ? 'completed' : '' }} {{ $currentStep == $key ? 'active' : '' }}">
                                        @if($loop->index < $stepIndex)
                                            <i class="fas fa-check"></i>
                                        @else
                                            <i class="fas {{ $step['icon'] }}"></i>
                                        @endif
                                    </div>
                                    <div class="step-label mt-2 {{ $loop->index <= $stepIndex ? 'text-primary' : 'text-muted' }}">
                                        <strong>{{ $step['label'] }}</strong>
                                        <div class="small">{{ $step['desc'] }}</div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Status Badge -->
                    <div class="text-center mb-4">
                        {!! $pengembalian->status_badge !!}
                        @if($pengembalian->status == 'selesai')
                            <span class="badge bg-success ms-2"><i class="fas fa-check-circle"></i> Selesai</span>
                        @endif
                    </div>

                    <!-- Informasi Pengiriman -->
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-truck me-2"></i> Informasi Pengiriman</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
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
                                </div>
                                <div class="col-md-6">
                                    <div class="info-row">
                                        <span class="info-label">Tanggal Sampai</span>
                                        <span class="info-value">{{ $pengembalian->tanggal_sampai ? $pengembalian->tanggal_sampai->format('d M Y H:i') : '-' }}</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Status</span>
                                        <span class="info-value">{!! $pengembalian->status_badge !!}</span>
                                    </div>
                                </div>
                            </div>

                            @if($pengembalian->status == 'menunggu_pengiriman')
                            <div class="alert alert-warning mt-3">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Belum mengirim barang?</strong> Silakan update resi pengiriman Anda.
                                <button class="btn btn-sm btn-warning ms-3" data-bs-toggle="collapse" data-bs-target="#updateResiForm">
                                    <i class="fas fa-edit"></i> Update Resi
                                </button>
                            </div>

                            <div class="collapse mt-3" id="updateResiForm">
                                <form action="{{ route('user.pengembalian.update-shipping', $pengembalian->id) }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-5 mb-2">
                                            <input type="text" name="kurir" class="form-control" placeholder="Nama Kurir" required>
                                        </div>
                                        <div class="col-md-5 mb-2">
                                            <input type="text" name="no_resi" class="form-control" placeholder="No. Resi" required>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <button type="submit" class="btn btn-primary w-100">Simpan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Foto Barang -->
                    <div class="row mb-4">
                        @if($pengembalian->foto_barang_dikembalikan)
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-secondary text-white">
                                    <h6 class="mb-0"><i class="fas fa-camera me-2"></i> Foto Barang Dikirim</h6>
                                </div>
                                <div class="card-body text-center">
                                    <img src="{{ asset('storage/' . $pengembalian->foto_barang_dikembalikan) }}"
                                         alt="Foto Barang Dikirim" class="img-fluid rounded-3" style="max-height: 200px;">
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($pengembalian->foto_barang_setelah_sampai)
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-info text-white">
                                    <h6 class="mb-0"><i class="fas fa-clipboard-check me-2"></i> Foto Setelah Diperiksa</h6>
                                </div>
                                <div class="card-body text-center">
                                    <img src="{{ asset('storage/' . $pengembalian->foto_barang_setelah_sampai) }}"
                                         alt="Foto Setelah Diperiksa" class="img-fluid rounded-3" style="max-height: 200px;">
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Hasil Pemeriksaan -->
                    @if($pengembalian->status == 'diproses' || $pengembalian->status == 'selesai')
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-header" style="background: linear-gradient(135deg, #f59e0b, #d97706); color: white;">
                            <h5 class="mb-0"><i class="fas fa-clipboard-list me-2"></i> Hasil Pemeriksaan Petugas</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-row">
                                        <span class="info-label">Kondisi Barang</span>
                                        <span class="info-value">{!! $pengembalian->kondisi_badge !!}</span>
                                    </div>
                                    @if($pengembalian->deskripsi_kerusakan)
                                    <div class="info-row">
                                        <span class="info-label">Deskripsi Kerusakan</span>
                                        <span class="info-value">{{ $pengembalian->deskripsi_kerusakan }}</span>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    @if($pengembalian->biaya_kerusakan > 0)
                                    <div class="info-row">
                                        <span class="info-label">Biaya Kerusakan</span>
                                        <span class="info-value text-danger">Rp {{ number_format($pengembalian->biaya_kerusakan, 0, ',', '.') }}</span>
                                    </div>
                                    @endif
                                    @if($pengembalian->denda_keterlambatan > 0)
                                    <div class="info-row">
                                        <span class="info-label">Denda Keterlambatan</span>
                                        <span class="info-value text-danger">Rp {{ number_format($pengembalian->denda_keterlambatan, 0, ',', '.') }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @if($pengembalian->catatan_petugas)
                            <div class="alert alert-secondary mt-3">
                                <strong><i class="fas fa-comment"></i> Catatan Petugas:</strong><br>
                                {{ $pengembalian->catatan_petugas }}
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Rincian Pembayaran -->
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-money-bill-wave me-2"></i> Rincian Pembayaran</h5>
                        </div>
                        <div class="card-body">
                            <div class="bg-light p-3 rounded-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Sisa Pembayaran Awal</span>
                                    <span>Rp {{ number_format($sisaPembayaran, 0, ',', '.') }}</span>
                                </div>
                                @if($pengembalian->biaya_kerusakan > 0)
                                <div class="d-flex justify-content-between mb-2 text-danger">
                                    <span>+ Biaya Kerusakan</span>
                                    <span>Rp {{ number_format($pengembalian->biaya_kerusakan, 0, ',', '.') }}</span>
                                </div>
                                @endif
                                @if($pengembalian->denda_keterlambatan > 0)
                                <div class="d-flex justify-content-between mb-2 text-danger">
                                    <span>+ Denda Keterlambatan</span>
                                    <span>Rp {{ number_format($pengembalian->denda_keterlambatan, 0, ',', '.') }}</span>
                                </div>
                                @endif
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <strong class="fs-5">Total yang Harus Dibayar</strong>
                                    <strong class="fs-5 text-success">Rp {{ number_format($pengembalian->total_biaya_yang_harus_dibayar, 0, ',', '.') }}</strong>
                                </div>
                            </div>

                            @if($pengembalian->status == 'diproses')
                            <div class="alert alert-info mt-3">
                                <i class="fas fa-credit-card me-2"></i>
                                <strong>Pembayaran akan segera dibuka.</strong> Silakan cek kembali halaman ini untuk melakukan pembayaran.
                            </div>
                            @endif

                            @if($pengembalian->status == 'selesai')
                            <div class="alert alert-success mt-3">
                                <i class="fas fa-check-circle me-2"></i>
                                <strong>Proses pengembalian selesai!</strong> Terima kasih telah menggunakan layanan kami.
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('transaksi.riwayat') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali ke Riwayat
                        </a>
                        <a href="{{ route('user.pengembalian.index') }}" class="btn btn-primary">
                            <i class="fas fa-list me-1"></i> Semua Pengembalian
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.info-row {
    display: flex;
    justify-content: space-between;
    padding: 0.75rem 0;
    border-bottom: 1px solid #e2e8f0;
}
.info-label {
    font-weight: 600;
    color: #64748b;
}
.info-value {
    font-weight: 500;
    color: #0f172a;
}
.step-circle {
    width: 60px;
    height: 60px;
    background: white;
    border: 3px solid #e2e8f0;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    transition: all 0.3s;
}
.step-circle.completed {
    border-color: #10b981;
    background: #10b981;
    color: white;
}
.step-circle.active {
    border-color: #0b2c5d;
    background: #0b2c5d;
    color: white;
    transform: scale(1.1);
    box-shadow: 0 0 0 5px rgba(11,44,93,0.2);
}
.step-label {
    font-size: 0.8rem;
}
@media (max-width: 768px) {
    .step-circle {
        width: 45px;
        height: 45px;
        font-size: 1rem;
    }
    .step-label {
        font-size: 0.65rem;
    }
}
</style>
@endsection
