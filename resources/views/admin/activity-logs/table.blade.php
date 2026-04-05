@foreach ($logs as $log)
<tr>
    <td class="align-middle font-weight-semibold">
        <div class="d-flex align-items-center gap-2">
            <div class="bg-light d-flex align-items-center justify-content-center rounded-circle"
                style="width: 40px;height: 40px;">
                <i class="fa-solid fa-user text-muted"></i>
            </div>
            <div>
                <div class="fw-semibold">{{ $log->user_name ?? 'Guest' }}</div>
                <small class="text-muted">{{ $log->user_email ?? '-' }}</small>
                @if($log->user_level)
                    <div>
                        <span class="badge bg-secondary badge-sm">{{ ucfirst($log->user_level) }}</span>
                    </div>
                @endif
            </div>
        </div>
    </td>

    <td class="align-middle">
        @php
            $badgeClass = 'secondary';
            $icon = 'fa-regular fa-clock';

            switch($log->action) {
                case 'login':
                    $badgeClass = 'success';
                    $icon = 'fa-solid fa-right-to-bracket';
                    break;
                case 'logout':
                    $badgeClass = 'warning';
                    $icon = 'fa-solid fa-right-from-bracket';
                    break;
                case 'register':
                    $badgeClass = 'info';
                    $icon = 'fa-solid fa-user-plus';
                    break;
                case 'create':
                    $badgeClass = 'primary';
                    $icon = 'fa-solid fa-plus';
                    break;
                case 'update':
                    $badgeClass = 'primary';
                    $icon = 'fa-solid fa-pen';
                    break;
                case 'delete':
                    $badgeClass = 'danger';
                    $icon = 'fa-solid fa-trash';
                    break;
                case 'restore':
                    $badgeClass = 'success';
                    $icon = 'fa-solid fa-rotate-left';
                    break;
                case 'force_delete':
                    $badgeClass = 'danger';
                    $icon = 'fa-solid fa-trash-can';
                    break;
                case 'verify_email':
                    $badgeClass = 'success';
                    $icon = 'fa-solid fa-envelope-circle-check';
                    break;
                default:
                    $badgeClass = 'secondary';
                    $icon = 'fa-regular fa-clock';
            }
        @endphp
        <span class="badge bg-{{ $badgeClass }}">
            <i class="{{ $icon }} me-1"></i>
            {{ ucfirst(str_replace('_', ' ', $log->action)) }}
        </span>
    </td>

    <td class="align-middle">
        @if($log->module)
            <span class="badge bg-dark">
                {{ ucfirst($log->module) }}
            </span>
        @else
            <span class="text-muted">-</span>
        @endif
    </td>

    <td class="align-middle">
        <small class="font-monospace">{{ $log->ip_address ?? '-' }}</small>
    </td>

    <td class="align-middle">
        @if($log->status == 'success')
            <span class="badge bg-success">
                <i class="fa-solid fa-check-circle me-1"></i> Sukses
            </span>
        @else
            <span class="badge bg-danger">
                <i class="fa-solid fa-times-circle me-1"></i> Gagal
            </span>
        @endif
        <div class="mt-1">
            <small class="text-muted">{{ $log->created_at->format('d/m/Y H:i') }}</small>
        </div>
    </td>

    <td class="align-middle text-center">
        <div class="d-flex justify-content-center gap-2">
            <a href="#" class="btn text-decoration-none border-0 p-0" title="Detail"
               data-bs-toggle="modal" data-bs-target="#viewModal{{ $log->id }}">
                <i class="fa-solid fa-eye text-dark"></i>
            </a>

            <form action="{{ route('activity-logs.destroy', $log->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-delete-log border-0 p-0" title="Hapus">
                    <i class="fa-solid fa-trash-can text-dark"></i>
                </button>
            </form>
        </div>
    </td>
</tr>
@endforeach

@if($logs->isEmpty())
<tr>
    <td colspan="7" class="text-center text-muted py-5">
        <i class="fa-regular fa-inbox fa-3x mb-3 d-block"></i>
        Tidak ada data log aktivitas
    </td>
</tr>
@endif

