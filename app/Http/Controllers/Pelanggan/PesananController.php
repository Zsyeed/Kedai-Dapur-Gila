<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Services\TransaksiService;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    public function __construct(
        private TransaksiService $transaksiService
    ) {}

    public function index()
    {
        $pesanan = Transaksi::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('pelanggan.pesanan', compact('pesanan'));
    }

    public function show(int $id)
    {
        $transaksi = Transaksi::where('user_id', Auth::id())
            ->with('detailTransaksi.produk')
            ->findOrFail($id);

        return view('pelanggan.pesanan-show', compact('transaksi'));
    }

    public function batalkan(int $id)
    {
        $transaksi = Transaksi::where('user_id', Auth::id())
            ->findOrFail($id);

        if ($transaksi->status !== 'menunggu') {
            return back()->with('error', 'Pesanan yang sudah diproses tidak bisa dibatalkan.');
        }

        try {
            $this->transaksiService->updateStatus($transaksi->id, 'dibatalkan');
            return back()->with('success', 'Pesanan ' . $transaksi->kode_transaksi . ' berhasil dibatalkan.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}