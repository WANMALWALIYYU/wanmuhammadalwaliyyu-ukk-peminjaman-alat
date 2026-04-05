@foreach ($transaksis as $transaksi)
<tr>
    <td class="align-middle">
        <div class="d-flex flex-column">
            <span class="fw-bold">{{ $transaksi->kode_transaksi }}</span>
            <small class="text-muted">{{ $transaksi->created_at->format('d/m/Y H:i') }}</small>
        </div>
    </td>
    <td class="align-middle">
        <div class="d-flex flex-column">
            <span>{{ $transaksi->nama_lengkap }}</span>
            <small class="text-muted">{{ $transaksi->email }}</small>
            <small class="text-muted">{{ $transaksi->no_telepon }}</small>
        </div>
    </td>
    <td class="align-middle">
        <div class="d-flex flex-column">
            <span class="fw-semibold">{{ $transaksi->detailTransaksis->count() }} produk</span>
            <small class="text-muted">
                @foreach($transaksi->detailTransaksis->take(2) as $detail)
                    {{ $detail->nama_produk }}@if(!$loop->last), @endif
                @endforeach
                @if($transaksi->detailTransaksis->count() > 2)
                    <span class="text-primary">+{{ $transaksi->detailTransaksis->count() - 2 }}</span>
                @endif
            </small>
        </div>
    </td>
    <td class="align-middle fw-bold text-primary">
        Rp {{ number_format($transaksi->total_biaya, 0, ',', '.') }}
    </td>
    <td class="align-middle">
        <span class="fw-semibold">Rp {{ number_format($transaksi->jumlah_deposit, 0, ',', '.') }}</span>
        <br>
        <small class="text-muted">{{ $transaksi->metode_pembayaran_label }}</small>
    </td>
    <td class="align-middle">
        {!! $transaksi->status_badge !!}
        @if($transaksi->verified_by && $transaksi->tanggal_verifikasi)
            <br>
            <small class="text-muted">
                Verif: {{ $transaksi->verifiedBy->name ?? '-' }}
            </small>
        @endif
    </td>
    <td class="align-middle">
        <div class="d-flex flex-column">
            <small>Pengajuan: {{ $transaksi->tanggal_pengajuan->format('d/m/Y') }}</small>
            @if($transaksi->tanggal_verifikasi)
                <small class="text-muted">Verif: {{ \Carbon\Carbon::parse($transaksi->tanggal_verifikasi)->format('d/m/Y') }}</small>
            @endif
        </div>
    </td>
    <td class="align-middle text-center">
        <div class="d-flex justify-content-center gap-2">
            <a href="#" class="btn btn-view-transaksi text-decoration-none border-0 p-2"
               data-url="{{ route('admin.transaksi.show', $transaksi->id) }}"
               title="Detail Transaksi">
                <i class="fa-solid fa-eye text-dark"></i>
            </a>
        </div>
    </td>
</tr>
@endforeach

@if($transaksis->isEmpty())
<tr>
    <td colspan="8" class="text-center text-muted py-5">
        <i class="fa-regular fa-receipt fa-3x mb-3 d-block"></i>
        <p>Belum ada transaksi</p>
    </td>
</tr>
@endif
