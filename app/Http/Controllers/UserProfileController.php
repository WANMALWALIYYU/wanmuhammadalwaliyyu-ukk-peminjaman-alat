<?php

namespace App\Http\Controllers;

use App\Mail\EmailVerification;
use App\Mail\PasswordResetVerification;
use App\Traits\LogsActivity; //  trait
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserProfileController extends Controller
{
    use LogsActivity; //  trait

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('user.profile.profile');
    }

    /**
     * Show the form for creating a new resource.
     */
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
    public function edit()
    {
        $user = Auth::user();
        return view('user.profile.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Simpan data lama sebelum update
        $oldData = $user->replicate();

        // Validasi input dasar
        $request->validate([
            'name' => 'required|min:3|max:255',
            'nomor_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:500',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'name.required' => 'Nama lengkap wajib diisi',
            'name.min' => 'Minimal karakter nama adalah 3',
            'name.max' => 'Maksimal karakter nama adalah 255',
            'nomor_hp.max' => 'Nomor HP maksimal 20 karakter',
            'alamat.max' => 'Alamat maksimal 500 karakter',
            'foto.image' => 'File harus berupa gambar',
            'foto.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau webp',
            'foto.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        // Data yang akan diupdate
        $dataUser = [
            'name' => $request->input('name'),
            'nomor_hp' => $request->input('nomor_hp'),
            'alamat' => $request->input('alamat'),
        ];

        // Handle perubahan email
        if ($request->has('email') && $request->email != $user->email) {
            $request->validate([
                'email' => 'required|email|unique:users,email,' . $user->id,
            ], [
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Format email tidak valid',
                'email.unique' => 'Email sudah digunakan oleh pengguna lain',
            ]);

            // Generate token verifikasi email
            $emailToken = Str::random(64);

            // Simpan email baru sementara di session
            session([
                'pending_email' => $request->email,
                'email_verification_token' => $emailToken,
                'email_verification_expires' => now()->addMinutes(30)
            ]);

            // Log email change request
            $this->logActivity(
                'email_change_request',
                'profile',
                $user->id,
                $user->email,
                "User {$user->name} meminta perubahan email dari {$user->email} ke {$request->email}"
            );

            // Kirim email verifikasi
            Mail::to($request->email)->send(new EmailVerification($emailToken, $user->name));

            return redirect()->back()->with('info', 'Verifikasi email telah dikirim ke alamat email baru Anda. Silakan cek inbox untuk mengkonfirmasi perubahan email.');
        }

        // Handle perubahan password
        if ($request->has('password') && !empty($request->password)) {
            $request->validate([
                'current_password' => 'required|string',
                'password' => 'required|string|min:5|confirmed',
            ], [
                'current_password.required' => 'Password saat ini wajib diisi',
                'password.required' => 'Password baru wajib diisi',
                'password.min' => 'Password minimal 5 karakter',
                'password.confirmed' => 'Konfirmasi password tidak sesuai',
            ]);

            // Verifikasi password saat ini
            if (!Hash::check($request->current_password, $user->password)) {
                // Log failed password change attempt
                $this->logActivity(
                    'password_change_failed',
                    'profile',
                    $user->id,
                    $user->email,
                    "Percobaan perubahan password gagal - password saat ini tidak sesuai",
                    null,
                    null,
                    'failed',
                    'Password saat ini tidak sesuai'
                );

                return redirect()->back()->withErrors(['current_password' => 'Password saat ini tidak sesuai']);
            }

            // Generate token verifikasi password
            $passwordToken = Str::random(64);

            // Simpan password baru sementara di session
            session([
                'pending_password' => Hash::make($request->password),
                'password_verification_token' => $passwordToken,
                'password_verification_expires' => now()->addMinutes(30)
            ]);

            // Log password change request
            $this->logActivity(
                'password_change_request',
                'profile',
                $user->id,
                $user->email,
                "User {$user->name} meminta perubahan password"
            );

            // Kirim email verifikasi password
            Mail::to($user->email)->send(new PasswordResetVerification($passwordToken, $user->name));

            return redirect()->back()->with('info', 'Verifikasi perubahan password telah dikirim ke email Anda. Silakan cek inbox untuk mengkonfirmasi perubahan password.');
        }

        // Cek apakah ada request untuk hapus foto
        if ($request->has('delete_foto') && $request->delete_foto == '1') {
            // Hapus file foto dari storage
            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }
            $dataUser['foto'] = null;

            // Log delete photo
            $this->logActivity(
                'delete_photo',
                'profile',
                $user->id,
                $user->email,
                "User {$user->name} menghapus foto profil"
            );
        }

        // Jika ada file foto baru
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }

            // Upload foto baru
            $file = $request->file('foto');
            $namaFile = time() . '_' . Str::slug($user->name) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('profile-photos', $namaFile, 'public');
            $dataUser['foto'] = $path;

            // Log upload photo
            $this->logActivity(
                'upload_photo',
                'profile',
                $user->id,
                $user->email,
                "User {$user->name} mengupload foto profil baru"
            );
        }

        // Update user
        $user->update($dataUser);

        // Log profile update (if only name, phone, address changed)
        if (!isset($dataUser['foto']) && !isset($dataUser['email'])) {
            $this->logUpdate('profile', $user, $oldData, 'email', "User {$user->name} memperbarui data profil");
        }

        // Toast notifikasi
        toast('Sukses mengupdate profil', 'success')
            ->timerProgressBar()
            ->autoClose(2000)
            ->width('400px')
            ->padding('10px');

        return redirect()->route('user.profile');
    }

    /**
     * Verify email change
     */
    public function verifyEmail($token)
    {
        $user = Auth::user();

        // Cek token di session
        if (session('email_verification_token') !== $token) {
            $this->logActivity(
                'email_verification_failed',
                'profile',
                $user->id,
                $user->email,
                "Verifikasi email gagal - token tidak valid",
                null,
                null,
                'failed',
                'Token verifikasi tidak valid'
            );

            return redirect()->route('user.profile.edit')
                ->with('error', 'Token verifikasi tidak valid');
        }

        // Cek apakah token masih berlaku
        if (now()->gt(session('email_verification_expires'))) {
            session()->forget(['pending_email', 'email_verification_token', 'email_verification_expires']);

            $this->logActivity(
                'email_verification_failed',
                'profile',
                $user->id,
                $user->email,
                "Verifikasi email gagal - token kadaluarsa",
                null,
                null,
                'failed',
                'Token verifikasi telah kadaluarsa'
            );

            return redirect()->route('user.profile.edit')
                ->with('error', 'Token verifikasi telah kadaluarsa. Silakan coba lagi.');
        }

        $oldEmail = $user->email;
        $newEmail = session('pending_email');

        // Update email
        $user->email = $newEmail;
        $user->save();

        // Log successful email change
        $this->logActivity(
            'email_changed',
            'profile',
            $user->id,
            $user->email,
            "User {$user->name} berhasil mengubah email dari {$oldEmail} ke {$newEmail}",
            ['old_email' => $oldEmail],
            ['new_email' => $newEmail],
            'success'
        );

        // Clear session
        session()->forget(['pending_email', 'email_verification_token', 'email_verification_expires']);

        toast('Email berhasil diubah', 'success')
            ->timerProgressBar()
            ->autoClose(2000);

        return redirect()->route('user.profile');
    }

    /**
     * Verify password change
     */
    public function verifyPassword($token)
    {
        $user = Auth::user();

        // Cek token di session
        if (session('password_verification_token') !== $token) {
            $this->logActivity(
                'password_verification_failed',
                'profile',
                $user->id,
                $user->email,
                "Verifikasi perubahan password gagal - token tidak valid",
                null,
                null,
                'failed',
                'Token verifikasi tidak valid'
            );

            return redirect()->route('user.profile.edit')
                ->with('error', 'Token verifikasi tidak valid');
        }

        // Cek apakah token masih berlaku
        if (now()->gt(session('password_verification_expires'))) {
            session()->forget(['pending_password', 'password_verification_token', 'password_verification_expires']);

            $this->logActivity(
                'password_verification_failed',
                'profile',
                $user->id,
                $user->email,
                "Verifikasi perubahan password gagal - token kadaluarsa",
                null,
                null,
                'failed',
                'Token verifikasi telah kadaluarsa'
            );

            return redirect()->route('user.profile.edit')
                ->with('error', 'Token verifikasi telah kadaluarsa. Silakan coba lagi.');
        }

        // Update password
        $user->password = session('pending_password');
        $user->save();

        // Log successful password change
        $this->logActivity(
            'password_changed',
            'profile',
            $user->id,
            $user->email,
            "User {$user->name} berhasil mengubah password"
        );

        // Clear session
        session()->forget(['pending_password', 'password_verification_token', 'password_verification_expires']);

        // Logout user agar login ulang dengan password baru
        Auth::logout();

        toast('Password berhasil diubah. Silakan login kembali dengan password baru Anda.', 'success')
            ->timerProgressBar()
            ->autoClose(3000);

        return redirect()->route('login');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
