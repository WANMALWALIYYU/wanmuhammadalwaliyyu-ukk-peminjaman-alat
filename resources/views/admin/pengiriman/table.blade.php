@foreach ($pengirimans as $pengiriman)
<tr>
    <td class="align-middle">
        <div class="d-flex flex-column">
            <span class="fw-semibold">#{{ $pengiriman->id }}</span>
            <small class="text-muted">{{ $pengiriman->transaksi->kode_transaksi ?? '-' }}</small>
        </div>
    </td>
    <td class="align-middle">
        <div class="d-flex flex-column">
            <span class="fw-semibold">{{ $pengiriman->transaksi->nama_lengkap ?? '-' }}</span>
            <small class="text-muted">
                <i class="fas fa-envelope me-1"></i> {{ $pengiriman->transaksi->email ?? '-' }}<br>
                <i class="fas fa-phone me-1"></i> {{ $pengiriman->transaksi->no_telepon ?? '-' }}
            </small>
        </div>
    </td>
    <td class="align-middle">
        @if($pengiriman->tanggal_dikirim)
            <span class="fw-semibold">{{ $pengiriman->tanggal_dikirim->format('d M Y') }}</span>
            <br>
            <small class="text-muted">{{ $pengiriman->tanggal_dikirim->format('H:i') }}</small>
        @else
            <span class="text-muted">-</span>
        @endif
    </td>
    <td class="align-middle">
        @if($pengiriman->tanggal_sampai)
            <span class="fw-semibold text-success">{{ $pengiriman->tanggal_sampai->format('d M Y') }}</span>
            <br>
            <small class="text-muted">{{ $pengiriman->tanggal_sampai->format('H:i') }}</small>
        @else
            <span class="text-muted">-</span>
        @endif
    </td>
    <td class="align-middle">
        <div class="d-flex align-items-center gap-2">
            <div class="avatar bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                <i class="fas fa-user text-secondary fa-sm"></i>
            </div>
            <span>{{ $pengiriman->petugas->name ?? '-' }}</span>
        </div>
    </td>
    <td class="align-middle text-center">
        @if($pengiriman->tanggal_sampai)
            <span class="badge bg-success">
                <i class="fas fa-check-circle me-1"></i> Selesai
            </span>
        @elseif($pengiriman->tanggal_dikirim)
            <span class="badge bg-warning text-dark">
                <i class="fas fa-truck-moving me-1"></i> Dalam Perjalanan
            </span>
        @else
            <span class="badge bg-secondary">
                <i class="fas fa-clock me-1"></i> Belum Dikirim
            </span>
        @endif
    </td>
    <td class="align-middle text-center">
        <button type="button" class="btn btn-sm btn-view" data-url="{{ route('admin.pengiriman.show', $pengiriman->id) }}" title="Detail">
            <i class="fa-solid fa-eye"></i>
        </button>
    </td>
</tr>
@endforeach

@if($pengirimans->isEmpty())
<tr>
    <td colspan="7" class="text-center text-muted py-5">
        <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
        Tidak ada data pengiriman
    </td>
</tr>
@endif
