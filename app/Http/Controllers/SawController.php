<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SawController extends Controller
{
    public function index()
    {
        // 1. Ambil data produk sekaligus hitung TOTAL TERJUAL secara dinamis dari tabel asli Anda
        // Menggunakan tabel 'detail_transaksi' dan 'transaksi' sesuai database DapurGila
        $produks = DB::table('produk')
            ->leftJoin('detail_transaksi', 'produk.id', '=', 'detail_transaksi.produk_id')
            ->leftJoin('transaksi', 'transaksi.id', '=', 'detail_transaksi.transaksi_id')
            ->select(
                'produk.*',
                DB::raw('COALESCE(SUM(CASE WHEN transaksi.status = "Selesai" THEN detail_transaksi.jumlah ELSE 0 END), 0) as total_terjual')
            )
            ->groupBy('produk.id')
            ->get();

        if ($produks->isEmpty()) {
            return view('owner.saw', [
                'rankings' => [],
                'weights' => ['c1' => 0.4, 'c2' => 0.3, 'c3' => 0.3]
            ]);
        }

        // 2. Tentukan Bobot W 
        // C1: Stok (40% - Benefit), C2: Total Terjual (30% - Benefit), C3: Harga (30% - Cost)
        $weights = [
            'c1' => 0.4,
            'c2' => 0.3,
            'c3' => 0.3
        ];

        // 3. Cari Nilai Max dan Min untuk Normalisasi
        $maxC1 = $produks->max('stok') ?? 1;
        $maxC2 = $produks->max('total_terjual') ?? 1; 
        $minC3 = $produks->where('harga', '>', 0)->min('harga') ?? 1;

        $rankings = [];

        // 4. Proses Perhitungan Metode SAW
        foreach ($produks as $produk) {
            // C1 (Stok) - Benefit: Nilai / Nilai Maksimal
            $r1 = $maxC1 > 0 ? ($produk->stok / $maxC1) : 0;
            
            // C2 (Total Terjual) - Benefit: Nilai / Nilai Maksimal
            $r2 = $maxC2 > 0 ? ($produk->total_terjual / $maxC2) : 0;

            // C3 (Harga) - Cost: Nilai Minimal / Nilai
            $r3 = $produk->harga > 0 ? ($minC3 / $produk->harga) : 0;

            // Rumus V: (r1 * w1) + (r2 * w2) + (r3 * w3)
            $score = ($r1 * $weights['c1']) + ($r2 * $weights['c2']) + ($r3 * $weights['c3']);

            $rankings[] = [
                'kode_menu' => $produk->kode_menu,
                'nama' => $produk->nama,
                'stok' => $produk->stok,
                'total_terjual' => (int)$produk->total_terjual, // Menggunakan total terjual riil dari database
                'harga' => $produk->harga,
                'score' => round($score, 4)
            ];
        }

        // 5. Urutkan hasil berdasarkan skor tertinggi (Perankingan)
        usort($rankings, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        return view('owner.saw', compact('rankings', 'weights'));
    }
}