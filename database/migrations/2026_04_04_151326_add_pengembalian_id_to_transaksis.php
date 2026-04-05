<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->foreignId('pengembalian_id')->nullable()->after('id')
                  ->constrained('pengembalians')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropForeign(['pengembalian_id']);
            $table->dropColumn('pengembalian_id');
        });
    }
};
