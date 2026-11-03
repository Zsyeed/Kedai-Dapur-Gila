<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Services\KeranjangService;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    public function __construct(
        private KeranjangService $keranjangService
    ) {}

    public function index()
    {
        $items = $this->keranjangService->getItems();
        $total = $this->keranjangService->getTotal();

        return view('pelanggan.keranjang', compact('items', 'total'));
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'jumlah'    => 'nullable|integer|min:1',
        ]);

        try {
            $jumlah = $request->integer('jumlah', 1);
            $this->keranjangService->tambah($request->produk_id, $jumlah);

            return back()->with('success', 'Produk ditambahkan ke keranjang.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        try {
            $this->keranjangService->updateJumlah($id, $request->jumlah);
            return back()->with('success', 'Jumlah berhasil diupdate.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function hapus(int $id)
    {
        $this->keranjangService->hapus($id);
        return back()->with('success', 'Item dihapus dari keranjang.');
    }
}