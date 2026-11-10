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
        // Ubah dari 'transaksis' menjadi 'transaksi' (sesuai nama tabel asli Anda)
        Schema::table('transaksi', function (Blueprint $table) {
            $table->decimal('ongkir', 10, 2)->default(0)->after('total_harga');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropColumn('ongkir');
        });
    }
};