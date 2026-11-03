<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';

    protected $fillable = [
        'kode_menu',
        'nama',
        'deskripsi',
        'harga',
        'kategori',
        'gambar',
        'stok',
        'status',
        'is_terlaris',
        'is_baru',
    ];

    protected $casts = [
        'harga'       => 'integer',
        'stok'        => 'integer',
        'is_terlaris' => 'boolean',
        'is_baru'     => 'boolean',
    ];


    public static function generateKodeMenu($prefix = 'MNU')
        {
        // Ubah prefix ke huruf besar dan hapus spasi
        $prefix = strtoupper(trim($prefix));
        $prefix = str_replace(' ', '-', $prefix);

        // Ambil kode terakhir berdasarkan prefix
        $lastProduk = self::where('kode_menu', 'like', $prefix . '-%')
            ->orderBy('kode_menu', 'desc')
            ->first();

        if ($lastProduk) {
            // Ambil angka terakhir
            $lastNumber = (int) substr(
                $lastProduk->kode_menu,
                strlen($prefix) + 1
            );

            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        // Format 3 digit
        return $prefix . '-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    /* ---------- Relasi ---------- */

    public function keranjang()
    {
        return $this->hasMany(Keranjang::class);
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class);
    }

    /* ---------- Accessor ---------- */

    public function getHargaFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

// Di Model Produk.php
    public function getGambarUrlAttribute(): string
    {
        return $this->gambar 
            ? asset($this->gambar)
            : asset('images/default.png');
    }
}