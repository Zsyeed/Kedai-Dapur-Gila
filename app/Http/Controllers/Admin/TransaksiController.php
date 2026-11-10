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

        // Ambil nilai per_page dari request, default 10 (atau sesuaikan dengan kebutuhan)
        $perPage = $request->get('per_page', 10);

        // Validasi agar nilai per_page aman dari input sembarangan
        $allowedPerPage = [10, 20, 50, 100];
        if (!in_array($perPage, $allowedPerPage)) {
            $perPage = 10;
        }

        $transaksi = $query->latest()->paginate($perPage)->withQueryString();

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