<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\PengembalianController as AdminPengembalianController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Admin\PengirimanController as AdminPengirimanController;
use App\Http\Controllers\Admin\TransaksiController as AdminTransaksiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboardController;
use App\Http\Controllers\Petugas\PeminjamanController;
use App\Http\Controllers\Petugas\PengembalianController as PetugasPengembalianController;
use App\Http\Controllers\Petugas\PengirimanController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\User\PengembalianController as UserPengembalianController;
use App\Http\Controllers\User\UserPengirimanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==================== PUBLIC ROUTES ====================
Route::get('/', [UserController::class, 'index'])->name('landing-page');
Route::get('/produk', [UserController::class, 'produk'])->name('produk.list');
Route::get('/produk/{id}', [UserController::class, 'detail'])->name('produk.detail');

// ==================== AUTH ROUTES ====================
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'storeLogin'])->name('login-store');

Route::get('/registrasi', [AuthController::class, 'registrasi'])->name('registrasi');
Route::post('/registrasi', [AuthController::class, 'storeRegistrasi'])->name('registrasi-store');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==================== EMAIL VERIFICATION ROUTES ====================
Route::get('/email/verify', function () {
    return view('authentication.verifikasi', [
        'email' => auth()->user()->email ?? ''
    ]);
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $user = $request->user();

    $request->fulfill();

    \App\Models\ActivityLog::create([
        'user_id' => $user->id,
        'user_name' => $user->name,
        'user_email' => $user->email,
        'user_level' => $user->level,
        'action' => 'verify_email',
        'module' => 'auth',
        'description' => "User {$user->name} ({$user->email}) berhasil memverifikasi email",
        'ip_address' => request()->ip(),
        'user_agent' => request()->userAgent(),
        'status' => 'success',
    ]);

    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login')
        ->with('success', 'Email berhasil diverifikasi! Silakan login dengan akun Anda.');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', [AuthController::class, 'resendVerification'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

Route::get('/email/verified', [AuthController::class, 'verified'])
    ->name('verification.verified');

// ==================== ADMIN ROUTES ====================
Route::prefix('admin')->middleware(['auth', 'check.level:admin'])->group(function() {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Kategori Management
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
    Route::post('/kategori/create', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/kategori/{id}/update', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{id}/delete-image', [KategoriController::class, 'deleteImage'])->name('kategori.delete-image');
    Route::delete('/kategori/{id}/destroy', [KategoriController::class, 'destroy'])->name('kategori.destroy');
    Route::post('/kategori/{id}/restore', [KategoriController::class, 'restore'])->name('kategori.restore');
    Route::delete('/kategori/{id}/force-delete', [KategoriController::class, 'forceDelete'])->name('kategori.forceDelete');

    // Produk Management
    Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
    Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
    Route::post('/produk/create', [ProdukController::class, 'store'])->name('produk.store');
    Route::get('/produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::put('/produk/{id}/update', [ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{id}/destroy', [ProdukController::class, 'destroy'])->name('produk.destroy');
    Route::post('/produk/{id}/restore', [ProdukController::class, 'restore'])->name('produk.restore');
    Route::delete('/produk/{id}/force-delete', [ProdukController::class, 'forceDelete'])->name('produk.forceDelete');

    // User Management
    Route::get('/user', [AdminUserController::class, 'index'])->name('user.index');

    // Transaksi Management
    Route::get('/transaksi', [AdminTransaksiController::class, 'index'])->name('admin.transaksi.index');
    Route::get('/transaksi/{id}', [AdminTransaksiController::class, 'show'])->name('admin.transaksi.show');
    Route::get('/transaksi-stats', [AdminTransaksiController::class, 'getStats'])->name('admin.transaksi.stats');
    Route::get('/transaksi-export', [AdminTransaksiController::class, 'export'])->name('admin.transaksi.export');

    // Pengiriman Management
    Route::get('/pengiriman', [AdminPengirimanController::class, 'index'])->name('admin.pengiriman.index');
    Route::get('/pengiriman/{id}', [AdminPengirimanController::class, 'show'])->name('admin.pengiriman.show');
    Route::get('/pengiriman-stats', [AdminPengirimanController::class, 'getStats'])->name('admin.pengiriman.stats');
    Route::get('/pengiriman-export', [AdminPengirimanController::class, 'export'])->name('admin.pengiriman.export');
    Route::get('/pengiriman-chart', [AdminPengirimanController::class, 'chartData'])->name('admin.pengiriman.chart');

    // Pengembalian Management
    Route::get('/pengembalian', [AdminPengembalianController::class, 'index'])->name('admin.pengembalian.index');
    Route::get('/pengembalian/{id}', [AdminPengembalianController::class, 'show'])->name('admin.pengembalian.show');
    Route::get('/pengembalian-export', [AdminPengembalianController::class, 'export'])->name('admin.pengembalian.export');
    Route::get('/pengembalian-stats', [AdminPengembalianController::class, 'getStats'])->name('admin.pengembalian.stats');


    // Activity Logs
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
    Route::get('/activity-logs/{id}', [ActivityLogController::class, 'show'])->name('activity-logs.show');
    Route::delete('/activity-logs/{id}', [ActivityLogController::class, 'destroy'])->name('activity-logs.destroy');
    Route::post('/activity-logs/clear', [ActivityLogController::class, 'clear'])->name('activity-logs.clear');
});

// ==================== PETUGAS ROUTES ====================
Route::prefix('petugas')->middleware(['auth', 'check.level:petugas,admin'])->group(function() {
    // Dashboard Petugas
    Route::get('/dashboard', [PetugasDashboardController::class, 'index'])->name('petugas.dashboard');
    Route::get('/dashboard/stats', [PetugasDashboardController::class, 'getDashboardStats'])->name('petugas.dashboard.stats');

    // Peminjaman Management (Approve/Reject/View)
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('petugas.peminjaman');
    Route::get('/transaksi/{id}', [PeminjamanController::class, 'detail'])->name('petugas.peminjaman.detail');
    Route::post('/peminjaman/approve/{id}', [PeminjamanController::class, 'approve'])->name('petugas.peminjaman.approve');
    Route::post('/peminjaman/reject/{id}', [PeminjamanController::class, 'reject'])->name('petugas.peminjaman.reject');

    // Status Update Routes
    Route::post('/transaksi/{id}/update-pengiriman', [PeminjamanController::class, 'updateStatusPengiriman'])->name('petugas.transaksi.update-pengiriman');
    Route::post('/transaksi/{id}/mark-dikembalikan', [PeminjamanController::class, 'markAsDikembalikan'])->name('petugas.transaksi.mark-dikembalikan');
    Route::post('/transaksi/{id}/complete', [PeminjamanController::class, 'completeTransaksi'])->name('petugas.transaksi.complete');

    // Pengiriman Management
    Route::prefix('pengiriman')->group(function() {
        Route::get('/', [PengirimanController::class, 'index'])->name('petugas.pengiriman.index');
        Route::get('/create/{id}', [PengirimanController::class, 'create'])->name('petugas.pengiriman.create');
        Route::post('/store/{id}', [PengirimanController::class, 'store'])->name('petugas.pengiriman.store');
        Route::get('/show/{id}', [PengirimanController::class, 'show'])->name('petugas.pengiriman.show');
        Route::get('/in-progress', [PengirimanController::class, 'inProgress'])->name('petugas.pengiriman.in-progress');
    });

    // Pengembalian Routes
    Route::get('/pengembalian', [PetugasPengembalianController::class, 'index'])->name('petugas.pengembalian.index');
    Route::get('/pengembalian/{id}', [PetugasPengembalianController::class, 'show'])->name('petugas.pengembalian.show');
    Route::post('/pengembalian/{id}/mark-sampai', [PetugasPengembalianController::class, 'markAsSampai'])->name('petugas.pengembalian.mark-sampai');
    Route::get('/pengembalian/{id}/pemeriksaan', [PetugasPengembalianController::class, 'prosesPemeriksaan'])->name('petugas.pengembalian.pemeriksaan');
    Route::post('/pengembalian/{id}/pemeriksaan', [PetugasPengembalianController::class, 'storePemeriksaan'])->name('petugas.pengembalian.store-pemeriksaan');
    Route::post('/pengembalian/{id}/complete', [PetugasPengembalianController::class, 'complete'])->name('petugas.pengembalian.complete');
});

// ==================== USER ROUTES ====================
Route::prefix('user')->middleware(['auth', 'check.level:user,admin'])->group(function() {
    // Profile Routes
    Route::get('/profile', [UserProfileController::class, 'index'])->name('user.profile');
    Route::get('/profile/edit', [UserProfileController::class, 'edit'])->name('user.profile.edit');
    Route::put('/profile/update', [UserProfileController::class, 'update'])->name('user.profile.update');

    // Verification Routes
    Route::get('/profile/verify-email/{token}', [UserProfileController::class, 'verifyEmail'])->name('user.profile.verify-email');
    Route::get('/profile/verify-password/{token}', [UserProfileController::class, 'verifyPassword'])->name('user.profile.verify-password');

    // Transaksi Routes
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/transaksi/selesai/{id}', [TransaksiController::class, 'selesai'])->name('transaksi.selesai');
    Route::get('/transaksi/riwayat', [TransaksiController::class, 'riwayat'])->name('transaksi.riwayat');
    Route::get('/transaksi/{id}', [TransaksiController::class, 'show'])->name('transaksi.show');
    Route::put('/transaksi/{id}/batal', [TransaksiController::class, 'batal'])->name('transaksi.batal');
    Route::get('/transaksi/reapply/{id}', [TransaksiController::class, 'reapply'])->name('transaksi.reapply');

    // Pengiriman Routes - Konfirmasi Penerimaan
    Route::get('/konfirmasi-penerimaan/{id}', [UserPengirimanController::class, 'confirmForm'])->name('user.konfirmasi-penerimaan');
    Route::post('/konfirmasi-penerimaan/{id}', [UserPengirimanController::class, 'confirmReceipt'])->name('user.konfirmasi-penerimaan.store');
    Route::get('/pinjaman-aktif', [UserPengirimanController::class, 'currentLoans'])->name('user.pinjaman-aktif');

    // Pengembalian Routes
    Route::get('/pengembalian', [UserPengembalianController::class, 'index'])->name('user.pengembalian.index');
    Route::get('/pengembalian/create/{id}', [UserPengembalianController::class, 'create'])->name('user.pengembalian.create');
    Route::post('/pengembalian/store/{id}', [UserPengembalianController::class, 'store'])->name('user.pengembalian.store');
    Route::get('/pengembalian/{id}', [UserPengembalianController::class, 'show'])->name('user.pengembalian.show');
    Route::post('/pengembalian/{id}/update-shipping', [UserPengembalianController::class, 'updateShipping'])->name('user.pengembalian.update-shipping');

    //Payment
    Route::get('/pembayaran/{id}', [PaymentController::class, 'create'])->name('user.payment.create');
    Route::get('/pembayaran/selesai', [PaymentController::class, 'success'])->name('user.payment.success');
    Route::get('/pembayaran/pending', [PaymentController::class, 'pending'])->name('user.payment.pending');
    Route::get('/pembayaran/gagal', [PaymentController::class, 'error'])->name('user.payment.error');
});

// Webhook midtrans
Route::post('/api/midtrans/notification', [PaymentController::class, 'notification'])->name('midtrans.notification');
