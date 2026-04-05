@foreach ($getProduk as $produk)
<tr>
    <td class="align-middle font-weight-semibold">
        <div class="d-flex align-items-center gap-2">
            @if($produk->gambar)
                <img src="{{ asset('storage/' . $produk->gambar) }}"
                    alt="{{ $produk->nama_produk }}"
                    class="rounded shadow-sm"
                    style="width: 70px;height: 50px;object-fit: cover;">
            @else
                <div class="bg-light d-flex align-items-center justify-content-center rounded"
                    style="width:60px;height:45px;">
                    <i class="fa-solid fa-image text-muted"></i>
                </div>
            @endif

            <span>
                {{ ($getProduk->currentPage() - 1) * $getProduk->perPage() + $loop->iteration }}
                / {{ $produk->kode_produk }}
            </span>
        </div>
    </td>

    <td class="align-middle">
        {{ $produk->category->nama_kategori ?? 'Tanpa Kategori' }}
    </td>

    <td class="align-middle">
        {{ $produk->nama_produk }}
    </td>

    <td class="align-middle font-weight-bold text-primary">
        {{ $produk->harga_formatted }}
    </td>

    <td class="align-middle">
        {!! $produk->status_badge !!}
    </td>

    <td class="align-middle text-center">
        <div class="d-flex justify-content-center gap-2">
            <a href="{{ route('produk.edit', $produk->id) }}" class="btn text-decoration-none border-0 p-0" title="Edit">
                <i class="fa-solid fa-pen-to-square text-dark"></i>
            </a>

            <a href="#" class="btn text-decoration-none border-0 p-0" title="Detail"
               data-bs-toggle="modal" data-bs-target="#viewModal{{ $produk->id }}">
                <i class="fa-solid fa-eye text-dark"></i>
            </a>

            <form action="{{ route('produk.destroy', $produk->id) }}" method="POST" class="d-inline">
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

@if($getProduk->isEmpty())
<tr>
    <td colspan="8" class="text-center text-muted py-4">
        <i class="fa-regular fa-box me-2"></i>
        Tidak ada produk tersedia
    </td>
</tr>
@endif
