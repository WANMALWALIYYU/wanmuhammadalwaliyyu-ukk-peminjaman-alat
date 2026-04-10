<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/image/logo-mcr.png') }}" />
    <title>Transaksi Peminjaman - MedikCareRent</title>

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- AOS Animation -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f6f9fc 0%, #edf2f9 100%);
            color: #1a2639;
            line-height: 1.6;
            min-height: 100vh;
        }

        :root {
            --primary: #1B4C8C;
            --primary-dark: #0f3a6b;
            --primary-light: #2d6eb0;
            --primary-soft: #e1ebfa;
            --secondary: #2ECC71;
            --secondary-dark: #27ae60;
            --secondary-light: #a3e4b7;
            --accent: #9b59b6;
            --warning: #f39c12;
            --danger: #e74c3c;
            --dark: #1e2b3a;
            --gray: #7f8c8d;
            --light: #f8fafd;
            --white: #ffffff;
            --shadow-sm: 0 2px 4px rgba(0,0,0,0.02), 0 4px 8px rgba(0,0,0,0.02);
            --shadow-md: 0 4px 12px rgba(27,76,140,0.08), 0 8px 24px rgba(27,76,140,0.12);
            --shadow-lg: 0 20px 40px rgba(27,76,140,0.15);
            --shadow-hover: 0 30px 60px rgba(27,76,140,0.2);
            --border-radius-sm: 12px;
            --border-radius-md: 20px;
            --border-radius-lg: 32px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Modern Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--primary-soft);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-light);
            border-radius: 10px;
            transition: var(--transition);
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary);
        }

        /* Header Modern */
        .header-gradient {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            padding: 1rem 2rem;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .header-gradient::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .header-container {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            z-index: 2;
        }

        .logo-wrapper {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .logo-wrapper img {
            width: 60px;
            height: auto;
            filter: brightness(0) invert(1);
            transition: var(--transition);
        }

        .logo-wrapper img:hover {
            transform: scale(1.05);
        }

        .page-info h1 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
            letter-spacing: -0.5px;
        }

        .page-info p {
            font-size: 0.95rem;
            opacity: 0.9;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .help-badge {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            display: flex;
            align-items: center;
            gap: 1rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: var(--transition);
        }

        .help-badge:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px);
        }

        .help-badge i {
            font-size: 1.2rem;
        }

        .help-badge a {
            color: white;
            text-decoration: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50px;
            transition: var(--transition);
        }

        .help-badge a:hover {
            background: var(--secondary);
            transform: scale(1.05);
        }

        /* Progress Steps Modern */
        .progress-wrapper {
            background: white;
            padding: 1.5rem 0;
            box-shadow: var(--shadow-sm);
            position: sticky;
            top: 0;
            z-index: 100;
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }

        .progress-container {
            max-width: 900px;
            margin: 0 auto;
            position: relative;
            display: flex;
            justify-content: space-between;
            padding: 0 2rem;
        }

        .progress-line-bg {
            position: absolute;
            top: 30px;
            left: 100px;
            right: 100px;
            height: 4px;
            background: #e9ecef;
            border-radius: 4px;
            z-index: 1;
        }

        .progress-line-fill {
            position: absolute;
            top: 30px;
            left: 100px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary) 0%, var(--secondary) 100%);
            border-radius: 4px;
            transition: width 0.5s ease;
            z-index: 2;
        }

        .step {
            position: relative;
            z-index: 3;
            background: white;
            padding: 0 1.5rem;
            text-align: center;
            flex: 1;
        }

        .step-circle {
            width: 60px;
            height: 60px;
            background: white;
            border: 3px solid #e9ecef;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-weight: 700;
            font-size: 1.3rem;
            color: var(--gray);
            transition: var(--transition);
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        .step.active .step-circle {
            border-color: var(--primary);
            background: var(--primary);
            color: white;
            transform: scale(1.1);
            box-shadow: 0 10px 25px rgba(27,76,140,0.3);
        }

        .step.completed .step-circle {
            border-color: var(--secondary);
            background: var(--secondary);
            color: white;
        }

        .step.completed .step-circle i {
            font-size: 1.3rem;
        }

        .step.completed .step-circle span {
            display: none;
        }

        .step-label {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--gray);
            transition: var(--transition);
        }

        .step.active .step-label {
            color: var(--primary);
            font-weight: 700;
        }

        .step.completed .step-label {
            color: var(--secondary);
        }

        /* Main Content */
        .main-content {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
        }

        /* Modern Cards */
        .glass-card {
            border-radius: var(--border-radius-lg);
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(215, 215, 215, 0.5);
            transition: var(--transition);
            animation: slideUp 0.5s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .glass-card:hover {
            transform: translateY(-5px);
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--primary-soft);
        }

        .card-header i {
            font-size: 1.8rem;
            color: var(--primary);
            background: var(--primary-soft);
            padding: 1rem;
            border-radius: 16px;
        }

        .card-header h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            margin: 0;
        }

        .card-header p {
            color: var(--gray);
            font-size: 0.95rem;
            margin-top: 0.25rem;
        }

        /* Product Cards Modern */
        .product-grid {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .product-item {
            display: flex;
            gap: 2rem;
            padding: 1.5rem;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .product-image {
            width: 150px;
            height: 150px;
            border-radius: var(--border-radius-md);
            overflow: hidden;
            flex-shrink: 0;
            box-shadow: var(--shadow-sm);
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .product-item:hover .product-image img {
            transform: scale(1.1);
        }

        .product-details {
            flex: 1;
        }

        .product-title {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .product-title h3 {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.25rem;
        }

        .product-code {
            font-size: 0.8rem;
            color: var(--gray);
            background: var(--primary-soft);
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            display: inline-block;
        }

        .product-price-info {
            background: linear-gradient(135deg, #e8f4ff 0%, #d9ebff 100%);
            padding: 0.75rem 1.5rem;
            border-radius: 40px;
            text-align: center;
        }

        .price-label {
            font-size: 0.7rem;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .price-value {
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--primary);
            line-height: 1.2;
        }

        .product-specs {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            margin: 1rem 0;
        }

        .spec-badge {
            background: #f8f9fa;
            padding: 0.5rem 1rem;
            border-radius: 30px;
            font-size: 0.85rem;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            border: 1px solid #e9ecef;
        }

        .spec-badge i {
            color: var(--primary);
        }

        /* Quantity Control Modern */
        .quantity-wrapper {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-top: 1rem;
        }

        .quantity-btn {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            border: 2px solid var(--primary-soft);
            background: white;
            color: var(--primary);
            font-size: 1.2rem;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .quantity-btn:hover:not(:disabled) {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
            transform: scale(1.1);
        }

        .quantity-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .quantity-input {
            width: 70px;
            height: 45px;
            border: 2px solid var(--primary-soft);
            border-radius: 12px;
            text-align: center;
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--primary);
            background: white;
        }

        .stock-badge {
            background: #e8f5e9;
            color: var(--secondary-dark);
            padding: 0.4rem 1rem;
            border-radius: 30px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        /* Date Picker Modern */
        .date-section {
            display: flex;
            gap: 1.5rem;
            margin-top: 1.5rem;
            padding: 1.5rem;
            background: linear-gradient(135deg, #f8faff 0%, #f0f5ff 100%);
            border-radius: var(--border-radius-md);
            flex-wrap: wrap;
        }

        .date-field {
            flex: 1;
            min-width: 200px;
        }

        .date-field label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .date-field input {
            width: 100%;
            padding: 0.9rem 1.2rem;
            border: 2px solid #e9ecef;
            border-radius: 16px;
            font-family: 'Inter', sans-serif;
            transition: var(--transition);
            background: white;
        }

        .date-field input:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 4px rgba(27,76,140,0.1);
        }

        .duration-badge-modern {
            background: var(--primary);
            color: white;
            padding: 0.9rem 1.5rem;
            border-radius: 16px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: var(--shadow-sm);
        }

        /* Form Modern */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group.full-width {
            grid-column: span 2;
        }

        .form-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .form-label i {
            color: var(--primary-light);
        }

        .form-control, .form-select {
            width: 100%;
            padding: 0.9rem 1.2rem;
            border: 2px solid #e9ecef;
            border-radius: 16px;
            font-family: 'Inter', sans-serif;
            font-size: 0.95rem;
            transition: var(--transition);
            background: white;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 4px rgba(27,76,140,0.1);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        /* Upload Area Modern */
        .upload-area {
            border: 3px dashed var(--primary-soft);
            border-radius: 30px;
            padding: 2.5rem;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
            background: linear-gradient(135deg, #ffffff 0%, #fafcff 100%);
            position: relative;
            overflow: hidden;
        }

        .upload-area::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            opacity: 0;
            transition: var(--transition);
            z-index: 1;
        }

        .upload-area:hover::before {
            opacity: 0.05;
        }

        .upload-area:hover {
            border-color: var(--primary);
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .upload-area i {
            font-size: 4rem;
            color: var(--primary);
            margin-bottom: 1rem;
            position: relative;
            z-index: 2;
        }

        .upload-area p {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 2;
        }

        .upload-area small {
            color: var(--gray);
            position: relative;
            z-index: 2;
        }

        .preview-modern {
            margin-top: 1.5rem;
            border-radius: 20px;
            overflow: hidden;
            background: linear-gradient(135deg, #f8faff 0%, #f0f5ff 100%);
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .preview-image {
            width: 120px;
            height: 120px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow-md);
        }

        .preview-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .preview-info {
            flex: 1;
        }

        .preview-name {
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.25rem;
        }

        .preview-size {
            font-size: 0.85rem;
            color: var(--gray);
            margin-bottom: 0.5rem;
        }

        .btn-clear-modern {
            padding: 0.6rem 1.2rem;
            border: 2px solid var(--danger);
            border-radius: 30px;
            background: transparent;
            color: var(--danger);
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-clear-modern:hover {
            background: var(--danger);
            color: white;
        }

        /* Location Select Modern */
        .location-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        /* Payment Methods Modern */
        .payment-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }

        .payment-method {
            background: white;
            border: 2px solid #e9ecef;
            border-radius: 30px;
            padding: 2rem 1.5rem;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .payment-method::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary) 0%, var(--secondary) 100%);
            transform: translateY(-100%);
            transition: var(--transition);
        }

        .payment-method:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-lg);
            border-color: transparent;
        }

        .payment-method:hover::before {
            transform: translateY(0);
        }

        .payment-method.selected {
            border-color: var(--primary);
            background: linear-gradient(135deg, #f8faff 0%, #f0f5ff 100%);
            box-shadow: var(--shadow-md);
        }

        .payment-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            background: var(--primary-soft);
            border-radius: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: var(--primary);
            transition: var(--transition);
        }

        .payment-method:hover .payment-icon {
            transform: scale(1.1) rotate(5deg);
            background: var(--primary);
            color: white;
        }

        .payment-name {
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
        }

        .payment-desc {
            font-size: 0.85rem;
            color: var(--gray);
        }

        /* Payment Details Modern */
        .payment-details {
            background: linear-gradient(135deg, #f8faff 0%, #f0f5ff 100%);
            border-radius: 30px;
            padding: 2rem;
            margin-top: 2rem;
        }

        .payment-details h4 {
            font-size: 1.2rem;
            color: var(--primary);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .payment-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.2rem 1.5rem;
            background: white;
            border-radius: 20px;
            margin-bottom: 1rem;
            transition: var(--transition);
            border: 1px solid rgba(27,76,140,0.1);
        }

        .payment-item:hover {
            transform: translateX(10px);
            box-shadow: var(--shadow-md);
            border-color: var(--primary);
        }

        .payment-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .payment-logo {
            width: 50px;
            height: 50px;
            background: var(--primary-soft);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            color: var(--primary);
            font-size: 1.2rem;
        }

        .payment-detail h5 {
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.25rem;
        }

        .payment-detail p {
            font-size: 0.85rem;
            color: var(--gray);
        }

        .account-number {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--primary);
            letter-spacing: 1px;
        }

        .btn-copy {
            padding: 0.7rem 1.2rem;
            border: 2px solid var(--primary-soft);
            border-radius: 15px;
            background: white;
            color: var(--primary);
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-copy:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        /* Summary Modern */
        .summary-card {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            border-radius: 40px;
            padding: 2.5rem;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .summary-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 70%);
            animation: rotate 30s linear infinite;
        }

        .summary-header {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            position: relative;
            z-index: 2;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 1rem 0;
            border-bottom: 1px solid rgba(255,255,255,0.2);
            position: relative;
            z-index: 2;
        }

        .summary-row.total {
            border-bottom: none;
            font-size: 1.3rem;
            font-weight: 700;
            padding-top: 1.5rem;
        }

        .summary-row.deposit {
            background: rgba(255,255,255,0.15);
            padding: 1.5rem;
            border-radius: 20px;
            margin: 1.5rem 0;
            border: none;
            backdrop-filter: blur(10px);
        }

        .summary-badge {
            background: rgba(255,255,255,0.2);
            padding: 1rem 1.5rem;
            border-radius: 20px;
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-top: 1.5rem;
            backdrop-filter: blur(10px);
            position: relative;
            z-index: 2;
        }

        /* Transaction Detail Modern - Enhanced for Step 3 */
        .detail-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
        }

        .detail-box {
            background: linear-gradient(135deg, #f8faff 0%, #f0f5ff 100%);
            border-radius: 30px;
            padding: 2rem;
        }

        .detail-box h4 {
            font-size: 1.1rem;
            color: var(--primary);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid rgba(27,76,140,0.1);
        }

        /* Multi-line detail items for better readability */
        .detail-item {
            display: flex;
            padding: 0.75rem 0;
            border-bottom: 1px dashed rgba(27,76,140,0.1);
        }

        .detail-item:last-child {
            border-bottom: none;
        }

        .detail-label {
            width: 110px;
            flex-shrink: 0;
            color: var(--gray);
            font-weight: 500;
        }

        .detail-value {
            flex: 1;
            font-weight: 600;
            color: var(--primary);
            word-wrap: break-word;
            word-break: break-word;
            white-space: normal;
            line-height: 1.5;
        }

        /* Product list in confirmation */
        .confirm-product-list {
            max-height: 300px;
            overflow-y: auto;
            padding-right: 10px;
        }

        .confirm-product-item {
            padding: 12px 0;
            border-bottom: 1px solid rgba(27,76,140,0.08);
        }

        .confirm-product-item:last-child {
            border-bottom: none;
        }

        .confirm-product-name {
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .confirm-product-name i {
            color: var(--primary-light);
            font-size: 0.9rem;
        }

        .confirm-product-detail {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 6px;
        }

        .confirm-product-qty {
            font-size: 0.85rem;
            color: var(--gray);
            background: var(--primary-soft);
            padding: 4px 10px;
            border-radius: 20px;
        }

        .confirm-product-duration {
            font-size: 0.85rem;
            color: var(--gray);
            background: #e8f5e9;
            padding: 4px 10px;
            border-radius: 20px;
        }

        .confirm-product-total {
            font-weight: 700;
            color: var(--secondary);
            font-size: 0.95rem;
        }

        .confirm-subtotal-row {
            margin-top: 12px;
            padding-top: 12px;
            border-top: 2px solid var(--primary-soft);
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 700;
        }

        .confirm-subtotal-label {
            color: var(--primary);
        }

        .confirm-subtotal-value {
            color: var(--secondary);
            font-size: 1rem;
        }

        /* Payment summary box */
        .payment-summary-box {
            background: linear-gradient(135deg, #e8f4ff 0%, #d9ebff 100%);
            border-radius: 20px;
            padding: 1.5rem;
            margin-top: 1rem;
        }

        .payment-summary-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
        }

        .payment-summary-row.total {
            border-top: 2px solid var(--primary);
            margin-top: 10px;
            padding-top: 15px;
            font-size: 1.1rem;
            font-weight: 800;
        }

        /* Action Buttons Modern */
        .action-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 2rem;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn-modern {
            padding: 1rem 2rem;
            border-radius: 16px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            border: none;
            font-family: 'Inter', sans-serif;
        }

        .btn-outline {
            background: transparent;
            border: 2px solid var(--primary-soft);
            color: var(--primary);
        }

        .btn-outline:hover {
            border-color: var(--primary);
            background: var(--primary-soft);
            transform: translateX(-5px);
        }

        .btn-primary-modern {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white;
            box-shadow: var(--shadow-md);
        }

        .btn-primary-modern:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }

        .btn-primary-modern i {
            transition: var(--transition);
        }

        .btn-primary-modern:hover i {
            transform: translateX(5px);
        }

        .btn-success-modern {
            background: linear-gradient(135deg, var(--secondary) 0%, var(--secondary-dark) 100%);
            color: white;
            box-shadow: 0 10px 25px rgba(46, 204, 113, 0.3);
        }

        .btn-success-modern:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(46, 204, 113, 0.4);
        }

        /* Alert Modern */
        .alert-modern {
            padding: 1.2rem 1.5rem;
            border-radius: 20px;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            animation: slideIn 0.3s ease;
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

        .alert-danger-modern {
            background: #fee2e2;
            border-left: 4px solid var(--danger);
            color: #991b1b;
        }

        .alert-success-modern {
            background: #dcfce7;
            border-left: 4px solid var(--secondary);
            color: #166534;
        }

        /* Terms Modern */
        .terms-box {
            background: linear-gradient(135deg, #f8faff 0%, #f0f5ff 100%);
            border-radius: 30px;
            padding: 2rem;
            max-height: 200px;
            overflow-y: auto;
            margin-bottom: 1.5rem;
        }

        .terms-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.75rem 0;
            border-bottom: 1px solid rgba(27,76,140,0.1);
        }

        .terms-item i {
            color: var(--secondary);
            font-size: 1.1rem;
        }

        .checkbox-modern {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
        }

        .checkbox-modern input {
            width: 20px;
            height: 20px;
            cursor: pointer;
            accent-color: var(--primary);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .header-container {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .logo-wrapper {
                flex-direction: column;
            }

            .progress-line-bg,
            .progress-line-fill {
                left: 50px;
                right: 50px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-group.full-width {
                grid-column: span 1;
            }

            .location-grid {
                grid-template-columns: 1fr;
            }

            .detail-grid {
                grid-template-columns: 1fr;
            }

            .product-item {
                flex-direction: column;
            }

            .product-image {
                width: 100%;
                height: 200px;
            }

            .date-section {
                flex-direction: column;
            }

            .action-bar {
                flex-direction: column;
            }

            .action-bar .btn-modern {
                width: 100%;
                justify-content: center;
            }

            .detail-item {
                flex-direction: column;
            }

            .detail-label {
                width: 100%;
                margin-bottom: 5px;
            }
        }

        @media (max-width: 576px) {
            .progress-line-bg,
            .progress-line-fill {
                display: none;
            }

            .step {
                padding: 0 0.5rem;
            }

            .step-circle {
                width: 45px;
                height: 45px;
                font-size: 1rem;
            }

            .step-label {
                font-size: 0.8rem;
            }

            .main-content {
                padding: 1rem;
            }

            .glass-card {
                padding: 1.5rem;
            }

            .product-title {
                flex-direction: column;
                gap: 1rem;
            }

            .product-price-info {
                align-self: flex-start;
            }

            .quantity-wrapper {
                flex-wrap: wrap;
            }

            .confirm-product-detail {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>

<!-- Header Modern -->
<div class="header-gradient">
    <div class="header-container">
        <div class="logo-wrapper">
            <img src="{{ asset('assets/image/logo-mcr.png') }}" alt="MedikCareRent">
            <div class="page-info">
                <h1>Transaksi Peminjaman</h1>
                <p><i class="fas fa-shield-alt"></i> Aman & Terpercaya • 100% Garansi</p>
            </div>
        </div>
        <div class="help-badge">
            <i class="fas fa-headset"></i>
            <span>Butuh Bantuan?</span>
            <a href="https://wa.me/62895352983076" target="_blank">
                <i class="fab fa-whatsapp"></i>
                Hubungi Admin
            </a>
        </div>
    </div>
</div>

<!-- Progress Steps Modern -->
<div class="progress-wrapper">
    <div class="progress-container">
        <div class="progress-line-bg"></div>
        <div class="progress-line-fill" id="stepProgress" style="width: 0%"></div>

        <div class="step active" data-step="1">
            <div class="step-circle"><span>1</span></div>
            <div class="step-label">Detail Pesanan</div>
        </div>
        <div class="step" data-step="2">
            <div class="step-circle"><span>2</span></div>
            <div class="step-label">Pembayaran</div>
        </div>
        <div class="step" data-step="3">
            <div class="step-circle"><span>3</span></div>
            <div class="step-label">Konfirmasi</div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="main-content">
    <!-- Alerts -->
    @if($errors->any())
        <div class="alert-modern alert-danger-modern" data-aos="fade-down">
            <i class="fas fa-exclamation-circle fa-2x"></i>
            <div>
                <strong>Terjadi Kesalahan:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="alert-modern alert-danger-modern" data-aos="fade-down">
            <i class="fas fa-exclamation-circle fa-2x"></i>
            <div>
                <strong>Error:</strong> {{ session('error') }}
            </div>
        </div>
    @endif

    @if(session('success'))
        <div class="alert-modern alert-success-modern" data-aos="fade-down">
            <i class="fas fa-check-circle fa-2x"></i>
            <div>
                <strong>Sukses:</strong> {{ session('success') }}
            </div>
        </div>
    @endif

    <form action="{{ route('transaksi.store') }}" method="POST" id="transactionForm" enctype="multipart/form-data">
        @csrf

        <!-- STEP 1: Detail Pesanan -->
        <div class="step-content" id="step1">
            <!-- Ringkasan Produk -->
            <div class="glass-card" data-aos="fade-up">
                <div class="card-header">
                    <i class="fas fa-shopping-bag"></i>
                    <div>
                        <h2>Ringkasan Produk</h2>
                        <p>Detail produk yang akan Anda pinjam</p>
                    </div>
                </div>

                <div class="product-grid">
                    @forelse($transaksiItems ?? [] as $index => $item)
                    <div class="product-item" data-produk-id="{{ $item->produk_id }}" data-harga="{{ $item->produk->harga }}" data-stok="{{ $item->produk->stok }}" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <div class="product-image">
                            @if($item->produk->gambar)
                                <img src="{{ asset('storage/' . $item->produk->gambar) }}"
                                     alt="{{ $item->produk->nama_produk }}"
                                     onerror="this.src='https://via.placeholder.com/150x150/1B4C8C/FFFFFF?text=MEDIK'">
                            @else
                                <img src="https://via.placeholder.com/150x150/1B4C8C/FFFFFF?text=MEDIK"
                                     alt="Product">
                            @endif
                        </div>

                        <div class="product-details">
                            <div class="product-title">
                                <div>
                                    <h3>{{ $item->produk->nama_produk }}</h3>
                                    <span class="product-code">
                                        <i class="fas fa-barcode"></i>
                                        {{ $item->produk->kode_produk }}
                                    </span>
                                </div>
                                <div class="product-price-info">
                                    <div class="price-label">Harga Sewa</div>
                                    <div class="price-value">Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</div>
                                    <div style="font-size: 0.7rem; color: var(--primary);">/ hari</div>
                                </div>
                            </div>

                            <div class="product-specs">
                                <span class="spec-badge">
                                    <i class="fas fa-box"></i>
                                    Stok: <span id="stok-{{ $index }}">{{ $item->produk->stok }}</span> unit
                                </span>
                                <span class="spec-badge">
                                    <i class="fas fa-tag"></i>
                                    {{ ucfirst($item->produk->kondisi) }}
                                </span>
                                @if($item->produk->fitur)
                                <span class="spec-badge">
                                    <i class="fas fa-star"></i>
                                    {{ Str::limit($item->produk->fitur, 30) }}
                                </span>
                                @endif
                            </div>

                            <!-- Quantity Control Modern -->
                            <div class="quantity-wrapper">
                                <button type="button" class="quantity-btn" onclick="decreaseQuantity({{ $index }}, {{ $item->produk->stok }})">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" class="quantity-input" id="quantity-{{ $index }}" name="jumlahs[]" value="{{ $item->jumlah }}" min="1" max="{{ $item->produk->stok }}" readonly>
                                <button type="button" class="quantity-btn" onclick="increaseQuantity({{ $index }}, {{ $item->produk->stok }})">
                                    <i class="fas fa-plus"></i>
                                </button>
                                <span class="stock-badge">
                                    <i class="fas fa-check-circle"></i>
                                    Maks. {{ $item->produk->stok }} unit
                                </span>
                            </div>

                            <!-- Date Selection Modern -->
                            <div class="date-section">
                                <div class="date-field">
                                    <label>
                                        <i class="fas fa-calendar-alt"></i>
                                        Tanggal Mulai
                                    </label>
                                    <input type="date" id="tanggal_mulai-{{ $index }}" name="tanggal_mulai[]" value="{{ $item->tanggal_mulai ?? '' }}" onchange="calculateDuration({{ $index }})" min="{{ date('Y-m-d') }}" required>
                                </div>
                                <div class="date-field">
                                    <label>
                                        <i class="fas fa-calendar-check"></i>
                                        Tanggal Selesai
                                    </label>
                                    <input type="date" id="tanggal_selesai-{{ $index }}" name="tanggal_selesai[]" value="{{ $item->tanggal_selesai ?? '' }}" onchange="calculateDuration({{ $index }})" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                                </div>
                                <div class="duration-badge-modern">
                                    <i class="fas fa-clock"></i>
                                    <span id="duration-{{ $index }}">{{ $item->durasi }} Hari</span>
                                    <input type="hidden" id="durasi-{{ $index }}" name="durasis[]" value="{{ $item->durasi }}">
                                </div>
                            </div>

                            <!-- Total Price -->
                            <div style="text-align: right; margin-top: 1rem;">
                                <span style="color: var(--gray); font-size: 0.9rem;">Total:</span>
                                <span style="font-size: 1.5rem; font-weight: 800; color: var(--secondary); margin-left: 1rem;" id="price-total-{{ $index }}">
                                    Rp {{ number_format($item->produk->harga * $item->jumlah * $item->durasi, 0, ',', '.') }}
                                </span>
                            </div>

                            <!-- Hidden inputs -->
                            <input type="hidden" name="produk_ids[]" value="{{ $item->produk_id }}">
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-5" data-aos="fade-up">
                        <i class="fas fa-shopping-cart fa-4x" style="color: var(--primary-soft); margin-bottom: 1rem;"></i>
                        <p style="color: var(--gray); font-size: 1.1rem;">Tidak ada produk yang dipilih</p>
                        <a href="{{ route('produk.list') }}" class="btn-modern btn-primary-modern" style="margin-top: 1rem; text-decoration: none;">
                            <i class="fas fa-search"></i>
                            Pilih Produk
                        </a>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Data Peminjam -->
            <div class="glass-card" data-aos="fade-up" data-aos-delay="100">
                <div class="card-header">
                    <i class="fas fa-user-circle"></i>
                    <div>
                        <h2>Data Peminjam</h2>
                        <p>Informasi lengkap peminjam alat</p>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-user"></i>
                            Nama Lengkap <span style="color: var(--danger);">*</span>
                        </label>
                        <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                               name="nama_lengkap" value="{{ old('nama_lengkap', $user->name ?? '') }}"
                               required placeholder="Masukkan nama lengkap">
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-envelope"></i>
                            Email <span style="color: var(--danger);">*</span>
                        </label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email', $user->email ?? '') }}"
                               required placeholder="contoh@email.com">
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-phone-alt"></i>
                            No. Telepon <span style="color: var(--danger);">*</span>
                        </label>
                        <input type="text" class="form-control @error('no_telepon') is-invalid @enderror"
                               name="no_telepon" value="{{ old('no_telepon', $user->nomor_hp ?? '') }}"
                               required placeholder="08xxxxxxxxxx">
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-id-card"></i>
                            No. Identitas (KTP) <span style="color: var(--danger);">*</span>
                        </label>
                        <input type="text" class="form-control @error('no_identitas') is-invalid @enderror"
                               name="no_identitas" value="{{ old('no_identitas') }}"
                               required placeholder="Nomor KTP">
                    </div>
                </div>

                <!-- Upload KTP Modern -->
                <div class="form-group full-width" style="margin-top: 1rem;">
                    <label class="form-label">
                        <i class="fas fa-camera"></i>
                        Foto KTP <span style="color: var(--danger);">*</span>
                    </label>

                    <div class="upload-area" onclick="document.getElementById('foto_ktp').click()">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <p>Klik untuk upload foto KTP</p>
                        <small>Format: JPG, PNG, GIF, WEBP (Max. 2MB)</small>
                    </div>

                    <input type="file" id="foto_ktp" name="foto_ktp" accept="image/*" style="display: none;" required onchange="previewKTP(this)">

                    <div class="preview-modern" id="ktpPreview" style="display: none;">
                        <div class="preview-image">
                            <img id="preview-ktp-img" src="#" alt="Preview KTP">
                        </div>
                        <div class="preview-info">
                            <div class="preview-name" id="ktpFileName"></div>
                            <div class="preview-size" id="ktpFileSize"></div>
                            <button type="button" class="btn-clear-modern" onclick="clearKtpFile()">
                                <i class="fas fa-trash-alt"></i>
                                Hapus File
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alamat Pengiriman -->
            <div class="glass-card" data-aos="fade-up" data-aos-delay="200">
                <div class="card-header">
                    <i class="fas fa-map-marked-alt"></i>
                    <div>
                        <h2>Alamat Pengiriman</h2>
                        <p>Lokasi pengiriman alat</p>
                    </div>
                </div>

                <div class="location-grid">
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-map-pin"></i>
                            Provinsi <span style="color: var(--danger);">*</span>
                        </label>
                        <select class="form-select @error('provinsi') is-invalid @enderror" id="provinsi" name="provinsi" required onchange="loadKabupaten(this.value)">
                            <option value="">Pilih Provinsi</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-map-pin"></i>
                            Kabupaten/Kota <span style="color: var(--danger);">*</span>
                        </label>
                        <select class="form-select @error('kabupaten') is-invalid @enderror" id="kabupaten" name="kabupaten" required onchange="loadKecamatan(this.value)">
                            <option value="">Pilih Kabupaten/Kota</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-map-pin"></i>
                            Kecamatan <span style="color: var(--danger);">*</span>
                        </label>
                        <select class="form-select @error('kecamatan') is-invalid @enderror" id="kecamatan" name="kecamatan" required onchange="loadKelurahan(this.value)">
                            <option value="">Pilih Kecamatan</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-map-pin"></i>
                            Kelurahan/Desa <span style="color: var(--danger);">*</span>
                        </label>
                        <select class="form-select @error('kelurahan') is-invalid @enderror" id="kelurahan" name="kelurahan" required onchange="updateFullAddress()">
                            <option value="">Pilih Kelurahan/Desa</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-home"></i>
                        Alamat Lengkap <span style="color: var(--danger);">*</span>
                    </label>
                    <textarea class="form-control @error('alamat_lengkap') is-invalid @enderror"
                              id="alamat_lengkap" name="alamat_lengkap" rows="3"
                              placeholder="Masukkan alamat lengkap (nama jalan, nomor rumah, RT/RW)"
                              required>{{ old('alamat_lengkap') }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-truck"></i>
                        Catatan untuk Kurir (Opsional)
                    </label>
                    <input type="text" class="form-control" name="catatan_kurir"
                           value="{{ old('catatan_kurir') }}"
                           placeholder="Cont: Dekat masjid / Pagar hijau">
                </div>
            </div>

            <!-- Syarat & Ketentuan -->
            <div class="glass-card" data-aos="fade-up" data-aos-delay="300">
                <div class="card-header">
                    <i class="fas fa-file-contract"></i>
                    <div>
                        <h2>Syarat & Ketentuan</h2>
                        <p>Baca dengan seksama sebelum menyetujui</p>
                    </div>
                </div>

                <div class="terms-box">
                    <div class="terms-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Peminjam bertanggung jawab penuh atas alat yang dipinjam selama masa sewa.</span>
                    </div>
                    <div class="terms-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Alat harus dikembalikan dalam kondisi yang sama seperti saat diterima.</span>
                    </div>
                    <div class="terms-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Keterlambatan pengembalian akan dikenakan denda sebesar 10% dari biaya sewa per hari.</span>
                    </div>
                    <div class="terms-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Kerusakan alat akibat kelalaian peminjam akan ditagihkan biaya perbaikan.</span>
                    </div>
                    <div class="terms-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Pelunasan pembayaran dilakukan setelah barang dikembalikan.</span>
                    </div>
                    <div class="terms-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Pembatalan sewa kurang dari 24 jam sebelum pengiriman akan dikenakan biaya 50%.</span>
                    </div>
                </div>

                <div class="checkbox-modern">
                    <input type="checkbox" id="termsAgree" name="terms_agree" required>
                    <label for="termsAgree">Saya telah membaca dan menyetujui semua syarat dan ketentuan peminjaman yang berlaku <span style="color: var(--danger);">*</span></label>
                </div>
            </div>
        </div>

        <!-- STEP 2: Pembayaran -->
        <div class="step-content" id="step2" style="display: none;">
            <div class="glass-card" data-aos="fade-up">
                <div class="card-header">
                    <i class="fas fa-credit-card"></i>
                    <div>
                        <h2>Metode Pembayaran</h2>
                        <p>Pilih metode pembayaran yang Anda inginkan</p>
                    </div>
                </div>

                <div class="payment-grid">
                    <div class="payment-method" data-payment="transfer">
                        <div class="payment-icon">
                            <i class="fas fa-university"></i>
                        </div>
                        <div class="payment-name">Transfer Bank</div>
                        <div class="payment-desc">BCA • Mandiri • BRI • BNI</div>
                    </div>
                    <div class="payment-method" data-payment="va">
                        <div class="payment-icon">
                            <i class="fas fa-credit-card"></i>
                        </div>
                        <div class="payment-name">Virtual Account</div>
                        <div class="payment-desc">Livin' by Mandiri • BCA VA • BRI VA</div>
                    </div>
                    <div class="payment-method" data-payment="ewallet">
                        <div class="payment-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="payment-name">E-Wallet</div>
                        <div class="payment-desc">OVO • GoPay • Dana • ShopeePay</div>
                    </div>
                </div>

                <input type="hidden" name="metode_pembayaran" id="metodePembayaran" value="{{ old('metode_pembayaran') }}">
                <input type="hidden" name="jumlah_deposit" id="depositAmount" value="0">

                <!-- Transfer Bank Details -->
                <div class="payment-details" id="transferDetails" style="display: none;">
                    <h4><i class="fas fa-university"></i> Transfer Bank</h4>
                    <div class="payment-item">
                        <div class="payment-info">
                            <div class="payment-logo">BCA</div>
                            <div class="payment-detail">
                                <h5>Bank BCA</h5>
                                <p>a.n. MedikCareRent</p>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <span class="account-number">1234567890</span>
                            <button type="button" class="btn-copy" onclick="copyToClipboard('1234567890')">
                                <i class="fas fa-copy"></i>
                                Salin
                            </button>
                        </div>
                    </div>

                    <div class="payment-item">
                        <div class="payment-info">
                            <div class="payment-logo">MDR</div>
                            <div class="payment-detail">
                                <h5>Bank Mandiri</h5>
                                <p>a.n. MedikCareRent</p>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <span class="account-number">1234567890</span>
                            <button type="button" class="btn-copy" onclick="copyToClipboard('1234567890')">
                                <i class="fas fa-copy"></i>
                                Salin
                            </button>
                        </div>
                    </div>

                    <div class="payment-item">
                        <div class="payment-info">
                            <div class="payment-logo">BRI</div>
                            <div class="payment-detail">
                                <h5>Bank BRI</h5>
                                <p>a.n. MedikCareRent</p>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <span class="account-number">1234567890</span>
                            <button type="button" class="btn-copy" onclick="copyToClipboard('1234567890')">
                                <i class="fas fa-copy"></i>
                                Salin
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Virtual Account Details -->
                <div class="payment-details" id="vaDetails" style="display: none;">
                    <h4><i class="fas fa-credit-card"></i> Virtual Account</h4>
                    <div class="payment-item">
                        <div class="payment-info">
                            <div class="payment-logo">LVN</div>
                            <div class="payment-detail">
                                <h5>Livin' by Mandiri</h5>
                                <p>Kode Virtual Account</p>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <span class="account-number">1234 5678 9012 3456</span>
                            <button type="button" class="btn-copy" onclick="copyToClipboard('1234567890123456')">
                                <i class="fas fa-copy"></i>
                                Salin
                            </button>
                        </div>
                    </div>

                    <div class="payment-item">
                        <div class="payment-info">
                            <div class="payment-logo">BCA</div>
                            <div class="payment-detail">
                                <h5>BCA Virtual Account</h5>
                                <p>Kode VA BCA</p>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <span class="account-number">1234 5678 9012 3456</span>
                            <button type="button" class="btn-copy" onclick="copyToClipboard('1234567890123456')">
                                <i class="fas fa-copy"></i>
                                Salin
                            </button>
                        </div>
                    </div>

                    <div class="payment-item">
                        <div class="payment-info">
                            <div class="payment-logo">BRI</div>
                            <div class="payment-detail">
                                <h5>BRI Virtual Account</h5>
                                <p>Kode VA BRI</p>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <span class="account-number">1234 5678 9012 3456</span>
                            <button type="button" class="btn-copy" onclick="copyToClipboard('1234567890123456')">
                                <i class="fas fa-copy"></i>
                                Salin
                            </button>
                        </div>
                    </div>
                </div>

                <!-- E-Wallet Details -->
                <div class="payment-details" id="ewalletDetails" style="display: none;">
                    <h4><i class="fas fa-mobile-alt"></i> E-Wallet</h4>
                    <div class="payment-item">
                        <div class="payment-info">
                            <div class="payment-logo">OVO</div>
                            <div class="payment-detail">
                                <h5>OVO</h5>
                                <p>Nomor OVO</p>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <span class="account-number">0812 3456 7890</span>
                            <button type="button" class="btn-copy" onclick="copyToClipboard('081234567890')">
                                <i class="fas fa-copy"></i>
                                Salin
                            </button>
                        </div>
                    </div>

                    <div class="payment-item">
                        <div class="payment-info">
                            <div class="payment-logo">GOP</div>
                            <div class="payment-detail">
                                <h5>GoPay</h5>
                                <p>Nomor GoPay</p>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <span class="account-number">0812 3456 7890</span>
                            <button type="button" class="btn-copy" onclick="copyToClipboard('081234567890')">
                                <i class="fas fa-copy"></i>
                                Salin
                            </button>
                        </div>
                    </div>

                    <div class="payment-item">
                        <div class="payment-info">
                            <div class="payment-logo">DAN</div>
                            <div class="payment-detail">
                                <h5>Dana</h5>
                                <p>Nomor Dana</p>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <span class="account-number">0812 3456 7890</span>
                            <button type="button" class="btn-copy" onclick="copyToClipboard('081234567890')">
                                <i class="fas fa-copy"></i>
                                Salin
                            </button>
                        </div>
                    </div>

                    <div class="payment-item">
                        <div class="payment-info">
                            <div class="payment-logo">SHP</div>
                            <div class="payment-detail">
                                <h5>ShopeePay</h5>
                                <p>Nomor ShopeePay</p>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <span class="account-number">0812 3456 7890</span>
                            <button type="button" class="btn-copy" onclick="copyToClipboard('081234567890')">
                                <i class="fas fa-copy"></i>
                                Salin
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Informasi Pembayaran -->
                <div class="payment-details" style="margin-top: 2rem;">
                    <h4><i class="fas fa-info-circle"></i> Informasi Pembayaran</h4>
                    <div class="payment-item">
                        <div class="payment-info">
                            <div class="payment-logo">🏷️</div>
                            <div class="payment-detail">
                                <h5>Subtotal Produk</h5>
                                <p>Total harga sewa produk</p>
                            </div>
                        </div>
                        <div class="account-number" style="font-size: 1rem;">
                            Rp <span id="subtotalDisplay">0</span>
                        </div>
                    </div>

                    <div class="payment-item" style="background: linear-gradient(135deg, rgba(46,204,113,0.1) 0%, rgba(39,174,96,0.1) 100%);">
                        <div class="payment-info">
                            <div class="payment-logo" style="background: var(--secondary); color: white;">
                                💰
                            </div>
                            <div class="payment-detail">
                                <h5>Deposit (25% dari Subtotal)</h5>
                                <p>Uang muka yang akan dipotong saat pelunasan</p>
                            </div>
                        </div>
                        <div class="account-number" style="color: var(--secondary); font-size: 1.2rem;">
                            Rp <span id="depositDisplay">0</span>
                        </div>
                    </div>

                    <div class="payment-item" style="border-top: 2px solid var(--primary); margin-top: 1rem;">
                        <div class="payment-info">
                            <div class="payment-logo" style="background: var(--primary); color: white;">
                                💳
                            </div>
                            <div class="payment-detail">
                                <h5>Total yang Harus Dibayar</h5>
                                <p>Deposit (25% dari total sewa)</p>
                            </div>
                        </div>
                        <div class="account-number" style="font-size: 1.5rem; font-weight: 800; color: var(--primary);">
                            Rp <span id="totalBayarUtama">0</span>
                        </div>
                    </div>
                </div>

                <!-- Upload Bukti Deposit -->
                <div class="form-group full-width" id="uploadProof" style="display: none; margin-top: 2rem;">
                    <label class="form-label">
                        <i class="fas fa-receipt"></i>
                        Upload Bukti Pembayaran <span style="color: var(--danger);">*</span>
                    </label>
                    <p style="color: var(--gray); margin-bottom: 1rem;">
                        Jumlah yang harus dibayar: <strong style="color: var(--secondary); font-size: 1.2rem;" id="uploadTotalDisplay">Rp 0</strong>
                    </p>
                    <p style="color: var(--warning); margin-bottom: 1rem; font-size: 0.9rem;">
                        <i class="fas fa-info-circle"></i> Silakan upload bukti transfer sesuai dengan total yang harus dibayar di atas.
                    </p>

                    <div class="upload-area" onclick="document.getElementById('bukti_deposit').click()">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <p>Klik untuk upload bukti pembayaran</p>
                        <small>Format: JPG, PNG (Max. 2MB)</small>
                    </div>

                    <input type="file" id="bukti_deposit" name="bukti_deposit" accept="image/*" style="display: none;" required onchange="previewDeposit(this)">

                    <div class="preview-modern" id="depositPreview" style="display: none;">
                        <div class="preview-image">
                            <img id="preview-deposit-img" src="#" alt="Preview Bukti">
                        </div>
                        <div class="preview-info">
                            <div class="preview-name" id="depositFileName"></div>
                            <div class="preview-size" id="depositFileSize"></div>
                            <button type="button" class="btn-clear-modern" onclick="clearDepositFile()">
                                <i class="fas fa-trash-alt"></i>
                                Hapus File
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- STEP 3: Konfirmasi (ENHANCED VERSION) -->
        <div class="step-content" id="step3" style="display: none;">
            <div class="glass-card" data-aos="fade-up">
                <div class="card-header">
                    <i class="fas fa-check-circle" style="color: var(--secondary);"></i>
                    <div>
                        <h2>Konfirmasi Transaksi</h2>
                        <p>Pastikan data yang Anda masukkan sudah benar</p>
                    </div>
                </div>

                <div class="detail-grid">
                    <!-- Data Peminjam - Multi-line friendly -->
                    <div class="detail-box">
                        <h4><i class="fas fa-user"></i> Data Peminjam</h4>
                        <div class="detail-item">
                            <span class="detail-label">Nama Lengkap</span>
                            <span class="detail-value" id="confirmNama">-</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Nomor Telepon</span>
                            <span class="detail-value" id="confirmTelepon">-</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Email</span>
                            <span class="detail-value" id="confirmEmail">-</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">No. KTP</span>
                            <span class="detail-value" id="confirmIdentitas">-</span>
                        </div>
                    </div>

                    <!-- Alamat - Multi-line friendly -->
                    <div class="detail-box">
                        <h4><i class="fas fa-map-marker-alt"></i> Alamat Pengiriman</h4>
                        <div class="detail-item">
                            <span class="detail-label">Provinsi</span>
                            <span class="detail-value" id="confirmProvinsi">-</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Kabupaten/Kota</span>
                            <span class="detail-value" id="confirmKabupaten">-</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Kecamatan</span>
                            <span class="detail-value" id="confirmKecamatan">-</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Kelurahan/Desa</span>
                            <span class="detail-value" id="confirmKelurahan">-</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Alamat Lengkap</span>
                            <span class="detail-value" id="confirmAlamat">-</span>
                        </div>
                    </div>

                    <!-- Detail Produk yang Dipinjam - Enhanced -->
                    <div class="detail-box">
                        <h4><i class="fas fa-box"></i> Detail Produk yang Dipinjam</h4>
                        <div id="confirmProducts" class="confirm-product-list"></div>
                        <div class="confirm-subtotal-row" id="confirmSubtotalRow" style="display: none;">
                            <span class="confirm-subtotal-label">Total Subtotal</span>
                            <span class="confirm-subtotal-value" id="confirmSubtotalValue">Rp 0</span>
                        </div>
                    </div>

                    <!-- Pembayaran - Enhanced -->
                    <div class="detail-box">
                        <h4><i class="fas fa-credit-card"></i> Ringkasan Pembayaran</h4>
                        <div class="payment-summary-box">
                            <div class="payment-summary-row">
                                <span>Metode Pembayaran</span>
                                <strong id="confirmMetode">-</strong>
                            </div>
                            <div class="payment-summary-row">
                                <span>Subtotal Produk</span>
                                <span id="confirmSubtotalDetail">Rp 0</span>
                            </div>
                            <div class="payment-summary-row">
                                <span>Deposit (25% dari Subtotal)</span>
                                <span id="confirmDepositDetail" style="color: var(--secondary); font-weight: 700;">Rp 0</span>
                            </div>
                            <div class="payment-summary-row total">
                                <span>Total Dibayarkan Sekarang</span>
                                <span id="confirmTotalDetail" style="color: var(--secondary); font-size: 1.2rem;">Rp 0</span>
                            </div>
                        </div>
                        <div style="margin-top: 1rem; padding: 1rem; background: #e8f5e9; border-radius: 16px;">
                            <small style="display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-info-circle" style="color: var(--secondary);"></i>
                                <span style="color: #2e7d32;">Sisa pembayaran (pelunasan) akan dibayarkan setelah barang dikembalikan dalam kondisi baik.</span>
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ringkasan Informasi -->
            <div class="glass-card" data-aos="fade-up" data-aos-delay="100">
                <div class="summary-card">
                    <div class="summary-header">
                        <i class="fas fa-info-circle"></i>
                        Informasi Penting
                    </div>

                    <div class="summary-row">
                        <span>💰 Deposit (25%)</span>
                        <span>Dipotong dari total pembayaran saat pelunasan</span>
                    </div>
                    <div class="summary-row">
                        <span>📅 Durasi Sewa</span>
                        <span>Sesuai dengan tanggal yang dipilih</span>
                    </div>
                    <div class="summary-row total">
                        <span>💳 Pelunasan</span>
                        <span>Setelah barang dikembalikan dalam kondisi baik</span>
                    </div>

                    <div class="summary-badge">
                        <i class="fas fa-shield-alt fa-2x"></i>
                        <span>Pembayaran yang Anda lakukan sekarang adalah DEPOSIT (uang muka) sebesar 25% dari total harga sewa. Sisa pembayaran akan dilunasi setelah barang dikembalikan.</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-bar" data-aos="fade-up">
            <a href="{{ route('produk.list') }}" class="btn-modern btn-outline">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Produk
            </a>
            <div style="display: flex; gap: 1rem;">
                <button type="button" class="btn-modern btn-outline" id="prevStep" style="display: none;">
                    <i class="fas fa-arrow-left"></i>
                    Sebelumnya
                </button>
                <button type="button" class="btn-modern btn-primary-modern" id="nextStep">
                    Lanjutkan ke Pembayaran
                    <i class="fas fa-arrow-right"></i>
                </button>
                <button type="submit" class="btn-modern btn-success-modern" id="submitBtn" style="display: none;">
                    <i class="fas fa-check-circle"></i>
                    Konfirmasi & Selesaikan
                </button>
            </div>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Initialize AOS
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true,
        mirror: false
    });

    // Step Management
    let currentStep = 1;
    const totalSteps = 3;

    function updateStep(step) {
        const progress = ((step - 1) / (totalSteps - 1)) * 100;
        document.getElementById('stepProgress').style.width = progress + '%';

        document.querySelectorAll('.step').forEach((item, index) => {
            const stepNum = index + 1;
            item.classList.remove('active', 'completed');

            if (stepNum < step) {
                item.classList.add('completed');
                const circle = item.querySelector('.step-circle');
                circle.innerHTML = '<i class="fas fa-check"></i>';
            } else if (stepNum === step) {
                item.classList.add('active');
                const circle = item.querySelector('.step-circle');
                circle.innerHTML = `<span>${stepNum}</span>`;
            } else {
                const circle = item.querySelector('.step-circle');
                circle.innerHTML = `<span>${stepNum}</span>`;
            }
        });

        for (let i = 1; i <= totalSteps; i++) {
            document.getElementById(`step${i}`).style.display = i === step ? 'block' : 'none';
        }

        document.getElementById('prevStep').style.display = step === 1 ? 'none' : 'inline-flex';

        if (step === totalSteps) {
            document.getElementById('nextStep').style.display = 'none';
            document.getElementById('submitBtn').style.display = 'inline-flex';
            updateConfirmationData();
        } else {
            document.getElementById('nextStep').style.display = 'inline-flex';
            document.getElementById('submitBtn').style.display = 'none';
            document.getElementById('nextStep').innerHTML = step === 2 ?
                'Lanjutkan ke Konfirmasi <i class="fas fa-arrow-right"></i>' :
                'Lanjutkan ke Pembayaran <i class="fas fa-arrow-right"></i>';
        }

        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    document.getElementById('nextStep').addEventListener('click', function() {
        if (currentStep < totalSteps) {
            if (currentStep === 1 && !validateStep1()) return;
            if (currentStep === 2 && !validateStep2()) return;

            currentStep++;
            updateStep(currentStep);
        }
    });

    document.getElementById('prevStep').addEventListener('click', function() {
        if (currentStep > 1) {
            currentStep--;
            updateStep(currentStep);
        }
    });

    // Calculate total subtotal from all products
    function calculateTotalSubtotal() {
        let subtotal = 0;
        const productCards = document.querySelectorAll('.product-item');

        productCards.forEach((card, index) => {
            const harga = parseFloat(card.dataset.harga);
            const quantity = parseInt(document.getElementById(`quantity-${index}`).value);
            const durasi = parseInt(document.getElementById(`durasi-${index}`).value) || 1;

            subtotal += harga * quantity * durasi;
        });

        return subtotal;
    }

    // Update deposit based on subtotal (25% dari subtotal)
    function updateDepositAndTotal() {
        const subtotal = calculateTotalSubtotal();
        const deposit = Math.max(25000, Math.round(subtotal * 0.25));

        // Update display
        const subtotalDisplay = document.getElementById('subtotalDisplay');
        const depositDisplay = document.getElementById('depositDisplay');
        const totalBayarUtama = document.getElementById('totalBayarUtama');
        const uploadTotalDisplay = document.getElementById('uploadTotalDisplay');

        if (subtotalDisplay) subtotalDisplay.textContent = subtotal.toLocaleString('id-ID');
        if (depositDisplay) depositDisplay.textContent = deposit.toLocaleString('id-ID');
        if (totalBayarUtama) totalBayarUtama.textContent = deposit.toLocaleString('id-ID');
        if (uploadTotalDisplay) uploadTotalDisplay.textContent = 'Rp ' + deposit.toLocaleString('id-ID');

        // Update hidden input
        const depositAmount = document.getElementById('depositAmount');
        if (depositAmount) {
            depositAmount.value = deposit;
        }

        return { subtotal, deposit };
    }

    // Enhanced Update confirmation data
    function updateConfirmationData() {
        // Data Peminjam
        document.getElementById('confirmNama').textContent = document.querySelector('[name="nama_lengkap"]').value || '-';
        document.getElementById('confirmTelepon').textContent = document.querySelector('[name="no_telepon"]').value || '-';
        document.getElementById('confirmEmail').textContent = document.querySelector('[name="email"]').value || '-';
        document.getElementById('confirmIdentitas').textContent = document.querySelector('[name="no_identitas"]').value || '-';

        // Alamat (multi-line friendly)
        const provSelect = document.getElementById('provinsi');
        const kabSelect = document.getElementById('kabupaten');
        const kecSelect = document.getElementById('kecamatan');
        const kelSelect = document.getElementById('kelurahan');

        const prov = provSelect.selectedOptions[0]?.text || '';
        const kab = kabSelect.selectedOptions[0]?.text || '';
        const kec = kecSelect.selectedOptions[0]?.text || '';
        const kel = kelSelect.selectedOptions[0]?.text || '';
        const alamatLengkap = document.querySelector('[name="alamat_lengkap"]').value || '-';

        document.getElementById('confirmProvinsi').textContent = prov || '-';
        document.getElementById('confirmKabupaten').textContent = kab || '-';
        document.getElementById('confirmKecamatan').textContent = kec || '-';
        document.getElementById('confirmKelurahan').textContent = kel || '-';
        document.getElementById('confirmAlamat').textContent = alamatLengkap;

        // Metode Pembayaran
        const metodeMap = {
            'transfer': 'Transfer Bank',
            'va': 'Virtual Account',
            'ewallet': 'E-Wallet'
        };
        const metode = document.getElementById('metodePembayaran').value;
        document.getElementById('confirmMetode').textContent = metodeMap[metode] || '-';

        // Detail Produk
        const productsDiv = document.getElementById('confirmProducts');
        let productsHtml = '';
        let subtotal = 0;

        const productCards = document.querySelectorAll('.product-item');
        productCards.forEach((card, index) => {
            const productName = card.querySelector('h3').textContent;
            const harga = parseFloat(card.dataset.harga);
            const quantity = parseInt(document.getElementById(`quantity-${index}`).value);
            const durasi = parseInt(document.getElementById(`durasi-${index}`).value) || 1;
            const total = harga * quantity * durasi;
            subtotal += total;

            productsHtml += `
                <div class="confirm-product-item">
                    <div class="confirm-product-name">
                        <i class="fas fa-cube"></i>
                        ${productName}
                    </div>
                    <div class="confirm-product-detail">
                        <span class="confirm-product-qty">
                            <i class="fas fa-box"></i> ${quantity} unit
                        </span>
                        <span class="confirm-product-duration">
                            <i class="fas fa-calendar-alt"></i> ${durasi} hari
                        </span>
                        <span class="confirm-product-total">
                            Rp ${total.toLocaleString('id-ID')}
                        </span>
                    </div>
                </div>
            `;
        });
        productsDiv.innerHTML = productsHtml;

        // Show subtotal row if there are products
        const subtotalRow = document.getElementById('confirmSubtotalRow');
        const subtotalValueSpan = document.getElementById('confirmSubtotalValue');
        if (subtotalRow && subtotalValueSpan && productCards.length > 0) {
            subtotalRow.style.display = 'flex';
            subtotalValueSpan.textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
        }

        // Hitung deposit (25% dari subtotal)
        const deposit = Math.max(25000, Math.round(subtotal * 0.25));

        document.getElementById('confirmSubtotalDetail').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
        document.getElementById('confirmDepositDetail').textContent = 'Rp ' + deposit.toLocaleString('id-ID');
        document.getElementById('confirmTotalDetail').textContent = 'Rp ' + deposit.toLocaleString('id-ID');
    }

    // Quantity Functions
    function increaseQuantity(index, maxStok) {
        const quantityInput = document.getElementById(`quantity-${index}`);
        let currentValue = parseInt(quantityInput.value);

        if (currentValue < maxStok) {
            quantityInput.value = currentValue + 1;
            updateProductTotal(index);
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Stok Tidak Mencukupi',
                text: `Stok tersedia hanya ${maxStok} unit`,
                timer: 2000,
                showConfirmButton: false
            });
        }
    }

    function decreaseQuantity(index, maxStok) {
        const quantityInput = document.getElementById(`quantity-${index}`);
        let currentValue = parseInt(quantityInput.value);

        if (currentValue > 1) {
            quantityInput.value = currentValue - 1;
            updateProductTotal(index);
        }
    }

    // Calculate Duration
    function calculateDuration(index) {
        const tanggalMulai = document.getElementById(`tanggal_mulai-${index}`).value;
        const tanggalSelesai = document.getElementById(`tanggal_selesai-${index}`).value;

        if (tanggalMulai && tanggalSelesai) {
            const start = new Date(tanggalMulai);
            const end = new Date(tanggalSelesai);

            if (end <= start) {
                Swal.fire({
                    icon: 'error',
                    title: 'Tanggal Tidak Valid',
                    text: 'Tanggal selesai harus setelah tanggal mulai',
                    timer: 2000,
                    showConfirmButton: false
                });
                document.getElementById(`tanggal_selesai-${index}`).value = '';
                return;
            }

            const diffTime = Math.abs(end - start);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

            document.getElementById(`duration-${index}`).textContent = diffDays + ' Hari';
            document.getElementById(`durasi-${index}`).value = diffDays;

            updateProductTotal(index);
        }
    }

    // Update Product Total
    function updateProductTotal(index) {
        const productCard = document.querySelectorAll('.product-item')[index];
        const harga = parseFloat(productCard.dataset.harga);
        const quantity = parseInt(document.getElementById(`quantity-${index}`).value);
        const durasi = parseInt(document.getElementById(`durasi-${index}`).value) || 1;

        const total = harga * quantity * durasi;
        document.getElementById(`price-total-${index}`).textContent = 'Rp ' + total.toLocaleString('id-ID');

        // Update semua perhitungan
        updateDepositAndTotal();

        // Update konfirmasi jika sedang di step 3
        if (currentStep === 3) {
            updateConfirmationData();
        }
    }

    // Validasi Step 1
    function validateStep1() {
        const requiredFields = [
            'nama_lengkap', 'email', 'no_telepon', 'no_identitas',
            'provinsi', 'kabupaten', 'kecamatan', 'kelurahan',
            'alamat_lengkap'
        ];

        for (let field of requiredFields) {
            const input = document.querySelector(`[name="${field}"]`);
            if (!input || !input.value) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: `Harap lengkapi field ${field.replace('_', ' ')}`,
                    timer: 2000,
                    showConfirmButton: false
                });
                input?.focus();
                return false;
            }
        }

        const productCards = document.querySelectorAll('.product-item');
        for (let i = 0; i < productCards.length; i++) {
            const tanggalMulai = document.getElementById(`tanggal_mulai-${i}`);
            const tanggalSelesai = document.getElementById(`tanggal_selesai-${i}`);

            if (!tanggalMulai || !tanggalMulai.value || !tanggalSelesai || !tanggalSelesai.value) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Harap lengkapi tanggal mulai dan selesai untuk semua produk',
                    timer: 2000,
                    showConfirmButton: false
                });
                return false;
            }
        }

        const ktpFile = document.getElementById('foto_ktp').files;
        if (ktpFile.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Harap upload foto KTP',
                timer: 2000,
                showConfirmButton: false
            });
            return false;
        }

        if (!document.getElementById('termsAgree').checked) {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Harap setujui syarat dan ketentuan',
                timer: 2000,
                showConfirmButton: false
            });
            return false;
        }

        return true;
    }

    // Validasi Step 2
    function validateStep2() {
        const metode = document.getElementById('metodePembayaran').value;
        if (!metode) {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Harap pilih metode pembayaran',
                timer: 2000,
                showConfirmButton: false
            });
            return false;
        }

        const bukti = document.getElementById('bukti_deposit').files;
        if (bukti.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Harap upload bukti pembayaran',
                timer: 2000,
                showConfirmButton: false
            });
            return false;
        }

        return true;
    }

    // Preview KTP
    function previewKTP(input) {
        const preview = document.getElementById('ktpPreview');
        const previewImg = document.getElementById('preview-ktp-img');
        const fileName = document.getElementById('ktpFileName');
        const fileSize = document.getElementById('ktpFileSize');

        if (input.files && input.files[0]) {
            const file = input.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.style.display = 'flex';
            }

            reader.readAsDataURL(file);

            fileName.textContent = file.name;
            fileSize.textContent = (file.size / 1024).toFixed(2) + ' KB';
        } else {
            preview.style.display = 'none';
        }
    }

    // Preview Deposit
    function previewDeposit(input) {
        const preview = document.getElementById('depositPreview');
        const previewImg = document.getElementById('preview-deposit-img');
        const fileName = document.getElementById('depositFileName');
        const fileSize = document.getElementById('depositFileSize');

        if (input.files && input.files[0]) {
            const file = input.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.style.display = 'flex';
            }

            reader.readAsDataURL(file);

            fileName.textContent = file.name;
            fileSize.textContent = (file.size / 1024).toFixed(2) + ' KB';
        } else {
            preview.style.display = 'none';
        }
    }

    function clearKtpFile() {
        document.getElementById('foto_ktp').value = '';
        document.getElementById('ktpPreview').style.display = 'none';
    }

    function clearDepositFile() {
        document.getElementById('bukti_deposit').value = '';
        document.getElementById('depositPreview').style.display = 'none';
    }

    // API Wilayah Indonesia
    const api = 'https://www.emsifa.com/api-wilayah-indonesia/api';

    fetch(`${api}/provinces.json`)
        .then(res => res.json())
        .then(data => {
            let options = '<option value="">Pilih Provinsi</option>';
            data.forEach(p => {
                const selected = "{{ old('provinsi') }}" === p.id ? 'selected' : '';
                options += `<option value="${p.id}" ${selected}>${p.name}</option>`;
            });
            document.getElementById('provinsi').innerHTML = options;

            if ("{{ old('provinsi') }}") {
                document.getElementById('provinsi').dispatchEvent(new Event('change'));
            }
        });

    function resetKabupaten() {
        document.getElementById('kabupaten').innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';
        document.getElementById('kecamatan').innerHTML = '<option value="">Pilih Kecamatan</option>';
        document.getElementById('kelurahan').innerHTML = '<option value="">Pilih Kelurahan</option>';
    }

    function resetKecamatan() {
        document.getElementById('kecamatan').innerHTML = '<option value="">Pilih Kecamatan</option>';
        document.getElementById('kelurahan').innerHTML = '<option value="">Pilih Kelurahan</option>';
    }

    function resetKelurahan() {
        document.getElementById('kelurahan').innerHTML = '<option value="">Pilih Kelurahan</option>';
    }

    function loadKabupaten(provId) {
        resetKabupaten();

        if (provId) {
            fetch(`${api}/regencies/${provId}.json`)
                .then(res => res.json())
                .then(data => {
                    let options = '<option value="">Pilih Kabupaten/Kota</option>';
                    data.forEach(k => {
                        const selected = "{{ old('kabupaten') }}" === k.id ? 'selected' : '';
                        options += `<option value="${k.id}" ${selected}>${k.name}</option>`;
                    });
                    document.getElementById('kabupaten').innerHTML = options;
                });
        }
        updateFullAddress();
    }

    function loadKecamatan(kabId) {
        resetKecamatan();

        if (kabId) {
            fetch(`${api}/districts/${kabId}.json`)
                .then(res => res.json())
                .then(data => {
                    let options = '<option value="">Pilih Kecamatan</option>';
                    data.forEach(k => {
                        const selected = "{{ old('kecamatan') }}" === k.id ? 'selected' : '';
                        options += `<option value="${k.id}" ${selected}>${k.name}</option>`;
                    });
                    document.getElementById('kecamatan').innerHTML = options;
                });
        }
        updateFullAddress();
    }

    function loadKelurahan(kecId) {
        resetKelurahan();

        if (kecId) {
            fetch(`${api}/villages/${kecId}.json`)
                .then(res => res.json())
                .then(data => {
                    let options = '<option value="">Pilih Kelurahan</option>';
                    data.forEach(k => {
                        const selected = "{{ old('kelurahan') }}" === k.id ? 'selected' : '';
                        options += `<option value="${k.id}" ${selected}>${k.name}</option>`;
                    });
                    document.getElementById('kelurahan').innerHTML = options;
                });
        }
        updateFullAddress();
    }

    function updateFullAddress() {
        const prov = document.getElementById('provinsi').selectedOptions[0]?.text || '';
        const kab = document.getElementById('kabupaten').selectedOptions[0]?.text || '';
        const kec = document.getElementById('kecamatan').selectedOptions[0]?.text || '';
        const kel = document.getElementById('kelurahan').selectedOptions[0]?.text || '';

        if (prov && kab && kec && kel) {
            const alamatLengkap = `${kel}, ${kec}, ${kab}, ${prov}`;
            document.getElementById('alamat_lengkap').value = alamatLengkap;
        }
    }

    // Payment Method Selection
    document.querySelectorAll('.payment-method').forEach(card => {
        card.addEventListener('click', function() {
            document.querySelectorAll('.payment-method').forEach(c => c.classList.remove('selected'));
            this.classList.add('selected');

            const metode = this.dataset.payment;
            document.getElementById('metodePembayaran').value = metode;

            document.getElementById('transferDetails').style.display = metode === 'transfer' ? 'block' : 'none';
            document.getElementById('vaDetails').style.display = metode === 'va' ? 'block' : 'none';
            document.getElementById('ewalletDetails').style.display = metode === 'ewallet' ? 'block' : 'none';
            document.getElementById('uploadProof').style.display = 'block';
        });
    });

    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Nomor berhasil disalin',
                timer: 1500,
                showConfirmButton: false
            });
        }).catch(() => {
            const textarea = document.createElement('textarea');
            textarea.value = text;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            document.body.removeChild(textarea);
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Nomor berhasil disalin',
                timer: 1500,
                showConfirmButton: false
            });
        });
    }

    // Form submission - update semua durasi sebelum submit
    document.getElementById('transactionForm').addEventListener('submit', function(e) {
        // Update semua durasi dari tanggal yang dipilih sebelum submit
        const productCards = document.querySelectorAll('.product-item');

        productCards.forEach((card, index) => {
            const tanggalMulai = document.getElementById(`tanggal_mulai-${index}`).value;
            const tanggalSelesai = document.getElementById(`tanggal_selesai-${index}`).value;

            if (tanggalMulai && tanggalSelesai) {
                const start = new Date(tanggalMulai);
                const end = new Date(tanggalSelesai);
                const diffDays = Math.ceil((end - start) / (1000 * 60 * 60 * 24));

                const durasiInput = document.getElementById(`durasi-${index}`);
                if (durasiInput && diffDays > 0) {
                    durasiInput.value = diffDays;
                }
            }
        });

        if (currentStep !== totalSteps) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Harap selesaikan semua langkah terlebih dahulu',
                timer: 2000,
                showConfirmButton: false
            });
            return;
        }

        if (!validateStep1() || !validateStep2()) {
            e.preventDefault();
            return;
        }

        Swal.fire({
            title: 'Memproses Transaksi',
            text: 'Harap tunggu sebentar...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    });

    // Set minimum dates on load and calculate initial deposit
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toISOString().split('T')[0];
        document.querySelectorAll('input[type="date"][id^="tanggal_mulai"]').forEach(input => {
            input.min = today;
        });

        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        const tomorrowStr = tomorrow.toISOString().split('T')[0];
        document.querySelectorAll('input[type="date"][id^="tanggal_selesai"]').forEach(input => {
            input.min = tomorrowStr;
        });

        const oldMetode = "{{ old('metode_pembayaran') }}";
        if (oldMetode) {
            const paymentCard = document.querySelector(`[data-payment="${oldMetode}"]`);
            if (paymentCard) {
                paymentCard.click();
            }
        }

        updateDepositAndTotal();

        // Hitung ulang durasi untuk setiap produk yang sudah memiliki tanggal
        const productCards = document.querySelectorAll('.product-item');
        productCards.forEach((card, index) => {
            calculateDuration(index);
        });
    });
</script>
</body>
</html>
