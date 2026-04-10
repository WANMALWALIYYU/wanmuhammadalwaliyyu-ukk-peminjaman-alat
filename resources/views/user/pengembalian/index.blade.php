@extends('index')

@section('pages', 'Riwayat Pengembalian')

@section('content')
<div class="container py-4">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-primary text-white py-3 rounded-top-4">
            <h4 class="mb-0">
                <i class="fas fa-history me-2"></i>
                Riwayat Pengembalian
            </h4>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Kode Transaksi</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Kurir/Resi</th>
                            <th>Status</th>
                            <th>Total Bayar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengembalians as $pengembalian)
                        <tr>
                            <td>
                                <strong>{{ $pengembalian->transaksi->kode_transaksi }}</strong>
                            </td>
                            <td>{{ $pengembalian->created_at->format('d M Y H:i') }}</td>
                            <td>
                                @if($pengembalian->kurir_pengembalian)
                                    {{ $pengembalian->kurir_pengembalian }}<br>
                                    <small class="text-muted">{{ $pengembalian->no_resi_pengembalian }}</small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{!! $pengembalian->status_badge !!}</td>
                            <td class="fw-bold text-primary">
                                Rp {{ number_format($pengembalian->total_biaya_yang_harus_dibayar, 0, ',', '.') }}
                            </td>
                            <td>
                                <a href="{{ route('user.pengembalian.show', $pengembalian->id) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-inbox fa-4x mb-3 d-block"></i>
                                Belum ada riwayat pengembalian
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($pengembalians->hasPages())
        <div class="card-footer bg-white">
            {{ $pengembalians->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
