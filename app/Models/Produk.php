<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produk extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'produks';
    protected $guarded = [];

    protected $casts = [
        'harga' => 'decimal:2',
        'stok' => 'integer',
    ];

    // Event untuk mengupdate status berdasarkan stok
    protected static function booted()
    {
        static::saving(function ($produk) {
            $produk->updateStatusByStock();
        });
    }

    // Method untuk update status berdasarkan stok
    public function updateStatusByStock()
    {
        if ($this->stok <= 0) {
            $this->status = 'dipinjam';
        } else {
            $this->status = 'tersedia';
        }
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function detailTransaksis()
    {
        return $this->hasMany(DetailTransaksi::class);
    }

    public function getHargaFormattedAttribute()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    public function getStatusBadgeAttribute()
    {
        return $this->status === 'tersedia'
            ? '<span class="badge bg-success">Tersedia</span>'
            : '<span class="badge bg-warning text-dark">Dipinjam</span>';
    }

    public function getKondisiBadgeAttribute()
    {
        $badges = [
            'baru' => '<span class="badge bg-primary">Baru</span>',
            'bekas' => '<span class="badge bg-secondary">Bekas</span>',
            'rusak' => '<span class="badge bg-danger">Rusak</span>'
        ];

        return $badges[$this->kondisi] ?? '<span class="badge bg-light">'.$this->kondisi.'</span>';
    }
}
