<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaksi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'transaksis';
    protected $guarded = [];

    protected $casts = [
        'tanggal_pengajuan' => 'datetime',
        'tanggal_verifikasi' => 'datetime',
        'jumlah_deposit' => 'decimal:2',
    ];

    // Status constants
    const STATUS_MENUNGGU_PERSETUJUAN = 'menunggu_persetujuan';
    const STATUS_DISETUJUI = 'disetujui';
    const STATUS_DITOLAK = 'ditolak';
    const STATUS_DIKIRIM = 'dikirim';
    const STATUS_DIPINJAM = 'dipinjam';        // Status setelah barang sampai ke peminjam
    const STATUS_DIKEMBALIKAN = 'dikembalikan';
    const STATUS_SELESAI = 'selesai';
    const STATUS_DIBATALKAN = 'dibatalkan';

    // Payment methods
    const METODE_TRANSFER = 'transfer';
    const METODE_VA = 'va';
    const METODE_EWALLET = 'ewallet';

    /*
    |----------------------------------------------------------------------
    | RELATIONS
    |----------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function detailTransaksis()
    {
        return $this->hasMany(DetailTransaksi::class);
    }

    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class);
    }

    public function pengiriman()
    {
        return $this->hasOne(Pengiriman::class);
    }

    /*
    |----------------------------------------------------------------------
    | SCOPES
    |----------------------------------------------------------------------
    */

    public function scopeMenungguPersetujuan($query)
    {
        return $query->where('status', self::STATUS_MENUNGGU_PERSETUJUAN);
    }

    public function scopeDisetujui($query)
    {
        return $query->where('status', self::STATUS_DISETUJUI);
    }

    public function scopeDipinjam($query)
    {
        return $query->where('status', self::STATUS_DIPINJAM);
    }

    public function scopeDikembalikan($query)
    {
        return $query->where('status', self::STATUS_DIKEMBALIKAN);
    }

    /*
    |----------------------------------------------------------------------
    | ACCESSORS
    |----------------------------------------------------------------------
    */

    public function getStatusBadgeAttribute()
    {
        $badges = [
            self::STATUS_MENUNGGU_PERSETUJUAN => '<span class="badge bg-warning text-dark">Menunggu Persetujuan</span>',
            self::STATUS_DISETUJUI => '<span class="badge bg-info text-dark">Disetujui</span>',
            self::STATUS_DITOLAK => '<span class="badge bg-danger">Ditolak</span>',
            self::STATUS_DIKIRIM => '<span class="badge bg-primary">Dikirim</span>',
            self::STATUS_DIPINJAM => '<span class="badge bg-success">Sedang Dipinjam</span>',
            self::STATUS_DIKEMBALIKAN => '<span class="badge bg-dark text-white">Dikembalikan</span>',
            self::STATUS_SELESAI => '<span class="badge bg-secondary">Selesai</span>',
            self::STATUS_DIBATALKAN => '<span class="badge bg-danger">Dibatalkan</span>',
        ];

        return $badges[$this->status] ?? '<span class="badge bg-light">'.$this->status.'</span>';
    }

    public function getMetodePembayaranLabelAttribute()
    {
        $labels = [
            self::METODE_TRANSFER => 'Transfer Bank',
            self::METODE_VA => 'Virtual Account',
            self::METODE_EWALLET => 'E-Wallet',
        ];

        return $labels[$this->metode_pembayaran] ?? $this->metode_pembayaran;
    }

    public function getTotalBiayaAttribute()
    {
        return $this->detailTransaksis->sum('subtotal');
    }

    public function getSisaPembayaranAttribute()
    {
        return $this->total_biaya - $this->jumlah_deposit;
    }

    /*
    |----------------------------------------------------------------------
    | METHODS
    |----------------------------------------------------------------------
    */

    public function approve($verifiedBy, $catatan = null)
    {
        $this->update([
            'status' => self::STATUS_DISETUJUI,
            'verified_by' => $verifiedBy,
            'tanggal_verifikasi' => now(),
            'catatan_verifikasi' => $catatan
        ]);

        // Kurangi stok produk saat disetujui
        foreach ($this->detailTransaksis as $detail) {
            $produk = $detail->produk;
            if ($produk) {
                $produk->decrement('stok', $detail->jumlah);
                if ($produk->stok <= 0) {
                    $produk->update(['status' => 'dipinjam']);
                }
            }
        }
    }

    public function reject($verifiedBy, $catatan)
    {
        $this->update([
            'status' => self::STATUS_DITOLAK,
            'verified_by' => $verifiedBy,
            'tanggal_verifikasi' => now(),
            'catatan_verifikasi' => $catatan
        ]);

        // Kembalikan stok produk
        foreach ($this->detailTransaksis as $detail) {
            $produk = $detail->produk;
            if ($produk) {
                $produk->increment('stok', $detail->jumlah);
                if ($produk->stok > 0) {
                    $produk->update(['status' => 'tersedia']);
                }
            }
        }
    }

    public function isOverdue()
    {
        $tanggalSelesai = $this->detailTransaksis->max('tanggal_selesai');
        if ($tanggalSelesai && now()->gt($tanggalSelesai)) {
            return now()->diffInDays($tanggalSelesai);
        }
        return 0;
    }

    public function calculateDendaKeterlambatan($dendaPerHari = 50000)
    {
        $daysOverdue = $this->isOverdue();
        if ($daysOverdue > 0) {
            return $daysOverdue * $dendaPerHari;
        }
        return 0;
    }

    public function markAsDikirim()
    {
        $this->update(['status' => self::STATUS_DIKIRIM]);
    }

    /**
     * Mark as borrowed (after user confirms receipt)
     * This changes status to DIPINJAM
     */
    public function markAsDipinjam()
    {
        $this->update(['status' => self::STATUS_DIPINJAM]);
    }

    public function markAsDikembalikan()
    {
        $this->update(['status' => self::STATUS_DIKEMBALIKAN]);
    }

    public function complete()
    {
        $this->update(['status' => self::STATUS_SELESAI]);
    }
}
