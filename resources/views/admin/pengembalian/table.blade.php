{{-- resources/views/admin/pengembalian/table.blade.php --}}
@foreach ($pengembalians as $pengembalian)
<tr>
    <td class="align-middle">
        <div class="d-flex flex-column">
            <span class="font-weight-semibold">
                {{ ($pengembalians->currentPage() - 1) * $pengembalians->perPage() + $loop->iteration }}
            </span>
            <small class="text-muted">{{ $pengembalian->transaksi->kode_transaksi ?? '-' }}</small>
        </div>
    </td>
    <td class="align-middle">
        <div>
            <span class="fw-semibold">{{ $pengembalian->transaksi->nama_lengkap ?? '-' }}</span>
            <br>
            <small class="text-muted">{{ $pengembalian->transaksi->email ?? '-' }}</small>
            <br>
            <small class="text-muted">
                <i class="fas fa-phone-alt me-1"></i>{{ $pengembalian->transaksi->no_telepon ?? '-' }}
            </small>
        </div>
    </td>
    <td class="align-middle">
        <div>
            <span>{{ $pengembalian->created_at ? $pengembalian->created_at->format('d M Y') : '-' }}</span>
            <br>
            <small class="text-muted">{{ $pengembalian->created_at ? $pengembalian->created_at->format('H:i') : '-' }}</small>
        </div>
    </td>
    <td class="align-middle">
        @if($pengembalian->kurir_pengembalian)
            <span class="fw-semibold">{{ $pengembalian->kurir_pengembalian }}</span>
            <br>
            <small class="text-muted">Resi: {{ $pengembalian->no_resi_pengembalian }}</small>
        @else
            <span class="text-muted">-</span>
        @endif
    </td>
    <td class="align-middle text-center">
        {!! $pengembalian->status_badge !!}
    </td>
    <td class="align-middle text-center">
        <div>
            <span class="fw-bold">Rp {{ number_format($pengembalian->total_biaya_tambahan ?? 0, 0, ',', '.') }}</span>
            <br>
            <small class="text-muted">
                @if($pengembalian->biaya_kerusakan > 0)
                    Kerusakan: Rp {{ number_format($pengembalian->biaya_kerusakan, 0, ',', '.') }}
                @endif
                @if($pengembalian->denda_keterlambatan > 0)
                    <br>Denda: Rp {{ number_format($pengembalian->denda_keterlambatan, 0, ',', '.') }}
                @endif
            </small>
        </div>
    </td>
    <td class="align-middle text-center">
        <div class="d-flex justify-content-center gap-2">
            <a href="{{ route('admin.pengembalian.show', $pengembalian->id) }}"
               class="btn"
               title="Detail">
                <i class="fa-solid fa-eye"></i>
            </a>
        </div>
    </td>
</tr>
@endforeach

@if($pengembalians->isEmpty())
<tr>
    <td colspan="7" class="text-center text-muted py-5">
        <i class="fas fa-inbox fa-3x mb-3 d-block text-muted"></i>
        Tidak ada data pengembalian
    </td>
</tr>
@endif
