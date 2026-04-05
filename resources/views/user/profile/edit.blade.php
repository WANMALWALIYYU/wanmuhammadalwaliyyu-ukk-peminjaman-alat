@extends('user.profile.index')
@section('profile-content')

<style>
    /* ===============================
       EDIT PROFILE STYLES
       =============================== */
    :root {
        --primary: #0b2c5d;
        --primary-dark: #081f3f;
        --primary-light: #1f3c88;
        --primary-soft: #e8f0fe;
        --accent-green: #10b981;
        --accent-blue: #3b82f6;
        --accent-red: #ef4444;
        --background: #ffffff;
        --background-sec: #f8fafc;
        --text-color: #0f172a;
        --text-color-sec: #334155;
        --text-muted: #64748b;
        --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
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

    /* Alert Messages */
    .alert-info {
        background: var(--primary-soft);
        border-left: 4px solid var(--primary);
        padding: 1rem;
        border-radius: var(--radius-md);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: var(--primary);
    }

    .alert-info i {
        font-size: 1.25rem;
    }

    .alert-error {
        background: #fee2e2;
        border-left: 4px solid var(--accent-red);
        padding: 1rem;
        border-radius: var(--radius-md);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: #991b1b;
    }

    /* Form Container */
    .edit-profile-container {
        background: var(--background);
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        border: 1px solid rgba(11, 44, 93, 0.08);
    }

    /* Form Sections */
    .form-section {
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .form-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .section-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-title i {
        font-size: 1.1rem;
    }

    /* Form Inputs */
    .form-group {
        margin-bottom: 1.25rem;
    }

    .form-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--text-muted);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 600;
    }

    .form-label i {
        width: 26px;
        height: 26px;
        background: var(--primary-soft);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        color: var(--primary);
        font-size: 0.8rem;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #e2e8f0;
        border-radius: var(--radius-md);
        font-size: 0.9rem;
        transition: var(--transition);
        background: var(--background);
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-light);
        box-shadow: 0 0 0 3px rgba(11, 44, 93, 0.1);
    }

    .form-control:disabled {
        background: var(--background-sec);
        cursor: not-allowed;
    }

    .form-text {
        font-size: 0.7rem;
        color: var(--text-muted);
        margin-top: 0.25rem;
    }

    /* Photo Section */
    .photo-section {
        margin-bottom: 1.5rem;
        padding: 1rem;
        background: var(--background-sec);
        border-radius: var(--radius-md);
    }

    .current-photo {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .current-photo-img {
        width: 120px;
        height: 120px;
        border-radius: var(--radius-full);
        object-fit: cover;
        border: 3px solid var(--primary-light);
        box-shadow: var(--shadow-md);
    }

    .current-photo-info {
        font-size: 0.75rem;
        color: var(--text-muted);
        text-align: center;
    }

    .btn-delete-photo {
        background: none;
        border: none;
        color: var(--accent-red);
        font-size: 0.75rem;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.25rem 0.5rem;
        border-radius: var(--radius-sm);
        transition: var(--transition);
    }

    .btn-delete-photo:hover {
        background: rgba(239, 68, 68, 0.1);
    }

    .upload-section {
        border: 2px dashed #e2e8f0;
        border-radius: var(--radius-md);
        padding: 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: var(--transition);
        margin-top: 1rem;
    }

    .upload-section:hover {
        border-color: var(--primary-light);
        background: var(--primary-soft);
    }

    .upload-section i {
        font-size: 2rem;
        color: var(--primary-light);
        margin-bottom: 0.5rem;
    }

    .upload-section p {
        margin-bottom: 0.25rem;
        font-size: 0.875rem;
    }

    .upload-section small {
        font-size: 0.7rem;
        color: var(--text-muted);
    }

    .file-info {
        margin-top: 0.5rem;
        font-size: 0.75rem;
        color: var(--text-muted);
        text-align: center;
    }

    .photo-preview {
        margin-top: 1rem;
        text-align: center;
    }

    .photo-preview img {
        width: 100px;
        height: 100px;
        border-radius: var(--radius-full);
        object-fit: cover;
        border: 2px solid var(--primary-light);
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 1rem;
        border-top: 1px solid #e2e8f0;
    }

    .btn-back {
        background: var(--background-sec);
        color: var(--text-color-sec);
        border: 1px solid #e2e8f0;
        padding: 0.7rem 1.5rem;
        border-radius: var(--radius-full);
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        transition: var(--transition);
        text-decoration: none;
    }

    .btn-back:hover {
        background: #e2e8f0;
        transform: translateX(-2px);
    }

    .btn-save {
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        color: white;
        border: none;
        padding: 0.7rem 1.75rem;
        border-radius: var(--radius-full);
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        cursor: pointer;
        transition: var(--transition);
    }

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .action-buttons {
            flex-direction: column;
        }
        .btn-back, .btn-save {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="content-header">
    <div>
        <h2>Edit Profil</h2>
        <p class="text-muted-light">Perbarui informasi pribadi dan keamanan akun Anda</p>
    </div>
</div>

<div class="edit-profile-container">
    <!-- Alert Messages -->
    @if(session('info'))
        <div class="alert-info">
            <i class="fas fa-info-circle"></i>
            <span>{{ session('info') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="alert-error">
            <i class="fas fa-exclamation-triangle"></i>
            <span>{{ $errors->first() }}</span>
        </div>
    @endif

    <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Informasi Dasar -->
        <div class="form-section">
            <div class="section-title">
                <i class="fas fa-user-circle"></i>
                Informasi Dasar
            </div>

            <!-- Nama Lengkap -->
            <div class="form-group">
                <div class="form-label">
                    <i class="fas fa-user"></i>
                    Nama Lengkap <span class="text-danger">*</span>
                </div>
                <input type="text"
                       class="form-control @error('name') is-invalid @enderror"
                       name="name"
                       value="{{ old('name', $user->name) }}"
                       placeholder="Masukkan nama lengkap"
                       required>
                @error('name')
                    <div class="invalid-feedback d-block text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Nomor HP -->
            <div class="form-group">
                <div class="form-label">
                    <i class="fas fa-phone-alt"></i>
                    Nomor HP
                </div>
                <input type="text"
                       class="form-control @error('nomor_hp') is-invalid @enderror"
                       name="nomor_hp"
                       value="{{ old('nomor_hp', $user->nomor_hp) }}"
                       placeholder="Contoh: 081234567890">
                @error('nomor_hp')
                    <div class="invalid-feedback d-block text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Alamat -->
            <div class="form-group">
                <div class="form-label">
                    <i class="fas fa-map-marker-alt"></i>
                    Alamat
                </div>
                <textarea class="form-control @error('alamat') is-invalid @enderror"
                          name="alamat"
                          placeholder="Masukkan alamat lengkap"
                          rows="3">{{ old('alamat', $user->alamat) }}</textarea>
                @error('alamat')
                    <div class="invalid-feedback d-block text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Email & Keamanan -->
        <div class="form-section">
            <div class="section-title">
                <i class="fas fa-envelope"></i>
                Email & Keamanan
            </div>

            <!-- Email -->
            <div class="form-group">
                <div class="form-label">
                    <i class="fas fa-envelope"></i>
                    Email
                </div>
                <input type="email"
                       class="form-control @error('email') is-invalid @enderror"
                       name="email"
                       value="{{ old('email', $user->email) }}"
                       placeholder="Masukkan email baru">
                <div class="form-text">
                    <i class="fas fa-info-circle"></i>
                    Jika mengubah email, Anda akan menerima email verifikasi untuk mengkonfirmasi perubahan.
                </div>
                @error('email')
                    <div class="invalid-feedback d-block text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <div class="form-label">
                    <i class="fas fa-lock"></i>
                    Password Baru
                </div>
                <input type="password"
                       class="form-control @error('password') is-invalid @enderror"
                       name="password"
                       placeholder="Masukkan password baru (minimal 8 karakter)">
                <div class="form-text">
                    <i class="fas fa-info-circle"></i>
                    Kosongkan jika tidak ingin mengubah password. Jika mengisi, Anda akan menerima email verifikasi.
                </div>
                @error('password')
                    <div class="invalid-feedback d-block text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Konfirmasi Password -->
            <div class="form-group">
                <div class="form-label">
                    <i class="fas fa-lock"></i>
                    Konfirmasi Password Baru
                </div>
                <input type="password"
                       class="form-control"
                       name="password_confirmation"
                       placeholder="Konfirmasi password baru">
            </div>

            <!-- Password Saat Ini -->
            <div class="form-group" id="current-password-group" style="display: none;">
                <div class="form-label">
                    <i class="fas fa-key"></i>
                    Password Saat Ini <span class="text-danger">*</span>
                </div>
                <input type="password"
                       class="form-control @error('current_password') is-invalid @enderror"
                       name="current_password"
                       placeholder="Masukkan password saat ini untuk konfirmasi">
                @error('current_password')
                    <div class="invalid-feedback d-block text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Foto Profil -->
        <div class="form-section">
            <div class="section-title">
                <i class="fas fa-camera"></i>
                Foto Profil
            </div>

            <div class="photo-section">
                <!-- Foto Saat Ini -->
                <div class="current-photo">
                    @if($user->foto && Storage::disk('public')->exists($user->foto))
                        <img src="{{ asset('storage/' . $user->foto) }}"
                             alt="Foto Profil"
                             class="current-photo-img"
                             id="current-photo-img">
                        <div class="current-photo-info">
                            <small>Foto saat ini</small>
                            <button type="button" class="btn-delete-photo" id="btn-delete-photo">
                                <i class="fas fa-trash-alt"></i> Hapus Foto
                            </button>
                        </div>
                    @else
                        <div class="current-photo-info">
                            <div class="current-photo-img" style="background: var(--primary-soft); display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-user-circle" style="font-size: 4rem; color: var(--primary-light);"></i>
                            </div>
                            <small>Belum ada foto profil</small>
                        </div>
                    @endif
                </div>

                <!-- Hidden input untuk delete foto -->
                <input type="hidden" name="delete_foto" id="delete_foto" value="0">

                <!-- Upload Foto Baru -->
                <div class="upload-section" onclick="document.getElementById('foto').click();">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <p>Klik untuk upload foto baru</p>
                    <small>Format: JPG, PNG, GIF, WEBP (Max 2MB)</small>
                </div>
                <input type="file"
                       id="foto"
                       name="foto"
                       accept="image/*"
                       class="d-none @error('foto') is-invalid @enderror"
                       onchange="previewPhoto(this)">
                <div class="file-info" id="file-info">
                    <i class="far fa-clock"></i> Belum ada file dipilih
                </div>

                <!-- Preview Foto Baru -->
                <div class="photo-preview" id="photo-preview" style="display: none;">
                    <p class="small text-muted mb-2">Preview foto baru:</p>
                    <img id="preview-img" src="" alt="Preview">
                </div>

                @error('foto')
                    <div class="invalid-feedback d-block text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="{{ route('user.profile') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
            <button type="submit" class="btn-save">
                <i class="fas fa-save"></i>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<script>
    // Show/hide current password field when password field is filled
    const passwordInput = document.querySelector('input[name="password"]');
    const currentPasswordGroup = document.getElementById('current-password-group');

    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            if (this.value.length > 0) {
                currentPasswordGroup.style.display = 'block';
                document.querySelector('input[name="current_password"]').required = true;
            } else {
                currentPasswordGroup.style.display = 'none';
                document.querySelector('input[name="current_password"]').required = false;
            }
        });
    }

    // Preview photo function
    function previewPhoto(input) {
        const fileInfo = document.getElementById('file-info');
        const photoPreview = document.getElementById('photo-preview');
        const previewImg = document.getElementById('preview-img');
        const deletePhotoBtn = document.getElementById('btn-delete-photo');
        const deleteFotoInput = document.getElementById('delete_foto');

        if (input.files && input.files[0]) {
            const file = input.files[0];
            fileInfo.innerHTML = `<i class="fas fa-check-circle text-success"></i> File dipilih: ${file.name}`;

            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                photoPreview.style.display = 'block';
            }
            reader.readAsDataURL(file);

            // Reset delete flag when new photo selected
            deleteFotoInput.value = '0';

            // Show message that current photo will be replaced
            if (deletePhotoBtn) {
                const currentPhotoInfo = document.querySelector('.current-photo-info');
                if (currentPhotoInfo) {
                    const replaceMsg = document.createElement('small');
                    replaceMsg.className = 'text-warning d-block mt-1';
                    replaceMsg.innerHTML = '<i class="fas fa-arrows-rotate"></i> Foto akan diganti dengan yang baru';
                    if (!document.querySelector('.replace-message')) {
                        replaceMsg.classList.add('replace-message');
                        currentPhotoInfo.appendChild(replaceMsg);
                    }
                }
            }
        } else {
            fileInfo.innerHTML = '<i class="far fa-clock"></i> Belum ada file dipilih';
            photoPreview.style.display = 'none';
        }
    }

    // Delete photo button handler
    document.getElementById('btn-delete-photo')?.addEventListener('click', function(e) {
        e.preventDefault();
        const deleteFotoInput = document.getElementById('delete_foto');
        const currentPhotoImg = document.getElementById('current-photo-img');
        const currentPhotoInfo = document.querySelector('.current-photo-info');
        const fileInput = document.getElementById('foto');

        if (confirm('Apakah Anda yakin ingin menghapus foto profil?')) {
            deleteFotoInput.value = '1';

            // Hide current photo
            if (currentPhotoImg) {
                currentPhotoImg.style.display = 'none';
            }

            // Add message
            if (currentPhotoInfo) {
                const deleteMsg = document.createElement('small');
                deleteMsg.className = 'text-danger d-block mt-1';
                deleteMsg.innerHTML = '<i class="fas fa-trash-alt"></i> Foto akan dihapus saat disimpan';
                if (!document.querySelector('.delete-message')) {
                    deleteMsg.classList.add('delete-message');
                    currentPhotoInfo.appendChild(deleteMsg);
                }
            }

            // Clear file input
            if (fileInput) {
                fileInput.value = '';
                document.getElementById('file-info').innerHTML = '<i class="far fa-clock"></i> Belum ada file dipilih';
                document.getElementById('photo-preview').style.display = 'none';
            }

            this.style.opacity = '0.5';
            this.disabled = true;
        }
    });
</script>

@endsection
