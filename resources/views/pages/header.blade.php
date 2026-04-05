<header class="header-section">
        <div class="header-container d-flex justify-content-between align-items-center"  data-aos="fade-down" data-aos-delay="200">
            <div class="logo mx-0 px-0">
                <img src="{{ asset('assets/image/logo-name-mcr.png') }}" class="img-fluid"
                    alt="logo-name-mcr">
            </div>
            <div class="navigasi d-flex align-items-center mx-0 px-0">
                <a href="{{ route('landing-page') }}#" class="nav-link">Beranda</a>
                <a href="{{ route('landing-page') }}#product-section" class="nav-link">Produk</a>
                <a href="{{ route('landing-page') }}#paket-peminjaman" class="nav-link">Paket</a>
                <a href="{{ route('landing-page') }}#cara-peminjaman" class="nav-link">Cara Pinjam</a>
                {{-- <a href="pages/berita.html" class="nav-link">Berita & Artikel</a>
                <a href="pages/karir.html" class="nav-link">Karir</a> --}}
            </div>
            <!-- Navbar bagian search dan profile/auth -->
            <div class="search-demo d-flex align-items-center">
                <a href="#" class="search-btn me-4" id="searchTrigger">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </a>

                <!-- CEK APAKAH USER SUDAH LOGIN -->
                @auth
                    <!-- Tampilkan foto profile dengan dropdown -->
                    <div class="dropdown profile-dropdown-container">
                        <a href="#" class="d-flex align-items-center text-decoration-none"
                        id="dropdownProfile"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">
                            <div class="profile-img-wrapper">
                                @if(Auth::user()->foto && file_exists(public_path('storage/' . Auth::user()->foto)))
                                    <img src="{{ asset('storage/' . Auth::user()->foto) }}"
                                        alt="{{ Auth::user()->name }}"
                                        class="img-fluid object-fit-cover rounded-circle img-user"
                                        width="40"
                                        height="40">
                                @else
                                    <div class="profile-initial rounded-circle d-flex align-items-center justify-content-center bg-primary text-white"
                                        style="width: 40px; height: 40px; font-weight: 600;">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                        </a>

                        <!-- Dropdown Menu -->
                        <ul class="dropdown-menu dropdown-menu-end profile-dropdown bg-light p-3 border-0 shadow-sm rounded-3"
                            aria-labelledby="dropdownProfile">
                            <!-- Info User -->
                            <li>
                                <div class="profile-user d-flex gap-3 pb-3 border-bottom">
                                    <div class="profile-img-dropdown">
                                        @if(Auth::user()->foto && file_exists(public_path('storage/' . Auth::user()->foto)))
                                            <img src="{{ asset('storage/' . Auth::user()->foto) }}"
                                                alt="{{ Auth::user()->name }}"
                                                class="img-fluid object-fit-cover rounded-circle"
                                                width="45"
                                                height="45">
                                        @else
                                            <div class="profile-initial-dropdown rounded-circle d-flex align-items-center justify-content-center bg-primary text-white"
                                                style="width: 45px; height: 45px; font-size: 18px; font-weight: 600;">
                                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="d-block" style="max-width: 160px;">
                                        <span class="nama-drop d-block text-dark fw-semibold"
                                            style="font-size: 14px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            {{ Auth::user()->name }}
                                        </span>
                                        <span class="email d-block text-secondary small"
                                            style="font-size: 12px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"
                                            title="{{ Auth::user()->email }}">
                                            {{ Auth::user()->email }}
                                        </span>
                                        @if(Auth::user()->level == 'admin')
                                            <span class="badge bg-danger bg-opacity-10 text-danger mt-1 px-2 py-1"
                                                style="font-size: 10px; border-radius: 4px;">
                                                <i class="fa-solid fa-shield-alt me-1"></i>Admin
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </li>

                            <!-- Menu Items -->
                            <li class="mt-2">
                                <a class="dropdown-item text-secondary rounded-3 py-2"
                                href="{{ Auth::user()->level == 'admin' ? '#' : route('user.profile') }}">
                                    <i class="fa-regular fa-user me-2"></i> Profil Saya
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item text-secondary rounded-3 py-2" href="#">
                                    <i class="fa-regular fa-clipboard me-2"></i> Riwayat Peminjaman
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item text-secondary rounded-3 py-2" href="#">
                                    <i class="fa-solid fa-user-gear me-2"></i> Pengaturan
                                </a>
                            </li>

                            <li><hr class="dropdown-divider my-2"></li>

                            <!-- Logout Form -->
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit"
                                            class="dropdown-item text-danger rounded-3 py-2"
                                            onclick="return confirm('Apakah Anda yakin ingin logout?')">
                                        <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <!-- Tampilkan tombol Masuk jika belum login -->
                    <a href="{{ route('login') }}" class="masuk-btn">
                        <i class="fa-regular fa-circle-user me-2 d-none d-md-inline"></i>Masuk
                    </a>
                @endauth
            </div>
        </div>
    </header>
