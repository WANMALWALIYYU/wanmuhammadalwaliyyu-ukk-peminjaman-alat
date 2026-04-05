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
        Schema::create('detail_transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_id')->constrained()->cascadeOnDelete();
            $table->foreignId('produk_id')->constrained()->cascadeOnDelete();

            // Snapshot data produk saat transaksi
            $table->string('nama_produk');
            $table->decimal('harga_per_hari', 10, 2); // snapshot harga sewa

            $table->integer('jumlah');
            $table->integer('durasi_hari');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');

            // Subtotal untuk produk ini (harga_per_hari * durasi_hari * jumlah)
            $table->decimal('subtotal', 12, 2);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transaksis');
    }
};
