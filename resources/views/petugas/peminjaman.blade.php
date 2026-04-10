@extends('petugas.index')
@section('title', 'Manajemen Peminjaman')
@section('content')
<div class="container-fluid">
    <!-- Header Section - SAME STYLE AS DASHBOARD -->
    <div class="peminjaman-header" data-aos="fade-down">
        <h1>
            <i class="fas fa-hand-holding"></i>
            Manajemen Peminjaman
        </h1>
        <p>
            <i class="fas fa-box"></i>
            <span>Kelola dan pantau semua transaksi peminjaman alat medis</span>
        </p>
    </div>

    <!-- Filter Card Modern -->
    <div class="filter-card-modern" data-aos="fade-up" data-aos-delay="150">
        <div class="filter-header">
            <h6>
                <i class="fas fa-filter text-primary me-2"></i>
                Filter Transaksi
            </h6>
            <button type="button" class="btn-reset" id="resetFilter">
                <i class="fas fa-undo-alt me-1"></i> Reset
            </button>
        </div>
        <form id="filterForm">
            <div class="filter-row">
                <div class="filter-group">
                    <label><i class="fas fa-tag me-1"></i> Status</label>
                    <select name="status" id="filterStatus" class="filter-select">
                        <option value="">Semua Status</option>
                        <option value="menunggu_persetujuan">Menunggu Persetujuan</option>
                        <option value="disetujui">Disetujui</option>
                        <option value="dikirim">Dikirim</option>
                        <option value="dipinjam">Dipinjam</option>
                        <option value="dikembalikan">Dikembalikan</option>
                        <option value="selesai">Selesai</option>
                        <option value="ditolak">Ditolak</option>
                        <option value="dibatalkan">Dibatalkan</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label><i class="fas fa-calendar me-1"></i> Tanggal Pengajuan</label>
                    <input type="date" name="tanggal" id="filterTanggal" class="filter-input">
                </div>
                <div class="filter-group filter-group-search">
                    <label><i class="fas fa-search me-1"></i> Cari</label>
                    <div class="search-wrapper">
                        <input type="text" name="search" id="filterSearch" placeholder="Kode / Nama / Email / Telepon">
                        <button type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="filter-group filter-group-button">
                    <button type="button" id="quickFilterMenunggu" class="btn-quick-filter">
                        <i class="fas fa-clock me-1"></i> Menunggu
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Transactions Table -->
    <div class="table-card" data-aos="fade-up" data-aos-delay="200">
        <div class="table-header">
            <h5>
                <i class="fas fa-list-alt text-primary me-2"></i>
                Daftar Peminjaman
                <span class="table-badge" id="totalCount">0</span>
            </h5>
        </div>
        <div class="table-responsive">
            <table class="table-modern-peminjaman" id="transaksiTable">
                <thead>
                    <tr>
                        <th><i class="fas fa-barcode me-1"></i> Kode Transaksi</th>
                        <th><i class="fas fa-user me-1"></i> Peminjam</th>
                        <th><i class="fas fa-box me-1"></i> Produk</th>
                        <th><i class="fas fa-calendar me-1"></i> Tanggal Sewa</th>
                        <th><i class="fas fa-money-bill me-1"></i> Deposit</th>
                        <th><i class="fas fa-tag me-1"></i> Status</th>
                        <th><i class="fas fa-cog me-1"></i> Aksi</th>
                    </tr>
                </thead>
                <tbody id="transaksiBody">
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="loading-spinner-table"></div>
                            <p class="mt-3 text-muted">Memuat data...</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="paginationLinks" class="pagination-wrapper"></div>
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
/* ===============================
   HEADER - SAME AS DASHBOARD
   =============================== */
