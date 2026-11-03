<?php

namespace App\Services;

use App\Models\Keranjang;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;

class KeranjangService
{
    /**
     * Tambah produk ke keranjang, jika sudah ada maka tambah jumlahnya
     */
    public function tambah(int $produkId, int $jumlah = 1): Keranjang
    {
        $produk = Produk::findOrFail($produkId);

        if ($produk->status !== 'tersedia') {
            throw new \Exception('Produk "' . $produk->nama . '" sedang tidak tersedia.');
        }

        $keranjang = Keranjang::where('user_id', Auth::id())
            ->where('produk_id', $produkId)
            ->first();

        if ($keranjang) {
            $jumlahBaru = $keranjang->jumlah + $jumlah;
            if ($jumlahBaru > $produk->stok) {
                throw new \Exception('Stok tidak mencukupi. Sisa stok: ' . $produk->stok . '.');
            }
            $keranjang->update(['jumlah' => $jumlahBaru]);
        } else {
            if ($jumlah > $produk->stok) {
                throw new \Exception('Stok tidak mencukupi. Sisa stok: ' . $produk->stok . '.');
            }
            $keranjang = Keranjang::create([
                'user_id'  => Auth::id(),
                'produk_id' => $produkId,
                'jumlah'   => $jumlah,
            ]);
        }

        return $keranjang->load('produk');
    }

    /**
     * Update jumlah item keranjang
     */
    public function updateJumlah(int $keranjangId, int $jumlah): Keranjang
    {
        $keranjang = Keranjang::where('id', $keranjangId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($jumlah < 1) {
            throw new \Exception('Jumlah minimal 1.');
        }

        if ($jumlah > $keranjang->produk->stok) {
            throw new \Exception('Stok tidak mencukupi. Sisa stok: ' . $keranjang->produk->stok . '.');
        }

        $keranjang->update(['jumlah' => $jumlah]);
        return $keranjang->load('produk');
    }

    /**
     * Hapus item dari keranjang
     */
    public function hapus(int $keranjangId): void
    {
        Keranjang::where('id', $keranjangId)
            ->where('user_id', Auth::id())
            ->delete();
    }

    /**
     * Kosongkan seluruh keranjang user
     */
    public function kosongkan(): void
    {
        Keranjang::where('user_id', Auth::id())->delete();
    }

    /**
     * Ambil semua item keranjang user
     */
    public function getItems()
    {
        return Keranjang::where('user_id', Auth::id())
            ->with('produk')
            ->get();
    }

    /**
     * Hitung total harga keranjang
     */
    public function getTotal(): int
    {
        return $this->getItems()->sum(function ($item) {
            return $item->produk->harga * $item->jumlah;
        });
    }
}