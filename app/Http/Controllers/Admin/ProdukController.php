<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProdukRequest;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $query = Produk::query();

        // Pencarian berdasarkan nama produk
        if ($request->filled('cari')) {
            $query->where('nama', 'like', '%' . $request->cari . '%');
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $produk = $query->latest()->paginate(10)->withQueryString();

        return view('admin.produk.index', compact('produk'));
    }

    public function create()
    {
        return view('admin.produk.create');
    }

    public function store(ProdukRequest $request)
    {
        $data = $request->validated();

        // Generate kode_menu otomatis, misal: MNU001
        $data['kode_menu'] = Produk::generateKodeMenu();

        // Checkbox boolean
        $data['is_terlaris'] = $request->boolean('is_terlaris', false);
        $data['is_baru']     = $request->boolean('is_baru', false);

        // Upload gambar
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $nama = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/ramen'), $nama);
            $data['gambar'] = 'images/ramen/' . $nama;
        }

        Produk::create($data);

        return redirect()
            ->route('admin.produk.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Produk $produk)
    {
        return view('admin.produk.edit', compact('produk'));
    }

    public function update(ProdukRequest $request, Produk $produk)
    {
        $data = $request->validated();

        // Checkbox boolean
        $data['is_terlaris'] = $request->boolean('is_terlaris', false);
        $data['is_baru']     = $request->boolean('is_baru', false);

        // Pastikan kode_menu tidak berubah jika field tidak dikirim
        $data['kode_menu'] = $produk->kode_menu;

        // Upload gambar baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($produk->gambar && file_exists(public_path($produk->gambar))) {
                unlink(public_path($produk->gambar));
            }

            $file = $request->file('gambar');
            $nama = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/ramen'), $nama);
            $data['gambar'] = 'images/ramen/' . $nama;
        }

        $produk->update($data);

        return redirect()
            ->route('admin.produk.index')
            ->with('success', 'Produk berhasil diupdate.');
    }

    public function destroy(Produk $produk)
    {
        // Hapus gambar jika ada
        if ($produk->gambar && file_exists(public_path($produk->gambar))) {
            unlink(public_path($produk->gambar));
        }

        $produk->delete();

        return redirect()
            ->route('admin.produk.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}