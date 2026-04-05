@extends('admin.index')
@section('title', 'Log Aktivitas')
@section('page-title', 'Log Aktivitas')
@section('breadcrumb', 'Log Aktivitas')
@section('content-dashboard')

<div class="container-fluid pe-4">
    <!-- TABEL UTAMA (Log Aktivitas) -->
    <div class="row">
        <div class="col-12">
            <div class="card border shadow-xs mb-4">
                <div class="card-header border-bottom pb-0">
                    <div>
                        <h6 class="font-weight-semibold text-lg mb-0">Log Aktivitas</h6>
                        <p class="text-sm">Memantau semua aktivitas yang dilakukan oleh user</p>
                    </div>
                    <div class="ms-auto d-flex">
                        <button type="button" class="btn btn-sm btn-danger btn-icon d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#clearLogsModal">
                            <span class="text-white me-2">
                                <i class="fa-solid fa-trash-can"></i>
                            </span>
                            <span class="text-white">Bersihkan Log</span>
                        </button>
                    </div>
                </div>

                <div class="card-body px-0 py-0">
                    <div class="border-bottom py-3 px-3 d-flex justify-content-between align-items-center">
                        <!-- Filter dan Search -->
                        <div class="d-flex align-items-center w-100 gap-2 flex-wrap">
                            <!-- Filter Action -->
                            <select name="action" id="filter-action" class="form-select form-select-sm w-auto">
                                <option value="">Semua Aksi</option>
                                @foreach($actions as $action)
                                    <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('_', ' ', $action)) }}
                                    </option>
                                @endforeach
                            </select>

                            <!-- Filter Module -->
                            <select name="module" id="filter-module" class="form-select form-select-sm w-auto">
                                <option value="">Semua Modul</option>
                                @foreach($modules as $module)
                                    <option value="{{ $module }}" {{ request('module') == $module ? 'selected' : '' }}>
                                        {{ ucfirst($module) }}
                                    </option>
                                @endforeach
                            </select>

                            <!-- Filter Status -->
                            <select name="status" id="filter-status" class="form-select form-select-sm w-auto">
                                <option value="">Semua Status</option>
                                <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>Sukses</option>
                                <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Gagal</option>
                            </select>

                            <!-- Filter Tanggal -->
                            <input type="date" name="date_from" id="filter-date-from" class="form-control form-control-sm w-auto"
                                   placeholder="Dari Tanggal" value="{{ request('date_from') }}">
                            <input type="date" name="date_to" id="filter-date-to" class="form-control form-control-sm w-auto"
                                   placeholder="Sampai Tanggal" value="{{ request('date_to') }}">

                            <!-- Search -->
                            <div class="input-group ms-auto w-sm-25">
                                <span class="input-group-text text-body">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path>
                                    </svg>
                                </span>
                                <input type="text" id="search-input" class="form-control" placeholder="Cari user, aksi, modul..." value="{{ request('search') }}">
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7"># / User</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7">Aksi</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7">Modul</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7">IP Address</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7">Status</th>
                                    <th class="text-secondary text-center text-xs font-weight-semibold opacity-7">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="activity-logs-data">
                                @include('admin.activity-logs.table', ['logs' => $logs])
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="border-top py-3 px-3">
                        {{ $logs->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Clear Logs -->
<div class="modal fade" id="clearLogsModal" tabindex="-1" aria-hidden="true" style="z-index: 9999;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bersihkan Log Aktivitas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('activity-logs.clear') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Hapus log yang lebih dari (hari)</label>
                        <select name="days" class="form-select">
                            <option value="7">7 hari</option>
                            <option value="30" selected>30 hari</option>
                            <option value="60">60 hari</option>
                            <option value="90">90 hari</option>
                            <option value="180">180 hari</option>
                            <option value="365">1 tahun</option>
                        </select>
                        <div class="form-text text-warning mt-2">
                            <i class="fa-solid fa-triangle-exclamation me-1"></i>
                            Log yang dihapus tidak dapat dikembalikan!
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, Bersihkan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(function () {
    let debounceTimer;

    function fetchActivityLogs(url = "{{ route('activity-logs.index') }}") {
        let search = $('#search-input').val();
        let action = $('#filter-action').val();
        let module = $('#filter-module').val();
        let status = $('#filter-status').val();
        let dateFrom = $('#filter-date-from').val();
        let dateTo = $('#filter-date-to').val();

        $.ajax({
            url: url,
            type: "GET",
            data: {
                search: search,
                action: action,
                module: module,
                status: status,
                date_from: dateFrom,
                date_to: dateTo
            },
            success: function (response) {
                $('#activity-logs-data').html(response);
            },
            error: function (xhr) {
                console.error(xhr.responseText);
            }
        });
    }

    // Debounce search
    $('#search-input').on('keyup', function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => fetchActivityLogs(), 400);
    });

    // Filter changes
    $('#filter-action, #filter-module, #filter-status, #filter-date-from, #filter-date-to').on('change', function () {
        fetchActivityLogs();
    });

    // Enter key
    $('#search-input').on('keypress', function(e) {
        if (e.which == 13) {
            e.preventDefault();
            fetchActivityLogs();
        }
    });

    // Pagination AJAX
    $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();
        let url = $(this).attr('href');
        fetchActivityLogs(url);
    });

    // SweetAlert untuk Delete Log
    $(document).on('click', '.btn-delete-log', function(e) {
        e.preventDefault();
        let form = $(this).closest('form');

        Swal.fire({
            title: 'Hapus Log?',
            text: "Log aktivitas akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
@endsection
