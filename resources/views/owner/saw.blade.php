@extends('layouts.owner')

@section('page-title', 'Analisis Metode SAW (Produk Terbaik)')

@section('content')
<style>
    /* CSS Khusus Halaman SAW (Status & Ranking) */
    .badge-pill-status {
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-block;
        white-space: nowrap;
    }

    .status-sangat-rekomendasi {
        background-color: #e6f6f4;
        color: #2b9381;
    }

    .status-rekomendasi {
        background-color: #e0f2fe;
        color: #0369a1;
    }

    .status-cukup {
        background-color: #f1f5f9;
        color: #475569;
    }

    .score-highlight {
        font-family: 'SFMono-Regular', Consolas, monospace;
        font-weight: 700;
        color: var(--text-main);
        font-size: 0.95rem;
    }

    .item-info {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
        color: var(--text-main);
    }
</style>

<!-- Header Judul -->
<div style="margin-bottom: 2rem;">
    <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--text-main); margin-bottom: 0.25rem;">Analisis Metode SAW</h2>
    <p style="color: var(--text-muted); font-size: 0.95rem; margin: 0;">Sistem Pendukung Keputusan Penentuan Produk Rekomendasi</p>
</div>

<!-- Konfigurasi Bobot (Diubah menggunakan Grid CSS agar sejajar rapi) -->
<div style="margin-bottom: 1rem;">
    <h3 style="font-size: 1rem; font-weight: 600; color: var(--text-main); margin-bottom: 1rem;">Konfigurasi Bobot Kriteria Penilaian</h3>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        
        <!-- C1 -->
        <div class="admin-card" style="background-color: #fdf8f5; border: 1px solid #fae8d4; padding: 1.25rem 1.5rem; display: flex; align-items: center; justify-content: space-between; margin-bottom: 0;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div style="background-color: #f5e6dc; width: 42px; height: 42px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">📦</div>
                <span style="font-size: 0.9rem; font-weight: 500; color: var(--text-muted);">C1 - Stok Produk (Benefit)</span>
            </div>
            <strong style="font-size: 1.25rem; color: var(--text-main);">{{ $weights['c1'] * 100 }}%</strong>
        </div>

        <!-- C2 -->
        <div class="admin-card" style="background-color: #fdf8f5; border: 1px solid #fae8d4; padding: 1.25rem 1.5rem; display: flex; align-items: center; justify-content: space-between; margin-bottom: 0;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div style="background-color: #f5e6dc; width: 42px; height: 42px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">📈</div>
                <span style="font-size: 0.9rem; font-weight: 500; color: var(--text-muted);">C2 - Total Terjual (Benefit)</span>
            </div>
            <strong style="font-size: 1.25rem; color: var(--text-main);">{{ $weights['c2'] * 100 }}%</strong>
        </div>

        <!-- C3 -->
        <div class="admin-card" style="background-color: #fdf8f5; border: 1px solid #fae8d4; padding: 1.25rem 1.5rem; display: flex; align-items: center; justify-content: space-between; margin-bottom: 0;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div style="background-color: #f5e6dc; width: 42px; height: 42px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">💰</div>
                <span style="font-size: 0.9rem; font-weight: 500; color: var(--text-muted);">C3 - Harga Produk (Cost)</span>
            </div>
            <strong style="font-size: 1.25rem; color: var(--text-main);">{{ $weights['c3'] * 100 }}%</strong>
        </div>

    </div>
</div>

<!-- Tabel Hasil Perankingan -->
<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title">Hasil Perankingan Rekomendasi</h3>
    </div>
    
    <div class="admin-table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="text-align: center; width: 80px;">RANKING</th>
                    <th>NAMA PRODUK</th>
                    <th>STOK</th>
                    <th>TERJUAL</th>
                    <th>HARGA</th>
                    <th style="text-align: center;">SKOR AKHIR (V)</th>
                    <th style="text-align: center;">STATUS REKOMENDASI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rankings as $index => $rank)
                <tr>
                    <td style="text-align: center;">
                        @if($index + 1 == 1)
                            <span style="background: linear-gradient(135deg, #ffe082 0%, #ffb300 100%); color: #452900; padding: 0.3rem 0.6rem; border-radius: 6px; font-weight: bold; display: inline-block; min-width: 50px;">🥇 1</span>
                        @elseif($index + 1 == 2)
                            <span style="border: 1px solid #cbd5e1; background: #f8fafc; color: #475569; padding: 0.3rem 0.6rem; border-radius: 6px; font-weight: bold; display: inline-block; min-width: 50px;">🥈 2</span>
                        @elseif($index + 1 == 3)
                            <span style="border: 1px solid #cbd5e1; background: #f8fafc; color: #475569; padding: 0.3rem 0.6rem; border-radius: 6px; font-weight: bold; display: inline-block; min-width: 50px;">🥉 3</span>
                        @else
                            <span style="font-weight: 600; color: var(--text-muted);">{{ $index + 1 }}</span>
                        @endif
                    </td>

                    <td style="font-weight: 600; color: var(--text-main);">
                        {{ $rank['nama'] }}
                    </td>

                    <td>
                        <div class="item-info"><span>📦</span> {{ $rank['stok'] }} Pcs</div>
                    </td>

                    <td>
                        <div class="item-info"><span>📊</span> {{ $rank['total_terjual'] }} Terjual</div>
                    </td>

                    <td>
                        <div class="item-info"><span>🔥</span> Rp {{ number_format($rank['harga'], 0, ',', '.') }}</div>
                    </td>

                    <td class="score-highlight" style="text-align: center;">
                        {{ number_format($rank['score'], 4) }}
                    </td>

                    <td style="text-align: center;">
                        @if($index + 1 == 1)
                            <span class="badge-pill-status status-sangat-rekomendasi">Sangat Direkomendasikan</span>
                        @elseif($rank['score'] >= 0.5)
                            <span class="badge-pill-status status-rekomendasi">Direkomendasikan</span>
                        @else
                            <span class="badge-pill-status status-cukup">Cukup Baik</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 3rem; color: var(--text-muted);">
                        📭 Belum ada data produk untuk dianalisis.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection