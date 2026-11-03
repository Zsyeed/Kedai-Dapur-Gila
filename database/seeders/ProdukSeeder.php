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
                'deskripsi'   => 'Ramen kuah kaldu sapi dengan daging rendang pedas khas Padang. Level pedas bisa disesuaikan.',
                'harga'       => 27000,
                'kategori'    => 'Ramen',
                'gambar'      => 'ramen/Currymiso.jpg',
                'stok'        => 20,
                'status'      => 'tersedia',
                'is_terlaris' => true,
                'is_baru'     => false,
            ],
            [
                'nama'        => 'Toripaitan Ramen',
                'deskripsi'   => 'Ramen dengan topping ayam suwir dan sambal matah segar khas Bali.',
                'harga'       => 27000,
                'kategori'    => 'Ramen',
                'gambar'      => 'ramen/Toripaitan.jpg',
                'stok'        => 20,
                'status'      => 'tersedia',
                'is_terlaris' => false,
                'is_baru'     => false,
            ],
            [
                'nama'        => 'Nasi Katsu',
                'deskripsi'   => 'Ramen dengan udang, cumi, dan telur puyuh dalam kuah bumbu kuning rempah.',
                'harga'       => 18000,
                'kategori'    => 'Ramen',
                'gambar'      => 'ramen/Nasikatsu.jpg',
                'stok'        => 20,
                'status'      => 'tersedia',
                'is_terlaris' => false,
                'is_baru'     => true,
            ],
            [
                'nama'        => 'Nasi Popcorn',
                'deskripsi'   => 'Fusion ramen dengan kuah toseng kambing yang gurih dan harum rempah.',
                'harga'       => 18000,
                'kategori'    => 'Ramen',
                'gambar'      => 'ramen/Nasipopcorn.jpg',
                'stok'        => 20,
                'status'      => 'tersedia',
                'is_terlaris' => false,
                'is_baru'     => true,
            ],
            [
                'nama'        => 'Kentang Popcorn',
                'deskripsi'   => 'Miso ramen otentik dengan chashu, telur setengah matang, dan nori.',
                'harga'       => 16000,
                'kategori'    => 'Ramen',
                'gambar'      => 'ramen/Kentangpopcorn.jpg',
                'stok'        => 20,
                'status'      => 'tersedia',
                'is_terlaris' => true,
                'is_baru'     => false,
            ],
            [
                'nama'        => 'Egg Chicken Roll Salad',
                'deskripsi'   => 'Ramen dengan kuah santan soto Betawi, daging sapi, dan kentang.',
                'harga'       => 19000,
                'kategori'    => 'Ramen',
                'gambar'      => 'ramen/Eggchickenroll.jpg',
                'stok'        => 20,
                'status'      => 'tersedia',
                'is_terlaris' => false,
                'is_baru'     => false,
            ],
            [
                'nama'        => 'Shrimp Roll Salad',
                'deskripsi'   => 'Tonkotsu ramen dengan level pedas extreme dan topping ekstra chashu.',
                'harga'       => 19000,
                'kategori'    => 'Ramen',
                'gambar'      => 'ramen/Shrimproll.jpg',
                'stok'        => 20,
                'status'      => 'tersedia',
                'is_terlaris' => true,
                'is_baru'     => false,
            ],
            [
                'nama'        => 'Ocha',
                'deskripsi'   => 'Ramen dingin dengan saus kacang, tahu, tempe goreng crispy, dan sayuran segar.',
                'harga'       => 7000,
                'kategori'    => 'Minuman',
                'gambar'      => 'ramen/Ocha.jpg',
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