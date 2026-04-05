<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/image/logo-mcr.png') }}" />
    <title>MedikCareRent - Verifikasi Email</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap");

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

        .verification-container {
            max-width: 550px;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 40px;
            padding: 50px;
            box-shadow: var(--shadow-lg);
            text-align: center;
            animation: fadeInUp 0.8s ease-out;
            border: 1px solid rgba(255, 255, 255, 0.5);
            position: relative;
            overflow: hidden;
        }

        .verification-container::before {
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

        .verification-icon {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            box-shadow: var(--shadow-md);
            position: relative;
            z-index: 2;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                box-shadow: var(--shadow-md);
            }
            50% {
                transform: scale(1.05);
                box-shadow: var(--shadow-lg);
            }
        }

        .verification-icon i {
            font-size: 56px;
            color: white;
        }

        h1 {
            font-size: 36px;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 15px;
            position: relative;
            z-index: 2;
        }

        .description {
            color: var(--text-muted);
            margin-bottom: 25px;
            font-size: 16px;
            position: relative;
            z-index: 2;
        }

        .email-address {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            padding: 20px;
            border-radius: 20px;
            margin: 25px 0;
            font-weight: 600;
            color: var(--light);
            font-size: 18px;
            word-break: break-all;
            box-shadow: var(--shadow-md);
            position: relative;
            z-index: 2;
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
        }

        .email-address i {
            margin-right: 10px;
            color: rgba(255, 255, 255, 0.9);
        }

        .instructions {
            text-align: left;
            background: rgba(27, 76, 140, 0.05);
            backdrop-filter: blur(10px);
            padding: 25px;
            border-radius: 24px;
            margin: 25px 0;
            border: 1px solid rgba(27, 76, 140, 0.1);
            position: relative;
            z-index: 2;
        }

        .instructions h3 {
            color: var(--primary);
            margin-bottom: 15px;
            font-size: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .instructions ol {
            padding-left: 25px;
        }

        .instructions li {
            margin-bottom: 12px;
            color: var(--text-color-sec);
        }

        .alert {
            padding: 18px 22px;
            border-radius: 20px;
            font-size: 14px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            animation: slideIn 0.5s ease;
            border: none;
            box-shadow: var(--shadow-md);
            position: relative;
            z-index: 2;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
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

        .actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            position: relative;
            z-index: 2;
        }

        .btn {
            flex: 1;
            padding: 16px 24px;
            border: none;
            border-radius: 16px;
            font-size: 16px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
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

        .btn:hover::before {
            opacity: 1;
            animation: shine 1.5s infinite;
        }

        @keyframes shine {
            0% { transform: translateX(-100%) rotate(45deg); }
            100% { transform: translateX(100%) rotate(45deg); }
        }

        .btn-google {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white;
            box-shadow: var(--shadow-md);
        }

        .btn-google:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            color: var(--primary);
            border: 1px solid rgba(27, 76, 140, 0.1);
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }

        .btn:active {
            transform: translateY(0);
        }

        .footer-note {
            margin-top: 30px;
            text-align: center;
            font-size: 13px;
            color: var(--text-muted);
            border-top: 1px solid rgba(27, 76, 140, 0.1);
            padding-top: 25px;
            position: relative;
            z-index: 2;
        }

        .footer-note a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
        }

        .footer-note a:hover {
            color: var(--primary-light);
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 576px) {
            body {
                padding: 10px;
            }

            .verification-container {
                padding: 30px 20px;
                border-radius: 30px;
            }

            h1 {
                font-size: 28px;
            }

            .actions {
                flex-direction: column;
            }

            .email-address {
                font-size: 16px;
                padding: 15px;
            }

            .verification-icon {
                width: 100px;
                height: 100px;
            }

            .verification-icon i {
                font-size: 48px;
            }

            .orb-1, .orb-2, .orb-3 {
                display: none;
            }
        }

        /* Loading animation for button */
        .btn .fa-spinner {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <!-- Floating Orbs untuk Efek Background -->
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    <div class="verification-container">
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        <div class="verification-icon">
            <i class="fas fa-envelope-open-text"></i>
        </div>

        <h1>Verifikasi Email Anda</h1>

        <p class="description">
            Terima kasih telah mendaftar!<br>
            Kami telah mengirimkan link verifikasi ke:
        </p>

        <div class="email-address">
            <i class="fas fa-envelope"></i>
            {{ session('email') ?? auth()->user()->email ?? 'email@anda.com' }}
        </div>

        <div class="instructions">
            <h3>
                <i class="fas fa-info-circle"></i>
                Langkah-langkah verifikasi:
            </h3>
            <ol>
                <li>Klik tombol <strong>"Buka Gmail"</strong> di bawah</li>
                <li>Buka email dari <strong>MedikCareRent</strong> dengan subjek "Verifikasi Email"</li>
                <li>Klik tombol <strong>"Verify Email Address"</strong> di dalam email</li>
                <li>Anda akan otomatis dialihkan ke halaman login setelah verifikasi</li>
            </ol>
        </div>

        <div class="actions">
            <a href="https://mail.google.com/" target="_blank" class="btn btn-google">
                <i class="fab fa-google"></i> Buka Gmail
            </a>

            <form method="POST" action="{{ route('verification.send') }}" style="flex: 1;">
                @csrf
                <button type="submit" class="btn btn-secondary">
                    <i class="fas fa-paper-plane"></i> Kirim Ulang
                </button>
            </form>
        </div>

        <div class="footer-note">
            <p>&copy; 2025 MedikCareRent. Semua hak dilindungi.</p>
            <p style="margin-top: 10px;">
                <small>
                    <i class="fas fa-exclamation-triangle" style="color: #f39c12;"></i>
                    Tidak menerima email? Periksa folder spam atau
                    <a href="#" style="color: var(--primary);">hubungi support</a>
                </small>
            </p>
        </div>
    </div>

    <script>
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

        // Prevent form double submission
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', function() {
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';
                }
            });
        });

        // Efek hover pada container
        const container = document.querySelector('.verification-container');
        if (container) {
            container.addEventListener('mousemove', (e) => {
                const rect = container.getBoundingClientRect();
                const x = (e.clientX - rect.left) / rect.width - 0.5;
                const y = (e.clientY - rect.top) / rect.height - 0.5;
                container.style.transform = `perspective(1000px) rotateY(${x * 1}deg) rotateX(${y * -0.5}deg)`;
            });

            container.addEventListener('mouseleave', () => {
                container.style.transform = 'perspective(1000px) rotateY(0deg) rotateX(0deg)';
            });
        }
    </script>
</body>
</html>
