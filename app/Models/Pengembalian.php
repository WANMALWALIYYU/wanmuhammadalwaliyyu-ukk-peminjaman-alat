<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengembalian extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pengembalians';
    protected $guarded = [];

    protected $casts = [
        'tanggal_dikirim' => 'datetime',
        'tanggal_sampai' => 'datetime',
        'biaya_kerusakan' => 'decimal:2',
        'denda_keterlambatan' => 'decimal:2',
        'total_biaya_tambahan' => 'decimal:2',
    ];

    // Status constants
    const STATUS_MENUNGGU_PENGIRIMAN = 'menunggu_pengiriman';
    const STATUS_DIKIRIM = 'dikirim';
    const STATUS_SAMPAI = 'sampai';
    const STATUS_DIPROSES = 'diproses';
    const STATUS_SELESAI = 'selesai';
    const STATUS_DIBATALKAN = 'dibatalkan';

    /**
     * Relations
     */
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    /**
     * Accessors
     */
    public function getStatusBadgeAttribute()
    {
        $badges = [
            self::STATUS_MENUNGGU_PENGIRIMAN => '<span class="badge bg-warning text-dark">Menunggu Pengiriman</span>',
            self::STATUS_DIKIRIM => '<span class="badge bg-info text-dark">Dikirim</span>',
            self::STATUS_SAMPAI => '<span class="badge bg-primary">Sampai</span>',
            self::STATUS_DIPROSES => '<span class="badge bg-secondary">Diproses</span>',
            self::STATUS_SELESAI => '<span class="badge bg-success">Selesai</span>',
            self::STATUS_DIBATALKAN => '<span class="badge bg-danger">Dibatalkan</span>',
        ];

        return $badges[$this->status] ?? '<span class="badge bg-light">'.$this->status.'</span>';
    }

    public function getKondisiBadgeAttribute()
    {
        $badges = [
            'baik' => '<span class="badge bg-success">Baik</span>',
            'rusak_ringan' => '<span class="badge bg-warning text-dark">Rusak Ringan</span>',
            'rusak_berat' => '<span class="badge bg-danger">Rusak Berat</span>',
        ];

        return $badges[$this->kondisi_barang] ?? '<span class="badge bg-secondary">-</span>';
    }

    /**
     * Calculate total biaya yang harus dibayar user setelah pengembalian
     */
    public function getTotalBiayaYangHarusDibayarAttribute()
    {
        $transaksi = $this->transaksi;
        $subtotal = $transaksi->detailTransaksis->sum('subtotal');
        $sisaPembayaran = $subtotal - $transaksi->jumlah_deposit;

        return $sisaPembayaran + $this->total_biaya_tambahan;
    }

    /**
     * Methods
     */
    public function markAsDikirim($noResi = null, $kurir = null, $foto = null)
    {
        $this->update([
            'status' => self::STATUS_DIKIRIM,
            'no_resi_pengembalian' => $noResi,
            'kurir_pengembalian' => $kurir,
            'foto_barang_dikembalikan' => $foto,
            'tanggal_dikirim' => now(),
        ]);

        // Update transaksi status to DIKEMBALIKAN
        $this->transaksi->update(['status' => Transaksi::STATUS_DIKEMBALIKAN]);
    }

    public function markAsSampai($foto = null)
    {
        $this->update([
            'status' => self::STATUS_SAMPAI,
            'foto_barang_setelah_sampai' => $foto,
            'tanggal_sampai' => now(),
        ]);
    }

    public function prosesPemeriksaan($data)
    {
        $totalBiayaTambahan = ($data['biaya_kerusakan'] ?? 0) + ($data['denda_keterlambatan'] ?? 0);

        $this->update([
            'status' => self::STATUS_DIPROSES,
            'petugas_id' => auth()->id(),
            'kondisi_barang' => $data['kondisi_barang'],
            'deskripsi_kerusakan' => $data['deskripsi_kerusakan'] ?? null,
            'biaya_kerusakan' => $data['biaya_kerusakan'] ?? 0,
            'denda_keterlambatan' => $data['denda_keterlambatan'] ?? 0,
            'total_biaya_tambahan' => $totalBiayaTambahan,
            'catatan_petugas' => $data['catatan_petugas'] ?? null,
        ]);
    }

    public function complete()
    {
        $this->update(['status' => self::STATUS_SELESAI]);
    }
}
