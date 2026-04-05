<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/image/logo-mcr.png') }}" />
    <title>MedikCareRent - Registrasi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");

        /* ===============================
           VARIABLES & RESET
           =============================== */
        :root {
            /* ===== PRIMARY (Medical Blue) ===== */
            --primary: #1B4C8C;
            --primary-dark: #0f3a6b;
            --primary-light: #2d6eb0;
            --primary-soft: #e1ebfa;
            --secondary: #2ECC71;
            --secondary-dark: #27ae60;
            --secondary-light: #a3e4b7;

            /* ===== BACKGROUND ===== */
            --background: #ffffff;
            --background-sec: #d7d8da;
            --light-bg: #f5f7fa;
            --gray-light: #f0f2f5;

            /* ===== TEXT ===== */
            --text-color: #1d1d1f;
            --text-color-sec: #424245;
            --text-muted: #86868b;
            --text-hover: #4da8da;

            /* ===== NEUTRAL COLORS ===== */
            --gray: #86868b;
            --gray-dark: #424245;
            --light: #ffffff;

            /* ===== GRADIENT ===== */
            --gradient-primary: linear-gradient(135deg, #1B4C8C 0%, #2d6eb0 100%);
            --gradient-primary-sec: linear-gradient(135deg, #1B4C8C 0%, #0f3a6b 100%);
            --gradient-soft: linear-gradient(135deg, #e8f1ff 0%, #ffffff 100%);

            /* ===== SHADOW ===== */
            --shadow-sm: 0 2px 8px rgba(27, 76, 140, 0.08);
            --shadow-md: 0 6px 20px rgba(27, 76, 140, 0.12);
            --shadow-lg: 0 12px 40px rgba(27, 76, 140, 0.18);

            /* ===== TRANSITION ===== */
            --transition: all 0.3s ease;
            --transition-slow: all 0.5s ease;

            /* ===== VALIDATION COLORS ===== */
            --validation-error: #e74c3c;
            --validation-success: #2ecc71;
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

        .register-container {
            display: flex;
            width: 100%;
            max-width: 1200px;
            min-height: 750px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 40px;
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            transition: var(--transition-slow);
            border: 1px solid rgba(255, 255, 255, 0.5);
            position: relative;
        }

        .register-container::before {
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

        .register-left {
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

        .register-left::before {
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
            margin-top: 40px;
            position: relative;
            z-index: 2;
        }

        .feature-item {
            display: flex;
            margin-bottom: 20px;
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

        .register-right {
            flex: 1;
            padding: 50px 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            animation: fadeInRight 0.8s ease;
            position: relative;
            z-index: 2;
            overflow-y: auto;
        }

        .register-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .register-header h2 {
            font-size: 38px;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 10px;
        }

        .register-header p {
            color: var(--text-muted);
            font-size: 16px;
        }

        .register-form {
            width: 100%;
        }

        .form-row {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .form-row .form-group {
            flex: 1;
            margin-bottom: 0;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group label {
            display: block;
            font-weight: 500;
            margin-bottom: 8px;
            color: var(--text-color-sec);
        }

        .form-group label .required {
            color: var(--validation-error);
            margin-left: 3px;
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
            padding: 14px 20px 14px 50px;
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
            border-color: var(--validation-error);
            background-color: rgba(231, 76, 60, 0.05);
        }

        .form-control.success {
            border-color: var(--validation-success);
            background-color: rgba(46, 204, 113, 0.05);
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

        select.form-control {
            appearance: none;
            padding-right: 50px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%2386868b' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 18px center;
            background-size: 16px;
            cursor: pointer;
        }

        textarea.form-control {
            min-height: 100px;
            resize: vertical;
            padding-top: 12px;
        }

        .error-message {
            color: var(--validation-error);
            font-size: 13px;
            margin-top: 5px;
            display: none;
            align-items: center;
            gap: 5px;
        }

        .server-error {
            color: var(--validation-error);
            font-size: 13px;
            margin-top: 5px;
            display: block;
        }

        /* Password Strength */
        .password-wrapper {
            width: 100%;
        }

        .password-strength-container {
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .password-strength {
            flex: 1;
            min-width: 150px;
            height: 6px;
            border-radius: 10px;
            background-color: rgba(27, 76, 140, 0.1);
            overflow: hidden;
        }

        .strength-meter {
            height: 100%;
            width: 0;
            transition: width 0.3s ease, background-color 0.3s ease;
            border-radius: 10px;
        }

        .strength-label {
            display: flex;
            align-items: center;
            font-size: 13px;
            font-weight: 500;
            padding: 4px 12px;
            background: rgba(27, 76, 140, 0.05);
            border-radius: 20px;
            white-space: nowrap;
        }

        .strength-text {
            color: var(--text-muted);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }

        .strength-icon {
            margin-right: 6px;
            font-size: 12px;
        }

        /* Warna untuk strength meter */
        .strength-weak {
            background: linear-gradient(90deg, #e74c3c, #c0392b);
        }

        .strength-medium {
            background: linear-gradient(90deg, #f39c12, #e67e22);
        }

        .strength-strong {
            background: linear-gradient(90deg, #2ecc71, #27ae60);
        }

        .strength-very-strong {
            background: linear-gradient(90deg, #27ae60, #2ecc71, var(--primary));
        }

        /* Warna untuk label */
        .strength-weak-label {
            color: #e74c3c;
            background: rgba(231, 76, 60, 0.1);
        }

        .strength-medium-label {
            color: #f39c12;
            background: rgba(243, 156, 18, 0.1);
        }

        .strength-strong-label {
            color: #2ecc71;
            background: rgba(46, 204, 113, 0.1);
        }

        .strength-very-strong-label {
            color: var(--primary);
            background: rgba(27, 76, 140, 0.1);
        }

        .form-options {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
        }

        .terms-agreement {
            display: flex;
            align-items: flex-start;
        }

        .terms-agreement input {
            margin-right: 10px;
            margin-top: 3px;
            accent-color: var(--primary);
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .terms-agreement label {
            font-size: 14px;
            color: var(--text-color-sec);
            cursor: pointer;
        }

        .terms-agreement a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
        }

        .terms-agreement a:hover {
            color: var(--primary-light);
            text-decoration: underline;
        }

        .register-btn {
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

        .register-btn::before {
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

        .register-btn:hover::before {
            opacity: 1;
            animation: shine 1.5s infinite;
        }

        .register-btn:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }

        .register-btn:active {
            transform: translateY(0);
        }

        .register-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        @keyframes shine {
            0% { transform: translateX(-100%) rotate(45deg); }
            100% { transform: translateX(100%) rotate(45deg); }
        }

        .login-link {
            text-align: center;
            color: var(--text-muted);
            font-size: 15px;
            margin-top: 15px;
        }

        .login-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
        }

        .login-link a:hover {
            color: var(--primary-light);
            text-decoration: underline;
        }

        .footer-note {
            margin-top: 20px;
            text-align: center;
            font-size: 13px;
            color: var(--text-muted);
            border-top: 1px solid rgba(27, 76, 140, 0.1);
            padding-top: 15px;
        }

        /* Alert messages */
        .alert-container {
            margin-bottom: 20px;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 16px;
            font-size: 14px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideIn 0.5s ease;
            border: none;
            box-shadow: var(--shadow-md);
        }

        .alert-success {
            background: linear-gradient(135deg, var(--secondary) 0%, var(--secondary-dark) 100%);
            color: white;
        }

        .alert-error {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
        }

        .alert i {
            font-size: 20px;
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
            .register-container {
                flex-direction: column;
                max-width: 700px;
                min-height: auto;
            }

            .register-left {
                padding: 40px 30px;
            }

            .register-right {
                padding: 40px;
                max-height: none;
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

        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
                gap: 20px;
            }
        }

        @media (max-width: 576px) {
            body {
                padding: 10px;
            }

            .register-container {
                border-radius: 30px;
            }

            .register-left,
            .register-right {
                padding: 30px 20px;
            }

            .welcome-section h2 {
                font-size: 30px;
            }

            .register-header h2 {
                font-size: 30px;
            }

            .feature-item {
                flex-direction: row;
                text-align: left;
            }

            .form-control {
                padding: 12px 15px 12px 45px;
            }

            .password-strength-container {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            .password-strength {
                width: 100%;
            }

            .strength-label {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <!-- Floating Orbs untuk Efek Background -->
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    @if(session('verification_sent'))
        <div class="alert-container" style="position: fixed; top: 20px; right: 20px; z-index: 9999; max-width: 400px;">
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('verification_sent') }}
            </div>
        </div>
    @endif

    <div class="register-container">
        <!-- Left Side: Branding & Info -->
        <div class="register-left">
            <div class="logo-icon">
                <img src="{{ asset('assets/image/logo-name-mcr.png') }}" class="img-fluid" alt="logo-name-mcr">
            </div>

            <div class="welcome-section">
                <h2>Bergabung dengan Kami</h2>
                <p>Buat akun untuk mengakses sistem rental alat kesehatan terbaik dengan pengalaman yang aman dan terpercaya.</p>

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
                            <p>Berpengalaman melayani penyewaan alat kesehatan untuk Rumah Sakit, Klinik, dan perawatan Home Care</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <div class="feature-text">
                            <h4>Proses Cepat</h4>
                            <p>Registrasi hanya membutuhkan beberapa menit</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <div class="feature-text">
                            <h4>Dukungan 24/7</h4>
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

        <!-- Right Side: Registration Form -->
        <div class="register-right">
            <div class="register-header">
                <h2>Buat Akun Baru</h2>
                <p>Isi data diri Anda untuk memulai penggunaan layanan</p>
            </div>

            <!-- Display success/error messages -->
            @if(session('success'))
                <div class="alert-container">
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="alert-container">
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <div>
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('registrasi-store') }}" method="POST" class="register-form" id="registerForm">
                @csrf

                <div class="form-row">
                    <div class="form-group">
                        <label for="nama">Nama Lengkap <span class="required">*</span></label>
                        <div class="input-with-icon">
                            <i class="fas fa-user"></i>
                            <input type="text" id="nama" name="nama" class="form-control @error('nama') error @enderror"
                                   value="{{ old('nama') }}" placeholder="Masukkan nama lengkap" required>
                        </div>
                        <div class="error-message" id="nama-error">
                            <i class="fas fa-times-circle"></i>
                            Nama lengkap harus diisi
                        </div>
                        @error('nama')
                            <div class="server-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Email <span class="required">*</span></label>
                        <div class="input-with-icon">
                            <i class="fas fa-envelope"></i>
                            <input type="email" id="email" name="email" class="form-control @error('email') error @enderror"
                                   value="{{ old('email') }}" placeholder="email@contoh.com" required>
                        </div>
                        <div class="error-message" id="email-error">
                            <i class="fas fa-times-circle"></i>
                            Email tidak valid
                        </div>
                        @error('email')
                            <div class="server-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="password">Kata Sandi <span class="required">*</span></label>
                        <div class="input-with-icon">
                            <i class="fas fa-lock"></i>
                            <input type="password" id="password" name="password"
                                class="form-control @error('password') error @enderror"
                                placeholder="Minimal 5 karakter" required>
                            <button type="button" class="password-toggle" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>

                        <!-- strength Menampilkan kekuatan password -->
                        <div class="password-wrapper">
                            <div class="password-strength-container">
                                <div class="password-strength">
                                    <div class="strength-meter" id="passwordStrength"></div>
                                </div>
                                <div class="strength-label" id="strengthLabel">
                                    <span class="strength-text" id="strengthText">
                                        <i class="fas fa-info-circle strength-icon"></i> Masukkan kata sandi
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="error-message" id="password-error">
                            <i class="fas fa-times-circle"></i>
                            Kata sandi minimal 5 karakter
                        </div>
                        @error('password')
                            <div class="server-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Sandi <span class="required">*</span></label>
                        <div class="input-with-icon">
                            <i class="fas fa-lock"></i>
                            <input type="password" id="confirmPassword" name="password_confirmation"
                                   class="form-control @error('password_confirmation') error @enderror"
                                   placeholder="Ulangi kata sandi" required>
                            <button type="button" class="password-toggle" id="toggleConfirmPassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="error-message" id="confirmPassword-error">
                            <i class="fas fa-times-circle"></i>
                            Kata sandi tidak cocok
                        </div>
                        @error('password_confirmation')
                            <div class="server-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-options">
                    <div class="terms-agreement">
                        <input type="checkbox" id="terms" name="terms" required
                               {{ old('terms') ? 'checked' : '' }}>
                        <label for="terms">
                            Saya menyetujui <a href="#">Syarat & Ketentuan</a> dan <a href="#">Kebijakan Privasi</a> <span class="required">*</span>
                        </label>
                    </div>
                </div>

                <button type="submit" class="register-btn" id="submitBtn">
                    <i class="fas fa-user-plus"></i>
                    Daftar Akun
                </button>

                <div class="login-link">
                    Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
                </div>
            </form>

            <div class="footer-note">
                &copy; 2025 MedikCareRent. Semua hak dilindungi.
            </div>
        </div>
    </div>

    <script>
    // ==================== DOM ELEMENTS ====================
    const registerForm = document.getElementById('registerForm');
    const submitBtn = document.getElementById('submitBtn');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirmPassword');
    const togglePasswordBtn = document.getElementById('togglePassword');
    const toggleConfirmPasswordBtn = document.getElementById('toggleConfirmPassword');
    const passwordStrength = document.getElementById('passwordStrength');
    const strengthText = document.getElementById('strengthText');

    // Error elements
    const errorElements = {
        nama: document.getElementById('nama-error'),
        email: document.getElementById('email-error'),
        password: document.getElementById('password-error'),
        confirmPassword: document.getElementById('confirmPassword-error'),
    };

    // ==================== PASSWORD TOGGLE ====================
    togglePasswordBtn.addEventListener('click', function() {
        togglePasswordVisibility(passwordInput, this);
    });

    toggleConfirmPasswordBtn.addEventListener('click', function() {
        togglePasswordVisibility(confirmPasswordInput, this);
    });

    function togglePasswordVisibility(inputElement, button) {
        const icon = button.querySelector('i');
        if (inputElement.type === 'password') {
            inputElement.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            inputElement.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    // ==================== PASSWORD STRENGTH WITH REALTIME FEEDBACK ====================
    function checkPasswordStrength(password) {
        let score = 0;
        let feedback = {
            text: '',
            icon: '',
            className: '',
            level: ''
        };

        // Empty password
        if (password.length === 0) {
            return {
                score: 0,
                feedback: {
                    text: 'Masukkan kata sandi',
                    icon: 'fa-info-circle',
                    className: '',
                    level: 'none'
                }
            };
        }

        // Length checks
        if (password.length >= 5) score += 10;
        if (password.length >= 8) score += 15;
        if (password.length >= 12) score += 15;

        // Character variety checks
        if (/[a-z]/.test(password)) score += 15;
        if (/[A-Z]/.test(password)) score += 15;
        if (/[0-9]/.test(password)) score += 15;
        if (/[^A-Za-z0-9]/.test(password)) score += 20;

        // Bonus untuk kombinasi
        if (/[a-z]/.test(password) && /[A-Z]/.test(password)) score += 5;
        if (/[a-zA-Z]/.test(password) && /[0-9]/.test(password)) score += 5;
        if (/[a-zA-Z0-9]/.test(password) && /[^A-Za-z0-9]/.test(password)) score += 5;

        // Determine feedback based on score
        if (score < 40) {
            feedback = {
                text: 'Password lemah',
                icon: 'fa-times-circle',
                className: 'strength-weak-label',
                level: 'weak'
            };
        } else if (score < 60) {
            feedback = {
                text: 'Password cukup',
                icon: 'fa-exclamation-circle',
                className: 'strength-medium-label',
                level: 'medium'
            };
        } else if (score < 80) {
            feedback = {
                text: 'Password kuat',
                icon: 'fa-check-circle',
                className: 'strength-strong-label',
                level: 'strong'
            };
        } else {
            feedback = {
                text: 'Password sangat kuat',
                icon: 'fa-shield-alt',
                className: 'strength-very-strong-label',
                level: 'very-strong'
            };
        }

        return { score, feedback };
    }

    // Password input event listener
    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            const result = checkPasswordStrength(password);

            // Update strength meter
            if (passwordStrength) {
                passwordStrength.style.width = result.score + '%';

                // Update meter color
                passwordStrength.className = 'strength-meter';
                if (result.score > 0) {
                    if (result.score < 40) {
                        passwordStrength.classList.add('strength-weak');
                    } else if (result.score < 60) {
                        passwordStrength.classList.add('strength-medium');
                    } else if (result.score < 80) {
                        passwordStrength.classList.add('strength-strong');
                    } else {
                        passwordStrength.classList.add('strength-very-strong');
                    }
                }
            }

            // Update strength text label
            if (strengthText) {
                strengthText.innerHTML = `<i class="fas ${result.feedback.icon} strength-icon"></i> ${result.feedback.text}`;
                strengthText.className = `strength-text ${result.feedback.className}`;
            }

            // Update validation status
            validateField('password', password);

            // Check confirm password if it has value
            if (confirmPasswordInput.value) {
                validateField('confirmPassword', confirmPasswordInput.value);
            }
        });
    }

    // ==================== FORM REALTIME VALIDATION ====================
    function validateField(fieldId, value) {
        let isValid = true;
        const field = document.getElementById(fieldId);

        if (!field) return true;

        switch(fieldId) {
            case 'nama':
                if (!value.trim()) {
                    showError('nama', 'Nama lengkap harus diisi');
                    field.classList.add('error');
                    field.classList.remove('success');
                    isValid = false;
                } else {
                    hideError('nama');
                    field.classList.remove('error');
                    field.classList.add('success');
                }
                break;

            case 'email':
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(value)) {
                    showError('email', 'Email tidak valid');
                    field.classList.add('error');
                    field.classList.remove('success');
                    isValid = false;
                } else {
                    hideError('email');
                    field.classList.remove('error');
                    field.classList.add('success');
                }
                break;

            case 'password':
                if (value.length < 5) {
                    showError('password', 'Kata sandi minimal 5 karakter');
                    field.classList.add('error');
                    field.classList.remove('success');
                    isValid = false;
                } else {
                    hideError('password');
                    field.classList.remove('error');
                    field.classList.add('success');
                }
                break;

            case 'confirmPassword':
                if (value !== passwordInput.value) {
                    showError('confirmPassword', 'Kata sandi tidak cocok');
                    field.classList.add('error');
                    field.classList.remove('success');
                    isValid = false;
                } else {
                    hideError('confirmPassword');
                    field.classList.remove('error');
                    field.classList.add('success');
                }
                break;
        }

        return isValid;
    }

    function showError(fieldId, message) {
        if (errorElements[fieldId]) {
            const errorElement = errorElements[fieldId];
            errorElement.innerHTML = `<i class="fas fa-times-circle"></i> ${message}`;
            errorElement.style.display = 'flex';
        }
    }

    function hideError(fieldId) {
        if (errorElements[fieldId]) {
            errorElements[fieldId].style.display = 'none';
        }
    }

    // Add real-time validation for all fields
    const inputs = ['nama', 'email', 'password', 'confirmPassword'];
    inputs.forEach(inputId => {
        const input = document.getElementById(inputId);
        if (input) {
            input.addEventListener('blur', () => validateField(inputId, input.value));
            input.addEventListener('input', function() {
                validateField(inputId, this.value);
            });
        }
    });

    // ==================== FORM SUBMISSION ====================
    registerForm.addEventListener('submit', function(e) {
        // Validasi client-side sebelum submit
        let isFormValid = true;

        // Validasi field wajib
        inputs.forEach(inputId => {
            const input = document.getElementById(inputId);
            if (input && !validateField(inputId, input.value)) {
                isFormValid = false;
            }
        });

        // Check terms agreement
        const termsCheckbox = document.getElementById('terms');
        if (!termsCheckbox.checked) {
            alert('Anda harus menyetujui Syarat & Ketentuan dan Kebijakan Privasi');
            isFormValid = false;
            e.preventDefault();
        }

        if (!isFormValid) {
            e.preventDefault();
            alert('Harap perbaiki kesalahan pada formulir sebelum melanjutkan.');
        } else {
            // Disable submit button and show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses Pendaftaran...';
        }
    });

    // ==================== AUTO-HIDE ALERTS ====================
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

    // Efek hover pada container
    const container = document.querySelector('.register-container');
    if (container) {
        container.addEventListener('mousemove', (e) => {
            const rect = container.getBoundingClientRect();
            const x = (e.clientX - rect.left) / rect.width - 0.5;
            const y = (e.clientY - rect.top) / rect.height - 0.5;
            container.style.transform = `perspective(1000px) rotateY(${x * 2}deg) rotateX(${y * -1}deg)`;
        });

        container.addEventListener('mouseleave', () => {
            container.style.transform = 'perspective(1000px) rotateY(0deg) rotateX(0deg)';
        });
    }
    </script>
</body>
</html>
