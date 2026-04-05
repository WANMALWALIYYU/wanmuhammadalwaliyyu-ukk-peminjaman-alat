<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'level',
        'foto',
        'alamat',
        'nomor_hp',
        'last_seen',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_seen' => 'datetime',
        ];
    }

    // Cek role user
    public function isAdmin()
    {
        return $this->level === 'admin';
    }

    public function isPetugas()
    {
        return $this->level === 'petugas';
    }

    public function isUser()
    {
        return $this->level === 'user';
    }

    /**
     * Check if user is online (within last 2 minutes)
     */
    public function isOnline(): bool
    {
        return $this->last_seen && Carbon::parse($this->last_seen)->diffInMinutes(now()) < 2;
    }

    /**
     * Get online status badge HTML
     */
    public function getOnlineStatusBadge()
    {
        if ($this->isOnline()) {
            return '<span class="badge badge-sm bg-success text-white">Online</span>';
        } else {
            return '<span class="badge badge-sm bg-secondary text-white">Offline</span>';
        }
    }

    /**
     * Relations
     */
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function verifiedTransaksis()
    {
        return $this->hasMany(Transaksi::class, 'verified_by');
    }
}
