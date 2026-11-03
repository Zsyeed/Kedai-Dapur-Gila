@extends('layouts.owner')

@section('page-title', 'Dashboard Owner')

@section('content')
<!-- Stat Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(5,150,105,0.15);color:#34d399;">
            <i class="fas fa-money-bill-wave"></i>
        </div>
        <div class="stat-info">
            <span class="stat-label">Total Pendapatan</span>
            <strong class="stat-value">{{ 'Rp ' . number_format($stats['total_pendapatan'], 0, ',', '.') }}</strong>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(59, 130, 246, 0.15);color:#60a5fa;">
            <i class="fas fa-calendar-day"></i>
        </div>
        <div class="stat-info">
            <span class="stat-label">Pendapatan Hari Ini</span>
            <strong class="stat-value">{{ 'Rp ' . number_format($stats['pendapatan_hari_ini'], 0, ',', '.') }}</strong>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(185,28,28,0.15);color:#f87171;">
            <i class="fas fa-receipt"></i>
        </div>
        <div class="stat-info">
            <span class="stat-label">Total Pesanan</span>
            <strong class="stat-value">{{ $stats['total_pesanan'] }}</strong>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(217,119,6,0.15);color:#fbbf24;">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stat-info">
            <span class="stat-label">Menunggu Proses</span>
            <strong class="stat-value">{{ $stats['menunggu'] }}</strong>
        </div>
    </div>
</div>

<!-- Chart + Produk Terlaris -->
<div class="admin-grid">
    <div class="admin-card" style="grid-column: span 2;">
        <div class="admin-card-header">
            <h3 class="admin-card-title">Pendapatan 7 Hari Terakhir</h3>
        </div>
        <div style="padding:1rem;">
            <canvas id="pendapatanChart"
                    data-labels="{{ json_encode($chart['labels']) }}"
                    data-values="{{ json_encode($chart['data']) }}"
                    height="120">
            </canvas>
        </div>
    </div>

    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">Produk Terlaris</h3>
        </div>
        <div class="top-products">
            @foreach($produkTerlaris as $i => $p)
                <div class="top-product-item">
                    <span class="top-product-rank">{{ $i + 1 }}</span>
                    <img src="{{ $p->gambar_url }}" alt="{{ $p->nama }}" style="width:36px;height:36px;border-radius:8px;object-fit:cover;">
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:0.82rem;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $p->nama }}</div>
                        <div style="font-size:0.72rem;color:#888;">{{ $p->total_terjual }} terjual</div>
                    </div>
                </div>
            @endforeach
            @if($produkTerlaris->isEmpty())
                <p style="color:#888;text-align:center;padding:1rem;">Belum ada data.</p>
            @endif
        </div>
    </div>
</div>

<!-- Status Ringkasan -->
<div class="admin-grid">
    <div class="admin-card">
        <h3 class="admin-card-title" style="margin-bottom:1rem;">Ringkasan Status</h3>
        <div class="status-list">
            <div class="status-item">
                <div class="status-dot" style="background:#fbbf24;"></div>
                <span class="status-label">Menunggu</span>
                <strong>{{ $stats['menunggu'] }}</strong>
            </div>
            <div class="status-item">
                <div class="status-dot" style="background:#60a5fa;"></div>
                <span class="status-label">Diproses</span>
                <strong>{{ $stats['diproses'] }}</strong>
            </div>
            <div class="status-item">
                <div class="status-dot" style="background:#34d399;"></div>
                <span class="status-label">Selesai</span>
                <strong>{{ $stats['selesai'] }}</strong>
            </div>
            <div class="status-item">
                <div class="status-dot" style="background:#f87171;"></div>
                <span class="status-label">Dibatalkan</span>
                <strong>{{ $stats['dibatalkan'] }}</strong>
            </div>
        </div>
    </div>

    <div class="admin-card" style="grid-column: span 2;">
        <div class="admin-card-header">
            <h3 class="admin-card-title">Pesanan Terbaru</h3>
        </div>
        <div class="admin-table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pesananTerbaru as $t)
                        <tr>
                            <td style="font-weight:600;">{{ $t->kode_transaksi }}</td>
                            <td>{{ $t->user->nama }}</td>
                            <td>{{ $t->total_harga_formatted }}</td>
                            <td><span class="badge badge-{{ $t->status_color }}">{{ $t->status_label }}</span></td>
                            <td style="color:#888;font-size:.82rem;">{{ $t->created_at->locale('id')->isoFormat('D MMM, HH:mm') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection