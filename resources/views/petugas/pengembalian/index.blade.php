{{-- resources/views/petugas/pengembalian/index.blade.php --}}
@extends('petugas.index')

@section('title', 'Manajemen Pengembalian')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="pengembalian-header">
        <h1>
            <i class="fas fa-undo-alt"></i>
            Manajemen Pengembalian
        </h1>
        <p>
            <i class="fas fa-box"></i>
            <span>Kelola dan proses pengembalian barang dari peminjam</span>
        </p>
    </div>

    <!-- Stats Cards -->
    <div class="stats-row mb-4">
        <div class="stat-card">
            <div class="stat-icon bg-warning">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $stats['menunggu_pengiriman'] ?? 0 }}</h3>
                <p>Menunggu Pengiriman</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-info">
                <i class="fas fa-truck"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $stats['dikirim'] ?? 0 }}</h3>
                <p>Dalam Pengiriman</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-primary">
                <i class="fas fa-box"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $stats['sampai'] ?? 0 }}</h3>
                <p>Barang Sampai</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-secondary">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $stats['diproses'] ?? 0 }}</h3>
                <p>Sedang Diproses</p>
            </div>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="filter-card">
        <form method="GET" action="{{ route('petugas.pengembalian.index') }}" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="menunggu_pengiriman" {{ request('status') == 'menunggu_pengiriman' ? 'selected' : '' }}>Menunggu Pengiriman</option>
                    <option value="dikirim" {{ request('status') == 'dikirim' ? 'selected' : '' }}>Dalam Pengiriman</option>
                    <option value="sampai" {{ request('status') == 'sampai' ? 'selected' : '' }}>Barang Sampai</option>
                    <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Sedang Diproses</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>
            <div class="col-md-5">
                <label class="form-label">Cari</label>
                <input type="text" name="search" class="form-control" placeholder="Kode transaksi / Nama peminjam" value="{{ request('search') }}">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="fas fa-search me-1"></i> Filter
                </button>
                <a href="{{ route('petugas.pengembalian.index') }}" class="btn btn-secondary">
                    <i class="fas fa-sync-alt me-1"></i> Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="table-card">
        <div class="table-header">
            <h5><i class="fas fa-list-alt me-2"></i> Daftar Pengembalian</h5>
        </div>
        <div class="table-responsive">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>Kode Transaksi</th>
                        <th>Peminjam</th>
                        <th>Tgl Pengajuan</th>
                        <th>Kurir/Resi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengembalians as $pengembalian)
                    <tr>
                        <td>
                            <strong>{{ $pengembalian->transaksi->kode_transaksi }}</strong>
                        </td>
                        <td>
                            {{ $pengembalian->transaksi->nama_lengkap }}<br>
                            <small class="text-muted">{{ $pengembalian->transaksi->email }}</small>
                        </td>
                        <td>{{ $pengembalian->created_at->format('d M Y H:i') }}</td>
                        <td>
                            @if($pengembalian->kurir_pengembalian)
                                {{ $pengembalian->kurir_pengembalian }}<br>
                                <small>{{ $pengembalian->no_resi_pengembalian }}</small>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{!! $pengembalian->status_badge !!}</td>
                        <td>
                            <a href="{{ route('petugas.pengembalian.show', $pengembalian->id) }}"
                               class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-inbox fa-4x mb-3 d-block"></i>
                            Tidak ada data pengembalian
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="pagination-wrapper">
            {{ $pengembalians->links() }}
        </div>
    </div>
</div>

<style>
.pengembalian-header {
    background: linear-gradient(145deg, #0b2c5d, #1f3c88);
    border-radius: 1.5rem;
    padding: 2rem;
    margin-bottom: 2rem;
    color: white;
}
.pengembalian-header h1 {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}
.stats-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}
.stat-card {
    background: white;
    border-radius: 1rem;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}
.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    color: white;
}
.stat-icon.bg-warning { background: #f59e0b; }
.stat-icon.bg-info { background: #0ea5e9; }
.stat-icon.bg-primary { background: #0b2c5d; }
.stat-icon.bg-secondary { background: #64748b; }
.stat-info h3 {
    font-size: 1.8rem;
    font-weight: 700;
    margin: 0;
}
.stat-info p {
    margin: 0;
    color: #64748b;
}
.filter-card, .table-card {
    background: white;
    border-radius: 1rem;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}
.table-modern {
    width: 100%;
    border-collapse: collapse;
}
.table-modern th, .table-modern td {
    padding: 1rem;
    border-bottom: 1px solid #e2e8f0;
}
.table-modern th {
    background: #f8fafc;
    font-weight: 700;
    color: #475569;
}
.pagination-wrapper {
    margin-top: 1.5rem;
    text-align: center;
}
@media (max-width: 768px) {
    .stats-row {
        grid-template-columns: repeat(2, 1fr);
    }
    .pengembalian-header h1 {
        font-size: 1.5rem;
    }
}
</style>
@endsection
