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
        Schema::create('pengirimans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_id')->constrained()->cascadeOnDelete();
            $table->foreignId('petugas_id')->constrained('users')->cascadeOnDelete();

            // Foto pengiriman
            $table->string('foto_barang_dikirim')->nullable();
            $table->string('foto_barang_sampai')->nullable();

            // Catatan
            $table->text('catatan_pengiriman')->nullable();
            $table->text('catatan_penerimaan')->nullable();

            // Timestamps
            $table->timestamp('tanggal_dikirim')->nullable();
            $table->timestamp('tanggal_sampai')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengirimans');
    }
};
