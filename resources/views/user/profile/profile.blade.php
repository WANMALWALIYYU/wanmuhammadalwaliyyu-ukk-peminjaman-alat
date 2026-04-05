@extends('user.profile.index')
@section('profile-content')

<style>
    /* ===============================
       MODERN PROFILE CONTENT STYLES
       =============================== */
    :root {
        --primary: #0b2c5d;
        --primary-dark: #081f3f;
        --primary-light: #1f3c88;
        --primary-soft: #e8f0fe;
        --accent-green: #10b981;
        --accent-blue: #3b82f6;
        --accent-purple: #8b5cf6;
        --accent-orange: #f59e0b;
        --accent-red: #ef4444;
        --background: #ffffff;
        --background-sec: #f8fafc;
        --text-color: #0f172a;
        --text-color-sec: #334155;
        --text-muted: #64748b;
        --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        --radius-sm: 0.5rem;
        --radius-md: 1rem;
        --radius-lg: 1.5rem;
        --radius-full: 9999px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Content Header */
    .content-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .content-header h2 {
        font-size: 1.75rem;
        font-weight: 700;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        background-clip: text;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 0.25rem;
    }

    .text-muted-light {
        color: var(--text-muted);
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .btn-edit-profile {
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        color: white;
        border: none;
        padding: 0.75rem 1.75rem;
        border-radius: var(--radius-full);
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        cursor: pointer;
        transition: var(--transition);
        box-shadow: var(--shadow-sm);
        font-size: 0.875rem;
        text-decoration: none;
    }

    .btn-edit-profile:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        background: linear-gradient(135deg, var(--primary-dark), var(--primary));
    }

    /* Profile Info Grid */
    .profile-info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .info-item {
        background: var(--background);
        padding: 1.25rem;
        border-radius: var(--radius-md);
        transition: var(--transition);
        border: 1px solid rgba(11, 44, 93, 0.08);
        box-shadow: var(--shadow-sm);
    }

    .info-item.full-width {
        grid-column: span 2;
    }

    .info-item:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        border-color: var(--primary-soft);
    }

    .info-label {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--text-muted);
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-label i {
        width: 28px;
        height: 28px;
        background: var(--primary-soft);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        color: var(--primary);
        font-size: 0.8rem;
    }

    .info-value {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-color);
        word-break: break-word;
        padding-left: 0.25rem;
    }

    .info-value.small {
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--text-color-sec);
    }

    /* Badge Status */
    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.35rem 1rem;
        border-radius: var(--radius-full);
        font-size: 0.75rem;
        font-weight: 600;
    }

    .badge-status.admin {
        background: linear-gradient(135deg, #1e293b, #0f172a);
        color: white;
    }

    .badge-status.petugas {
        background: linear-gradient(135deg, var(--accent-blue), #2563eb);
        color: white;
    }

    .badge-status.user {
        background: linear-gradient(135deg, var(--accent-green), #059669);
        color: white;
    }

    /* Stats Cards */
    .stats-container {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin: 2rem 0;
    }

    .stat-card {
        background: var(--background);
        padding: 1.25rem;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: var(--transition);
        border: 1px solid rgba(11, 44, 93, 0.08);
        box-shadow: var(--shadow-sm);
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .stat-icon.green {
        background: rgba(16, 185, 129, 0.1);
        color: var(--accent-green);
    }

    .stat-icon.blue {
        background: rgba(59, 130, 246, 0.1);
        color: var(--accent-blue);
    }

    .stat-icon.yellow {
        background: rgba(245, 158, 11, 0.1);
        color: var(--accent-orange);
    }

    .stat-icon.purple {
        background: rgba(139, 92, 246, 0.1);
        color: var(--accent-purple);
    }

    .stat-content h4 {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--text-color);
        line-height: 1.2;
    }

    .stat-content p {
        font-size: 0.7rem;
        color: var(--text-muted);
        font-weight: 500;
        margin-top: 0.25rem;
    }

    /* Bio Section */
    .bio-section {
        background: linear-gradient(135deg, var(--background-sec), var(--background));
        padding: 1.5rem;
        border-radius: var(--radius-lg);
        margin: 2rem 0;
        border: 1px solid rgba(11, 44, 93, 0.08);
        transition: var(--transition);
    }

    .bio-section:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .bio-section h4 {
        color: var(--primary);
        margin-bottom: 1rem;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 600;
    }

    .bio-section h4 i {
        background: var(--primary-soft);
        padding: 0.5rem;
        border-radius: var(--radius-sm);
        color: var(--primary);
        font-size: 0.9rem;
    }

    .bio-section p {
        color: var(--text-color-sec);
        line-height: 1.6;
        font-size: 0.875rem;
    }

    .btn-add-bio {
        margin-top: 1rem;
        background: transparent;
        border: 1px dashed var(--primary-light);
        color: var(--primary);
        padding: 0.4rem 1.2rem;
        border-radius: var(--radius-full);
        font-size: 0.75rem;
        font-weight: 500;
        cursor: pointer;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-add-bio:hover {
        background: var(--primary-soft);
        border-color: var(--primary);
    }

    /* Verification Wrapper */
    .verification-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 1.5rem 0;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .verification-badge {
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        color: white;
        padding: 0.45rem 1.2rem;
        border-radius: var(--radius-full);
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: var(--shadow-sm);
    }

    .security-badge {
        color: var(--text-muted);
        font-size: 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Recent Activities */
    .recent-activities {
        margin-top: 2rem;
        background: var(--background);
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        border: 1px solid rgba(11, 44, 93, 0.08);
    }

    .recent-activities h5 {
        color: var(--primary-dark);
        margin-bottom: 1rem;
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 600;
    }

    .activity-list {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .activity-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: var(--background-sec);
        border-radius: var(--radius-sm);
        transition: var(--transition);
        border: 1px solid rgba(11, 44, 93, 0.03);
    }

    .activity-item:hover {
        transform: translateX(5px);
        background: var(--background);
        box-shadow: var(--shadow-sm);
        border-color: var(--primary-soft);
    }

    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: var(--radius-sm);
        background: var(--primary-soft);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        font-size: 1rem;
    }

    .activity-content {
        flex: 1;
    }

    .activity-text {
        font-weight: 600;
        color: var(--text-color);
        margin-bottom: 0.25rem;
        font-size: 0.875rem;
    }

    .activity-time {
        font-size: 0.7rem;
        color: var(--text-muted);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .stats-container {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .profile-info-grid {
            grid-template-columns: 1fr;
        }
        .info-item.full-width {
            grid-column: span 1;
        }
        .stats-container {
            grid-template-columns: 1fr;
        }
        .content-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .btn-edit-profile {
            width: 100%;
            justify-content: center;
        }
        .verification-wrapper {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<div class="content-header">
    <div>
        <h2>Profil Saya</h2>
        <p class="text-muted-light">Kelola informasi pribadi dan data akun Anda</p>
    </div>
    <a href="{{ route('user.profile.edit') }}" class="btn-edit-profile">
        <i class="fas fa-pen-fancy"></i>
        Update Profil
    </a>
</div>

<!-- Informasi profile grid -->
<div class="profile-info-grid">
    <div class="info-item">
        <div class="info-label"><i class="fas fa-user-circle"></i> Nama Lengkap</div>
        <div class="info-value small">{{ Auth::user()->name ?? 'Belum diisi - Segera Update Profile' }}</div>
    </div>
    <div class="info-item">
        <div class="info-label"><i class="fas fa-envelope"></i> Email</div>
        <div class="info-value small">{{ Auth::user()->email ?? 'Belum diisi - Segera Update Profile' }}</div>
    </div>
    <div class="info-item">
        <div class="info-label"><i class="fas fa-phone-alt"></i> Nomor HP</div>
        <div class="info-value small">{{ Auth::user()->nomor_hp ?? 'Belum diisi - Segera Update Profile' }}</div>
    </div>
    <div class="info-item">
        <div class="info-label"><i class="fas fa-calendar-alt"></i> Bergabung Sejak</div>
        <div class="info-value small">{{ Auth::user()->created_at ? Auth::user()->created_at->translatedFormat('d F Y') : 'Belum tersedia' }}</div>
    </div>
    <div class="info-item">
        <div class="info-label"><i class="fas fa-tag"></i> Status Akun</div>
        <div class="info-value">
            @if(Auth::user()->level == 'admin')
                <span class="badge-status admin"><i class="fas fa-shield-alt"></i> Administrator</span>
            @elseif(Auth::user()->level == 'petugas')
                <span class="badge-status petugas"><i class="fas fa-user-nurse"></i> Petugas Medis</span>
            @else
                <span class="badge-status user"><i class="fas fa-user"></i> Pasien</span>
            @endif
        </div>
    </div>
    <div class="info-item">
        <div class="info-label"><i class="fas fa-clock"></i> Terakhir Online</div>
        <div class="info-value">{{ Auth::user()->last_seen ? \Carbon\Carbon::parse(Auth::user()->last_seen)->diffForHumans() : 'Belum tersedia' }}</div>
    </div>
    <div class="info-item full-width">
        <div class="info-label"><i class="fas fa-map-marker-alt"></i> Alamat</div>
        <div class="info-value small">{{ Auth::user()->alamat ?? 'Belum diisi - Segera Update Profile' }}</div>
    </div>
</div>

<!-- Stats Cards -->
<div class="stats-container">
    <div class="stat-card">
        <div class="stat-icon green">
            <i class="fas fa-calendar-check"></i>
        </div>
        <div class="stat-content">
            <h4>{{ Auth::user()->created_at ? Auth::user()->created_at->translatedFormat('d M Y') : '-' }}</h4>
            <p>Terdaftar sejak</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue">
            <i class="fas fa-shopping-bag"></i>
        </div>
        <div class="stat-content">
            <h4>0</h4>
            <p>Total Transaksi</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon yellow">
            <i class="fas fa-star"></i>
        </div>
        <div class="stat-content">
            <h4>0</h4>
            <p>Rating</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon purple">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-content">
            <h4>{{ Auth::user()->email_verified_at ? 'Terverifikasi' : 'Belum' }}</h4>
            <p>Verifikasi Email</p>
        </div>
    </div>
</div>

<!-- Bio Section -->
<div class="bio-section">
    <h4>
        <i class="fas fa-address-card"></i>
        Tentang Saya
    </h4>
    <p>{{ Auth::user()->bio ?? 'Belum ada deskripsi. Tambahkan bio untuk memperkenalkan diri Anda.' }}</p>
    @if(!isset(Auth::user()->bio) || !Auth::user()->bio)
        <button class="btn-add-bio" onclick="alert('Fitur tambah bio akan segera hadir')">
            <i class="fas fa-plus-circle"></i> Tambah Bio
        </button>
    @endif
</div>

<!-- Verification Badge -->
<div class="verification-wrapper">
    <span class="verification-badge">
        <i class="fas fa-check-circle"></i>
        {{ Auth::user()->email_verified_at ? 'Akun Terverifikasi' : 'Verifikasi Email' }}
    </span>
    <span class="security-badge">
        <i class="fas fa-shield-alt"></i> Data terenkripsi & aman
    </span>
</div>

<!-- Recent Activities -->
<div class="recent-activities">
    <h5>
        <i class="fas fa-history"></i>
        Aktivitas Terkini
    </h5>
    <div class="activity-list">
        <div class="activity-item">
            <div class="activity-icon">
                <i class="fas fa-sign-in-alt"></i>
            </div>
            <div class="activity-content">
                <div class="activity-text">Login terakhir</div>
                <div class="activity-time">
                    <i class="far fa-clock"></i>
                    {{ Auth::user()->last_seen ? \Carbon\Carbon::parse(Auth::user()->last_seen)->diffForHumans() : 'Belum ada aktivitas' }}
                </div>
            </div>
        </div>
        <div class="activity-item">
            <div class="activity-icon">
                <i class="fas fa-user-edit"></i>
            </div>
            <div class="activity-content">
                <div class="activity-text">Profil diperbarui</div>
                <div class="activity-time">
                    <i class="far fa-clock"></i>
                    {{ Auth::user()->updated_at ? Auth::user()->updated_at->diffForHumans() : 'Belum ada perubahan' }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
