<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Services\KeranjangService;
use App\Services\TransaksiService;
use Illuminate\Http\Request;
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
            // Ambil data dari form request yang sudah tervalidasi
            $data = $request->validated();

            // Tangkap data ongkir dan total keseluruhan (makanan + ongkir) dari form
            $data['ongkir'] = $request->input('ongkir', 0);
            
            if ($request->has('total_keseluruhan')) {
                $data['total_harga'] = $request->input('total_keseluruhan');
            }

            // Upload bukti pembayaran jika ada (untuk metode QRIS / Transfer Bank)
            if ($request->hasFile('bukti_pembayaran')) {
                $data['bukti_pembayaran'] = $request
                    ->file('bukti_pembayaran')
                    ->store('bukti-pembayaran', 'public');
            }

            // Proses penyimpanan transaksi melalui TransaksiService
            $transaksi = $this->transaksiService->checkout($data);

            // Redirect ke halaman daftar pesanan dengan pesan sukses
            return redirect()
                ->route('pelanggan.pesanan')
                ->with(
                    'success',
                    'Pesanan berhasil dibuat! Kode: ' . $transaksi->kode_transaksi
                );

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage());
        }
    }

    /**
     * Membatalkan pesanan dan mengosongkan keranjang belanja.
     */
    public function batal()
    {
        try {
            // Cek nama method yang tersedia di KeranjangService Anda
            if (method_exists($this->keranjangService, 'kosongkan')) {
                $this->keranjangService->kosongkan();
            } else {
                $this->keranjangService->clear(); 
            }

            return redirect()
                ->route('pelanggan.menu')
                ->with('success', 'Pesanan dibatalkan dan keranjang telah dikosongkan.');

        } catch (\Exception $e) {
            return redirect()
                ->route('pelanggan.menu')
                ->with('error', 'Gagal membatalkan pesanan: ' . $e->getMessage());
        }
    }
}