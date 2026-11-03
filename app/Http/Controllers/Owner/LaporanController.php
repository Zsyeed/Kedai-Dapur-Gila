<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Order; // Sesuaikan dengan model transaksi Anda
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::query();

        if ($request->filter == 'hari') {
            $query->whereDate('created_at', Carbon::today());
        }

        elseif ($request->filter == 'minggu') {
            $query->whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ]);
        }

        elseif ($request->filter == 'bulan') {
            $query->whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year);
        }

        $laporan = $query->latest()->get();

        return view('owner.laporan.index', compact('laporan'));
    }

    public function exportPdf(Request $request)
    {
        $laporan = Transaksi::where('status', 'selesai')->latest()->get();
        
        // Memuat view blade yang akan di-convert jadi PDF
        $pdf = Pdf::loadView('owner.laporan.pdf', compact('laporan'));
        
        // Mengunduh file PDF
        return $pdf->download('Laporan_Penjualan_DapurGilaRamen.pdf');
    }
}