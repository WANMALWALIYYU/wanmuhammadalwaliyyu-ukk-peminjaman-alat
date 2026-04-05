<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Perubahan Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8fafc;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #0b2c5d, #1e3a8a);
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            color: white;
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px;
        }
        .content p {
            color: #334155;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #0b2c5d, #1e3a8a);
            color: white;
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 9999px;
            font-weight: 600;
            margin: 20px 0;
        }
        .footer {
            background: #f1f5f9;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #64748b;
        }
        .warning {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 12px;
            margin: 20px 0;
            font-size: 12px;
            color: #92400e;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Verifikasi Perubahan Password</h1>
        </div>
        <div class="content">
            <p>Halo <strong>{{ $name }}</strong>,</p>
            <p>Kami menerima permintaan untuk mengubah password pada akun Anda. Untuk melanjutkan proses perubahan password, silakan klik tombol verifikasi di bawah ini:</p>

            <div style="text-align: center;">
                <a href="{{ route('user.profile.verify-password', $token) }}" class="button">
                    Verifikasi Password Baru
                </a>
            </div>

            <div class="warning">
                <strong>⚠️ Penting:</strong> Token verifikasi ini akan kadaluarsa dalam 30 menit. Jika Anda tidak melakukan permintaan perubahan password, abaikan email ini.
            </div>

            <p>Jika tombol di atas tidak berfungsi, salin dan tempel tautan berikut ke browser Anda:</p>
            <p style="word-break: break-all; font-size: 12px; color: #0b2c5d;">
                {{ route('user.profile.verify-password', $token) }}
            </p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Medical Care. All rights reserved.</p>
            <p>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
        </div>
    </div>
</body>
</html>
