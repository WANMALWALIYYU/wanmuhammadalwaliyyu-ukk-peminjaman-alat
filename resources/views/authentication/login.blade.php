<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/image/logo-mcr.png') }}" />
    <title>MedikCareRent - Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap");

        :root {
            --primary: #1B4C8C;
            --primary-dark: #0f3a6b;
            --primary-light: #2d6eb0;
            --primary-soft: #e1ebfa;
            --secondary: #2ECC71;
            --secondary-dark: #27ae60;
            --secondary-light: #a3e4b7;
            --accent: #9b59b6;
            --background: #ffffff;
            --background-sec: #d7d8da;
            --light-bg: #f5f7fa;
            --gray-light: #f0f2f5;
            --text-color: #1d1d1f;
            --text-color-sec: #424245;
            --text-muted: #86868b;
            --gray: #86868b;
            --gray-dark: #424245;
            --light: #ffffff;
            --shadow-sm: 0 2px 8px rgba(27, 76, 140, 0.08);
            --shadow-md: 0 6px 20px rgba(27, 76, 140, 0.12);
            --shadow-lg: 0 12px 40px rgba(27, 76, 140, 0.18);
            --transition: all 0.3s ease;
            --transition-slow: all 0.5s ease;
            --error-color: #e74c3c;
            --success-color: #2ecc71;
            --warning-color: #f39c12;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        /* Background Modern dengan Efek Gradien dan Animasi */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            z-index: -2;
        }

        body::after {
            content: '';
            position: fixed;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: rotate 30s linear infinite;
            z-index: -1;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Floating Orbs */
        .orb {
            position: fixed;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(5px);
            animation: float 15s infinite ease-in-out;
            z-index: -1;
        }

        .orb-1 {
            width: 300px;
            height: 300px;
            top: -100px;
            left: -100px;
            background: linear-gradient(135deg, rgba(46, 204, 113, 0.2), rgba(52, 152, 219, 0.2));
            animation-delay: 0s;
        }

        .orb-2 {
            width: 400px;
            height: 400px;
            bottom: -150px;
            right: -150px;
            background: linear-gradient(135deg, rgba(155, 89, 182, 0.2), rgba(52, 152, 219, 0.2));
            animation-delay: 2s;
        }

        .orb-3 {
            width: 200px;
            height: 200px;
            top: 50%;
            left: 20%;
            background: linear-gradient(135deg, rgba(241, 196, 15, 0.2), rgba(230, 126, 34, 0.2));
            animation-delay: 4s;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0) scale(1);
            }
            50% {
                transform: translateY(-50px) scale(1.1);
            }
        }

        .login-container {
            display: flex;
            width: 100%;
            max-width: 1200px;
            min-height: 700px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 40px;
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            transition: var(--transition-slow);
            border: 1px solid rgba(255, 255, 255, 0.5);
            position: relative;
        }

        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
            pointer-events: none;
            z-index: 1;
        }

        .login-left {
            flex: 1;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        .login-left::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
            z-index: 1;
        }

        .logo-icon {
            display: flex;
            flex-direction: column;
            justify-content: left;
            position: relative;
            margin-bottom: 40px;
            z-index: 2;
        }

        .logo-icon img {
            width: 300px;
            max-width: 100%;
            filter: brightness(0) invert(1);
            transition: var(--transition);
        }

        .logo-icon img:hover {
            transform: scale(1.05);
        }

        .welcome-section {
            position: relative;
            z-index: 2;
        }

        .welcome-section h2 {
            font-size: 42px;
            font-weight: 800;
            margin-bottom: 15px;
            line-height: 1.2;
            animation: fadeInUp 0.8s ease;
            text-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }

        .welcome-section p {
            font-size: 16px;
            opacity: 0.95;
            max-width: 400px;
            margin-bottom: 30px;
            animation: fadeInUp 0.8s ease 0.1s both;
            text-shadow: 0 1px 5px rgba(0,0,0,0.1);
        }

        .features {
            margin-top: 50px;
            position: relative;
            z-index: 2;
        }

        .feature-item {
            display: flex;
            margin-bottom: 25px;
            animation: fadeInUp 0.8s ease;
            animation-fill-mode: both;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 15px 20px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: var(--transition);
        }

        .feature-item:hover {
            transform: translateX(10px);
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .feature-item:nth-child(1) { animation-delay: 0.2s; }
        .feature-item:nth-child(2) { animation-delay: 0.3s; }
        .feature-item:nth-child(3) { animation-delay: 0.4s; }
        .feature-item:nth-child(4) { animation-delay: 0.5s; }

        .feature-icon {
            background: rgba(255, 255, 255, 0.25);
            width: 55px;
            height: 55px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 22px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .feature-text h4 {
            font-size: 17px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .feature-text p {
            font-size: 13px;
            opacity: 0.9;
            margin-bottom: 0;
        }

        .medical-icons {
            position: absolute;
            bottom: 30px;
            right: 30px;
            z-index: 2;
            display: flex;
            gap: 15px;
            background: rgba(255, 255, 255, 0.15);
            padding: 15px 25px;
            border-radius: 50px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .medical-icons i {
            font-size: 24px;
            animation: pulse 2s infinite;
            opacity: 0.9;
        }

        .medical-icons i:nth-child(2) { animation-delay: 0.5s; }
        .medical-icons i:nth-child(3) { animation-delay: 1s; }
        .medical-icons i:nth-child(4) { animation-delay: 1.5s; }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.9; }
            50% { transform: scale(1.2); opacity: 1; }
        }

        .login-right {
            flex: 1;
            padding: 70px 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            animation: fadeInRight 0.8s ease;
            position: relative;
            z-index: 2;
        }

        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .login-header h2 {
            font-size: 38px;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 10px;
        }

        .login-header p {
            color: var(--text-muted);
            font-size: 16px;
        }

        .login-form {
            width: 100%;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-group label {
            display: block;
            font-weight: 500;
            margin-bottom: 8px;
            color: var(--text-color-sec);
        }

        .input-with-icon {
            position: relative;
        }

        .input-with-icon i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
            font-size: 18px;
            transition: var(--transition);
            z-index: 1;
        }

        .form-control {
            width: 100%;
            padding: 16px 20px 16px 50px;
            border: 2px solid rgba(27, 76, 140, 0.1);
            border-radius: 16px;
            font-size: 15px;
            font-family: 'Poppins', sans-serif;
            background: white;
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(27, 76, 140, 0.1);
        }

        .form-control.error {
            border-color: var(--error-color);
            background-color: rgba(231, 76, 60, 0.05);
        }

        .password-toggle {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--gray);
            cursor: pointer;
            font-size: 18px;
            z-index: 1;
        }

        .error-message {
            color: var(--error-color);
            font-size: 13px;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .server-error {
            background-color: rgba(231, 76, 60, 0.1);
            color: var(--error-color);
            padding: 12px 15px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-left: 4px solid var(--error-color);
        }

        .alert {
            padding: 15px 20px;
            border-radius: 16px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            animation: slideIn 0.5s ease;
            border: none;
            box-shadow: var(--shadow-md);
        }

        .alert-success {
            background: linear-gradient(135deg, var(--secondary) 0%, var(--secondary-dark) 100%);
            color: white;
        }

        .alert-warning {
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
            color: white;
        }

        .alert-error {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
        }

        .alert i {
            font-size: 20px;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .remember-me input {
            width: 18px;
            height: 18px;
            accent-color: var(--primary);
            cursor: pointer;
        }

        .remember-me label {
            margin-bottom: 0;
            cursor: pointer;
            color: var(--text-color-sec);
        }

        .forgot-password {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
        }

        .forgot-password:hover {
            color: var(--primary-light);
            text-decoration: underline;
        }

        .login-btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white;
            border: none;
            border-radius: 16px;
            font-size: 18px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            transition: var(--transition);
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: var(--shadow-md);
            position: relative;
            overflow: hidden;
        }

        .login-btn::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.3) 0%, transparent 70%);
            transform: rotate(45deg);
            transition: var(--transition);
            opacity: 0;
        }

        .login-btn:hover::before {
            opacity: 1;
            animation: shine 1.5s infinite;
        }

        .login-btn:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .login-btn i {
            font-size: 18px;
        }

        @keyframes shine {
            0% { transform: translateX(-100%) rotate(45deg); }
            100% { transform: translateX(100%) rotate(45deg); }
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 25px 0;
            color: var(--text-muted);
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--primary-soft), transparent);
        }

        .divider span {
            padding: 0 15px;
            font-size: 14px;
        }

        .social-login {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 30px;
        }

        .social-btn {
            width: 60px;
            height: 60px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            border: 2px solid rgba(27, 76, 140, 0.1);
            color: var(--primary);
            font-size: 24px;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
        }

        .social-btn:hover {
            transform: translateY(-5px);
            border-color: var(--primary);
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white;
            box-shadow: var(--shadow-lg);
        }

        .signup-link {
            text-align: center;
            color: var(--text-muted);
            font-size: 15px;
        }

        .signup-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
        }

        .signup-link a:hover {
            color: var(--primary-light);
            text-decoration: underline;
        }

        .footer-note {
            margin-top: 30px;
            text-align: center;
            font-size: 13px;
            color: var(--text-muted);
            border-top: 1px solid rgba(27, 76, 140, 0.1);
            padding-top: 20px;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .login-container {
                flex-direction: column;
                max-width: 600px;
                min-height: auto;
            }

            .login-left {
                padding: 40px 30px;
            }

            .medical-icons {
                display: none;
            }

            .welcome-section h2 {
                font-size: 36px;
            }

            .orb-1, .orb-2, .orb-3 {
                display: none;
            }
        }

        @media (max-width: 576px) {
            body {
                padding: 10px;
            }

            .login-container {
                border-radius: 30px;
            }

            .login-left,
            .login-right {
                padding: 30px 20px;
            }

            .welcome-section h2 {
                font-size: 30px;
            }

            .login-header h2 {
                font-size: 30px;
            }

            .form-options {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .feature-item {
                flex-direction: row;
                text-align: left;
            }
        }
    </style>
</head>
<body>
    <!-- Floating Orbs untuk Efek Background -->
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    <div class="login-container">
        <!-- Left Side: Branding & Info -->
        <div class="login-left">
            <div class="logo-icon">
                <img src="{{ asset('assets/image/logo-name-mcr.png') }}" class="img-fluid" alt="logo-name-mcr">
            </div>

            <div class="welcome-section">
                <h2>Selamat Datang Kembali</h2>
                <p>Masuk ke akun Anda untuk mengakses sistem rental alat kesehatan terbaik dengan pengalaman yang aman dan terpercaya.</p>

                <div class="features">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="feature-text">
                            <h4>Keamanan Terjamin</h4>
                            <p>Data Anda dilindungi dengan enkripsi tingkat tinggi</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <div class="feature-text">
                            <h4>Berpengalaman & Terpercaya</h4>
                            <p>Berpengalaman melayani penyewaan alat kesehatan</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <div class="feature-text">
                            <h4>Pengiriman Cepat</h4>
                            <p>Pesanan Anda dikirim tepat waktu ke lokasi</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <div class="feature-text">
                            <h4>Layanan Responsif</h4>
                            <p>Tim kami siap membantu kapan saja</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="medical-icons">
                <i class="fas fa-heartbeat"></i>
                <i class="fas fa-prescription-bottle-alt"></i>
                <i class="fas fa-procedures"></i>
                <i class="fas fa-ambulance"></i>
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="login-right">
            <div class="login-header">
                <h2>Masuk ke Akun</h2>
                <p>Masukkan kredensial Anda untuk mengakses dashboard</p>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('warning'))
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    {{ session('warning') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('login-store') }}" class="login-form" id="loginForm" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-with-icon">
                        <i class="fas fa-envelope"></i>
                        <input type="email"
                               id="email"
                               name="email"
                               class="form-control @error('email') error @enderror"
                               placeholder="email@contoh.com"
                               value="{{ old('email') }}"
                               required>
                    </div>
                    @error('email')
                        <div class="error-message">
                            <i class="fas fa-times-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Kata Sandi</label>
                    <div class="input-with-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password"
                               id="password"
                               name="password"
                               class="form-control @error('password') error @enderror"
                               placeholder="Masukkan kata sandi"
                               required>
                        <button type="button" class="password-toggle" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="error-message">
                            <i class="fas fa-times-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-options">
                    <div class="remember-me">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Ingat saya</label>
                    </div>
                    <a href="#" class="forgot-password" id="forgotPassword">Lupa kata sandi?</a>
                </div>

                <button type="submit" class="login-btn" id="loginBtn">
                    <i class="fas fa-sign-in-alt"></i>
                    Masuk ke Akun
                </button>

                <div class="divider">
                    <span>Atau masuk dengan</span>
                </div>

                <div class="social-login">
                    <button type="button" class="social-btn" onclick="handleSocialLogin('google')">
                        <i class="fab fa-google"></i>
                    </button>
                    <button type="button" class="social-btn" onclick="handleSocialLogin('facebook')">
                        <i class="fab fa-facebook-f"></i>
                    </button>
                    <button type="button" class="social-btn" onclick="handleSocialLogin('apple')">
                        <i class="fab fa-apple"></i>
                    </button>
                </div>

                <div class="signup-link">
                    Belum punya akun? <a href="{{ route('registrasi') }}">Daftar sekarang</a>
                </div>
            </form>

            <div class="footer-note">
                &copy; 2025 MedikCareRent. Semua hak dilindungi.
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    alert.style.transition = 'opacity 0.5s ease';
                    setTimeout(() => {
                        alert.style.display = 'none';
                    }, 500);
                }, 5000);
            });
        });

        // Social login handler
        function handleSocialLogin(platform) {
            alert(`Login dengan ${platform.charAt(0).toUpperCase() + platform.slice(1)} akan segera tersedia!`);
        }

        // Forgot password handler
        document.getElementById('forgotPassword').addEventListener('click', function(e) {
            e.preventDefault();
            const email = prompt('Masukkan email Anda untuk mereset kata sandi:');
            if (email && email.includes('@')) {
                alert(`Instruksi reset kata sandi telah dikirim ke ${email}`);
            } else if (email) {
                alert('Format email tidak valid!');
            }
        });

        // Prevent double submit
        document.getElementById('loginForm').addEventListener('submit', function() {
            const submitBtn = document.getElementById('loginBtn');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
        });

        // Highlight field with error
        @if($errors->has('email'))
            document.getElementById('email').focus();
        @elseif($errors->has('password'))
            document.getElementById('password').focus();
        @endif

        // Efek hover pada container
        const container = document.querySelector('.login-container');
        container.addEventListener('mousemove', (e) => {
            const x = e.clientX / window.innerWidth;
            const y = e.clientY / window.innerHeight;
            container.style.transform = `perspective(1000px) rotateY(${x * 2}deg) rotateX(${y * -2}deg)`;
        });

        container.addEventListener('mouseleave', () => {
            container.style.transform = 'perspective(1000px) rotateY(0deg) rotateX(0deg)';
        });
    </script>
</body>
</html>
