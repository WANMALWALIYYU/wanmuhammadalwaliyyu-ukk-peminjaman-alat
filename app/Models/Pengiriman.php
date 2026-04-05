<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengiriman extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pengirimans';
    protected $guarded = [];

    protected $casts = [
        'tanggal_dikirim' => 'datetime',
        'tanggal_sampai' => 'datetime',
    ];

    /**
     * Relations
     */
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    /**
     * Accessors
     */
    public function getStatusPengirimanAttribute()
    {
        if ($this->tanggal_dikirim && !$this->tanggal_sampai) {
            return '<span class="badge bg-warning text-dark">Dalam Pengiriman</span>';
        } elseif ($this->tanggal_sampai) {
            return '<span class="badge bg-success">Sampai</span>';
        }
        return '<span class="badge bg-secondary">Belum Dikirim</span>';
    }

    public function getStatusTextAttribute()
    {
        if ($this->tanggal_dikirim && !$this->tanggal_sampai) {
            return 'Dalam Pengiriman';
        } elseif ($this->tanggal_sampai) {
            return 'Sampai';
        }
        return 'Belum Dikirim';
    }

    public function getFotoDikirimUrlAttribute()
    {
        return $this->foto_barang_dikirim ? asset('storage/' . $this->foto_barang_dikirim) : null;
    }

    public function getFotoSampaiUrlAttribute()
    {
        return $this->foto_barang_sampai ? asset('storage/' . $this->foto_barang_sampai) : null;
    }
}
