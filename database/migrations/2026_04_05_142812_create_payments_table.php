<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            // Relasi ke transaksis
            $table->foreignId('transaksi_id')
                  ->constrained('transaksis')
                  ->onDelete('cascade');

            // Relasi ke pengembalian (opsional)
            $table->foreignId('pengembalian_id')
                  ->nullable()
                  ->constrained('pengembalians')
                  ->nullOnDelete();

            // Kode pembayaran internal
            $table->string('kode_pembayaran')->unique();

            // Jenis pembayaran
            $table->enum('jenis_pembayaran', ['deposit', 'pelunasan', 'denda'])->default('pelunasan');

            // Detail pembayaran
            $table->decimal('jumlah_tagihan', 12, 2);
            $table->decimal('jumlah_dibayar', 12, 2)->default(0);
            $table->decimal('sisa_tagihan', 12, 2);

            // Data dari Midtrans
            $table->string('transaction_id')->unique()->nullable();
            $table->string('order_id_midtrans')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('bank')->nullable();
            $table->string('va_number')->nullable();
            $table->string('bill_key')->nullable();
            $table->string('biller_code')->nullable();
            $table->string('pdf_url')->nullable();
            $table->string('qr_code_url')->nullable();

            // Status pembayaran dari Midtrans
            $table->enum('transaction_status', [
                'pending', 'settlement', 'capture', 'deny',
                'cancel', 'expire', 'failure', 'refund'
            ])->default('pending');

            $table->string('fraud_status')->nullable();

            // Data lengkap dari Midtrans (JSON)
            $table->json('raw_response')->nullable();

            // Snap Token
            $table->string('snap_token')->nullable();

            // Waktu kadaluarsa
            $table->timestamp('expiry_time')->nullable();
            $table->timestamp('paid_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Index
            $table->index('transaction_id');
            $table->index('transaction_status');
            $table->index('kode_pembayaran');
            $table->index(['transaksi_id', 'transaction_status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
