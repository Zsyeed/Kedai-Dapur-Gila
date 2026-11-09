@extends('layouts.admin')

@section('page-title', 'Dashboard')

@section('content')
<!-- Stat Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(185,28,28,0.15);color:#f87171;">
            <i class="fas fa-bowl-food"></i>
        </div>
        <div class="stat-info">
            <span class="stat-label">Total Produk</span>
            <strong class="stat-value">{{ $stats['total_produk'] }}</strong>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(5,150,105,0.15);color:#34d399;">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-info">
            <span class="stat-label">Tersedia</span>
            <strong class="stat-value">{{ $stats['produk_tersedia'] }}</strong>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(217,119,6,0.15);color:#fbbf24;">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div class="stat-info">
            <span class="stat-label">Stok Habis</span>
            <strong class="stat-value">{{ $stats['produk_habis'] }}</strong>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(59,130,246,0.15);color:#60a5fa;">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-info">
            <span class="stat-label">Pelanggan</span>
            <strong class="stat-value">{{ $stats['total_pelanggan'] }}</strong>
        </div>
    </div>
</div>

<!-- Pesanan Baru + Status -->
<div class="admin-grid">
    <div class="admin-card" style="grid-column: span 2;">
        <div class="admin-card-header">
            <h3 class="admin-card-title">Pesanan Terbaru</h3>
            <a href="{{ route('admin.transaksi.index') }}" class="btn-sm btn-outline">Lihat Semua</a>
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
                            <td><a href="{{ route('admin.transaksi.show', $t) }}" class="text-accent">{{ $t->kode_transaksi }}</a></td>
                            <td>{{ $t->user->nama }}</td>
                            <td>{{ $t->total_harga_formatted }}</td>
                            <td><span class="badge badge-{{ $t->status_color }}">{{ $t->status_label }}</span></td>
                            <td style="color:var(--text-muted);font-size:0.82rem;">{{ $t->created_at->locale('id')->isoFormat('D MMM, HH:mm') }}</td>
                        </tr>
                    @endforeach
                    @if($pesananTerbaru->isEmpty())
                        <tr><td colspan="5" style="text-align:center;color:var(--text-muted);">Belum ada pesanan</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">Status Pesanan</h3>
        </div>
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
                <strong>{{ $stats['total_pesanan'] }}</strong>
            </div>
        </div>
    </div>
</div>
@endsection