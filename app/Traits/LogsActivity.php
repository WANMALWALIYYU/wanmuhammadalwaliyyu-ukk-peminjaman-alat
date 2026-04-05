<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Request;

trait LogsActivity
{
    /**
     * Log aktivitas user
     */
    protected function logActivity(
        $action,
        $module = null,
        $itemId = null,
        $itemCode = null,
        $description = null,
        $oldData = null,
        $newData = null,
        $status = 'success',
        $errorMessage = null
    ) {
        $user = auth()->user();

        ActivityLog::create([
            'user_id' => $user?->id,
            'user_name' => $user?->name,
            'user_email' => $user?->email,
            'user_level' => $user?->level,
            'action' => $action,
            'module' => $module,
            'item_id' => $itemId,
            'item_code' => $itemCode,
            'description' => $description,
            'old_data' => $oldData ? (is_array($oldData) ? $oldData : ($oldData->toArray() ?? null)) : null,
            'new_data' => $newData ? (is_array($newData) ? $newData : ($newData->toArray() ?? null)) : null,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'status' => $status,
            'error_message' => $errorMessage,
        ]);
    }

    /**
     * Log untuk aktivitas login
     */
    protected function logLogin($email, $status = 'success', $errorMessage = null)
    {
        ActivityLog::create([
            'user_id' => null,
            'user_name' => null,
            'user_email' => $email,
            'user_level' => null,
            'action' => 'login',
            'module' => 'auth',
            'description' => $status === 'success' ? "User dengan email {$email} berhasil login" : "Percobaan login gagal untuk email {$email}",
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'status' => $status,
            'error_message' => $errorMessage,
        ]);
    }

    /**
     * Log untuk aktivitas logout
     */
    protected function logLogout($user)
    {
        $this->logActivity(
            'logout',
            'auth',
            $user->id,
            $user->email,
            "User {$user->name} ({$user->email}) telah logout"
        );
    }

    /**
     * Log untuk aktivitas register
     */
    protected function logRegister($user, $status = 'success', $errorMessage = null)
    {
        ActivityLog::create([
            'user_id' => $status === 'success' ? $user->id : null,
            'user_name' => $user->name ?? null,
            'user_email' => $user->email,
            'user_level' => $user->level ?? 'user',
            'action' => 'register',
            'module' => 'auth',
            'description' => $status === 'success'
                ? "Registrasi user baru: {$user->name} ({$user->email})"
                : "Registrasi gagal untuk email: {$user->email}",
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'status' => $status,
            'error_message' => $errorMessage,
        ]);
    }

    /**
     * Log untuk aktivitas create
     */
    protected function logCreate($module, $item, $itemCodeField = 'id', $description = null)
    {
        $itemId = $item->id ?? null;
        $itemCode = $item->{$itemCodeField} ?? $item->kode_produk ?? $item->kode_kategori ?? $item->kode_transaksi ?? null;

        $this->logActivity(
            'create',
            $module,
            $itemId,
            $itemCode,
            $description ?? "Menambahkan data {$module} baru: " . ($itemCode ?? $itemId),
            null,
            $item
        );
    }

    /**
     * Log untuk aktivitas update
     */
    protected function logUpdate($module, $item, $oldData, $itemCodeField = 'id', $description = null)
    {
        $itemId = $item->id ?? null;
        $itemCode = $item->{$itemCodeField} ?? $item->kode_produk ?? $item->kode_kategori ?? $item->kode_transaksi ?? null;

        $this->logActivity(
            'update',
            $module,
            $itemId,
            $itemCode,
            $description ?? "Mengupdate data {$module}: " . ($itemCode ?? $itemId),
            $oldData,
            $item
        );
    }

    /**
     * Log untuk aktivitas delete (soft delete)
     */
    protected function logDelete($module, $item, $itemCodeField = 'id', $description = null)
    {
        $itemId = $item->id ?? null;
        $itemCode = $item->{$itemCodeField} ?? $item->kode_produk ?? $item->kode_kategori ?? $item->kode_transaksi ?? null;

        $this->logActivity(
            'delete',
            $module,
            $itemId,
            $itemCode,
            $description ?? "Menghapus data {$module}: " . ($itemCode ?? $itemId),
            $item,
            null
        );
    }

    /**
     * Log untuk aktivitas restore
     */
    protected function logRestore($module, $item, $itemCodeField = 'id', $description = null)
    {
        $itemId = $item->id ?? null;
        $itemCode = $item->{$itemCodeField} ?? $item->kode_produk ?? $item->kode_kategori ?? $item->kode_transaksi ?? null;

        $this->logActivity(
            'restore',
            $module,
            $itemId,
            $itemCode,
            $description ?? "Mengembalikan data {$module}: " . ($itemCode ?? $itemId),
            null,
            $item
        );
    }

    /**
     * Log untuk aktivitas force delete
     */
    protected function logForceDelete($module, $item, $itemCodeField = 'id', $description = null)
    {
        $itemId = $item->id ?? null;
        $itemCode = $item->{$itemCodeField} ?? $item->kode_produk ?? $item->kode_kategori ?? $item->kode_transaksi ?? null;

        $this->logActivity(
            'force_delete',
            $module,
            $itemId,
            $itemCode,
            $description ?? "Menghapus permanen data {$module}: " . ($itemCode ?? $itemId),
            $item,
            null
        );
    }

    /**
     * Log untuk aktivitas verifikasi email
     */
    protected function logEmailVerification($user, $status = 'success', $errorMessage = null)
    {
        $this->logActivity(
            'verify_email',
            'auth',
            $user->id,
            $user->email,
            $status === 'success'
                ? "User {$user->name} ({$user->email}) berhasil memverifikasi email"
                : "Verifikasi email gagal untuk user {$user->name} ({$user->email})",
            null,
            null,
            $status,
            $errorMessage
        );
    }
}
