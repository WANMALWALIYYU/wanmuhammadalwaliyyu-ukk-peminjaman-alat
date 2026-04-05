{{-- resources/views/petugas/pengiriman/in-progress.blade.php --}}
@extends('petugas.index')

@section('title', 'Pengiriman Dalam Proses')

@section('content')
<div class="container-fluid">
    <div class="pengiriman-header">
        <h1>
            <i class="fas fa-truck-moving"></i>
            Pengiriman Dalam Proses
        </h1>
        <p>
            <i class="fas fa-clock"></i>
            <span>Daftar pengiriman yang sedang dalam perjalanan menunggu konfirmasi penerimaan dari peminjam</span>
        </p>
    </div>

    <div class="filter-card-modern">
        <form method="GET" action="{{ route('petugas.pengiriman.in-progress') }}" class="d-flex gap-2">
            <input type="text" name="search" class="form-control" placeholder="Cari kode transaksi / nama" value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">Cari</button>
            <a href="{{ route('petugas.pengiriman.in-progress') }}" class="btn btn-secondary">Reset</a>
        </form>
    </div>

    <div class="table-card">
        <div class="table-header">
            <h5>
                <i class="fas fa-list-alt text-primary me-2"></i>
                Daftar Pengiriman Aktif
                <span class="table-badge">{{ $pengirimans->total() }}</span>
            </h5>
        </div>
        <div class="table-responsive">
            <table class="table-modern-pengiriman">
                <thead>
                    <tr>
                        <th><i class="fas fa-barcode me-1"></i> Kode Transaksi</th>
                        <th><i class="fas fa-user me-1"></i> Peminjam</th>
                        <th><i class="fas fa-calendar me-1"></i> Tanggal Kirim</th>
                        <th><i class="fas fa-camera me-1"></i> Foto Barang</th>
                        <th><i class="fas fa-cog me-1"></i> Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengirimans as $pengiriman)
                    <tr>
                        <td data-label="Kode">
                            <span class="fw-bold text-primary">{{ $pengiriman->transaksi->kode_transaksi }}</span>
                        </td>
                        <td data-label="Peminjam">
                            <div class="fw-semibold">{{ $pengiriman->transaksi->nama_lengkap }}</div>
                            <small class="text-muted"><i class="fas fa-phone-alt me-1"></i> {{ $pengiriman->transaksi->no_telepon }}</small>
                        </td>
                        <td data-label="Tanggal Kirim">
                            {{ $pengiriman->tanggal_dikirim->format('d M Y H:i') }}
                        </td>
                        <td data-label="Foto">
                            @if($pengiriman->foto_barang_dikirim)
                                <a href="{{ $pengiriman->foto_dikirim_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-image me-1"></i> Lihat Foto
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td data-label="Aksi">
                            <a href="{{ route('petugas.pengiriman.show', $pengiriman->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye me-1"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="fas fa-inbox fa-4x mb-3 d-block"></i>
                            Tidak ada pengiriman dalam proses
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="pagination-wrapper">
            {{ $pengirimans->links() }}
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

.filter-card-modern {
    background: white;
    border-radius: 1rem;
    padding: 1.25rem 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.table-card {
    background: white;
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.table-header {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #e2e8f0;
}

.table-header h5 {
    font-size: 1rem;
    font-weight: 700;
    margin: 0;
}

.table-badge {
    background: #0b2c5d;
    color: white;
    padding: 0.2rem 0.6rem;
    border-radius: 2rem;
    font-size: 0.7rem;
    margin-left: 0.5rem;
}

.table-modern-pengiriman {
    width: 100%;
    border-collapse: collapse;
}

.table-modern-pengiriman thead th {
    padding: 1rem;
    background: #f8fafc;
    font-size: 0.75rem;
    font-weight: 700;
    color: #475569;
    text-transform: uppercase;
    border-bottom: 1px solid #e2e8f0;
}

.table-modern-pengiriman tbody td {
    padding: 1rem;
    border-bottom: 1px solid #f1f5f9;
}

.pagination-wrapper {
    padding: 1rem 1.5rem;
    border-top: 1px solid #e2e8f0;
}

@media (max-width: 768px) {
    .pengiriman-header h1 {
        font-size: 1.5rem;
    }

    .table-modern-pengiriman thead {
        display: none;
    }

    .table-modern-pengiriman tbody tr {
        display: block;
        margin-bottom: 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.75rem;
        padding: 1rem;
    }

    .table-modern-pengiriman tbody td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border: none;
        padding: 0.5rem;
    }

    .table-modern-pengiriman tbody td::before {
        content: attr(data-label);
        font-weight: 700;
        font-size: 0.7rem;
        color: #64748b;
    }
}
</style>
@endsection
