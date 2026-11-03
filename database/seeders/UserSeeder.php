<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'nama'     => 'Admin Dapur Gila',
                'email'    => 'admin@dapurgila.id',
                'password' => Hash::make('admin123'),
                'role'     => 'admin',
                'no_telepon' => '081234567890',
            ],
            [
                'nama'     => 'Owner Dapur Gila',
                'email'    => 'owner@dapurgila.id',
                'password' => Hash::make('owner123'),
                'role'     => 'owner',
                'no_telepon' => '081298765432',
            ],
            [
                'nama'     => 'Budi Santoso',
                'email'    => 'budi@gmail.com',
                'password' => Hash::make('budi123'),
                'role'     => 'pelanggan',
                'no_telepon' => '085612345678',
                'alamat'   => 'Jl. Merdeka No. 45, Jakarta Selatan',
            ],
            [
                'nama'     => 'Siti Rahayu',
                'email'    => 'siti@gmail.com',
                'password' => Hash::make('siti123'),
                'role'     => 'pelanggan',
                'no_telepon' => '087811223344',
                'alamat'   => 'Jl. Sudirman No. 12, Tangerang',
            ],
        ];

        foreach ($users as $user) {
            $user['kode_user'] = User::generateKodeUser($user['role']);
            User::create($user);
        }
    }
}