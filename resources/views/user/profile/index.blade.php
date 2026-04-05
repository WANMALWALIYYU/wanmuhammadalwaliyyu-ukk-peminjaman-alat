@extends('index')
@section('pages', 'Profile')
@section('content')

<style>
    /* ===============================
       SIDEBAR STYLES ONLY
       =============================== */
    :root {
        /* ===== PRIMARY (Medical Blue) ===== */
        --primary: #0b2c5d;
        --primary-dark: #081f3f;
        --primary-light: #1f3c88;
        --primary-soft: #e8f0fe;

        /* ===== SECONDARY ===== */
        --secondary: #1f3c88;
        --secondary-soft: #f0f5ff;

        /* ===== ACCENT ===== */
        --accent-green: #10b981;
        --accent-blue: #3b82f6;
        --accent-purple: #8b5cf6;
        --accent-orange: #f59e0b;
        --accent-red: #ef4444;

        /* ===== BACKGROUND ===== */
        --background: #ffffff;
        --background-sec: #f8fafc;
        --light-bg: #f1f5f9;
        --gray-light: #e2e8f0;

        /* ===== TEXT ===== */
        --text-color: #0f172a;
        --text-color-sec: #334155;
        --text-muted: #64748b;

        /* ===== GRADIENT ===== */
        --gradient-primary: linear-gradient(145deg, #0b2c5d, #1e3a8a);
        --gradient-soft: linear-gradient(145deg, #f8fafc, #ffffff);

        /* ===== SHADOW ===== */
        --shadow-sm: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        --shadow-md: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        --shadow-lg: 0 25px 50px -12px rgb(0 0 0 / 0.25);

        /* ===== TRANSITION ===== */
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);

        /* ===== BORDER RADIUS ===== */
        --radius-sm: 0.5rem;
        --radius-md: 1rem;
        --radius-lg: 1.5rem;
        --radius-xl: 2rem;
        --radius-full: 9999px;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background-color: var(--background-sec);
        color: var(--text-color);
        line-height: 1.6;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    /* Container utama */
    .profile-dashboard {
        max-width: 1400px;
        margin: 2rem auto;
        padding: 0 1.5rem;
        display: grid;
        grid-template-columns: 320px 1fr;
        gap: 1.5rem;
        animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* ================= SIDEBAR KIRI ================= */
    .profile-sidebar {
        background: var(--background);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-md);
        overflow: hidden;
        height: fit-content;
        position: sticky;
        top: 1.5rem;
        transition: var(--transition);
        border: 1px solid rgba(11, 44, 93, 0.08);
    }

    .profile-sidebar:hover {
        box-shadow: var(--shadow-lg);
        transform: translateY(-2px);
    }

    /* Header sidebar */
    .sidebar-header {
        background: var(--gradient-primary);
        padding: 2rem 1.5rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .sidebar-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 100%);
        pointer-events: none;
    }

    .avatar-wrapper {
        width: 120px;
        height: 120px;
        margin: 0 auto 1rem;
        border-radius: var(--radius-full);
        border: 4px solid rgba(255,255,255,0.3);
        background: linear-gradient(145deg, #fff, var(--primary-soft));
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        box-shadow: var(--shadow-lg);
        position: relative;
        z-index: 1;
        transition: var(--transition);
    }

    .avatar-wrapper:hover {
        transform: scale(1.05);
        border-color: rgba(255,255,255,0.5);
    }

    .avatar-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-initial {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        font-weight: 700;
        color: var(--primary);
        background: linear-gradient(145deg, #fff, var(--primary-soft));
    }

    .sidebar-header h3 {
        font-size: 1.35rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: white;
        position: relative;
        z-index: 1;
    }

    .sidebar-header p {
        font-size: 0.85rem;
        opacity: 0.9;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        color: white;
        position: relative;
        z-index: 1;
    }

    .badge-premium {
        margin-top: 0.75rem;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
        padding: 0.4rem 1rem;
        border-radius: var(--radius-full);
        font-size: 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: 1px solid rgba(255,255,255,0.3);
        color: white;
        font-weight: 500;
        position: relative;
        z-index: 1;
    }

    /* Menu navigasi sidebar */
    .sidebar-menu {
        padding: 1rem 0;
    }

    .menu-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.75rem 1.5rem;
        color: var(--text-color-sec);
        font-weight: 500;
        transition: var(--transition);
        text-decoration: none;
        position: relative;
    }

    .menu-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: var(--gradient-primary);
        transform: scaleY(0);
        transition: var(--transition);
        border-radius: 0 4px 4px 0;
    }

    .menu-item i {
        width: 24px;
        font-size: 1.2rem;
        color: var(--primary-light);
        transition: var(--transition);
    }

    .menu-item:hover {
        background: var(--secondary-soft);
        color: var(--primary);
        padding-left: 2rem;
    }

    .menu-item:hover::before {
        transform: scaleY(1);
    }

    .menu-item:hover i {
        color: var(--primary);
        transform: scale(1.1);
    }

    .menu-item.active {
        background: var(--secondary-soft);
        color: var(--primary);
        font-weight: 600;
        padding-left: 2rem;
    }

    .menu-item.active::before {
        transform: scaleY(1);
    }

    .menu-item.active i {
        color: var(--primary);
    }

    /* Sidebar footer */
    .sidebar-footer {
        padding: 1rem 1.5rem 1.5rem;
        border-top: 1px solid var(--gray-light);
        background: var(--background-sec);
    }

    .logout-btn {
        display: flex;
        align-items: center;
        gap: 1rem;
        color: var(--accent-red);
        font-weight: 500;
        padding: 0.75rem 0;
        transition: var(--transition);
        text-decoration: none;
        border-radius: var(--radius-md);
    }

    .logout-btn i {
        width: 24px;
        color: var(--accent-red);
        transition: var(--transition);
    }

    .logout-btn:hover {
        color: #dc2626;
        transform: translateX(5px);
    }

    .status-info {
        font-size: 0.75rem;
        color: var(--text-muted);
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px dashed var(--gray-light);
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .status-info i {
        color: var(--accent-green);
    }

    /* ================= KONTEN KANAN ================= */
    .profile-content {
        background: var(--background);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-md);
        padding: 2rem;
        transition: var(--transition);
        border: 1px solid rgba(11, 44, 93, 0.08);
        animation: slideIn 0.5s ease;
    }

    @keyframes slideIn {
        from { opacity: 0; transform: translateX(20px); }
        to { opacity: 1; transform: translateX(0); }
    }

    .profile-content:hover {
        box-shadow: var(--shadow-lg);
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .profile-dashboard {
            grid-template-columns: 280px 1fr;
        }
    }

    @media (max-width: 900px) {
        .profile-dashboard {
            grid-template-columns: 1fr;
        }
        .profile-sidebar {
            position: static;
            margin-bottom: 1rem;
        }
    }

    @media (max-width: 640px) {
        .profile-dashboard {
            padding: 0 1rem;
        }
    }
</style>

<div class="profile-dashboard">
    <!-- SIDEBAR KIRI -->
    <aside class="profile-sidebar">
        <div class="sidebar-header">
            <div class="avatar-wrapper">
                @if(Auth::user()->foto && file_exists(public_path('storage/' . Auth::user()->foto)))
                    <img src="{{ asset('storage/' . Auth::user()->foto) }}" alt="{{ Auth::user()->name }}">
                @else
                    <div class="profile-initial">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif
            </div>
            <h3>{{ Auth::user()->name }}</h3>
            <p><i class="fas fa-envelope"></i> {{ Auth::user()->email }}</p>
            <div class="badge-premium">
                <i class="fas {{ Auth::user()->level == 'admin' ? 'fa-shield-alt' : (Auth::user()->level == 'petugas' ? 'fa-user-md' : 'fa-user') }}"></i>
                {{ ucfirst(Auth::user()->level) }}
            </div>
        </div>

        <div class="sidebar-menu">
            <a href="{{ route('user.profile') }}" class="menu-item {{ request()->routeIs('user.profile') ? 'active' : '' }}">
                <i class="fas fa-id-card"></i>
                <span>Profile</span>
            </a>
            <a href="{{ route('user.profile.edit') }}" class="menu-item">
                <i class="fas fa-user-edit"></i>
                <span>Update Profile</span>
            </a>
            <a href="{{ route('transaksi.riwayat') }}" class="menu-item">
                <i class="fas fa-shopping-bag"></i>
                <span>Pesanan Saya</span>
            </a>
            <a href="#" class="menu-item">
                <i class="fas fa-cog"></i>
                <span>Pengaturan Akun</span>
            </a>
        </div>

        <div class="sidebar-footer">
            <a href="{{ route('logout') }}" class="logout-btn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i>
                <span>Keluar</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <div class="status-info">
                <i class="fas fa-circle" style="font-size: 0.5rem; color: var(--accent-green);"></i>
                <span>Online</span>
                <i class="fas fa-shield-alt"></i>
                <span>Data Terenkripsi</span>
            </div>
        </div>
    </aside>

    <!-- KONTEN KANAN -->
    <main class="profile-content">
        @yield('profile-content')
    </main>
</div>

<!-- Font Awesome 6 -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<!-- Google Fonts - Inter -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

@endsection
