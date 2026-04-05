@forelse($historyProduk as $history)
<tr>
    <td class="align-middle">
        <p class="ms-3 text-sm font-weight-semibold mb-0">
            {{ $loop->iteration }} / {{ $history->kode_produk }}
        </p>
    </td>

    <td class="align-middle">
        <div class="d-flex px-2 py-1">
            <div>
                @if($history->gambar)
                    <img src="{{ asset('storage/' . $history->gambar) }}"
                         class="avatar avatar-sm rounded-circle me-2"
                         alt="{{ $history->nama_produk }}">
                @else
                    <div class="avatar avatar-sm rounded-circle bg-secondary me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-regular fa-image text-white"></i>
                    </div>
                @endif
            </div>
            <div class="d-flex flex-column justify-content-center">
                <h6 class="mb-0 text-sm">{{ $history->nama_produk }}</h6>
                <p class="text-xs text-secondary mb-0">{{ $history->category->nama_kategori ?? 'Tanpa Kategori' }}</p>
            </div>
        </div>
    </td>

    <td class="align-middle text-sm">
        <span class="text-primary">{{ $history->harga_formatted }}</span>
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
            <form action="{{ route('produk.restore', $history->id) }}" method="POST" class="d-inline">
                @csrf
                <button type="button" class="btn btn-restore border-0 p-0" title="Kembalikan">
                    <i class="fa-solid fa-rotate-left text-dark fs-5"></i>
                </button>
            </form>

            {{-- Force Delete Button --}}
            <form action="{{ route('produk.forceDelete', $history->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-force-delete border-0 p-0" title="Hapus Permanen">
                    <i class="fa-solid fa-trash-can text-dark fs-5"></i>
                </button>
            </form>

            {{-- View Button --}}
            <a href="#" class="btn text-decoration-none border-0 p-0" title="Detail"
               data-bs-toggle="modal" data-bs-target="#historyModal{{ $history->id }}">
                <i class="fa-solid fa-eye text-dark fs-5"></i>
            </a>
        </div>
    </td>
</tr>

@empty
<tr>
    <td colspan="5" class="text-center text-muted py-4">
        <i class="fa-regular fa-folder-open me-2"></i>
        Tidak ada data produk yang dihapus
    </td>
</tr>
@endforelse

{{-- MODALS --}}
@foreach($historyProduk as $history)
<div class="modal fade" id="historyModal{{ $history->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Produk Terhapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold mb-1">Kode Produk:</label>
                        <p>{{ $history->kode_produk }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold mb-1">Nama Produk:</label>
                        <p>{{ $history->nama_produk }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold mb-1">Kategori:</label>
                        <p>{{ $history->category->nama_kategori ?? 'Tanpa Kategori' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold mb-1">Harga:</label>
                        <p class="text-primary">{{ $history->harga_formatted }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold mb-1">Stok:</label>
                        <p>{{ $history->stok }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold mb-1">Kondisi:</label>
                        <p>{!! $history->kondisi_badge !!}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold mb-1">Status:</label>
                        <p>{!! $history->status_badge !!}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold mb-1">Dibuat:</label>
                        <p>{{ $history->created_at ? $history->created_at->format('d-m-Y H:i') : '-' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold mb-1">Dihapus:</label>
                        <p class="text-danger">{{ $history->deleted_at ? $history->deleted_at->format('d-m-Y H:i') : '-' }}</p>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="fw-bold mb-1">Fitur:</label>
                        <p class="text-secondary">{{ $history->fitur }}</p>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="fw-bold mb-1">Deskripsi:</label>
                        <p class="text-secondary">{{ $history->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                    </div>
                    @if($history->gambar)
                    <div class="col-md-12">
                        <label class="fw-bold mb-1">Gambar:</label>
                        <div>
                            <img src="{{ asset('storage/' . $history->gambar) }}"
                                 alt="{{ $history->nama_produk }}"
                                 class="img-fluid rounded shadow-sm"
                                 style="max-height: 200px;">
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <form action="{{ route('produk.restore', $history->id) }}" method="POST" class="d-inline">
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
