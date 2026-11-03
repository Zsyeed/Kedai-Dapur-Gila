<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $query = Produk::where('status', 'tersedia');

        // Filter kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Filter pencarian
        if ($request->filled('cari')) {
            $query->where('nama', 'like', '%' . $request->cari . '%');
        }

        // Urutkan
        $sort = $request->get('sort', 'terbaru');
        match ($sort) {
            'termurah'  => $query->orderBy('harga', 'asc'),
            'termahal'  => $query->orderBy('harga', 'desc'),
            'terbaru'   => $query->orderByDesc('is_baru'),
            'terlaris'  => $query->orderByDesc('is_terlaris'),
            default      => $query->latest(),
        };

        $produk = $query->paginate(12)->withQueryString();
        $kategori = Produk::distinct()->pluck('kategori');

        return view('pelanggan.menu', compact('produk', 'kategori', 'sort'));
    }
}