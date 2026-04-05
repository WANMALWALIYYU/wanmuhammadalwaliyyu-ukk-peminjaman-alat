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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('user_name')->nullable();
            $table->string('user_email')->nullable();
            $table->string('user_level')->nullable();
            $table->string('action'); // login, logout, register, create, update, delete, etc.
            $table->string('module')->nullable(); // auth, kategori, produk, user, transaksi, etc.
            $table->string('item_id')->nullable();
            $table->string('item_code')->nullable();
            $table->text('description')->nullable();
            $table->json('old_data')->nullable();
            $table->json('new_data')->nullable();
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->string('status')->default('success'); // success, failed
            $table->text('error_message')->nullable();
            $table->timestamps();

            // Index untuk performa query
            $table->index(['user_id', 'action', 'module']);
            $table->index('created_at');
            $table->index('action');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
