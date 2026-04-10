@extends('petugas.index')

@section('title', 'Detail Transaksi')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="detail-header" data-aos="fade-down">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <a href="{{ url()->previous() }}" class="btn-back">
                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar
                </a>
                <h1 class="mt-3 mb-1">Detail Transaksi</h1>
                <p class="text-muted mb-0">
                    <i class="fas fa-barcode me-1"></i>
                    Kode Transaksi: <strong>{{ $transaksi->kode_transaksi }}</strong>
                </p>
            </div>
            <div>
                {!! $transaksi->status_badge !!}
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Kolom Kiri -->
        <div class="col-lg-8">
            <!-- Data Peminjam -->
            <div class="info-card-modern" data-aos="fade-up">
                <div class="card-header-modern">
                    <i class="fas fa-user-circle"></i>
                    <h5 class="mb-0">Data Peminjam</h5>
                </div>
                <div class="card-body-modern">
                    <div class="detail-grid">
                        <div class="detail-item">
                            <span class="detail-label">Nama Lengkap</span>
                            <span class="detail-value">{{ $transaksi->nama_lengkap }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Email</span>
                            <span class="detail-value">{{ $transaksi->email }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">No. Telepon</span>
                            <span class="detail-value">{{ $transaksi->no_telepon }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">No. Identitas</span>
                            <span class="detail-value">{{ $transaksi->no_identitas }}</span>
                        </div>
                        @if($transaksi->foto_ktp)
                        <div class="detail-item full-width">
                            <span class="detail-label">Foto KTP</span>
                            <span class="detail-value">
                                <a href="{{ asset('storage/' . $transaksi->foto_ktp) }}" target="_blank" class="btn-link-view">
                                    <i class="fas fa-eye me-1"></i> Lihat Foto KTP
                                </a>
                            </span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Alamat Pengiriman -->
            <div class="info-card-modern" data-aos="fade-up" data-aos-delay="50">
                <div class="card-header-modern">
                    <i class="fas fa-map-marked-alt"></i>
                    <h5 class="mb-0">Alamat Pengiriman</h5>
                </div>
                <div class="card-body-modern">
                    <div class="detail-grid">
                        <div class="detail-item">
                            <span class="detail-label">Provinsi</span>
                            <span class="detail-value">{{ $transaksi->provinsi }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Kabupaten/Kota</span>
                            <span class="detail-value">{{ $transaksi->kabupaten }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Kecamatan</span>
                            <span class="detail-value">{{ $transaksi->kecamatan }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Kelurahan/Desa</span>
                            <span class="detail-value">{{ $transaksi->kelurahan }}</span>
                        </div>
                        <div class="detail-item full-width">
                            <span class="detail-label">Alamat Lengkap</span>
                            <span class="detail-value">{{ $transaksi->alamat_lengkap }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Produk yang Dipinjam -->
            <div class="info-card-modern" data-aos="fade-up" data-aos-delay="100">
                <div class="card-header-modern">
                    <i class="fas fa-boxes"></i>
                    <h5 class="mb-0">Produk yang Dipinjam</h5>
                </div>
                <div class="card-body-modern">
                    @foreach($transaksi->detailTransaksis as $detail)
                    <div class="product-item-detail">
                        <div class="product-image">
                            @if($detail->produk && $detail->produk->gambar)
                                <img src="{{ asset('storage/' . $detail->produk->gambar) }}"
                                     alt="{{ $detail->nama_produk }}"
                                     onerror="this.src='https://via.placeholder.com/80x80/1B4C8C/FFFFFF?text=MEDIK'">
                            @else
                                <img src="https://via.placeholder.com/80x80/1B4C8C/FFFFFF?text=MEDIK" alt="Product">
                            @endif
                        </div>
                        <div class="product-info">
                            <div class="product-name">{{ $detail->nama_produk }}</div>
                            <div class="product-meta">
                                <span class="meta-badge">
                                    <i class="fas fa-box"></i> {{ $detail->jumlah }} unit
                                </span>
                                <span class="meta-badge">
                                    <i class="fas fa-clock"></i> {{ $detail->durasi_hari }} hari
                                </span>
                                <span class="meta-badge">
                                    <i class="fas fa-calendar"></i>
                                    {{ \Carbon\Carbon::parse($detail->tanggal_mulai)->format('d/m/Y') }} -
                                    {{ \Carbon\Carbon::parse($detail->tanggal_selesai)->format('d/m/Y') }}
                                </span>
                            </div>
                            <div class="product-price">
                                Rp {{ number_format($detail->harga_per_hari, 0, ',', '.') }} / hari × {{ $detail->jumlah }} × {{ $detail->durasi_hari }} hari
                                = <strong>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</strong>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Kolom Kanan -->
        <div class="col-lg-4">
            <!-- Ringkasan Pembayaran -->
            <div class="info-card-modern" data-aos="fade-up" data-aos-delay="150">
                <div class="card-header-modern">
                    <i class="fas fa-calculator"></i>
                    <h5 class="mb-0">Ringkasan Pembayaran</h5>
                </div>
                <div class="card-body-modern">
                    <div class="summary-item">
                        <span>Subtotal Produk</span>
                        <span class="fw-bold">Rp {{ number_format($totalBiaya, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-item">
                        <span>Deposit Dibayarkan</span>
                        <span class="fw-bold text-success">Rp {{ number_format($transaksi->jumlah_deposit, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-item">
                        <span>Metode Pembayaran</span>
                        <span>
                            @if($transaksi->metode_pembayaran == 'transfer')
                                Transfer Bank
                            @elseif($transaksi->metode_pembayaran == 'va')
                                Virtual Account
                            @elseif($transaksi->metode_pembayaran == 'ewallet')
                                E-Wallet
                            @endif
                        </span>
                    </div>
                    @if($transaksi->bukti_deposit)
                    <div class="summary-item">
                        <span>Bukti Deposit</span>
                        <a href="{{ asset('storage/' . $transaksi->bukti_deposit) }}" target="_blank" class="btn-link-view">
                            <i class="fas fa-eye"></i> Lihat Bukti
                        </a>
                    </div>
                    @endif
                    <div class="summary-item total">
                        <span>Sisa Pembayaran (Pelunasan)</span>
                        <span class="fw-bold text-primary">Rp {{ number_format($sisaPembayaran, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Informasi Pengiriman -->
            @if($transaksi->pengiriman)
            <div class="info-card-modern" data-aos="fade-up" data-aos-delay="200">
                <div class="card-header-modern">
                    <i class="fas fa-truck"></i>
                    <h5 class="mb-0">Informasi Pengiriman</h5>
                </div>
                <div class="card-body-modern">
                    <div class="summary-item">
                        <span>Tanggal Dikirim</span>
                        <span>{{ $transaksi->pengiriman->tanggal_dikirim ? \Carbon\Carbon::parse($transaksi->pengiriman->tanggal_dikirim)->translatedFormat('d M Y H:i') : '-' }}</span>
                    </div>
                    <div class="summary-item">
                        <span>Tanggal Sampai</span>
                        <span>{{ $transaksi->pengiriman->tanggal_sampai ? \Carbon\Carbon::parse($transaksi->pengiriman->tanggal_sampai)->translatedFormat('d M Y H:i') : '-' }}</span>
                    </div>
                    @if($transaksi->pengiriman->foto_barang_dikirim)
                    <div class="summary-item">
                        <span>Foto Barang Dikirim</span>
                        <a href="{{ asset('storage/' . $transaksi->pengiriman->foto_barang_dikirim) }}" target="_blank" class="btn-link-view">
                            <i class="fas fa-image"></i> Lihat Foto
                        </a>
                    </div>
                    @endif
                    @if($transaksi->pengiriman->catatan_pengiriman)
                    <div class="summary-item full-width">
                        <span>Catatan Pengiriman</span>
                        <span class="text-muted">{{ $transaksi->pengiriman->catatan_pengiriman }}</span>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Timeline Status -->
            <div class="info-card-modern" data-aos="fade-up" data-aos-delay="250">
                <div class="card-header-modern">
                    <i class="fas fa-chart-line"></i>
                    <h5 class="mb-0">Timeline Status</h5>
                </div>
                <div class="card-body-modern">
                    <div class="timeline-modern">
                        <div class="timeline-item {{ $transaksi->created_at ? 'completed' : '' }}">
                            <div class="timeline-icon">
                                <i class="fas fa-file-invoice"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="timeline-title">Transaksi Dibuat</div>
                                <div class="timeline-date">{{ \Carbon\Carbon::parse($transaksi->created_at)->translatedFormat('d M Y H:i') }}</div>
                            </div>
                        </div>

                        <div class="timeline-item {{ in_array($transaksi->status, ['disetujui', 'dikirim', 'dipinjam', 'dikembalikan', 'selesai']) ? 'completed' : ($transaksi->status == 'menunggu_persetujuan' ? 'active' : '') }}">
                            <div class="timeline-icon">
                                <i class="fas fa-user-check"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="timeline-title">Verifikasi Petugas</div>
                                @if($transaksi->tanggal_verifikasi)
                                <div class="timeline-date">{{ \Carbon\Carbon::parse($transaksi->tanggal_verifikasi)->translatedFormat('d M Y H:i') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="timeline-item {{ in_array($transaksi->status, ['dikirim', 'dipinjam', 'dikembalikan', 'selesai']) ? 'completed' : ($transaksi->status == 'disetujui' ? 'active' : '') }}">
                            <div class="timeline-icon">
                                <i class="fas fa-truck"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="timeline-title">Pengiriman Barang</div>
                            </div>
                        </div>

                        <div class="timeline-item {{ in_array($transaksi->status, ['dipinjam', 'dikembalikan', 'selesai']) ? 'completed' : ($transaksi->status == 'dikirim' ? 'active' : '') }}">
                            <div class="timeline-icon">
                                <i class="fas fa-hand-holding-heart"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="timeline-title">Sedang Dipinjam</div>
                            </div>
                        </div>

                        <div class="timeline-item {{ in_array($transaksi->status, ['dikembalikan', 'selesai']) ? 'completed' : ($transaksi->status == 'dipinjam' ? 'active' : '') }}">
                            <div class="timeline-icon">
                                <i class="fas fa-undo-alt"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="timeline-title">Pengembalian Barang</div>
                            </div>
                        </div>

                        <div class="timeline-item {{ $transaksi->status == 'selesai' ? 'completed' : ($transaksi->status == 'dikembalikan' ? 'active' : '') }}">
                            <div class="timeline-icon">
                                <i class="fas fa-check-double"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="timeline-title">Transaksi Selesai</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Catatan Verifikasi -->
            @if($transaksi->catatan_verifikasi)
            <div class="info-card-modern" data-aos="fade-up" data-aos-delay="300">
                <div class="card-header-modern">
                    <i class="fas fa-comment-dots"></i>
                    <h5 class="mb-0">Catatan Petugas</h5>
                </div>
                <div class="card-body-modern">
                    <p class="mb-0">{{ $transaksi->catatan_verifikasi }}</p>
                    @if($transaksi->verified_by)
                    <small class="text-muted mt-2 d-block">
                        <i class="fas fa-user-check me-1"></i>
                        Diverifikasi oleh: {{ $transaksi->verifiedBy->name ?? 'Petugas' }}
                    </small>
                    @endif
                </div>
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="action-buttons-modern" data-aos="fade-up" data-aos-delay="350">
                @if($transaksi->status == 'menunggu_persetujuan')
                <button onclick="showApproveModal({{ $transaksi->id }})" class="btn btn-success w-100 mb-2">
                    <i class="fas fa-check-circle me-2"></i> Setujui Peminjaman
                </button>
                <button onclick="showRejectModal({{ $transaksi->id }})" class="btn btn-danger w-100">
                    <i class="fas fa-times-circle me-2"></i> Tolak Peminjaman
                </button>
                @endif

                @if($transaksi->status == 'disetujui')
                <a href="{{ route('petugas.pengiriman.create', $transaksi->id) }}" class="btn btn-primary w-100">
                    <i class="fas fa-truck me-2"></i> Buat Pengiriman
                </a>
                @endif

                @if($transaksi->status == 'dikirim')
                <form action="{{ route('petugas.transaksi.update-pengiriman', $transaksi->id) }}" method="POST" class="w-100">
                    @csrf
                    <input type="hidden" name="status" value="dipinjam">
                    <button type="submit" class="btn btn-warning w-100">
                        <i class="fas fa-hand-holding me-2"></i> Tandai Dipinjam
                    </button>
                </form>
                @endif

                @if($transaksi->status == 'dipinjam')
                <form action="{{ route('petugas.transaksi.mark-dikembalikan', $transaksi->id) }}" method="POST" class="w-100">
                    @csrf
                    <button type="submit" class="btn btn-secondary w-100">
                        <i class="fas fa-undo-alt me-2"></i> Tandai Dikembalikan
                    </button>
                </form>
                @endif

                @if($transaksi->status == 'dikembalikan')
                <form action="{{ route('petugas.transaksi.complete', $transaksi->id) }}" method="POST" class="w-100">
                    @csrf
                    <button type="submit" class="btn btn-success w-100">
                        <i class="fas fa-check-circle me-2"></i> Selesaikan Transaksi
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Approve -->
<div class="modal fade" id="approveModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="approveForm" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        Setujui Pengajuan Peminjaman
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Catatan (Opsional)</label>
                        <textarea name="catatan" class="form-control" rows="3"
                                  placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Setujui</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Reject -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="rejectForm" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">
                        <i class="fas fa-times-circle text-danger me-2"></i>
                        Tolak Pengajuan Peminjaman
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea name="catatan" class="form-control" rows="4" required
                                  placeholder="Berikan alasan penolakan dengan jelas..."></textarea>
                        <small class="text-muted">Minimal 10 karakter</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.detail-header {
    background: linear-gradient(145deg, #0b2c5d, #1f3c88);
    border-radius: 1rem;
    padding: 1.5rem;
    color: white;
    position: relative;
    overflow: hidden;
}

.detail-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    animation: rotate 20s linear infinite;
}

@keyframes rotate {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.btn-back {
    color: rgba(255,255,255,0.8);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    transition: all 0.2s;
}

.btn-back:hover {
    color: white;
    transform: translateX(-3px);
}

.info-card-modern {
    background: white;
    border-radius: 1rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    border: 1px solid #e2e8f0;
    overflow: hidden;
}

.card-header-modern {
    background: #f8fafc;
    padding: 1rem 1.25rem;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.card-header-modern i {
    color: #0b2c5d;
    font-size: 1.2rem;
}

.card-body-modern {
    padding: 1.25rem;
}

.detail-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 0.75rem;
}

.detail-item {
    display: flex;
    justify-content: space-between;
    padding: 0.5rem 0;
    border-bottom: 1px dashed #e2e8f0;
}

.detail-item.full-width {
    grid-column: span 2;
}

.detail-label {
    color: #64748b;
    font-size: 0.85rem;
}

.detail-value {
    font-weight: 600;
    color: #0f172a;
    font-size: 0.85rem;
}

.btn-link-view {
    color: #0b2c5d;
    text-decoration: none;
    font-size: 0.85rem;
}

.btn-link-view:hover {
    text-decoration: underline;
}

.product-item-detail {
    display: flex;
    gap: 1rem;
    padding: 1rem;
    background: #f8fafc;
    border-radius: 0.75rem;
    margin-bottom: 0.75rem;
}

.product-item-detail:last-child {
    margin-bottom: 0;
}

.product-image {
    width: 80px;
    height: 80px;
    border-radius: 0.5rem;
    overflow: hidden;
    flex-shrink: 0;
    background: #e2e8f0;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.product-info {
    flex: 1;
}

.product-name {
    font-weight: 700;
    color: #0b2c5d;
    margin-bottom: 0.5rem;
}

.product-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    margin-bottom: 0.5rem;
}

.meta-badge {
    background: white;
    padding: 0.25rem 0.5rem;
    border-radius: 0.375rem;
    font-size: 0.7rem;
    color: #475569;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
}

.product-price {
    font-size: 0.85rem;
    color: #475569;
}

.summary-item {
    display: flex;
    justify-content: space-between;
    padding: 0.75rem 0;
    border-bottom: 1px solid #e2e8f0;
}

.summary-item.total {
    border-top: 2px solid #0b2c5d;
    border-bottom: none;
    padding-top: 1rem;
    margin-top: 0.5rem;
    font-size: 1rem;
}

.timeline-modern {
    position: relative;
}

.timeline-item {
    display: flex;
    gap: 1rem;
    padding-bottom: 1.25rem;
    position: relative;
}

.timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: 20px;
    top: 32px;
    bottom: 0;
    width: 2px;
    background: #e2e8f0;
}

.timeline-icon {
    width: 40px;
    height: 40px;
    background: #f8fafc;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #0b2c5d;
    border: 2px solid #e2e8f0;
    z-index: 1;
    background: white;
}

.timeline-item.completed .timeline-icon {
    background: #0b2c5d;
    color: white;
    border-color: #0b2c5d;
}

.timeline-item.active .timeline-icon {
    background: #f59e0b;
    color: white;
    border-color: #f59e0b;
    animation: pulse 1.5s infinite;
}

@keyframes pulse {
    0%, 100% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.4); }
    50% { box-shadow: 0 0 0 6px rgba(245, 158, 11, 0); }
}

.timeline-content {
    flex: 1;
}

.timeline-title {
    font-weight: 600;
    color: #0f172a;
    font-size: 0.9rem;
}

.timeline-date {
    font-size: 0.7rem;
    color: #94a3b8;
}

.action-buttons-modern {
    position: sticky;
    top: 20px;
}

.action-buttons-modern .btn {
    padding: 0.75rem;
    font-weight: 600;
    border-radius: 0.5rem;
}

@media (max-width: 768px) {
    .detail-grid {
        grid-template-columns: 1fr;
    }

    .detail-item.full-width {
        grid-column: span 1;
    }

    .product-item-detail {
        flex-direction: column;
    }

    .product-image {
        width: 100%;
        height: 120px;
    }
}
</style>

<script>
function showApproveModal(id) {
    const modal = new bootstrap.Modal(document.getElementById('approveModal'));
    const form = document.getElementById('approveForm');
    form.action = "{{ url('petugas/peminjaman/approve') }}/" + id;
    modal.show();
}

function showRejectModal(id) {
    const modal = new bootstrap.Modal(document.getElementById('rejectModal'));
    const form = document.getElementById('rejectForm');
    form.action = "{{ url('petugas/peminjaman/reject') }}/" + id;
    modal.show();
}
</script>
@endsection
