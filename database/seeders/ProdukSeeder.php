<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produk;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        $produk = [
            [
                'nama'        => 'Japanese Curry Ramen',
                'deskripsi'   => 'Ramen dengan kuah kari Jepang yang kaya rempah, berpadu dengan mi kenyal, telur, dan topping pilihan yang lezat.',
                'harga'       => 27000,
                'kategori'    => 'Makanan',
                'gambar'      => 'images/ramen/Currymiso.jpg',
                'stok'        => 20,
                'status'      => 'tersedia',
                'is_terlaris' => true,
                'is_baru'     => false,
            ],
            [
                'nama'        => 'Toripaitan Ramen',
                'deskripsi'   => 'Ramen dengan kuah kaldu ayam kental dan creamy, disajikan bersama mi kenyal serta topping ayam dan sayuran yang menggugah selera.',
                'harga'       => 27000,
                'kategori'    => 'Makanan',
                'gambar'      => 'images/ramen/Toripaitan.jpg',
                'stok'        => 20,
                'status'      => 'tersedia',
                'is_terlaris' => false,
                'is_baru'     => false,
            ],
            [
                'nama'        => 'Nasi Katsu',
                'deskripsi'   => 'Nasi putih hangat dengan ayam katsu renyah berbalut tepung, disajikan bersama salad segar dan saus spesial yang menggugah selera.',
                'harga'       => 18000,
                'kategori'    => 'Makanan',
                'gambar'      => 'images/ramen/Nasikatsu.jpg',
                'stok'        => 20,
                'status'      => 'tersedia',
                'is_terlaris' => false,
                'is_baru'     => true,
            ],
            [
                'nama'        => 'Nasi Popcorn',
                'deskripsi'   => 'Nasi putih pulen dengan potongan ayam popcorn yang renyah, dipadukan dengan sambal pedas gurih dan lalapan segar.',
                'harga'       => 18000,
                'kategori'    => 'Makanan',
                'gambar'      => 'images/ramen/Nasipopcorn.jpg',
                'stok'        => 20,
                'status'      => 'tersedia',
                'is_terlaris' => false,
                'is_baru'     => true,
            ],
            [
                'nama'        => 'Kentang Popcorn',
                'deskripsi'   => 'Camilan kentang berbentuk bite-size dengan tekstur renyah di luar dan lembut di dalam, cocok dinikmati bersama saus favorit.',
                'harga'       => 16000,
                'kategori'    => 'Makanan',
                'gambar'      => 'images/ramen/Kentangpopcorn.jpg',
                'stok'        => 20,
                'status'      => 'tersedia',
                'is_terlaris' => true,
                'is_baru'     => false,
            ],
            [
                'nama'        => 'Egg Chicken Roll Salad',
                'deskripsi'   => 'Chicken roll berbalut telur dengan isian ayam gurih, disajikan bersama salad segar dan saus pilihan yang menambah kelezatan.',
                'harga'       => 19000,
                'kategori'    => 'Makanan',
                'gambar'      => 'images/ramen/Eggchickenroll.jpg',
                'stok'        => 20,
                'status'      => 'tersedia',
                'is_terlaris' => false,
                'is_baru'     => false,
            ],
            [
                'nama'        => 'Shrimp Roll Salad',
                'deskripsi'   => 'Gulungan udang segar dengan sayuran pilihan, dipadukan saus kacang gurih yang memberikan perpaduan rasa segar dan lezat.',
                'harga'       => 19000,
                'kategori'    => 'Makanan',
                'gambar'      => 'images/ramen/Shrimproll.jpg',
                'stok'        => 20,
                'status'      => 'tersedia',
                'is_terlaris' => true,
                'is_baru'     => false,
            ],
            [
                'nama'        => 'Ocha',
                'deskripsi'   => 'Teh hijau khas Jepang dengan rasa ringan dan menyegarkan, cocok dinikmati dingin sebagai teman berbagai hidangan.',
                'harga'       => 7000,
                'kategori'    => 'Minuman',
                'gambar'      => 'images/ramen/Ocha.jpg',
                'stok'        => 20,
                'status'      => 'tersedia',
                'is_terlaris' => false,
                'is_baru'     => true,
            ],
        ];

        foreach ($produk as $item) {
            $item['kode_menu'] = Produk::generateKodeMenu();
            Produk::create($item);
        }
    }
}