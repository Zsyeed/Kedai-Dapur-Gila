<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Produk;

class BerandaController extends Controller
{
    public function index()
    {
        $produkTerlaris = Produk::where('status', 'tersedia')
            ->where('is_terlaris', true)
            ->take(3)
            ->get();

        $produkBaru = Produk::where('status', 'tersedia')
            ->where('is_baru', true)
            ->take(3)
            ->get();

        return view('pelanggan.beranda', compact('produkTerlaris', 'produkBaru'));
    }
}