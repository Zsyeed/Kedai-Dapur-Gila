@extends('layouts.owner')

@section('page-title', 'Dashboard Owner')

@section('content')
<!-- 1. Stat Cards -->
<div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <div class="stat-card" style="background: var(--bg-card); padding: 1.25rem; border-radius: 0.75rem; border: 1px solid var(--border-color); display: flex; align-items: center; gap: 1rem;">
        <div class="stat-icon" style="background: rgba(5, 150, 105, 0.15); color: #10b981; width: 48px; height: 48px; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">
            <i class="fas fa-money-bill-wave"></i>
        </div>
        <div class="stat-info">
            <span style="font-size: 0.85rem; color: var(--text-muted); display: block;">Total Pendapatan</span>
            <strong style="font-size: 1.15rem; color: var(--text-main);">{{ 'Rp ' . number_format($stats['total_pendapatan'], 0, ',', '.') }}</strong>
        </div>
    </div>
    
    <div class="stat-card" style="background: var(--bg-card); padding: 1.25rem; border-radius: 0.75rem; border: 1px solid var(--border-color); display: flex; align-items: center; gap: 1rem;">
        <div class="stat-icon" style="background: rgba(59, 130, 246, 0.15); color: #3b82f6; width: 48px; height: 48px; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">
            <i class="fas fa-calendar-day"></i>
        </div>
        <div class="stat-info">
            <span style="font-size: 0.85rem; color: var(--text-muted); display: block;">Pendapatan Hari Ini</span>
            <strong style="font-size: 1.15rem; color: var(--text-main);">{{ 'Rp ' . number_format($stats['pendapatan_hari_ini'], 0, ',', '.') }}</strong>
        </div>
    </div>
    
    <div class="stat-card" style="background: var(--bg-card); padding: 1.25rem; border-radius: 0.75rem; border: 1px solid var(--border-color); display: flex; align-items: center; gap: 1rem;">
        <div class="stat-icon" style="background: rgba(185, 28, 28, 0.15); color: #ef4444; width: 48px; height: 48px; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">
            <i class="fas fa-receipt"></i>
        </div>
        <div class="stat-info">
            <span style="font-size: 0.85rem; color: var(--text-muted); display: block;">Total Pesanan</span>
            <strong style="font-size: 1.15rem; color: var(--text-main);">{{ $stats['total_pesanan'] }}</strong>
        </div>
    </div>
    
    <div class="stat-card" style="background: var(--bg-card); padding: 1.25rem; border-radius: 0.75rem; border: 1px solid var(--border-color); display: flex; align-items: center; gap: 1rem;">
        <div class="stat-icon" style="background: rgba(217, 119, 6, 0.15); color: #f59e0b; width: 48px; height: 48px; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stat-info">
            <span style="font-size: 0.85rem; color: var(--text-muted); display: block;">Menunggu Proses</span>
            <strong style="font-size: 1.15rem; color: var(--text-main);">{{ $stats['menunggu'] }}</strong>
        </div>
    </div>
</div>

<!-- 2. Chart + Produk Terlaris -->
<div class="admin-grid" style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
    <!-- Grafik Pendapatan -->
    <div class="admin-card" style="display: flex; flex-direction: column;">
        <div class="admin-card-header">
            <h3 class="admin-card-title">Pendapatan 7 Hari Terakhir</h3>
        </div>
        <div style="padding: 1.5rem; flex-grow: 1;">
            <canvas id="pendapatanChart" 
                    data-labels="{{ json_encode($chart['labels']) }}" 
                    data-values="{{ json_encode($chart['data']) }}" 
                    style="width: 100%; max-height: 280px;">
            </canvas>
        </div>
    </div>

    <!-- Produk Terlaris -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">Produk Terlaris</h3>
        </div>
        <div class="top-products" style="padding: 1rem 1.5rem;">
            @forelse($produkTerlaris as $i => $p)
                <div class="top-product-item" style="display: flex; align-items: center; gap: 1rem; padding: 0.75rem 0; border-bottom: 1px solid var(--border-color);">
                    <span class="top-product-rank" style="font-weight: bold; color: var(--owner-color); width: 20px;">#{{ $i + 1 }}</span>
                    <img src="{{ $p->gambar_url }}" alt="{{ $p->nama }}" style="width: 40px; height: 40px; border-radius: 8px; object-fit: cover;">
                    <div style="flex: 1; min-width: 0;">
                        <div style="font-size: 0.9rem; font-weight: 600; color: var(--text-main); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $p->nama }}</div>
                        <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $p->total_terjual }} terjual</div>
                    </div>
                </div>
            @empty
                <p style="color: var(--text-muted); text-align: center; padding: 2rem 0;">Belum ada data.</p>
            @endforelse
        </div>
    </div>
