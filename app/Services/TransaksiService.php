<?php

namespace App\Services;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Keranjang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransaksiService
{
    private KeranjangService $keranjangService;

    public function __construct(KeranjangService $keranjangService)
    {
        $this->keranjangService = $keranjangService;
    }

    /**
     * Proses checkout — wrap dalam DB transaction
     */
    public function checkout(array $data): Transaksi
    {
        $items = $this->keranjangService->getItems();

        if ($items->isEmpty()) {
            throw new \Exception('Keranjang kosong, tidak bisa checkout.');
        }

        return DB::transaction(function () use ($items, $data) {
            // Hitung subtotal harga makanan dari keranjang dengan benar
            $subtotalMakanan = $items->sum(function ($item) {
                return $item->produk->harga * $item->jumlah;
            });

            // Ambil nilai ongkir dari data request (default 0 jika tidak ada)
            $ongkir = isset($data['ongkir']) ? (float) $data['ongkir'] : 0;

            // Total keseluruhan = Subtotal Makanan + Ongkir
            $totalHarga = isset($data['total_harga']) ? (float) $data['total_harga'] : ($subtotalMakanan + $ongkir);

            /*
            |--------------------------------------------------------------------------
            | Generate Nomor Virtual Account
            |--------------------------------------------------------------------------
            | Hanya dibuat jika metode pembayaran = transfer.
            |--------------------------------------------------------------------------
            */
            $nomorVA = null;

            if ($data['metode_pembayaran'] === 'transfer') {
                $bank = $data['bank'] ?? 'bca'; // default BCA
                $nomorVA = Transaksi::generateNomorVA($bank);
            }

            // Simpan Transaksi ke Database (Termasuk Ongkir)
            $transaksi = Transaksi::create([
                'user_id'           => Auth::id(),
                'kode_transaksi'    => Transaksi::generateKode(),
                'total_harga'       => $totalHarga,
                'ongkir'            => $ongkir, // <--- Menyimpan biaya pengiriman ke database
                'status'            => 'menunggu',
                'metode_pembayaran' => $data['metode_pembayaran'],
                'nomor_va'          => $nomorVA,
                'alamat_pengiriman' => $data['alamat_pengiriman'],
                'no_telepon'        => $data['no_telepon'],
                'catatan'           => $data['catatan'] ?? null,
                'bukti_pembayaran'  => $data['bukti_pembayaran'] ?? null,
            ]);

            foreach ($items as $item) {
                $subtotalItem = $item->produk->harga * $item->jumlah;

                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'produk_id'    => $item->produk_id,
                    'jumlah'       => $item->jumlah,
                    'harga_satuan' => $item->produk->harga,
                    'subtotal'     => $subtotalItem,
                ]);

                // Kurangi stok produk
                $item->produk->decrement('stok', $item->jumlah);

                // Refresh agar stok terbaru terbaca
                $item->produk->refresh();

                if ($item->produk->stok <= 0) {
                    $item->produk->update([
                        'status' => 'habis'
                    ]);
                }
            }

            // Kosongkan keranjang
            $this->keranjangService->kosongkan();

            return $transaksi->load('detailTransaksi.produk', 'user');
        });
    }

    /**
     * Update status transaksi (digunakan admin)
     */
    public function updateStatus(int $transaksiId, string $status): Transaksi
    {
        $transaksi = Transaksi::findOrFail($transaksiId);

        $validTransitions = [
            'menunggu'   => ['diproses', 'dibatalkan'],
            'diproses'   => ['diantar', 'dibatalkan'],
            'diantar'    => ['selesai', 'dibatalkan'],
            'selesai'    => [],
            'dibatalkan' => [],
        ];

        if (!in_array($status, $validTransitions[$transaksi->status] ?? [])) {
            throw new \Exception('Perubahan status dari "' . $transaksi->status_label . '" ke "' . $status . '" tidak diizinkan.');
        }

        // Jika dibatalkan, kembalikan stok
        if ($status === 'dibatalkan' && in_array($transaksi->status, ['menunggu', 'diproses', 'diantar'])) {
            foreach ($transaksi->detailTransaksi as $detail) {
                $detail->produk->increment('stok', $detail->jumlah);
                if ($detail->produk->stok > 0) {
                    $detail->produk->update(['status' => 'tersedia']);
                }
            }
        }

        $transaksi->update(['status' => $status]);
        return $transaksi->load('detailTransaksi.produk', 'user');
    }

    /**
     * Statistik untuk dashboard owner
     */
    public function getOwnerStats(): array
    {
        $today = now()->toDateString();

        return [
            'total_pendapatan'    => Transaksi::where('status', 'selesai')->sum('total_harga'),
            'pendapatan_hari_ini' => Transaksi::where('status', 'selesai')
                ->whereDate('created_at', $today)
                ->sum('total_harga'),
            'total_pesanan'       => Transaksi::count(),
            'pesanan_hari_ini'    => Transaksi::whereDate('created_at', $today)->count(),
            'menunggu'            => Transaksi::where('status', 'menunggu')->count(),
            'diproses'            => Transaksi::where('status', 'diproses')->count(),
            'diantar'             => Transaksi::where('status', 'diantar')->count(),
            'selesai'             => Transaksi::where('status', 'selesai')->count(),
            'dibatalkan'          => Transaksi::where('status', 'dibatalkan')->count(),
        ];
    }

    /**
     * Data chart pendapatan 7 hari terakhir (untuk owner)
     */
    public function getPendapatanChart(): array
    {
        $labels = [];
        $data = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $labels[] = $date->locale('id')->isoFormat('ddd, D MMM');
            $data[] = Transaksi::where('status', 'selesai')
                ->whereDate('created_at', $date->toDateString())
                ->sum('total_harga');
        }

        return compact('labels', 'data');
    }

    /**
     * Statistik untuk dashboard admin
     */
    public function getAdminStats(): array
    {
        return [
            'total_produk'     => \App\Models\Produk::count(),
            'produk_tersedia'  => \App\Models\Produk::where('status', 'tersedia')->count(),
            'produk_habis'     => \App\Models\Produk::where('status', 'habis')->count(),
            'total_pelanggan'  => \App\Models\User::where('role', 'pelanggan')->count(),
            'total_pesanan'    => Transaksi::count(),
            'menunggu'         => Transaksi::where('status', 'menunggu')->count(),
            'diproses'         => Transaksi::where('status', 'diproses')->count(),
            'diantar'          => Transaksi::where('status', 'diantar')->count(),
        ];
    }
}