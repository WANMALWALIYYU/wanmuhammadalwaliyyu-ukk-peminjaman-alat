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
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            //Relasi table kategori
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();

            $table->string('kode_produk')->unique();
            $table->string('nama_produk');
            $table->text('deskripsi')->nullable();
            $table->integer('stok')->default(1);
            $table->decimal('harga', 10, 2);
            $table->string('kondisi');
            $table->string('fitur')->nullable();
            $table->enum('status', ['tersedia', 'dipinjam'])->default('tersedia');
            $table->string('gambar')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
