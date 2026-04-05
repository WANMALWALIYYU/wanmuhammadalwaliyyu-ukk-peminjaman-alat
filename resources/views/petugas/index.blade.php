<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MedikCareRent - Dashboard Petugas</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@next/dist/aos.css" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

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

        /* Sidebar Modern - SAME GRADIENT AS DASHBOARD HEADER */
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(145deg, #0b2c5d 0%, #1f3c88 100%);
            box-shadow: 4px 0 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            position: relative;
            z-index: 1000;
        }

        /* Animated gradient overlay for sidebar */
        .sidebar::before {
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

        .sidebar::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 1px;
            height: 100%;
            background: linear-gradient(180deg, transparent, rgba(255,255,255,0.2), transparent);
        }

        .sidebar .nav-link {
            color: rgba(255,255,255,0.85);
            padding: 12px 24px;
            margin: 6px 16px;
            border-radius: 14px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 500;
            position: relative;
            z-index: 1;
            overflow: hidden;
        }

        .sidebar .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
            transition: left 0.5s ease;
        }

        .sidebar .nav-link:hover::before {
            left: 100%;
        }

        .sidebar .nav-link:hover {
            background: rgba(255,255,255,0.12);
            color: white;
            transform: translateX(6px);
        }

        .sidebar .nav-link.active {
            background: linear-gradient(135deg, rgba(255,255,255,0.2), rgba(255,255,255,0.1));
            color: white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-left: 3px solid #10b981;
        }

        .sidebar .nav-link i {
            margin-right: 12px;
            width: 24px;
            font-size: 1.1rem;
        }

        /* Logo Section */
        .sidebar-logo {
            padding: 1.5rem;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            position: relative;
            z-index: 1;
        }

        .sidebar-logo img {
            margin-bottom: 0.5rem;
        }

        .sidebar-logo h5 {
            color: white;
            margin-bottom: 0;
            font-weight: 700;
        }

        .sidebar-logo small {
            color: rgba(255,255,255,0.7);
            font-size: 0.7rem;
        }

        /* Main Content */
        .main-content {
            padding: 24px 32px;
            min-height: 100vh;
        }

        /* Navbar Top */
        .navbar-top {
            background: white;
            border-radius: 24px;
            padding: 16px 28px;
            margin-bottom: 28px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(27,76,140,0.08);
        }

        /* Cards Modern */
        .card-stats {
            border: none;
            border-radius: 24px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            position: relative;
        }

        .card-stats::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
        }

        .card-stats:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 28px rgba(0,0,0,0.12);
        }

        .card-stats .card-body {
            padding: 1.5rem;
        }

        /* Badge Status */
        .badge-status {
            padding: 6px 14px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.3px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        /* Table Modern */
        .table-modern {
            border-radius: 20px;
            overflow: hidden;
        }

        .table-modern thead th {
            background: linear-gradient(135deg, #f8fafd 0%, #f1f5f9 100%);
            border-bottom: 2px solid #e2e8f0;
            padding: 16px 12px;
            font-weight: 600;
            color: #1e293b;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table-modern tbody tr {
            transition: all 0.2s ease;
            border-bottom: 1px solid #eef2f6;
        }

        .table-modern tbody tr:hover {
            background: linear-gradient(90deg, #f8fafc, #ffffff);
            transform: scale(1.01);
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .table-modern tbody td {
            padding: 16px 12px;
            vertical-align: middle;
        }

        /* Button Modern */
        .btn-modern {
            border-radius: 12px;
            padding: 8px 16px;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.2s ease;
            border: none;
        }

        .btn-modern:hover {
            transform: translateY(-2px);
        }

        /* Filter Card */
        .filter-card {
            border: none;
            border-radius: 20px;
            background: white;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            margin-bottom: 28px;
            overflow: hidden;
        }

        .filter-card .card-body {
            padding: 1.5rem;
        }

        /* Loading Spinner */
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
            border: 4px solid rgba(27,76,140,0.2);
            border-top: 4px solid #1B4C8C;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Alert Modern */
        .alert-modern {
            border-radius: 16px;
            border: none;
            padding: 16px 20px;
            margin-bottom: 24px;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Scrollbar Styling */
        .sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.3);
            border-radius: 4px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255,255,255,0.5);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                min-height: auto;
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                z-index: 1000;
                transform: translateY(calc(100% - 60px));
                transition: transform 0.3s ease;
            }

            .sidebar.show {
                transform: translateY(0);
            }

            .main-content {
                padding: 16px;
                margin-bottom: 70px;
            }

            .navbar-top {
                padding: 12px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- Sidebar -->
            <div class="col-auto px-0 sidebar" id="sidebar">
                <div class="sidebar-logo">
                    <img src="{{ asset('assets/image/logo-mcr.png') }}" alt="Logo" height="55" class="mb-2">
                    <h5 class="text-white mb-0 fw-bold">MedikCareRent</h5>
                    <small class="text-white-50">Petugas Panel</small>
                </div>
                <nav class="nav flex-column mt-3">
                    <a class="nav-link {{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}"
                    href="{{ route('petugas.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <a class="nav-link {{ request()->routeIs('petugas.peminjaman*') ? 'active' : '' }}"
                    href="{{ route('petugas.peminjaman') }}">
                        <i class="fas fa-hand-holding"></i> Peminjaman
                    </a>
                    <a class="nav-link {{ request()->routeIs('petugas.pengembalian*') ? 'active' : '' }}"
                    href="{{ route('petugas.pengembalian.index') }}">
                        <i class="fas fa-hand-holding"></i> Pengembalian
                    </a>
                    <a class="nav-link {{ request()->routeIs('petugas.pengiriman*') ? 'active' : '' }}"
                    href="{{ route('petugas.pengiriman.index') }}">
                        <i class="fas fa-truck"></i> Pengiriman
                    </a>
                    <a class="nav-link {{ request()->routeIs('petugas.pengiriman.in-progress') ? 'active' : '' }}"
                    href="{{ route('petugas.pengiriman.in-progress') }}">
                        <i class="fas fa-truck-moving"></i> Dalam Proses
                    </a>
                    <hr class="mx-3 my-2" style="border-color: rgba(255,255,255,0.1);">
                    <a class="nav-link" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col">
                <!-- Top Navbar -->
                <div class="navbar-top d-flex justify-content-between align-items-center">
                    <div>
                        <button class="btn btn-link d-md-none p-0 me-3" id="sidebarToggle">
                            <i class="fas fa-bars fa-lg text-primary"></i>
                        </button>
                        <h5 class="mb-0 d-inline-block">@yield('title')</h5>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="dropdown">
                            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-2">
                                    <i class="fas fa-user-circle fa-2x text-primary"></i>
                                </div>
                                <div class="text-start">
                                    <strong class="d-block text-dark">{{ Auth::user()->name }}</strong>
                                    <small class="text-muted">{{ Auth::user()->level == 'admin' ? 'Administrator' : 'Petugas' }}</small>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="main-content">
                    @if(session('success'))
                        <div class="alert alert-modern alert-success" role="alert">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close float-end" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-modern alert-danger" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                            <button type="button" class="btn-close float-end" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="loading-overlay" style="display: none;">
        <div class="spinner-modern"></div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>

    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true,
            offset: 50
        });

        // Sidebar Toggle for Mobile
        $('#sidebarToggle').click(function() {
            $('#sidebar').toggleClass('show');
        });

        // Auto close alerts after 5 seconds
        setTimeout(function() {
            $('.alert-modern').fadeOut('slow');
        }, 5000);

        // Show loading
        function showLoading() {
            $('#loadingOverlay').fadeIn(200);
        }

        function hideLoading() {
            $('#loadingOverlay').fadeOut(200);
        }
    </script>

    @stack('scripts')
</body>
</html>
