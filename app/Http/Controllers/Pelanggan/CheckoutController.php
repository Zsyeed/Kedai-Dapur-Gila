<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Services\KeranjangService;
use App\Services\TransaksiService;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function __construct(
        private KeranjangService $keranjangService,
        private TransaksiService $transaksiService
    ) {}

    public function index()
    {
        $items = $this->keranjangService->getItems();
        $total = $this->keranjangService->getTotal();

        if ($items->isEmpty()) {
            return redirect()
                ->route('pelanggan.menu')
                ->with('error', 'Keranjang kosong.');
        }

        $user = Auth::user();

        return view('pelanggan.checkout', compact('items', 'total', 'user'));
    }

    public function proses(CheckoutRequest $request)
    {
        try {
            // Ambil data validasi
            $data = $request->validated();

            // Upload bukti pembayaran jika ada
            if ($request->hasFile('bukti_pembayaran')) {
                $data['bukti_pembayaran'] = $request
                    ->file('bukti_pembayaran')
                    ->store('bukti-pembayaran', 'public');
            }

            // Proses checkout
            $transaksi = $this->transaksiService->checkout($data);

            // Redirect ke halaman pesanan
            return redirect()
                ->route('pelanggan.pesanan')
                ->with(
                    'success',
                    'Pesanan berhasil dibuat! Kode: ' . $transaksi->kode_transaksi
                );

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Membatalkan pesanan dan mengosongkan keranjang belanja.
     */
    public function batal()
    {
        try {
            // Panggil method pengosongan keranjang dari KeranjangService
            // Catatan: Pastikan nama method di service Anda sesuai (misal: kosongkan(), clear(), atau destroy())
            if (method_exists($this->keranjangService, 'kosongkan')) {
                $this->keranjangService->kosongkan();
            } else {
                // Jika nama method di service Anda adalah clear()
                $this->keranjangService->clear(); 
            }

            return redirect()
                ->route('pelanggan.menu')
                ->with('success', 'Pesanan berhasil dibatalkan dan keranjang telah dikosongkan.');

        } catch (\Exception $e) {
            return redirect()
                ->route('pelanggan.menu')
                ->with('error', 'Gagal membatalkan pesanan: ' . $e->getMessage());
        }
    }
}