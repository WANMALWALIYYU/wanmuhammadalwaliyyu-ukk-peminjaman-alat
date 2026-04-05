<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\LogsActivity; // Tambahkan trait
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    use LogsActivity; // Gunakan trait

    public function login()
    {
        return view('authentication.login');
    }

    public function storeLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:100',
            'password' => 'required|max:50'
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.max' => 'Maksimal karakter email adalah 100',
            'password.required' => 'Password wajib diisi',
            'password.max' => 'Maksimal karakter password adalah 50'
        ]);

        // Ambil user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // CEK 1: Email tidak ditemukan
        if (!$user) {
            // Log failed login - email not found
            $this->logLogin($request->email, 'failed', 'Email tidak terdaftar');

            return back()->withErrors([
                'email' => 'Email tidak terdaftar'
            ])->withInput();
        }

        // CEK 2: Password salah
        if (!Hash::check($request->password, $user->password)) {
            // Log failed login - wrong password
            $this->logLogin($request->email, 'failed', 'Password salah');

            return back()->withErrors([
                'password' => 'Password salah'
            ])->withInput();
        }

        // CEK 3: Email belum diverifikasi
        if (is_null($user->email_verified_at)) {
            // Log failed login - email not verified
            $this->logLogin($request->email, 'failed', 'Email belum diverifikasi');

            // Login user sementara untuk verifikasi
            Auth::login($user);

            return redirect()->route('verification.notice')
                ->with('warning', 'Email Anda belum diverifikasi. Silakan verifikasi terlebih dahulu.')
                ->with('email', $user->email);
        }

        // CEK 4: Email sudah diverifikasi, coba login
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->has('remember'))) {
            $user = Auth::user();

            // Update last seen
            $user->last_seen = now();
            $user->save();

            // Log successful login
            $this->logLogin($request->email, 'success');

            // Redirect berdasarkan level
            switch ($user->level) {
                case 'admin':
                    if (class_exists('toast')) {
                        toast('Anda berhasil login sebagai admin', 'success')
                            ->timerProgressBar()
                            ->autoClose(2500)
                            ->width('400px')
                            ->padding('10px');
                    }
                    return redirect()->route(route: 'admin.dashboard')->with('admin', $user);

                case 'petugas':
                    if (class_exists('toast')) {
                        toast('Anda berhasil login sebagai petugas', 'success')
                            ->timerProgressBar()
                            ->autoClose(2500)
                            ->width('400px')
                            ->padding('10px');
                    }
                    return redirect()->route(route: 'petugas.dashboard')->with('petugas', $user);

                case 'user':
                    if (class_exists('toast')) {
                        toast('Anda berhasil login sebagai user', 'success')
                            ->timerProgressBar()
                            ->autoClose(2500)
                            ->width('400px')
                            ->padding('10px');
                    }
                    return redirect()->route('landing-page')->with('user', $user);

                default:
                    Auth::logout();
                    // Log failed login - invalid level
                    $this->logLogin($request->email, 'failed', 'Level user tidak dikenali');

                    if (class_exists('Alert')) {
                        Alert::error('GAGAL', 'Level user tidak dikenali');
                    }
                    return redirect()->route('login');
            }
        }

        // Jika gagal login
        $this->logLogin($request->email, 'failed', 'Terjadi kesalahan saat login');

        return back()->withErrors([
            'email' => 'Terjadi kesalahan saat login. Silakan coba lagi.'
        ])->withInput();
    }

    public function registrasi()
    {
        return view('authentication.registrasi');
    }

    /** Proses Registrasi dengan Verifikasi Email */
    public function storeRegistrasi(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:50|min:3',
            'email' => 'required|string|email|max:100|min:10|unique:users,email',
            'password' => 'required|string|min:5|confirmed',
            'terms' => 'required|accepted',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'nama.min' => 'Minimal karakter nama adalah 3.',
            'nama.max' => 'Maksimal karakter nama adalah 50.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid',
            'email.min' => 'Minimal karakter email adalah 10.',
            'email.max' => 'Maksimal karakter email adalah 100.',
            'email.unique' => 'Email sudah digunakan, coba yang lain.',

            'password.required' => 'Password wajib diisi',
            'password.min' => 'Minimal karakter password adalah 5',
            'password.confirmed' => 'Konfirmasi password tidak cocok',

            'terms.required' => 'Anda harus menyetujui Syarat & Ketentuan',
            'terms.accepted' => 'Anda harus menyetujui Syarat & Ketentuan',
        ]);

        try {
            // Buat user baru
            $user = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'level' => 'user',
            ]);

            // Log successful registration
            $this->logRegister($user, 'success');

            // Kirim email verifikasi
            event(new Registered($user));

            // Login user sementara untuk verifikasi
            Auth::login($user);

            // Redirect ke halaman verifikasi dengan email
            return redirect()->route('verification.notice')
                ->with('success', 'Registrasi berhasil! Silakan verifikasi email Anda.')
                ->with('email', $user->email);

        } catch (\Exception $e) {
            // Log failed registration
            $failedUser = (object) [
                'name' => $request->nama,
                'email' => $request->email,
                'level' => 'user'
            ];
            $this->logRegister($failedUser, 'failed', $e->getMessage());

            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat registrasi. Silakan coba lagi.');
        }
    }

    /**
     * Kirim ulang email verifikasi
     */
    public function resendVerification(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('login')
                ->with('success', 'Email Anda sudah terverifikasi.');
        }

        $request->user()->sendEmailVerificationNotification();

        // Log resend verification
        $this->logActivity(
            'resend_verification',
            'auth',
            $request->user()->id,
            $request->user()->email,
            "Kirim ulang email verifikasi untuk user {$request->user()->name} ({$request->user()->email})"
        );

        return back()->with('success', 'Link verifikasi baru telah dikirim ke email Anda!')
            ->with('email', $request->user()->email);
    }

    /**
     * Proses setelah verifikasi email berhasil
     */
    public function verified()
    {
        // Log email verification sudah dilakukan di route closure
        // Logout user setelah verifikasi
        Auth::logout();

        return redirect()->route('login')
            ->with('success', 'Email berhasil diverifikasi! Silakan login dengan akun Anda.');
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        // Log logout activity
        if ($user) {
            $this->logLogout($user);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Anda berhasil logout.');
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
