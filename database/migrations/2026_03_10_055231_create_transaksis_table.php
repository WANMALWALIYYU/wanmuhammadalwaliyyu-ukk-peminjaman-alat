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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('kode_transaksi')->unique();

            // Data peminjam (diisi user saat transaksi)
            $table->string('nama_lengkap');
            $table->string('email');
            $table->string('no_telepon');
            $table->string('no_identitas'); // No KTP
            $table->string('foto_ktp'); // Upload foto KTP

            // Alamat lengkap pengiriman
            $table->string('provinsi');
            $table->string('kabupaten');
            $table->string('kecamatan');
            $table->string('kelurahan');
            $table->text('alamat_lengkap');

            // Bukti deposit awal
            $table->string('bukti_deposit'); // wajib upload bukti deposit
            $table->decimal('jumlah_deposit', 12, 2);
            $table->string('metode_pembayaran');

            // Timestamps
            $table->timestamp('tanggal_pengajuan')->useCurrent();

            // Status transaksi sesuai alur
            $table->enum('status', [
                'menunggu_persetujuan', // setelah ajukan, menunggu verifikasi petugas
                'disetujui', // disetujui petugas
                'ditolak', // ditolak petugas
                'dikirim', // dalam pengiriman
                'dipinjam', // sedang dipinjam
                'dikembalikan', // sudah dikembalikan, menunggu pengecekan
                'selesai', // transaksi selesai (sudah pelunasan)
                'dibatalkan'
            ])->default('menunggu_persetujuan');

            $table->text('catatan_verifikasi')->nullable(); // catatan jika ditolak
            $table->foreignId('verified_by')->nullable()->constrained('users');
            $table->timestamp('tanggal_verifikasi')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
