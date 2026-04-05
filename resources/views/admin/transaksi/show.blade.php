@php
    $statusColors = [
        App\Models\Transaksi::STATUS_MENUNGGU_PERSETUJUAN => 'warning',
        App\Models\Transaksi::STATUS_DISETUJUI => 'info',
        App\Models\Transaksi::STATUS_DITOLAK => 'danger',
        App\Models\Transaksi::STATUS_DIKIRIM => 'primary',
        App\Models\Transaksi::STATUS_DIPINJAM => 'success',
        App\Models\Transaksi::STATUS_DIKEMBALIKAN => 'dark',
        App\Models\Transaksi::STATUS_SELESAI => 'secondary',
        App\Models\Transaksi::STATUS_DIBATALKAN => 'danger'
    ];

    $statusLabels = [
        App\Models\Transaksi::STATUS_MENUNGGU_PERSETUJUAN => 'Menunggu Persetujuan',
        App\Models\Transaksi::STATUS_DISETUJUI => 'Disetujui',
        App\Models\Transaksi::STATUS_DITOLAK => 'Ditolak',
        App\Models\Transaksi::STATUS_DIKIRIM => 'Dikirim',
        App\Models\Transaksi::STATUS_DIPINJAM => 'Dipinjam',
        App\Models\Transaksi::STATUS_DIKEMBALIKAN => 'Dikembalikan',
        App\Models\Transaksi::STATUS_SELESAI => 'Selesai',
        App\Models\Transaksi::STATUS_DIBATALKAN => 'Dibatalkan'
    ];
@endphp

<div class="container-fluid">
    <!-- Header Status -->
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h5 class="mb-1">{{ $transaksi->kode_transaksi }}</h5>
            <p class="text-muted mb-0">
                <i class="fas fa-calendar-alt me-1"></i>
                {{ $transaksi->created_at->format('d F Y H:i') }}
            </p>
        </div>
        <div>
            <span class="badge bg-{{ $statusColors[$transaksi->status] ?? 'secondary' }} fs-6 px-3 py-2">
                {{ $statusLabels[$transaksi->status] ?? ucfirst($transaksi->status) }}
            </span>
        </div>
    </div>

    <div class="row g-4">
        <!-- Informasi Peminjam -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-bottom">
                    <h6 class="mb-0"><i class="fas fa-user me-2"></i> Informasi Peminjam</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-4 text-muted">Nama Lengkap</div>
                        <div class="col-8 fw-semibold">{{ $transaksi->nama_lengkap }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4 text-muted">Email</div>
                        <div class="col-8">{{ $transaksi->email }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4 text-muted">No. Telepon</div>
                        <div class="col-8">{{ $transaksi->no_telepon }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4 text-muted">No. Identitas</div>
                        <div class="col-8">{{ $transaksi->no_identitas }}</div>
                    </div>
                    @if($transaksi->user)
                    <div class="row mb-2">
                        <div class="col-4 text-muted">Username</div>
                        <div class="col-8">{{ $transaksi->user->name }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Informasi Pengiriman -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-bottom">
                    <h6 class="mb-0"><i class="fas fa-map-marker-alt me-2"></i> Alamat Pengiriman</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-4 text-muted">Provinsi</div>
                        <div class="col-8">{{ $transaksi->provinsi }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4 text-muted">Kabupaten/Kota</div>
                        <div class="col-8">{{ $transaksi->kabupaten }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4 text-muted">Kecamatan</div>
                        <div class="col-8">{{ $transaksi->kecamatan }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4 text-muted">Kelurahan</div>
                        <div class="col-8">{{ $transaksi->kelurahan }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4 text-muted">Alamat Lengkap</div>
                        <div class="col-8">{{ $transaksi->alamat_lengkap }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Produk -->
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-bottom">
                    <h6 class="mb-0"><i class="fas fa-box me-2"></i> Detail Produk</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Produk</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-center">Durasi</th>
                                    <th class="text-center">Harga/Hari</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transaksi->detailTransaksis as $detail)
                                <tr>
                                    <td>
                                        <div class="fw-semibold">{{ $detail->nama_produk }}</div>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($detail->tanggal_mulai)->format('d/m/Y') }} -
                                            {{ \Carbon\Carbon::parse($detail->tanggal_selesai)->format('d/m/Y') }}
                                        </small>
                                    </td>
                                    <td class="text-center">{{ $detail->jumlah }}</td>
                                    <td class="text-center">{{ $detail->durasi_hari }} hari</td>
                                    <td class="text-center">Rp {{ number_format($detail->harga_per_hari, 0, ',', '.') }}</td>
                                    <td class="text-end fw-semibold">{{ $detail->subtotal_formatted }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-light">
                                <tr>
                                    <td colspan="4" class="text-end fw-bold">Total Subtotal:</td>
                                    <td class="text-end fw-bold text-primary">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informasi Pembayaran -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-bottom">
                    <h6 class="mb-0"><i class="fas fa-credit-card me-2"></i> Informasi Pembayaran</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-5 text-muted">Metode Pembayaran</div>
                        <div class="col-7 fw-semibold">{{ $transaksi->metode_pembayaran_label }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 text-muted">Deposit Dibayar</div>
                        <div class="col-7 text-success fw-bold">Rp {{ number_format($transaksi->jumlah_deposit, 0, ',', '.') }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 text-muted">Sisa Pembayaran</div>
                        <div class="col-7 text-warning fw-bold">Rp {{ number_format($sisaPembayaran, 0, ',', '.') }}</div>
                    </div>
                    @if($transaksi->bukti_deposit)
                    <div class="row mb-2">
                        <div class="col-5 text-muted">Bukti Deposit</div>
                        <div class="col-7">
                            <a href="{{ asset('storage/' . $transaksi->bukti_deposit) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye me-1"></i> Lihat Bukti
                            </a>
                        </div>
                    </div>
                    @endif
                    @if($transaksi->foto_ktp)
                    <div class="row mb-2">
                        <div class="col-5 text-muted">Foto KTP</div>
                        <div class="col-7">
                            <a href="{{ asset('storage/' . $transaksi->foto_ktp) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-id-card me-1"></i> Lihat KTP
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Informasi Verifikasi -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-bottom">
                    <h6 class="mb-0"><i class="fas fa-check-circle me-2"></i> Informasi Verifikasi</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-5 text-muted">Tanggal Pengajuan</div>
                        <div class="col-7">{{ $transaksi->tanggal_pengajuan ? \Carbon\Carbon::parse($transaksi->tanggal_pengajuan)->format('d F Y H:i') : '-' }}</div>
                    </div>
                    @if($transaksi->tanggal_verifikasi)
                    <div class="row mb-2">
                        <div class="col-5 text-muted">Tanggal Verifikasi</div>
                        <div class="col-7">{{ \Carbon\Carbon::parse($transaksi->tanggal_verifikasi)->format('d F Y H:i') }}</div>
                    </div>
                    @endif
                    @if($transaksi->verified_by)
                    <div class="row mb-2">
                        <div class="col-5 text-muted">Diverifikasi Oleh</div>
                        <div class="col-7">{{ $transaksi->verifiedBy->name ?? '-' }}</div>
                    </div>
                    @endif
                    @if($transaksi->catatan_verifikasi)
                    <div class="row mb-2">
                        <div class="col-5 text-muted">Catatan Verifikasi</div>
                        <div class="col-7">
                            <div class="alert alert-warning mb-0 p-2 small">
                                {{ $transaksi->catatan_verifikasi }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
