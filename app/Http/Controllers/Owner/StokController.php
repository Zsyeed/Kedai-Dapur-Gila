<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;

class StokController extends Controller
{
    public function index()
    {
        // Mengambil data produk beserta stoknya
        $stok = Produk::orderBy('stok', 'asc')->get();
        
        return view('owner.stok.index', compact('stok'));
    }
}