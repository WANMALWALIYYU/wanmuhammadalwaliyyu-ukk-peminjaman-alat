<?php
// app/Models/Payment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'payments';
    protected $guarded = [];

    protected $casts = [
        'jumlah_tagihan' => 'decimal:2',
        'jumlah_dibayar' => 'decimal:2',
        'sisa_tagihan' => 'decimal:2',
        'expiry_time' => 'datetime',
        'paid_at' => 'datetime',
        'raw_response' => 'array',
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_SETTLEMENT = 'settlement';
    const STATUS_CAPTURE = 'capture';
    const STATUS_DENY = 'deny';
    const STATUS_CANCEL = 'cancel';
    const STATUS_EXPIRE = 'expire';
    const STATUS_FAILURE = 'failure';
    const STATUS_REFUND = 'refund';

    const JENIS_DEPOSIT = 'deposit';
    const JENIS_PELUNASAN = 'pelunasan';
    const JENIS_DENDA = 'denda';

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id');
    }

    public function pengembalian()
    {
        return $this->belongsTo(Pengembalian::class, 'pengembalian_id');
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            self::STATUS_PENDING => '<span class="badge bg-warning text-dark">Menunggu Pembayaran</span>',
            self::STATUS_SETTLEMENT => '<span class="badge bg-success">Lunas</span>',
            self::STATUS_CAPTURE => '<span class="badge bg-success">Tertangkap</span>',
            self::STATUS_DENY => '<span class="badge bg-danger">Ditolak</span>',
            self::STATUS_CANCEL => '<span class="badge bg-secondary">Dibatalkan</span>',
            self::STATUS_EXPIRE => '<span class="badge bg-danger">Kadaluarsa</span>',
            self::STATUS_FAILURE => '<span class="badge bg-danger">Gagal</span>',
            self::STATUS_REFUND => '<span class="badge bg-info">Refund</span>',
        ];

        return $badges[$this->transaction_status] ?? '<span class="badge bg-light">' . $this->transaction_status . '</span>';
    }

    public function getJenisPembayaranLabelAttribute()
    {
        $labels = [
            self::JENIS_DEPOSIT => 'Deposit Awal',
            self::JENIS_PELUNASAN => 'Pelunasan Sewa',
            self::JENIS_DENDA => 'Denda & Biaya Tambahan',
        ];

        return $labels[$this->jenis_pembayaran] ?? $this->jenis_pembayaran;
    }

    public function getJumlahTagihanFormattedAttribute()
    {
        return 'Rp ' . number_format($this->jumlah_tagihan, 0, ',', '.');
    }

    public function isSuccessful()
    {
        return in_array($this->transaction_status, [self::STATUS_SETTLEMENT, self::STATUS_CAPTURE]);
    }

    public function isPending()
    {
        return $this->transaction_status === self::STATUS_PENDING;
    }

    public function canRetry()
    {
        return in_array($this->transaction_status, [self::STATUS_EXPIRE, self::STATUS_FAILURE, self::STATUS_DENY, self::STATUS_CANCEL]);
    }
}
