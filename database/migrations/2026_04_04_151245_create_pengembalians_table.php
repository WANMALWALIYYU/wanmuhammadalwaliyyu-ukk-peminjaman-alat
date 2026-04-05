<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengembalians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('petugas_id')->nullable()->constrained('users');

            // Status pengembalian
            $table->enum('status', [
                'menunggu_pengiriman',  // User sudah request pengembalian, menunggu dikirim
                'dikirim',              // Barang sedang dalam pengiriman
                'sampai',               // Barang sudah sampai di petugas
                'diproses',             // Petugas sedang memproses
                'selesai',              // Selesai diproses, menunggu pembayaran
                'dibatalkan'            // Dibatalkan
            ])->default('menunggu_pengiriman');

            // Informasi pengiriman
            $table->string('no_resi_pengembalian')->nullable();
            $table->string('kurir_pengembalian')->nullable();
            $table->timestamp('tanggal_dikirim')->nullable();
            $table->timestamp('tanggal_sampai')->nullable();

            // Foto dan catatan dari user
            $table->string('foto_barang_dikembalikan')->nullable(); // Foto saat akan dikirim
            $table->text('catatan_user')->nullable();

            // Pemeriksaan oleh petugas
            $table->string('foto_barang_setelah_sampai')->nullable();
            $table->enum('kondisi_barang', ['baik', 'rusak_ringan', 'rusak_berat'])->nullable();
            $table->text('deskripsi_kerusakan')->nullable();
            $table->decimal('biaya_kerusakan', 12, 2)->default(0);
            $table->text('catatan_petugas')->nullable();

            // Biaya tambahan lainnya
            $table->decimal('denda_keterlambatan', 12, 2)->default(0);
            $table->decimal('total_biaya_tambahan', 12, 2)->default(0);

            // Timestamps
            $table->timestamps();
            $table->softDeletes();

            $table->index(['transaksi_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalians');
    }
};