</div>

<!-- 3. Status Ringkasan & Pesanan Terbaru -->
<div class="admin-grid" style="display: grid; grid-template-columns: 1fr 2fr; gap: 1.5rem;">
    <!-- Status Ringkasan -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">Ringkasan Status</h3>
        </div>
        <div class="status-list" style="padding: 1.25rem 1.5rem; display: flex; flex-direction: column; gap: 1rem;">
            <div class="status-item" style="display: flex; justify-content: space-between; padding: 0.75rem 1rem; background: var(--bg-body); border-radius: 0.5rem; border: 1px solid var(--border-color);">
                <div style="display: flex; align-items: center;"><div style="width:10px; height:10px; border-radius:50%; background:#f59e0b; margin-right:10px;"></div><span style="color:var(--text-muted); font-size:0.9rem;">Menunggu</span></div>
                <strong style="color:var(--text-main);">{{ $stats['menunggu'] }}</strong>
            </div>
            <div class="status-item" style="display: flex; justify-content: space-between; padding: 0.75rem 1rem; background: var(--bg-body); border-radius: 0.5rem; border: 1px solid var(--border-color);">
                <div style="display: flex; align-items: center;"><div style="width:10px; height:10px; border-radius:50%; background:#3b82f6; margin-right:10px;"></div><span style="color:var(--text-muted); font-size:0.9rem;">Diproses</span></div>
                <strong style="color:var(--text-main);">{{ $stats['diproses'] }}</strong>
            </div>
            <div class="status-item" style="display: flex; justify-content: space-between; padding: 0.75rem 1rem; background: var(--bg-body); border-radius: 0.5rem; border: 1px solid var(--border-color);">
                <div style="display: flex; align-items: center;"><div style="width:10px; height:10px; border-radius:50%; background:#10b981; margin-right:10px;"></div><span style="color:var(--text-muted); font-size:0.9rem;">Selesai</span></div>
                <strong style="color:var(--text-main);">{{ $stats['selesai'] }}</strong>
            </div>
            <div class="status-item" style="display: flex; justify-content: space-between; padding: 0.75rem 1rem; background: var(--bg-body); border-radius: 0.5rem; border: 1px solid var(--border-color);">
                <div style="display: flex; align-items: center;"><div style="width:10px; height:10px; border-radius:50%; background:#ef4444; margin-right:10px;"></div><span style="color:var(--text-muted); font-size:0.9rem;">Dibatalkan</span></div>
                <strong style="color:var(--text-main);">{{ $stats['dibatalkan'] }}</strong>
            </div>
        </div>
    </div>

    <!-- Pesanan Terbaru -->
    <div class="admin-card">
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
                    @forelse($pesananTerbaru as $t)
                        <tr>
                            <td style="font-weight:600; color: var(--owner-color);">{{ $t->kode_transaksi }}</td>
                            <td>{{ $t->user->nama }}</td>
                            <td style="font-weight:500;">{{ $t->total_harga_formatted }}</td>
                            <td><span class="badge badge-{{ $t->status_color }}">{{ $t->status_label }}</span></td>
                            <td style="color:var(--text-muted); font-size:0.85rem;">{{ $t->created_at->locale('id')->isoFormat('D MMM, HH:mm') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" style="text-align:center; padding: 2rem; color: var(--text-muted);">Belum ada pesanan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // SCRIPT INI WAJIB ADA AGAR GRAFIK MUNCUL!
    document.addEventListener('DOMContentLoaded', function() {
        const canvas = document.getElementById('pendapatanChart');
        if(canvas) {
            const ctx = canvas.getContext('2d');
            
            // Mengambil data dari atribut HTML canvas
            const rawLabels = canvas.getAttribute('data-labels');
            const rawValues = canvas.getAttribute('data-values');
            
            const labels = rawLabels ? JSON.parse(rawLabels) : [];
            const values = rawValues ? JSON.parse(rawValues) : [];

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Pendapatan (Rp)',
                        data: values,
                        borderColor: '#3b82f6', // Warna biru khas Owner
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.3, // Efek lengkung
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#3b82f6',
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, grid: { color: '#e2e8f0' } },
                        x: { grid: { display: false } }
                    }
                }
            });
        }
    });
</script>
@endpush