<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Services\TransaksiService;
use App\Models\Transaksi;
use App\Models\Produk;

class DashboardController extends Controller
{
    public function __construct(
        private TransaksiService $transaksiService
    ) {}

    public function index()
    {
        $stats = $this->transaksiService->getOwnerStats();
        $chart = $this->transaksiService->getPendapatanChart();

        // Produk terlaris
        $produkTerlaris = Produk::withCount(['detailTransaksi as total_terjual'])
            ->orderByDesc('total_terjual')
            ->take(5)
            ->get();

        // Pesanan terbaru
        $pesananTerbaru = Transaksi::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('owner.dashboard', compact('stats', 'chart', 'produkTerlaris', 'pesananTerbaru'));
    }
}