@foreach ($logs as $log)
<div class="modal fade" id="viewModal{{ $log->id }}" tabindex="-1" aria-hidden="true" style="z-index: 9999;">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <h5 class="modal-title text-white">
                    <i class="fa-solid fa-circle-info me-2"></i>
                    Detail Log Aktivitas
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Header Info Cards -->
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="card border-0 bg-light h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-white rounded-circle p-3 shadow-sm">
                                        <i class="fa-solid fa-id-card fa-2x text-primary"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">ID Log</small>
                                        <h5 class="mb-0 fw-bold">#{{ $log->id }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 bg-light h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-white rounded-circle p-3 shadow-sm">
                                        <i class="fa-regular fa-calendar fa-2x text-info"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Waktu</small>
                                        <h5 class="mb-0 fw-bold">{{ $log->created_at->format('d F Y H:i:s') }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Information -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 pt-3 pb-0">
                        <h6 class="fw-bold mb-0">
                            <i class="fa-solid fa-user-circle me-2 text-primary"></i> Informasi Pengguna
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4 text-center">
                                <div class="bg-gradient-light rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 80px; height: 80px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                    <i class="fa-solid fa-user fa-3x text-white"></i>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="mb-2">
                                    <label class="text-muted small mb-0">Nama</label>
                                    <p class="fw-semibold mb-1">{{ $log->user_name ?? 'Guest' }}</p>
                                </div>
                                <div class="mb-2">
                                    <label class="text-muted small mb-0">Email</label>
                                    <p class="mb-1">{{ $log->user_email ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="text-muted small mb-0">Level</label>
                                    <div>
                                        @if($log->user_level)
                                            <span class="badge bg-secondary">{{ ucfirst($log->user_level) }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Activity Information -->
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <label class="text-muted small mb-2">Aksi</label>
                                @php
                                    $badgeClass = 'secondary';
                                    $icon = 'fa-regular fa-clock';
                                    $bgColor = '#6c757d';

                                    switch($log->action) {
                                        case 'login':
                                            $badgeClass = 'success';
                                            $icon = 'fa-solid fa-right-to-bracket';
                                            $bgColor = '#28a745';
                                            break;
                                        case 'logout':
                                            $badgeClass = 'warning';
                                            $icon = 'fa-solid fa-right-from-bracket';
                                            $bgColor = '#ffc107';
                                            break;
                                        case 'register':
                                            $badgeClass = 'info';
                                            $icon = 'fa-solid fa-user-plus';
                                            $bgColor = '#17a2b8';
                                            break;
                                        case 'create':
                                            $badgeClass = 'primary';
                                            $icon = 'fa-solid fa-plus';
                                            $bgColor = '#007bff';
                                            break;
                                        case 'update':
                                            $badgeClass = 'primary';
                                            $icon = 'fa-solid fa-pen';
                                            $bgColor = '#007bff';
                                            break;
                                        case 'delete':
                                            $badgeClass = 'danger';
                                            $icon = 'fa-solid fa-trash';
                                            $bgColor = '#dc3545';
                                            break;
                                        case 'restore':
                                            $badgeClass = 'success';
                                            $icon = 'fa-solid fa-rotate-left';
                                            $bgColor = '#28a745';
                                            break;
                                        case 'force_delete':
                                            $badgeClass = 'danger';
                                            $icon = 'fa-solid fa-trash-can';
                                            $bgColor = '#dc3545';
                                            break;
                                        case 'verify_email':
                                            $badgeClass = 'success';
                                            $icon = 'fa-solid fa-envelope-circle-check';
                                            $bgColor = '#28a745';
                                            break;
                                        default:
                                            $badgeClass = 'secondary';
                                            $icon = 'fa-regular fa-clock';
                                            $bgColor = '#6c757d';
                                    }
                                @endphp
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle p-2" style="background: {{ $bgColor }}20; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                        <i class="{{ $icon }} fa-lg" style="color: {{ $bgColor }};"></i>
                                    </div>
                                    <div>
                                        <span class="badge bg-{{ $badgeClass }} px-3 py-2">
                                            {{ ucfirst(str_replace('_', ' ', $log->action)) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <label class="text-muted small mb-2">Status</label>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle p-2" style="background: {{ $log->status == 'success' ? '#28a74520' : '#dc354520' }}; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                        <i class="{{ $log->status == 'success' ? 'fa-solid fa-check-circle' : 'fa-solid fa-times-circle' }} fa-lg" style="color: {{ $log->status == 'success' ? '#28a745' : '#dc3545' }};"></i>
                                    </div>
                                    <div>
                                        <span class="badge bg-{{ $log->status == 'success' ? 'success' : 'danger' }} px-3 py-2">
                                            {{ $log->status == 'success' ? 'Sukses' : 'Gagal' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Module & Reference -->
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <label class="text-muted small mb-2">
                                    <i class="fa-regular fa-folder-open me-1"></i> Modul
                                </label>
                                <p class="mb-0">
                                    @if($log->module)
                                        <span class="badge bg-dark px-3 py-2">{{ ucfirst($log->module) }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <label class="text-muted small mb-2">
                                    <i class="fa-solid fa-tag me-1"></i> Referensi Item
                                </label>
                                @if($log->item_id || $log->item_code)
                                    <div class="d-flex flex-wrap gap-2">
                                        @if($log->item_code)
                                            <span class="badge bg-info text-dark px-3 py-2">
                                                <i class="fa-solid fa-code me-1"></i> {{ $log->item_code }}
                                            </span>
                                        @endif
                                        @if($log->item_id)
                                            <span class="badge bg-secondary px-3 py-2">
                                                <i class="fa-solid fa-hashtag me-1"></i> ID: {{ $log->item_id }}
                                            </span>
                                        @endif
                                    </div>
                                @else
                                    <p class="mb-0 text-muted">-</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <label class="text-muted small mb-2">
                            <i class="fa-regular fa-message me-1"></i> Deskripsi
                        </label>
                        <p class="mb-0">{{ $log->description ?? '-' }}</p>
                    </div>
                </div>

                <!-- Technical Details -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 pt-3 pb-0">
                        <h6 class="fw-bold mb-0">
                            <i class="fa-solid fa-microchip me-2 text-secondary"></i> Detail Teknis
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="text-muted small mb-1">
                                    <i class="fa-solid fa-network-wired me-1"></i> IP Address
                                </label>
                                <p class="font-monospace mb-0">{{ $log->ip_address ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small mb-1">
                                    <i class="fa-solid fa-globe me-1"></i> User Agent
                                </label>
                                <p class="small text-break mb-0">{{ Str::limit($log->user_agent ?? '-', 100) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Changes Section -->
                @if($log->old_data || $log->new_data)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 pt-3 pb-0">
                        <h6 class="fw-bold mb-0">
                            <i class="fa-solid fa-code-compare me-2 text-warning"></i> Perubahan Data
                        </h6>
                    </div>
                    <div class="card-body p-0">
                        <ul class="nav nav-tabs px-3 pt-2" id="dataTab{{ $log->id }}" role="tablist">
                            @if($log->old_data)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="old-tab-{{ $log->id }}" data-bs-toggle="tab" data-bs-target="#old-{{ $log->id }}" type="button" role="tab">
                                    <i class="fa-solid fa-history me-1"></i> Data Lama
                                </button>
                            </li>
                            @endif
                            @if($log->new_data)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ !$log->old_data ? 'active' : '' }}" id="new-tab-{{ $log->id }}" data-bs-toggle="tab" data-bs-target="#new-{{ $log->id }}" type="button" role="tab">
                                    <i class="fa-solid fa-file-signature me-1"></i> Data Baru
                                </button>
                            </li>
                            @endif
                            @if($log->old_data && $log->new_data)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="diff-tab-{{ $log->id }}" data-bs-toggle="tab" data-bs-target="#diff-{{ $log->id }}" type="button" role="tab">
                                    <i class="fa-solid fa-code-branch me-1"></i> Perbandingan
                                </button>
                            </li>
                            @endif
                        </ul>
                        <div class="tab-content p-3">
                            @if($log->old_data)
                            <div class="tab-pane fade show active" id="old-{{ $log->id }}" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="30%">Field</th>
                                                <th width="70%">Value</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach(json_decode(json_encode($log->old_data), true) as $key => $value)
                                            <tr>
                                                <td class="fw-semibold">{{ ucwords(str_replace('_', ' ', $key)) }}</td>
                                                <td>
                                                    @if(is_array($value) || is_object($value))
                                                        <pre class="mb-0 small" style="max-height: 100px; overflow: auto;">{{ json_encode($value, JSON_PRETTY_PRINT) }}</pre>
                                                    @elseif(is_null($value))
                                                        <span class="text-muted fst-italic">null</span>
                                                    @else
                                                        {{ $value }}
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endif

                            @if($log->new_data)
                            <div class="tab-pane fade {{ !$log->old_data ? 'show active' : '' }}" id="new-{{ $log->id }}" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="30%">Field</th>
                                                <th width="70%">Value</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach(json_decode(json_encode($log->new_data), true) as $key => $value)
                                            <tr>
                                                <td class="fw-semibold">{{ ucwords(str_replace('_', ' ', $key)) }}</td>
                                                <td>
                                                    @if(is_array($value) || is_object($value))
                                                        <pre class="mb-0 small" style="max-height: 100px; overflow: auto;">{{ json_encode($value, JSON_PRETTY_PRINT) }}</pre>
                                                    @elseif(is_null($value))
                                                        <span class="text-muted fst-italic">null</span>
                                                    @else
                                                        {{ $value }}
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endif

                            @if($log->old_data && $log->new_data)
                            <div class="tab-pane fade" id="diff-{{ $log->id }}" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="30%">Field</th>
                                                <th width="35%" class="bg-danger bg-opacity-10">Data Lama</th>
                                                <th width="35%" class="bg-success bg-opacity-10">Data Baru</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $oldArray = json_decode(json_encode($log->old_data), true);
                                                $newArray = json_decode(json_encode($log->new_data), true);
                                                $allKeys = array_unique(array_merge(array_keys($oldArray ?? []), array_keys($newArray ?? [])));
                                            @endphp
                                            @foreach($allKeys as $key)
                                            <tr>
                                                <td class="fw-semibold">{{ ucwords(str_replace('_', ' ', $key)) }}</td>
                                                <td class="bg-danger bg-opacity-10">
                                                    @if(isset($oldArray[$key]))
                                                        @if(is_array($oldArray[$key]) || is_object($oldArray[$key]))
                                                            <pre class="mb-0 small" style="max-height: 100px; overflow: auto;">{{ json_encode($oldArray[$key], JSON_PRETTY_PRINT) }}</pre>
                                                        @elseif(is_null($oldArray[$key]))
                                                            <span class="text-muted fst-italic">null</span>
                                                        @else
                                                            {{ $oldArray[$key] }}
                                                        @endif
                                                    @else
                                                        <span class="text-muted fst-italic">-</span>
                                                    @endif
                                                </td>
                                                <td class="bg-success bg-opacity-10">
                                                    @if(isset($newArray[$key]))
                                                        @if(is_array($newArray[$key]) || is_object($newArray[$key]))
                                                            <pre class="mb-0 small" style="max-height: 100px; overflow: auto;">{{ json_encode($newArray[$key], JSON_PRETTY_PRINT) }}</pre>
                                                        @elseif(is_null($newArray[$key]))
                                                            <span class="text-muted fst-italic">null</span>
                                                        @else
                                                            {{ $newArray[$key] }}
                                                        @endif
                                                    @else
                                                        <span class="text-muted fst-italic">-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <!-- Error Message -->
                @if($log->error_message)
                <div class="card border-danger shadow-sm">
                    <div class="card-body">
                        <label class="text-danger small mb-2">
                            <i class="fa-solid fa-bug me-1"></i> Pesan Error
                        </label>
                        <p class="mb-0 text-danger">{{ $log->error_message }}</p>
                    </div>
                </div>
                @endif
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fa-solid fa-times me-1"></i> Tutup
                </button>
                <form action="{{ route('activity-logs.destroy', $log->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-danger btn-delete-log">
                        <i class="fa-solid fa-trash-can me-1"></i> Hapus Log
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
