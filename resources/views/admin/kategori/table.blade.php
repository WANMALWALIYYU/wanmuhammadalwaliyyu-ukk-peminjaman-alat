@foreach ($getKategori as $kategori)
<tr>
    <td class="align-middle font-weight-semibold">
        <div class="d-flex align-items-center gap-2">
            @if($kategori->image)
                <img src="{{ asset('storage/' . $kategori->image) }}"
                    alt="{{ $kategori->nama_kategori }}"
                    class="rounded shadow-sm"
                    style="width:80px; height:60px; object-fit:cover;">
            @else
                <span class="text-muted">-</span>
            @endif
            <span>
                {{ ($getKategori->currentPage() - 1) * $getKategori->perPage() + $loop->iteration }} / {{ $kategori->kode_kategori }}
            </span>
        </div>

    </td>

    <td class="align-middle">
        {{ $kategori->nama_kategori }}
    </td>

    <td class="align-middle text-secondary"
        style="max-width:240px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
        {{ $kategori->deskripsi_kategori ?? '-' }}
    </td>

    <td class="align-middle text-center">
        <span class="badge bg-info">{{ $kategori->produks_count ?? 0 }} Produk</span>
    </td>

    <td class="align-middle text-center">
        <div class="d-flex justify-content-center gap-2">
            <a href="{{ route('kategori.edit', $kategori->id) }}" class="btn text-decoration-none border-0 p-0" title="Edit">
                <i class="fa-solid fa-pen-to-square text-dark"></i>
            </a>

            <a href="#" class="btn text-decoration-none border-0 p-0" title="Detail"
               data-bs-toggle="modal" data-bs-target="#viewModal{{ $kategori->id }}">
                <i class="fa-solid fa-eye text-dark"></i>
            </a>

            <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-delete border-0 p-0" title="Hapus">
                    <i class="fa-solid fa-trash-can text-dark"></i>
                </button>
            </form>
        </div>
    </td>
</tr>
@endforeach

@if($getKategori->isEmpty())
<tr>
    <td colspan="6" class="text-center text-muted py-4">Tidak ada data kategori</td>
</tr>
@endif

{{-- MODALS --}}
@foreach ($getKategori as $kategori)
<div class="modal fade" id="viewModal{{ $kategori->id }}" tabindex="-1" aria-hidden="true" style="z-index: 9999;">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    {{-- Gambar --}}
                    <div class="col-md-5 text-center">
                        @if($kategori->image)
                            <img src="{{ asset('storage/' . $kategori->image) }}"
                                 alt="{{ $kategori->nama_kategori }}"
                                 class="img-fluid rounded shadow-sm"
                                 style="max-height: 250px;">
                        @else
                            <div class="border rounded py-5 text-muted">
                                <i class="fa-regular fa-image fa-3x"></i>
                                <p class="mt-2">Tidak ada gambar</p>
                            </div>
                        @endif
                    </div>

                    {{-- Info Kategori --}}
                    <div class="col-md-7">
                        <div class="mb-3">
                            <label class="fw-bold mb-1">Kode Kategori:</label>
                            <p class="mb-2">{{ $kategori->kode_kategori }}</p>

                            <label class="fw-bold mb-1">Nama Kategori:</label>
                            <p class="mb-2">{{ $kategori->nama_kategori }}</p>

                            <label class="fw-bold mb-1">Jumlah Produk:</label>
                            <p class="mb-2">{{ $kategori->produks_count ?? 0 }} Produk</p>

                            <label class="fw-bold mb-1">Dibuat:</label>
                            <p class="mb-2">{{ $kategori->created_at ? $kategori->created_at->format('d-m-Y H:i') : '-' }}</p>

                            <label class="fw-bold mb-1">Diperbarui:</label>
                            <p class="mb-2">{{ $kategori->updated_at ? $kategori->updated_at->format('d-m-Y H:i') : '-' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Deskripsi --}}
                <hr class="my-3">
                <div>
                    <label class="fw-bold mb-2">Deskripsi:</label>
                    <p class="text-secondary">{{ $kategori->deskripsi_kategori ?? 'Tidak ada deskripsi' }}</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <a href="{{ route('kategori.edit', $kategori->id) }}" class="btn btn-primary">
                    <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                </a>
            </div>
        </div>
    </div>
</div>
@endforeach