.peminjaman-header {
    background: linear-gradient(145deg, #0b2c5d, #1f3c88);
    border-radius: 1.5rem;
    padding: 2rem;
    margin-bottom: 2rem;
    color: white;
    position: relative;
    overflow: hidden;
}

.peminjaman-header::before {
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

.peminjaman-header h1 {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.peminjaman-header p {
    font-size: 1rem;
    opacity: 0.9;
    position: relative;
    z-index: 1;
}

/* ===============================
   FILTER CARD MODERN
   =============================== */
.filter-card-modern {
    background: white;
    border-radius: 1rem;
    padding: 1.25rem 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    border: 1px solid rgba(11,44,93,0.08);
}

.filter-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    padding-bottom: 0.75rem;
    border-bottom: 1px solid #e2e8f0;
}

.filter-header h6 {
    font-size: 0.9rem;
    font-weight: 700;
    color: #0f172a;
    margin: 0;
}

.btn-reset {
    background: none;
    border: none;
    color: #ef4444;
    font-size: 0.75rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-reset:hover {
    color: #dc2626;
    text-decoration: underline;
}

.filter-row {
    display: grid;
    grid-template-columns: 200px 180px 1fr auto;
    gap: 1rem;
    align-items: end;
}

.filter-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.filter-group label {
    font-size: 0.7rem;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.filter-select, .filter-input {
    padding: 0.6rem 0.75rem;
    border: 1px solid #e2e8f0;
    border-radius: 0.75rem;
    font-size: 0.85rem;
    transition: all 0.2s;
    background: #f8fafc;
}

.filter-select:focus, .filter-input:focus {
    outline: none;
    border-color: #0b2c5d;
    box-shadow: 0 0 0 3px rgba(11,44,93,0.1);
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
    font-size: 0.85rem;
    background: #f8fafc;
}

.search-wrapper input:focus {
    outline: none;
    border-color: #0b2c5d;
    box-shadow: 0 0 0 3px rgba(11,44,93,0.1);
}

.search-wrapper button {
    padding: 0.6rem 1rem;
    background: #0b2c5d;
    border: none;
    border-radius: 0.75rem;
    color: white;
    cursor: pointer;
    transition: all 0.2s;
}

.search-wrapper button:hover {
    background: #1f3c88;
    transform: scale(0.98);
}

.btn-quick-filter {
    padding: 0.6rem 1.25rem;
    background: #fffbeb;
    border: 1px solid #fcd34d;
    border-radius: 0.75rem;
    color: #b45309;
    font-weight: 600;
    font-size: 0.8rem;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-quick-filter:hover {
    background: #fef3c7;
    transform: translateY(-2px);
}

/* ===============================
   TABLE CARD
   =============================== */
.table-card {
    background: white;
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    border: 1px solid rgba(11,44,93,0.08);
}

.table-header {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #e2e8f0;
}

.table-header h5 {
    font-size: 1rem;
    font-weight: 700;
    color: #0f172a;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.table-badge {
    background: #0b2c5d;
    color: white;
    padding: 0.2rem 0.6rem;
    border-radius: 2rem;
    font-size: 0.7rem;
    font-weight: 600;
}

.table-modern-peminjaman {
    width: 100%;
    border-collapse: collapse;
}

.table-modern-peminjaman thead th {
    padding: 1rem 1rem;
    background: #f8fafc;
    font-size: 0.75rem;
    font-weight: 700;
    color: #475569;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 1px solid #e2e8f0;
}

.table-modern-peminjaman tbody td {
    padding: 1rem;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
}

.table-modern-peminjaman tbody tr {
    transition: all 0.2s;
}

.table-modern-peminjaman tbody tr:hover {
    background: #f8fafc;
}

.loading-spinner-table {
    width: 40px;
    height: 40px;
    margin: 0 auto;
    border: 3px solid #e2e8f0;
    border-top: 3px solid #0b2c5d;
    border-radius: 50%;
    animation: spin 0.6s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Pagination */
.pagination-wrapper {
    padding: 1rem 1.5rem;
    border-top: 1px solid #e2e8f0;
    display: flex;
    justify-content: flex-end;
}

.pagination {
    display: flex;
    gap: 0.25rem;
    margin: 0;
    padding: 0;
    list-style: none;
}

.pagination .page-item .page-link {
    padding: 0.4rem 0.75rem;
    border-radius: 0.5rem;
    border: 1px solid #e2e8f0;
    background: white;
    color: #0f172a;
    font-size: 0.75rem;
    font-weight: 500;
    transition: all 0.2s;
}

.pagination .page-item.active .page-link {
    background: #0b2c5d;
    border-color: #0b2c5d;
    color: white;
}

.pagination .page-item .page-link:hover {
    background: #f1f5f9;
    transform: translateY(-1px);
}

/* Buttons */
.btn-modern-peminjaman {
    padding: 0.4rem 0.75rem;
    border-radius: 0.5rem;
    font-size: 0.7rem;
    font-weight: 600;
    transition: all 0.2s;
    border: none;
    cursor: pointer;
}

.btn-modern-peminjaman:hover {
    transform: translateY(-1px);
}

/* Fade animation */
.fade-in {
    animation: fadeIn 0.3s ease forwards;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Responsive */
@media (max-width: 1200px) {
    .filter-row {
        grid-template-columns: 1fr 1fr;
    }
}

@media (max-width: 768px) {
    .peminjaman-header {
        padding: 1.5rem;
    }
    .peminjaman-header h1 {
        font-size: 1.5rem;
    }
    .filter-row {
        grid-template-columns: 1fr;
    }
    .table-modern-peminjaman thead {
        display: none;
    }
    .table-modern-peminjaman tbody tr {
        display: block;
        margin-bottom: 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.75rem;
        padding: 1rem;
    }
    .table-modern-peminjaman tbody td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border: none;
        padding: 0.5rem;
    }
    .table-modern-peminjaman tbody td::before {
        content: attr(data-label);
        font-weight: 700;
        font-size: 0.7rem;
        color: #64748b;
    }
}
</style>

@push('scripts')
<script>
let currentPage = 1;
let isLoading = false;

// Load transactions with AJAX
function loadTransactions() {
    if (isLoading) return;
    isLoading = true;

    showTableLoading();

    const formData = {
        status: $('#filterStatus').val(),
        tanggal: $('#filterTanggal').val(),
        search: $('#filterSearch').val(),
        page: currentPage
    };

    $.ajax({
        url: '{{ route("petugas.peminjaman") }}',
        type: 'GET',
        data: formData,
        dataType: 'json',
        success: function(response) {
            renderTable(response.data);
            renderPagination(response);
            $('#totalCount').text(response.total || 0);
            isLoading = false;
        },
        error: function(xhr) {
            console.error('Error:', xhr);
            $('#transaksiBody').html(`
                <tr>
                    <td colspan="7" class="text-center py-5 text-danger">
                        <i class="fas fa-exclamation-circle fa-3x mb-3 d-block"></i>
                        Gagal memuat data.
                        <br>
                        <button class="btn btn-sm btn-primary mt-3" onclick="loadTransactions()">
                            <i class="fas fa-sync-alt me-1"></i> Coba Lagi
                        </button>
                    </td>
                </tr>
            `);
            isLoading = false;
        }
    });
}

function showTableLoading() {
    $('#transaksiBody').html(`
        <tr>
            <td colspan="7" class="text-center py-5">
                <div class="loading-spinner-table"></div>
                <p class="mt-3 text-muted">Memuat data...</p>
            </td>
        </tr>
    `);
}

function renderTable(transaksis) {
    if (!transaksis || transaksis.length === 0) {
        $('#transaksiBody').html(`
            <tr>
                <td colspan="7" class="text-center py-5 text-muted">
                    <i class="fas fa-inbox fa-4x mb-3 d-block"></i>
                    Tidak ada data peminjaman
                </td>
            </tr>
        `);
        return;
    }

    let html = '';
    transaksis.forEach(transaksi => {
        const firstProduct = transaksi.detail_transaksis && transaksi.detail_transaksis[0] ? transaksi.detail_transaksis[0] : null;
        const totalProducts = transaksi.detail_transaksis ? transaksi.detail_transaksis.length : 0;

        const sewaDate = firstProduct ? formatDate(firstProduct.tanggal_mulai) : '-';
        const selesaiDate = firstProduct ? formatDate(firstProduct.tanggal_selesai) : '-';

        let produkDisplay = '';
        if (firstProduct) {
            produkDisplay = `<div class="fw-semibold">${escapeHtml(firstProduct.nama_produk)}</div>`;
            if (totalProducts > 1) {
                produkDisplay += `<small class="text-muted">+${totalProducts - 1} lainnya</small>`;
            }
        } else {
            produkDisplay = '<span class="text-muted">-</span>';
        }

        html += `
            <tr class="fade-in">
                <td data-label="Kode">
                    <span class="fw-bold text-primary">${escapeHtml(transaksi.kode_transaksi)}</span>
                    <br>
                    <small class="text-muted">${transaksi.created_at_formatted || formatDateTime(transaksi.created_at)}</small>
                </td>
                <td data-label="Peminjam">
                    <div class="fw-semibold">${escapeHtml(transaksi.nama_lengkap)}</div>
                    <small class="text-muted"><i class="fas fa-phone-alt me-1"></i> ${escapeHtml(transaksi.no_telepon)}</small>
                </td>
                <td data-label="Produk">${produkDisplay}</td>
                <td data-label="Tanggal Sewa">
                    <div>${sewaDate}</div>
                    <small class="text-muted"><i class="fas fa-arrow-right"></i> ${selesaiDate}</small>
                    ${firstProduct ? `<div><small class="text-muted">${firstProduct.durasi_hari} hari</small></div>` : ''}
                </td>
                <td data-label="Deposit">
                    <div class="fw-bold text-success">Rp ${formatNumber(transaksi.jumlah_deposit)}</div>
                    <small class="text-muted">${transaksi.metode_pembayaran_label || '-'}</small>
                </td>
                <td data-label="Status">${transaksi.status_badge}</td>
                <td data-label="Aksi">
                    <div class="d-flex flex-column gap-1">
                        <div class="d-flex gap-1">
                            <a href="{{ url('petugas/transaksi/${transaksi.id}') }}" class="btn btn-sm text-dark btn-modern-peminjaman w-100" title="Detail peminjaman">
                            <i class="fas fa-eye me-1"></i>
                            </a>
                            ${transaksi.status === 'menunggu_persetujuan' ? `
                                <button onclick="showApproveModal(${transaksi.id})" class="btn btn-sm btn-success btn-modern-peminjaman w-100" title="Setujui pengajuan peminjaman">
                                    <i class="fas fa-check me-1"></i>
                                </button>
                                <button onclick="showRejectModal(${transaksi.id})" class="btn btn-sm btn-danger btn-modern-peminjaman w-100" title="Tolak pengajuan peminjaman">
                                    <i class="fas fa-times me-1"></i>
                                </button>
                            ` : ''}
                        </div>
                        ${transaksi.status === 'disetujui' ? `
                            <a href="/petugas/pengiriman/create/${transaksi.id}" class="btn btn-sm btn-info btn-modern-peminjaman w-100 mb-1" title="Buat pengiriman ke peminjam">
                                <i class="fas fa-truck me-1"></i> Buat Pengiriman
                            </a>
                        ` : ''}
                    </div>
                </td>
            </tr>
        `;
    });

    $('#transaksiBody').html(html);
    AOS.refresh();
}

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

function showButtonLoading(form) {
    const button = $(form).find('button');
    button.html('<i class="fas fa-spinner fa-spin me-1"></i> Memproses...');
    button.prop('disabled', true);
}

function escapeHtml(text) {
    if (!text) return '';
    const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
    return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}

function formatDate(dateString) {
    if (!dateString) return '-';
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
}

function formatDateTime(dateString) {
    if (!dateString) return '-';
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', hour: '2-digit', minute: '2-digit' });
}

function formatNumber(num) {
    return new Intl.NumberFormat('id-ID').format(num);
}

function renderPagination(data) {
    if (!data.links) return;
    let paginationHtml = '<ul class="pagination">';
    data.links.forEach(link => {
        const active = link.active ? 'active' : '';
        const disabled = link.url === null ? 'disabled' : '';
        let label = link.label.replace('&laquo;', '«').replace('&raquo;', '»');
        paginationHtml += `
            <li class="page-item ${active} ${disabled}">
                <a class="page-link" href="#" onclick="changePage('${link.url}'); return false;">${label}</a>
            </li>
        `;
    });
    paginationHtml += '</ul>';
    $('#paginationLinks').html(paginationHtml);
}

function changePage(url) {
    if (!url) return;
    const urlParams = new URLSearchParams(url.split('?')[1]);
    currentPage = urlParams.get('page') || 1;
    loadTransactions();
    $('html, body').animate({ scrollTop: $('.peminjaman-header').offset().top - 20 }, 300);
}

$(document).ready(function() {
    loadTransactions();

    $('#filterForm').on('submit', function(e) {
        e.preventDefault();
        currentPage = 1;
        loadTransactions();
    });

    $('#quickFilterMenunggu').click(function() {
        $('#filterStatus').val('menunggu_persetujuan');
        $('#filterTanggal').val('');
        $('#filterSearch').val('');
        currentPage = 1;
        loadTransactions();
    });

    $('#resetFilter').click(function() {
        $('#filterStatus').val('');
        $('#filterTanggal').val('');
        $('#filterSearch').val('');
        currentPage = 1;
        loadTransactions();
    });

    $('#filterStatus, #filterTanggal').on('change', function() {
        currentPage = 1;
        loadTransactions();
    });

    let searchTimeout;
    $('#filterSearch').on('keyup', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            currentPage = 1;
            loadTransactions();
        }, 500);
    });
});
</script>
@endpush
@endsection
