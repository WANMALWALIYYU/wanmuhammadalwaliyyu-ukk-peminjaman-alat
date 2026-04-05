@forelse($historyKategori as $history)
<tr>
    <td class="align-middle">
        <p class="ms-3 text-sm font-weight-semibold mb-0">
            {{ $loop->iteration }} / {{ $history->kode_kategori }}
        </p>
    </td>

    <td class="align-middle">
        <p class="ms-3 text-sm font-weight-semibold mb-0">{{ $history->nama_kategori }}</p>
    </td>

    <td class="align-middle">
        <p class="text-secondary text-sm font-weight-normal ps-0 mb-0"
           style="max-width: 200px; overflow: hidden; text-overflow: ellipsis;">
            {{ $history->deskripsi_kategori ?? '-' }}
        </p>
    </td>

    <td class="align-middle text-sm">
        <span class="badge bg-danger bg-opacity-10 text-danger p-2">
            <i class="fa-solid fa-trash me-1"></i>
            {{ $history->deleted_at ? $history->deleted_at->format('d-m-Y H:i') : '-' }}
        </span>
    </td>

    <td class="align-middle text-center">
        <div class="d-flex justify-content-center gap-2">
            {{-- Restore Button --}}
            <form action="{{ route('kategori.restore', $history->id) }}" method="POST" class="d-inline">
                @csrf
                <button type="button" class="btn btn-restore border-0 p-0" title="Kembalikan">
                    <i class="fa-solid fa-rotate-left text-dark"></i>
                </button>
            </form>

            {{-- Force Delete Button --}}
            <form action="{{ route('kategori.forceDelete', $history->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-force-delete border-0 p-0" title="Hapus Permanen">
                    <i class="fa-solid fa-trash-can text-dark"></i>
                </button>
            </form>

            {{-- View Button --}}
            <a href="#" class="btn text-decoration-none border-0 p-0" title="Detail"
               data-bs-toggle="modal" data-bs-target="#historyModal{{ $history->id }}">
                <i class="fa-solid fa-eye text-dark"></i>
            </a>
        </div>
    </td>
</tr>

@empty
<tr>
    <td colspan="5" class="text-center text-muted py-4">
        <i class="fa-regular fa-folder-open me-2"></i>
        Tidak ada data kategori yang dihapus
    </td>
</tr>
@endforelse

{{-- MODALS --}}
@foreach($historyKategori as $history)
<div class="modal fade" id="historyModal{{ $history->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Kategori Terhapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold mb-1">Kode Kategori:</label>
                        <p>{{ $history->kode_kategori }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold mb-1">Nama Kategori:</label>
                        <p>{{ $history->nama_kategori }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold mb-1">Dibuat:</label>
                        <p>{{ $history->created_at ? $history->created_at->format('d-m-Y H:i') : '-' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold mb-1">Dihapus:</label>
                        <p class="text-danger">{{ $history->deleted_at ? $history->deleted_at->format('d-m-Y H:i') : '-' }}</p>
                    </div>
                    <div class="col-md-12">
                        <label class="fw-bold mb-1">Deskripsi:</label>
                        <p class="text-secondary">{{ $history->deskripsi_kategori ?? 'Tidak ada deskripsi' }}</p>
                    </div>
                    @if($history->image)
                    <div class="col-md-12 mt-2">
                        <label class="fw-bold mb-1">Gambar:</label>
                        <div>
                            <img src="{{ asset('storage/' . $history->image) }}"
                                 alt="{{ $history->nama_kategori }}"
                                 class="img-fluid rounded shadow-sm"
                                 style="max-height: 150px;">
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <form action="{{ route('kategori.restore', $history->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        <i class="fa-solid fa-rotate-left me-1"></i> Restore
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
