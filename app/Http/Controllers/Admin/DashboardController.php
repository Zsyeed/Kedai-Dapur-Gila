<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\TransaksiService;
use App\Models\Transaksi;

class DashboardController extends Controller
{
    public function __construct(
        private TransaksiService $transaksiService
    ) {}

    public function index()
    {
        $stats = $this->transaksiService->getAdminStats();

        $pesananTerbaru = Transaksi::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'pesananTerbaru'));
    }
}