@foreach ($getUser as $user)
    <tr>
        <td class="align-middle">
            <p class="ms-3 text-sm font-weight-semibold">
                 {{ $loop->iteration + ($getUser->currentPage() - 1) * $getUser->perPage() }} / {{ $user->id }}
            </p>
        </td>
        <td class="text-center">
            <div class="d-flex align-items-center">
                @if(Auth::user()->foto && file_exists(public_path('storage/' . Auth::user()->foto)))
                    <img src="{{ asset('storage/' . Auth::user()->foto) }}"
                        alt="{{ Auth::user()->name }}"
                        class="avatar rounded-circle"
                        width="40"
                        height="40">
                @else
                    <div class="profile-initial rounded-circle d-flex align-items-center justify-content-center bg-dark text-white"
                        style="width: 40px; height: 40px; font-weight: 600;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif
                <div class="ms-2">
                    <h6 class="mb-0 text-sm font-weight-semibold">{{ $user->name }}</h6>
                    <p class="text-sm text-secondary mb-0">{{ $user->email }}</p>
                </div>
            </div>
        </td>
        <td class="align-middle">
            <span class="text-secondary text-sm font-weight-normal">{{ $user->nomor_hp ?? '-' }}</span>
        </td>
        <td class="align-middle">
            <p class="text-sm font-weight-semibold mb-0 {{ $user->level == 'admin' ? 'text-primary' : 'text-success' }}">{{ $user->level }}</p>
        </td>
        <td class="align-middle text-center text-sm">
          {!! $user->getOnlineStatusBadge() !!}
        </td>
        <td class="align-middle text-center">
            <div class="d-flex justify-content-center gap-2">
                {{-- <a href="{{ route('admin.user.edit', $user->id) }}" class="text-decoration-none"> --}}
                <a href="#" class="text-decoration-none">
                    <i class="fa-solid fa-pen-to-square text-dark"></i>
                </a>
                <a href="#" class="text-decoration-none text-info opacity-7">
                    <i class="fa-solid fa-eye text-dark"></i>
                </a>
                {{-- <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" class="d-inline"> --}}
                <form action="#" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-delete border-0 p-0" onclick="return confirm('Yakin ingin menghapus?')">
                        <i class="fa-solid fa-trash-can text-dark"></i>
                    </button>
                </form>
            </div>
        </td>
    </tr>
@endforeach

@if($getUser->isEmpty())
<tr>
    <td colspan="6" class="text-center text-muted py-4">Tidak ada data user</td>
</tr>
@endif

<tr>
    <td colspan="6">
        <div class="d-flex justify-content-center mt-4">
            {{ $getUser->links('pagination::bootstrap-5') }}
        </div>
    </td>
</tr>
