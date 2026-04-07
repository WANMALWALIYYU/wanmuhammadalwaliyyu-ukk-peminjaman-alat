<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="MediCareRent Admin Panel" />
    <meta name="keyword" content="medical, rental, admin" />
    <meta name="author" content="MediCareRent" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MediCareRent - @yield('title')</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/image/logo-mcr.png') }}" />

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Custom CSS -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        :root {
            --primary-dark: #0b2c5d;
            --primary: #1f3c88;
            --primary-light: #2d4a9e;
            --secondary: #10b981;
            --gray-bg: #f5f7fa;
            --white: #ffffff;
            --text-dark: #1e293b;
            --text-muted: #64748b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #eef2f7 100%);
            overflow-x: hidden;
        }

        /* ========== SIDEBAR MODERN ========== */
        .sidebar-modern {
            position: fixed;
            top: 0;
            left: 0;
            width: 280px;
            height: 100vh;
            background: linear-gradient(145deg, #0b2c5d 0%, #1f3c88 100%);
            box-shadow: 4px 0 20px rgba(0,0,0,0.08);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1030;
            overflow-y: auto;
        }

        /* Animated gradient overlay */
        .sidebar-modern::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
            pointer-events: none;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Logo Section */
        .sidebar-logo {
            padding: 24px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            position: relative;
            z-index: 2;
        }

        .sidebar-logo img {
            max-height: 50px;
            margin-bottom: 12px;
            filter: brightness(0) invert(1);
        }

        .sidebar-logo h4 {
            color: white;
            font-weight: 700;
            margin-bottom: 4px;
            font-size: 1.2rem;
        }

        .sidebar-logo p {
            color: rgba(255,255,255,0.7);
            font-size: 0.7rem;
            margin-bottom: 0;
        }

        /* Navigation Menu */
        .sidebar-nav {
            padding: 20px 0;
            position: relative;
            z-index: 2;
        }

        .nav-caption {
            color: rgba(255,255,255,0.5);
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 16px 24px 8px;
        }

        .nav-item {
            margin: 4px 16px;
        }

        .nav-link-custom {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            border-radius: 14px;
            font-weight: 500;
            font-size: 0.85rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .nav-link-custom::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
            transition: left 0.5s ease;
        }

        .nav-link-custom:hover::before {
            left: 100%;
        }

        .nav-link-custom:hover {
            background: rgba(255,255,255,0.12);
            color: white;
            transform: translateX(6px);
        }

        .nav-link-custom.active {
            background: linear-gradient(135deg, rgba(255,255,255,0.2), rgba(255,255,255,0.1));
            color: white;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        .nav-link-custom i {
            width: 28px;
            font-size: 1.1rem;
            margin-right: 12px;
            text-align: center;
        }

        /* Dropdown Menu */
        .nav-dropdown {
            position: relative;
        }

        .dropdown-arrow {
            margin-left: auto;
            transition: transform 0.3s ease;
        }

        .nav-dropdown.open .dropdown-arrow {
            transform: rotate(90deg);
        }

        .nav-submenu {
            padding-left: 48px;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .nav-dropdown.open .nav-submenu {
            max-height: 500px;
        }

        .nav-submenu .nav-link-custom {
            padding: 10px 20px;
            font-size: 0.8rem;
            color: rgba(255,255,255,0.75);
        }

        .nav-submenu .nav-link-custom:hover {
            color: white;
            background: rgba(255,255,255,0.1);
            transform: translateX(4px);
        }

        /* Sidebar Card */
        .sidebar-card {
            margin: 20px;
            background: rgba(255,255,255,0.08);
            border-radius: 16px;
            padding: 20px;
            text-align: center;
            border: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-card i {
            font-size: 2rem;
            color: rgba(255,255,255,0.8);
        }

        .sidebar-card h6 {
            color: white;
            margin: 12px 0 8px;
            font-weight: 600;
        }

        .sidebar-card p {
            color: rgba(255,255,255,0.6);
            font-size: 0.7rem;
            margin-bottom: 16px;
        }

        .sidebar-card .btn-download {
            background: rgba(255,255,255,0.2);
            border: none;
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s ease;
        }

        .sidebar-card .btn-download:hover {
            background: rgba(255,255,255,0.3);
        }

        /* ========== MAIN CONTENT ========== */
        .main-wrapper {
            margin-left: 280px;
            transition: all 0.3s ease;
        }

        /* Top Header */
        .top-header {
            background: white;
            padding: 16px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #e2e8f0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
            position: sticky;
            top: 0;
            z-index: 1020;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.2rem;
            color: var(--text-dark);
            cursor: pointer;
        }

        .page-title h4 {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0;
        }

        .breadcrumb-custom {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 4px;
        }

        .breadcrumb-custom a {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.75rem;
        }

        .breadcrumb-custom span {
            color: var(--text-muted);
            font-size: 0.75rem;
        }

        .breadcrumb-custom i {
            font-size: 0.6rem;
            color: var(--text-muted);
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .search-btn, .theme-toggle, .fullscreen-btn {
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            font-size: 1.1rem;
            padding: 8px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .search-btn:hover, .theme-toggle:hover, .fullscreen-btn:hover {
            background: #f1f5f9;
            color: var(--primary);
        }

        .notification-btn {
            position: relative;
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            font-size: 1.1rem;
            padding: 8px;
            border-radius: 8px;
        }

        .notification-badge {
            position: absolute;
            top: 0;
            right: 0;
            background: #ef4444;
            color: white;
            font-size: 0.6rem;
            padding: 2px 5px;
            border-radius: 10px;
        }

        .user-dropdown {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            padding: 6px 12px;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .user-dropdown:hover {
            background: #f1f5f9;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .user-info {
            text-align: right;
        }

        .user-name {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0;
            font-size: 0.85rem;
        }

        .user-role {
            font-size: 0.7rem;
            color: var(--text-muted);
        }

        /* Page Content */
        .page-content {
            padding: 24px 32px;
            min-height: calc(100vh - 73px);
        }

        /* Footer */
        .footer-custom {
            padding: 20px 32px;
            background: white;
            border-top: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }

        .footer-custom p {
            margin-bottom: 0;
            font-size: 0.7rem;
            color: var(--text-muted);
        }

        .footer-links {
            display: flex;
            gap: 24px;
        }

        .footer-links a {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.7rem;
            font-weight: 500;
        }

        .footer-links a:hover {
            color: var(--primary);
        }

        /* ========== DROPDOWN MENUS ========== */
        .dropdown-menu-custom {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            min-width: 300px;
            display: none;
            z-index: 1050;
            margin-top: 10px;
        }

        .dropdown-menu-custom.show {
            display: block;
            animation: fadeIn 0.2s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 1024px) {
            .sidebar-modern {
                transform: translateX(-100%);
            }

            .sidebar-modern.mobile-open {
                transform: translateX(0);
            }

            .main-wrapper {
                margin-left: 0;
            }

            .mobile-toggle {
                display: block;
            }

            .top-header {
                padding: 12px 20px;
            }

            .page-content {
                padding: 20px;
            }
        }

        @media (max-width: 768px) {
            .user-info {
                display: none;
            }

            .footer-custom {
                flex-direction: column;
                text-align: center;
            }
        }

        /* ========== SCROLLBAR ========== */
        .sidebar-modern::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-modern::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
        }

        .sidebar-modern::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.3);
            border-radius: 4px;
        }

        /* ========== ALERT STYLES ========== */
        .alert-modern {
            border-radius: 12px;
            border: none;
            padding: 16px 20px;
            margin-bottom: 24px;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ========== LOADING OVERLAY ========== */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            backdrop-filter: blur(4px);
        }

        .spinner-modern {
            width: 50px;
            height: 50px;
            border: 4px solid rgba(255,255,255,0.3);
            border-top: 4px solid white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>

    @stack('styles')
</head>

<body>
    {{-- Sweet Alert --}}
    @include('sweetalert::alert')

    <!-- Sidebar -->
    <aside class="sidebar-modern" id="sidebar">
        <div class="sidebar-logo">
            <img src="{{ asset('assets/image/logo-mcr.png') }}" alt="MediCareRent">
            <h4>MediCareRent</h4>
            <p>Admin Panel</p>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-caption">Navigation</div>

            <!-- Dashboard Dropdown -->
            <div class="nav-item nav-dropdown {{ request()->routeIs('admin.dashboard*') ? 'open' : '' }}">
                <a href="javascript:void(0);" class="nav-link-custom" onclick="toggleDropdown(this)">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboards</span>
                    <i class="fas fa-chevron-right dropdown-arrow"></i>
                </a>
                <div class="nav-submenu">
                    <a href="{{ route('admin.dashboard') }}"
                    class="nav-link-custom {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-chart-line"></i> Dashboard View
                    </a>
                    <a href="javascript:void(0);" class="nav-link-custom">
                        <i class="fas fa-chart-pie"></i> Analytics
                    </a>
                </div>
            </div>

            <!-- Users -->
            <div class="nav-item">
                <a href="{{ route('user.index') }}"
                class="nav-link-custom {{ request()->routeIs('user.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Users</span>
                </a>
            </div>

            <!-- Kategori -->
            <div class="nav-item">
                <a href="{{ route('kategori.index') }}"
                class="nav-link-custom {{ request()->routeIs('kategori.*') ? 'active' : '' }}">
                    <i class="fas fa-tags"></i>
                    <span>Kategori</span>
                </a>
            </div>

            <!-- Produk -->
            <div class="nav-item">
                <a href="{{ route('produk.index') }}"
                class="nav-link-custom {{ request()->routeIs('produk.*') ? 'active' : '' }}">
                    <i class="fas fa-box-open"></i>
                    <span>Produk</span>
                </a>
            </div>

            <!-- Transaksi -->
            <div class="nav-item">
                <a href="{{ route('admin.transaksi.index') }}"
                class="nav-link-custom {{ request()->routeIs('admin.transaksi*') ? 'active' : '' }}">
                    <i class="fas fa-file-invoice-dollar"></i>
                    <span>Transaksi</span>
                </a>
            </div>

            <!-- Pengembalian -->
            <div class="nav-item">
                <a href="{{ route('admin.pengembalian.index') }}"
                class="nav-link-custom {{ request()->routeIs('admin.pengembalian*') ? 'active' : '' }}">
                    <i class="fas fa-undo-alt"></i>
                    <span>Pengembalian</span>
                </a>
            </div>

            <!-- Pengiriman -->
            <div class="nav-item">
                <a href="{{ route('admin.pengiriman.index') }}"
                class="nav-link-custom {{ request()->routeIs('admin.pengiriman*') ? 'active' : '' }}">
                    <i class="fas fa-truck"></i>
                    <span>Pengiriman</span>
                </a>
            </div>

            <!-- Pembayaran -->
            <div class="nav-item">
                <a href="{{ route('admin.pengiriman.index') }}"
                class="nav-link-custom {{ request()->routeIs('admin.pengiriman*') ? 'active' : '' }}">
                    <i class="fas fa-credit-card"></i>
                    <span>Pembayaran</span>
                </a>
            </div>

            <!-- Log Activity -->
            <div class="nav-item">
                <a href="{{ route('activity-logs.index') }}"
                class="nav-link-custom {{ request()->routeIs('activity-logs.*') ? 'active' : '' }}">
                    <i class="fas fa-history"></i>
                    <span>Log Activity</span>
                </a>
            </div>

            <!-- Settings Dropdown -->
            <div class="nav-item nav-dropdown">
                <a href="javascript:void(0);" class="nav-link-custom" onclick="toggleDropdown(this)">
                    <i class="fas fa-cogs"></i>
                    <span>Settings</span>
                    <i class="fas fa-chevron-right dropdown-arrow"></i>
                </a>
                <div class="nav-submenu">
                    <a href="javascript:void(0);" class="nav-link-custom">
                        <i class="fas fa-sliders-h"></i> General
                    </a>
                    <a href="javascript:void(0);" class="nav-link-custom">
                        <i class="fas fa-search"></i> SEO
                    </a>
                    <a href="javascript:void(0);" class="nav-link-custom">
                        <i class="fas fa-envelope"></i> Email
                    </a>
                </div>
            </div>

            <div class="nav-caption mt-3">Support</div>

            <!-- Help Center -->
            <div class="nav-item">
                <a href="javascript:void(0);" class="nav-link-custom">
                    <i class="fas fa-life-ring"></i>
                    <span>Help Center</span>
                </a>
            </div>

        </nav>

        <!-- Sidebar Card -->
        <div class="sidebar-card">
            <i class="fas fa-cloud-download-alt"></i>
            <h6>Download Center</h6>
            <p>Get the latest version of MediCareRent</p>
            <a href="https://www.themewagon.com/themes/Duralux-admin" target="_blank" class="btn-download">
                Download Now
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="main-wrapper">
        <!-- Top Header -->
        <header class="top-header">
            <div class="header-left">
                <button class="mobile-toggle" id="mobileToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <div>
                    <h4 class="mb-0">@yield('page-title', 'Dashboard')</h4>
                    <div class="breadcrumb-custom">
                        <a href="{{ route('admin.dashboard') }}">Home</a>
                        <i class="fas fa-chevron-right"></i>
                        <span>@yield('breadcrumb', 'Dashboard')</span>
                    </div>
                </div>
            </div>
            <div class="header-right">
                <button class="search-btn" id="searchBtn">
                    <i class="fas fa-search"></i>
                </button>
                <button class="fullscreen-btn" id="fullscreenBtn">
                    <i class="fas fa-expand"></i>
                </button>
                <button class="theme-toggle" id="themeToggle">
                    <i class="fas fa-moon"></i>
                </button>
                <div class="notification-wrapper" style="position: relative;">
                    <button class="notification-btn" id="notificationBtn">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">3</span>
                    </button>
                    <div class="dropdown-menu-custom" id="notificationDropdown">
                        <div style="padding: 16px; border-bottom: 1px solid #e2e8f0;">
                            <h6 class="mb-0">Notifications</h6>
                        </div>
                        <div style="padding: 12px 16px; border-bottom: 1px solid #e2e8f0;">
                            <small class="text-muted">2 minutes ago</small>
                            <p class="mb-0">New user registered</p>
                        </div>
                        <div style="padding: 12px 16px; border-bottom: 1px solid #e2e8f0;">
                            <small class="text-muted">1 hour ago</small>
                            <p class="mb-0">Payment received #INV-001</p>
                        </div>
                        <div style="padding: 12px 16px;">
                            <small class="text-muted">3 hours ago</small>
                            <p class="mb-0">Product stock low</p>
                        </div>
                    </div>
                </div>
                <div class="user-dropdown" id="userDropdown">
                    <div class="user-info">
                        <p class="user-name">{{ Auth::user()->name ?? 'Admin' }}</p>
                        <p class="user-role">{{ Auth::user()->level == 'admin' ? 'Administrator' : 'Petugas' }}</p>
                    </div>
                    <div class="user-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                </div>
            </div>
        </header>

        <!-- User Dropdown Menu -->
        <div class="dropdown-menu-custom" id="userDropdownMenu" style="right: 32px; top: 70px; min-width: 200px;">
            <a href="javascript:void(0);" class="nav-link-custom" style="color: var(--text-dark); padding: 10px 16px;">
                <i class="fas fa-user"></i> Profile
            </a>
            <a href="javascript:void(0);" class="nav-link-custom" style="color: var(--text-dark); padding: 10px 16px;">
                <i class="fas fa-cog"></i> Settings
            </a>
            <hr style="margin: 8px 0;">
            <a href="{{ route('logout') }}" class="nav-link-custom" style="color: #ef4444; padding: 10px 16px;"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>

        <!-- Page Content -->
        <main class="page-content">
            @if(session('success'))
                <div class="alert alert-modern alert-success" style="background: #d1fae5; color: #065f46;">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-modern alert-danger" style="background: #fee2e2; color: #991b1b;">
                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                </div>
            @endif

            @yield('content-dashboard')
        </main>

        <!-- Footer -->
        <footer class="footer-custom">
            <p>Copyright © <script>document.write(new Date().getFullYear());</script> MediCareRent. All rights reserved.</p>
            <div class="footer-links">
                <a href="javascript:void(0);">Help</a>
                <a href="javascript:void(0);">Terms</a>
                <a href="javascript:void(0);">Privacy</a>
            </div>
        </footer>
    </div>

    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="loading-overlay" style="display: none;">
        <div class="spinner-modern"></div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Toggle Dropdown for sidebar navigation
        function toggleDropdown(element) {
            const parent = element.closest('.nav-dropdown');
            if (parent) {
                parent.classList.toggle('open');
            }
        }

        // Mobile sidebar toggle
        const mobileToggle = document.getElementById('mobileToggle');
        const sidebar = document.getElementById('sidebar');

        if (mobileToggle) {
            mobileToggle.addEventListener('click', function() {
                sidebar.classList.toggle('mobile-open');
            });
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            if (window.innerWidth <= 1024) {
                if (!sidebar.contains(event.target) && !mobileToggle.contains(event.target)) {
                    sidebar.classList.remove('mobile-open');
                }
            }
        });

        // User dropdown toggle
        const userDropdown = document.getElementById('userDropdown');
        const userDropdownMenu = document.getElementById('userDropdownMenu');

        if (userDropdown) {
            userDropdown.addEventListener('click', function(e) {
                e.stopPropagation();
                userDropdownMenu.classList.toggle('show');
            });
        }

        // Notification dropdown
        const notificationBtn = document.getElementById('notificationBtn');
        const notificationDropdown = document.getElementById('notificationDropdown');

        if (notificationBtn) {
            notificationBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                notificationDropdown.classList.toggle('show');
            });
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function() {
            if (userDropdownMenu) userDropdownMenu.classList.remove('show');
            if (notificationDropdown) notificationDropdown.classList.remove('show');
        });

        // Fullscreen functionality
        const fullscreenBtn = document.getElementById('fullscreenBtn');

        if (fullscreenBtn) {
            fullscreenBtn.addEventListener('click', function() {
                if (!document.fullscreenElement) {
                    document.documentElement.requestFullscreen();
                    fullscreenBtn.innerHTML = '<i class="fas fa-compress"></i>';
                } else {
                    document.exitFullscreen();
                    fullscreenBtn.innerHTML = '<i class="fas fa-expand"></i>';
                }
            });

            document.addEventListener('fullscreenchange', function() {
                if (document.fullscreenElement) {
                    fullscreenBtn.innerHTML = '<i class="fas fa-compress"></i>';
                } else {
                    fullscreenBtn.innerHTML = '<i class="fas fa-expand"></i>';
                }
            });
        }

        // Theme toggle (Dark/Light)
        const themeToggle = document.getElementById('themeToggle');
        let isDark = localStorage.getItem('theme') === 'dark';

        function setTheme(dark) {
            if (dark) {
                document.documentElement.style.setProperty('--gray-bg', '#0f172a');
                document.documentElement.style.setProperty('--white', '#1e293b');
                document.documentElement.style.setProperty('--text-dark', '#f1f5f9');
                document.documentElement.style.setProperty('--text-muted', '#94a3b8');
                themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
                localStorage.setItem('theme', 'dark');
            } else {
                document.documentElement.style.setProperty('--gray-bg', '#f5f7fa');
                document.documentElement.style.setProperty('--white', '#ffffff');
                document.documentElement.style.setProperty('--text-dark', '#1e293b');
                document.documentElement.style.setProperty('--text-muted', '#64748b');
                themeToggle.innerHTML = '<i class="fas fa-moon"></i>';
                localStorage.setItem('theme', 'light');
            }
        }

        if (themeToggle) {
            setTheme(isDark);
            themeToggle.addEventListener('click', function() {
                isDark = !isDark;
                setTheme(isDark);
            });
        }

        // Show/Hide Loading
        function showLoading() {
            document.getElementById('loadingOverlay').style.display = 'flex';
        }

        function hideLoading() {
            document.getElementById('loadingOverlay').style.display = 'none';
        }

        // Auto hide alerts after 5 seconds
        setTimeout(function() {
            document.querySelectorAll('.alert-modern').forEach(function(alert) {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.remove();
                }, 500);
            });
        }, 5000);
    </script>

    @stack('scripts')
</body>

</html>
