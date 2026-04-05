{{-- resources/views/petugas/pengiriman.blade.php --}}
@extends('petugas.index')

@section('title', 'Pengiriman Barang')

@section('content')
<div class="container-fluid">
    <div class="pengiriman-header">
        <h1>
            <i class="fas fa-truck"></i>
            Pengiriman Barang
        </h1>
        <p>
            <i class="fas fa-box"></i>
            <span>Kelola pengiriman barang untuk transaksi yang sudah disetujui</span>
        </p>
    </div>

    <!-- Filter Card -->
    <div class="filter-card-modern" data-aos="fade-up">
        <form id="filterForm" method="GET" action="{{ route('petugas.pengiriman.index') }}">
            <div class="filter-row">
                <div class="filter-group">
                    <label><i class="fas fa-search me-1"></i> Cari Transaksi</label>
                    <div class="search-wrapper">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Kode / Nama / Email">
                        <button type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="filter-group">
                    <a href="{{ route('petugas.pengiriman.progress') }}" class="btn btn-outline-primary">
                        <i class="fas fa-truck-moving me-1"></i> Pengiriman Dalam Proses
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Transactions Table -->
    <div class="table-card">
        <div class="table-header">
            <h5>
                <i class="fas fa-list-alt text-primary me-2"></i>
                Transaksi Siap Kirim
                <span class="table-badge">{{ $transaksis->total() }}</span>
            </h5>
        </div>
        <div class="table-responsive">
            <table class="table-modern-pengiriman">
                <thead>
                    <tr>
                        <th><i class="fas fa-barcode me-1"></i> Kode Transaksi</th>
                        <th><i class="fas fa-user me-1"></i> Peminjam</th>
                        <th><i class="fas fa-map-marker-alt me-1"></i> Alamat</th>
                        <th><i class="fas fa-money-bill me-1"></i> Deposit</th>
                        <th><i class="fas fa-calendar me-1"></i> Tanggal</th>
                        <th><i class="fas fa-cog me-1"></i> Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksis as $transaksi)
                    <tr>
                        <td>
                            <span class="fw-bold text-primary">{{ $transaksi->kode_transaksi }}</span>
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $transaksi->nama_lengkap }}</div>
                            <small class="text-muted"><i class="fas fa-phone-alt me-1"></i> {{ $transaksi->no_telepon }}</small>
                        </td>
                        <td>
                            <div>{{ $transaksi->alamat_lengkap }}</div>
                            <small class="text-muted">{{ $transaksi->kelurahan }}, {{ $transaksi->kecamatan }}</small>
                        </td>
                        <td class="fw-bold text-success">Rp {{ number_format($transaksi->jumlah_deposit, 0, ',', '.') }}</td>
                        <td>{{ $transaksi->created_at->translatedFormat('d M Y') }}</td>
                        <td>
                            <a href="{{ route('petugas.pengiriman.create', $transaksi->id) }}"
                               class="btn btn-primary btn-sm">
                                <i class="fas fa-truck me-1"></i> Buat Pengiriman
                            </a>
                            <a href="{{ route('petugas.peminjaman.detail', $transaksi->id) }}"
                               class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-eye me-1"></i> Detail
                            </a>
                         </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-inbox fa-4x mb-3 d-block"></i>
                            Tidak ada transaksi yang siap dikirim
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="pagination-wrapper">
            {{ $transaksis->links() }}
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

.filter-row {
    display: flex;
    gap: 1rem;
    align-items: flex-end;
    flex-wrap: wrap;
}

.filter-group {
    flex: 1;
    min-width: 250px;
}

.filter-group label {
    font-size: 0.7rem;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    margin-bottom: 0.5rem;
    display: block;
}

.search-wrapper {
    display: flex;
    gap: 0.5rem;
}

.search-wrapper input {
    flex: 1;
    padding: 0.6rem 0.75rem;
    border: 1px solid #e2e8f0;
    border-radius: 0.75rem;
}

.search-wrapper button {
    padding: 0.6rem 1rem;
    background: #0b2c5d;
    border: none;
    border-radius: 0.75rem;
    color: white;
    cursor: pointer;
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

    .filter-row {
        flex-direction: column;
    }

    .filter-group {
        width: 100%;
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
