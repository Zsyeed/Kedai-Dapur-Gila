<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Services\TransaksiService;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function __construct(
        private TransaksiService $transaksiService
    ) {}

    public function index(Request $request)
    {
        $query = Transaksi::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('cari')) {
            $query->where('kode_transaksi', 'like', '%' . $request->cari . '%');
        }

        $transaksi = $query->latest()->paginate(15)->withQueryString();

        return view('admin.transaksi.index', compact('transaksi'));
    }

    public function show(Transaksi $transaksi)
    {
        $transaksi->load('detailTransaksi.produk', 'user');
        return view('admin.transaksi.show', compact('transaksi'));
    }

    public function updateStatus(Request $request, Transaksi $transaksi)
    {
        $request->validate([
            'status' => 'required|in:diproses,selesai,diantar,dibatalkan',
        ]);

        try {
            $this->transaksiService->updateStatus($transaksi->id, $request->status);
            return back()->with('success', 'Status berhasil diupdate.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}