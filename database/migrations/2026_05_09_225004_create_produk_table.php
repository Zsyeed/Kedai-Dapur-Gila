<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            $table->string('kode_menu', 20)->unique();
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->unsignedInteger('harga');
            $table->enum('kategori', ['Ramen', 'Minuman'])->default('Ramen');
            $table->string('gambar')->nullable();
            $table->unsignedInteger('stok')->default(0);
            $table->enum('status', ['tersedia', 'habis'])->default('tersedia');
            $table->boolean('is_terlaris')->default(false);
            $table->boolean('is_baru')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};