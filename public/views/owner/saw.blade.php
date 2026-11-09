@extends('layouts.owner')

@section('page-title', 'Analisis Metode SAW (Produk Terbaik)')
@section('content')
<style>
    /* 1. Pengaturan Dasar & Tipografi */
    .container-fluid {
        font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
        background-color: #f8fafc;
    }

    /* 2. Desain Kartu Utama & Bobot */
    .custom-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #edf2f7;
    }

    .weight-card {
        background-color: #fdf8f5; /* Cream lembut sesuai gambar */
        border: 1px solid #f3e8e0;
        border-radius: 12px;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        
        /* Perubahan Utama */
        justify-content: space-between; /* Memaksa teks kriteria di kiri & angka persen di kanan */
        width: 100%; 
    }

    .weight-icon {
        background-color: #f5e6dc;
        padding: 12px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 18px; /* Ukuran emoji pas */
        flex-shrink: 0;  /* Mencegah ikon gepeng */
    }

    /* 3. Desain Tabel Modern */
    .table-custom {
        width: 100%;
        margin-bottom: 0;
    }

    .table-custom thead th {
        background-color: #f8fafc;
        color: #64748b;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        padding: 14px 20px;
        border-bottom: 1px solid #edf2f7;
    }

    .table-custom tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: background-color 0.2s ease;
    }

    .table-custom tbody tr:hover {
        background-color: #f8fafc !important;
    }

    .table-custom tbody td {
        padding: 16px 20px;
        color: #334155;
        font-size: 14px;
        vertical-align: middle;
    }

    /* 4. Indikator Data Item Mini (Ikon & Teks) */
    .item-info {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        color: #334155;
    }

    /* 5. Badge Status Rekomendasi Kapsul Pill */
    .badge-pill-status {
        padding: 8px 16px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
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

    /* 6. Desain Skor Akhir Berwarna Tebal */
    .score-highlight {
        font-family: 'SFMono-Regular', Menlo, Monaco, Consolas, monospace;
        font-weight: 700;
        color: #1e293b;
        font-size: 15px;
    }

    /* 7. Penyesuaian Scrollbar */
    .table-responsive {
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 #f1f5f9;
    }
    .table-responsive::-webkit-scrollbar { height: 5px; }
    .table-responsive::-webkit-scrollbar-track { background: #f1f5f9; }
    .table-responsive::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
</style>

<div class="container-fluid px-4 py-4" style="min-height: 100vh;">
    <div class="mb-4">
        <h4 class="m-0 fw-bold text-dark" style="font-size: 20px;">Analisis Metode SAW</h4>
        <p class="text-muted small mb-0">Sistem Pendukung Keputusan Penentuan Produk Rekomendasi</p>
    </div>

    <div class="custom-card shadow-sm p-4 mb-4" style="background: #ffffff; border-radius: 16px; border: 1px solid #edf2f7;">
        <div class="d-flex align-items-center mb-3">
            <h5 class="fw-bold m-0" style="font-size: 14px; color: #1e293b;">Konfigurasi Bobot Kriteria Penilaian</h5>
        </div>
        
        <div style="display: flex; flex-direction: row; gap: 16px; width: 100%; justify-content: space-between; align-items: stretch;">
            
            <div style="flex: 1; min-width: 0;">
                <div class="weight-card" style="display: flex; align-items: center; justify-content: space-between; background-color: #fdf8f5; border: 1px solid #f3e8e0; border-radius: 12px; padding: 16px 20px; height: 100%;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div class="weight-icon" style="background-color: #f5e6dc; padding: 10px; border-radius: 10px; display: inline-flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;">📦</div>
                        <small class="text-muted fw-semibold" style="font-size: 13px; white-space: nowrap;">C1 - Stok Produk (Benefit)</small>
                    </div>
                    <span class="fs-5 fw-bold text-dark" style="white-space: nowrap; margin-left: 8px;">{{ $weights['c1'] * 100 }}%</span>
                </div>
            </div>

            <div style="flex: 1; min-width: 0;">
                <div class="weight-card" style="display: flex; align-items: center; justify-content: space-between; background-color: #fdf8f5; border: 1px solid #f3e8e0; border-radius: 12px; padding: 16px 20px; height: 100%;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div class="weight-icon" style="background-color: #f5e6dc; padding: 10px; border-radius: 10px; display: inline-flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;">📈</div>
                        <small class="text-muted fw-semibold" style="font-size: 13px; white-space: nowrap;">C2 - Total Terjual (Benefit)</small>
                    </div>
                    <span class="fs-5 fw-bold text-dark" style="white-space: nowrap; margin-left: 8px;">{{ $weights['c2'] * 100 }}%</span>
                </div>
            </div>

            <div style="flex: 1; min-width: 0;">
                <div class="weight-card" style="display: flex; align-items: center; justify-content: space-between; background-color: #fdf8f5; border: 1px solid #f3e8e0; border-radius: 12px; padding: 16px 20px; height: 100%;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div class="weight-icon" style="background-color: #f5e6dc; padding: 10px; border-radius: 10px; display: inline-flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;">💰</div>
                        <small class="text-muted fw-semibold" style="font-size: 13px; white-space: nowrap;">C3 - Harga Produk (Cost)</small>
                    </div>
                    <span class="fs-5 fw-bold text-dark" style="white-space: nowrap; margin-left: 8px;">{{ $weights['c3'] * 100 }}%</span>
                </div>
            </div>

        </div>
    </div>

    <div class="custom-card shadow-sm overflow-hidden">
        <div class="p-4 border-bottom border-light">
            <h5 class="fw-bold m-0" style="font-size: 14px; color: #1e293b;">Hasil Perankingan Rekomendasi</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-custom align-middle">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 100px;">RANKING</th>
                            <th>NAMA PRODUK</th>
                            <th>STOK</th>
                            <th>TERJUAL</th>
                            <th>HARGA</th>
                            <th class="text-center">SKOR AKHIR (V)</th>
                            <th class="text-end" style="width: 240px;">STATUS REKOMENDASI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rankings as $index => $rank)
                        <tr>
                            <td class="text-center" style="vertical-align: middle;">
                                @if($index + 1 == 1)
                                    <span class="badge bg-warning text-dark px-2 py-1 fw-bold" style="background: linear-gradient(135deg, #ffe082 0%, #ffb300 100%) !important; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; min-width: 45px;">🥇 1</span>
                                @elseif($index + 1 == 2)
                                    <span class="badge bg-light text-secondary px-2 py-1 fw-bold" style="border: 1px solid #cbd5e1; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; min-width: 45px;">🥈 2</span>
                                @elseif($index + 1 == 3)
                                    <span class="badge bg-light text-secondary px-2 py-1 fw-bold" style="border: 1px solid #cbd5e1; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; min-width: 45px;">🥉 3</span>
                                @else
                                    <span class="text-secondary fw-semibold d-inline-block text-center" style="min-width: 45px; padding-left: 15px;">{{ $index + 1 }}</span>
                                @endif
                            </td>

                            <td class="fw-semibold text-dark">
                                {{ $rank['nama'] }}
                            </td>

                            <td>
                                <div class="item-info">
                                    <span>📦</span> {{ $rank['stok'] }} Pcs
                                </div>
                            </td>

                            <td>
                                <div class="item-info">
                                    <span>📊</span> {{ $rank['total_terjual'] }} Terjual
                                </div>
                            </td>

                            <td>
                                <div class="item-info">
                                    <span>🔥</span> Rp{{ number_format($rank['harga'], 0, ',', '.') }}
                                </div>
                            </td>

                            <td class="text-center score-highlight">
                                {{ number_format($rank['score'], 4) }}
                            </td>

                            <td class="text-end">
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
                            <td colspan="7" class="text-center py-5 text-muted">
                                📭 Belum ada data produk untuk dianalisis di database.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection