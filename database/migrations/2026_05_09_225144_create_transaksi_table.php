<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('kode_transaksi')->unique();
            $table->unsignedInteger('total_harga');
            $table->enum('status', ['menunggu', 'diproses', 'diantar', 'selesai', 'dibatalkan'])->default('menunggu');
            $table->enum('metode_pembayaran', ['transfer', 'qris', 'cod'])->default('cod');
            $table->string('nomor_va')->nullable();
            $table->string('bukti_pembayaran')->nullable();
            $table->text('alamat_pengiriman');
            $table->string('no_telepon', 20);
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};