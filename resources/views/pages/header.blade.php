<header class="header-section">
    <div class="header-container d-flex justify-content-between align-items-center" data-aos="fade-down" data-aos-delay="200">
        <div class="logo mx-0 px-0">
            <img src="{{ asset('assets/image/logo-name-mcr.png') }}" class="img-fluid" alt="logo-name-mcr">
        </div>

        <div class="navigasi d-flex align-items-center mx-0 px-0">
            <a href="{{ route('landing-page') }}#" class="nav-link">Beranda</a>
            <a href="{{ route('landing-page') }}#product-section" class="nav-link">Produk</a>
            <a href="{{ route('landing-page') }}#paket-peminjaman" class="nav-link">Paket</a>
            <a href="{{ route('landing-page') }}#cara-peminjaman" class="nav-link">Cara Pinjam</a>
        </div>

        <div class="search-demo d-flex align-items-center">
            <a href="#" class="search-btn me-4" id="searchTrigger">
                <i class="fa-solid fa-magnifying-glass"></i>
            </a>

            <button class="mobile-menu-toggle d-lg-none" id="mobileMenuToggle">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </button>

            @auth
                <!-- Tampilkan foto profile dengan dropdown -->
                <div class="dropdown profile-dropdown-container d-none d-md-block">
                    <a href="#" class="d-flex align-items-center text-decoration-none" id="dropdownProfile" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="profile-img-wrapper">
                            @if(Auth::user()->foto && file_exists(public_path('storage/' . Auth::user()->foto)))
                                <img src="{{ asset('storage/' . Auth::user()->foto) }}" alt="{{ Auth::user()->name }}" class="img-fluid object-fit-cover rounded-circle img-user" width="40" height="40">
                            @else
                                <div class="profile-initial rounded-circle d-flex align-items-center justify-content-center bg-primary text-white" style="width: 40px; height: 40px; font-weight: 600;">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end profile-dropdown bg-light p-3 border-0 shadow-sm rounded-3" aria-labelledby="dropdownProfile">
                        <li>
                            <div class="profile-user d-flex gap-3 pb-3 border-bottom">
                                <div class="profile-img-dropdown">
                                    @if(Auth::user()->foto && file_exists(public_path('storage/' . Auth::user()->foto)))
                                        <img src="{{ asset('storage/' . Auth::user()->foto) }}" alt="{{ Auth::user()->name }}" class="img-fluid object-fit-cover rounded-circle" width="45" height="45">
                                    @else
                                        <div class="profile-initial-dropdown rounded-circle d-flex align-items-center justify-content-center bg-primary text-white" style="width: 45px; height: 45px; font-size: 18px; font-weight: 600;">
                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="d-block" style="max-width: 160px;">
                                    <span class="nama-drop d-block text-dark fw-semibold" style="font-size: 14px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        {{ Auth::user()->name }}
                                    </span>
                                    <span class="email d-block text-secondary small" style="font-size: 12px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ Auth::user()->email }}">
                                        {{ Auth::user()->email }}
                                    </span>
                                    @if(Auth::user()->level == 'admin')
                                        <span class="badge bg-danger bg-opacity-10 text-danger mt-1 px-2 py-1" style="font-size: 10px; border-radius: 4px;">
                                            <i class="fa-solid fa-shield-alt me-1"></i>Admin
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </li>
                        <li class="mt-2">
                            <a class="dropdown-item text-secondary rounded-3 py-2" href="{{ Auth::user()->level == 'admin' ? '#' : route('user.profile') }}">
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
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger rounded-3 py-2" onclick="return confirm('Apakah Anda yakin ingin logout?')">
                                    <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <a href="{{ route('login') }}" class="masuk-btn d-none d-md-inline-flex">
                    <i class="fa-regular fa-circle-user me-2"></i>Masuk
                </a>
            @endauth
        </div>
    </div>

    <!-- Mobile Menu Overlay -->
    <div class="mobile-menu-overlay" id="mobileMenuOverlay"></div>

    <!-- Mobile Menu Dropdown -->
    <div class="mobile-menu-dropdown" id="mobileMenuDropdown">
        <div class="mobile-menu-container">
            <div class="mobile-menu-body">
                <a href="{{ route('landing-page') }}#" class="mobile-nav-link" data-section="home">
                    <i class="fas fa-home me-3"></i>Beranda
                </a>
                <a href="{{ route('landing-page') }}#product-section" class="mobile-nav-link" data-section="product-section">
                    <i class="fas fa-box me-3"></i>Produk
                </a>
                <a href="{{ route('landing-page') }}#paket-peminjaman" class="mobile-nav-link" data-section="paket-peminjaman">
                    <i class="fas fa-tags me-3"></i>Paket
                </a>
                <a href="{{ route('landing-page') }}#cara-peminjaman" class="mobile-nav-link" data-section="cara-peminjaman">
                    <i class="fas fa-hand-holding-heart me-3"></i>Cara Pinjam
                </a>

                @auth
                    <div class="mobile-divider"></div>
                    <div class="mobile-user-info">
                        <div class="mobile-user-avatar">
                            @if(Auth::user()->foto && file_exists(public_path('storage/' . Auth::user()->foto)))
                                <img src="{{ asset('storage/' . Auth::user()->foto) }}" alt="{{ Auth::user()->name }}">
                            @else
                                <div class="mobile-avatar-initial">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div class="mobile-user-details">
                            <span class="mobile-user-name">{{ Auth::user()->name }}</span>
                            <span class="mobile-user-email">{{ Auth::user()->email }}</span>
                        </div>
                    </div>
                    <a href="{{ Auth::user()->level == 'admin' ? '#' : route('user.profile') }}" class="mobile-nav-link">
                        <i class="fa-regular fa-user me-3"></i> Profil Saya
                    </a>
                    <a href="#" class="mobile-nav-link">
                        <i class="fa-regular fa-clipboard me-3"></i> Riwayat Peminjaman
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="mobile-logout-form">
                        @csrf
                        <button type="submit" class="mobile-nav-link mobile-logout">
                            <i class="fa-solid fa-right-from-bracket me-3"></i> Logout
                        </button>
                    </form>
                @else
                    <div class="mobile-divider"></div>
                    <a href="{{ route('login') }}" class="mobile-nav-link mobile-login-btn">
                        <i class="fa-regular fa-circle-user me-3"></i> Masuk
                    </a>
                @endauth
            </div>
        </div>
    </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileToggle = document.getElementById('mobileMenuToggle');
    const mobileOverlay = document.getElementById('mobileMenuOverlay');
    const mobileDropdown = document.getElementById('mobileMenuDropdown');

    function openMobileMenu() {
        mobileOverlay.classList.add('active');
        mobileDropdown.classList.add('active');
        document.body.style.overflow = 'hidden';

        // Ubah icon burger menjadi X
        const bars = document.querySelectorAll('.bar');
        bars[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
        bars[1].style.opacity = '0';
        bars[2].style.transform = 'rotate(-45deg) translate(7px, -6px)';
    }

    function closeMobileMenu() {
        mobileOverlay.classList.remove('active');
        mobileDropdown.classList.remove('active');
        document.body.style.overflow = '';

        // Kembalikan icon burger
        const bars = document.querySelectorAll('.bar');
        bars[0].style.transform = 'none';
        bars[1].style.opacity = '1';
        bars[2].style.transform = 'none';
    }

    // Toggle mobile menu
    if (mobileToggle) {
        mobileToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            if (mobileDropdown.classList.contains('active')) {
                closeMobileMenu();
            } else {
                openMobileMenu();
            }
        });
    }

    // Tutup menu saat klik overlay
    if (mobileOverlay) {
        mobileOverlay.addEventListener('click', function() {
            closeMobileMenu();
        });
    }

    // Smooth scroll untuk mobile nav links
    const mobileNavLinks = document.querySelectorAll('.mobile-nav-link[data-section]');
    mobileNavLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const sectionId = this.getAttribute('data-section');
            let targetElement;

            if (sectionId === 'home') {
                targetElement = document.querySelector('.hero-section');
            } else {
                targetElement = document.getElementById(sectionId);
            }

            if (targetElement) {
                // Tutup menu
                closeMobileMenu();

                // Smooth scroll ke target
                const header = document.querySelector('.header-section');
                const headerHeight = header ? header.offsetHeight : 80;
                const elementPosition = targetElement.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerHeight;

                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Tutup menu saat resize ke desktop
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 992) {
            closeMobileMenu();
        }
    });
});
</script>
