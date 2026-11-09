@extends('layouts.owner')

@section('page-title', 'Laporan Penjualan')

@section('content')
<!-- Header & Filter Action Bar -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
    <div>
        <p style="color: var(--text-muted); margin: 0; font-size: 0.95rem;">
            Daftar seluruh transaksi penjualan berdasarkan periode.
        </p>
    </div>

    <div style="display: flex; gap: 0.75rem; align-items: center;">
        <!-- Select Option (Filter) -->
        <form action="{{ route('owner.laporan.index') }}" method="GET" style="margin: 0;">
            <select name="filter" 
                    class="form-input" 
                    style="width: auto; padding: 0.5rem 1rem; cursor: pointer; border-radius: 0.375rem;" 
                    onchange="this.form.submit()">
                <option value="">Semua Periode</option>
                <option value="hari" {{ request('filter') == 'hari' ? 'selected' : '' }}>Hari Ini</option>
                <option value="minggu" {{ request('filter') == 'minggu' ? 'selected' : '' }}>Minggu Ini</option>
                <option value="bulan" {{ request('filter') == 'bulan' ? 'selected' : '' }}>Bulan Ini</option>
            </select>
        </form>

        <!-- Export PDF Button -->
        <a href="{{ route('owner.laporan.pdf', request()->query()) }}" class="btn-primary btn-sm" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1rem;">
            <i class="fa-solid fa-file-pdf"></i> Export PDF
        </a>
    </div>
</div>

<!-- Card Data Penjualan -->
<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title">Data Penjualan</h3>
    </div>

    <div class="admin-table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 60px;">No</th>
                    <th>Kode Transaksi</th>
                    <th>Tanggal</th>
                    <th style="text-align: right;">Total Harga</th>
                </tr>
            </thead>
            <tbody>
                @forelse($laporan as $item)
                <tr>
                    <td style="font-weight: 600; color: var(--owner-color);">
                        {{ $item->id }}
                    </td>
                    <td>
                        <span class="badge" style="background: #f1f5f9; color: var(--text-main); border: 1px solid var(--border-color); padding: 0.3rem 0.6rem;">
                            {{ $item->kode_transaksi }}
                        </span>
                    </td>
                    <td>
                        {{ $item->created_at->format('d M Y') }}
                    </td>
                    <td style="text-align: right; font-weight: 600; color: #10b981;">
                        Rp {{ number_format($item->total_harga, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding: 2.5rem; color: var(--text-muted);">
                        Belum ada data penjualan pada periode ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
            
            <!-- Footer Total Pendapatan -->
            <tfoot>
                <tr style="background-color: #f8fafc; border-top: 2px solid var(--border-color);">
                    <!-- Colspan diubah menjadi 3 agar pas dengan jumlah kolom di atasnya -->
                    <td colspan="3" style="text-align: right; font-weight: 600; padding: 1.25rem 1.5rem; color: var(--text-main);">
                        Total Pendapatan :
                    </td>
                    <td style="text-align: right; font-weight: 700; color: #10b981; font-size: 1.1rem; padding: 1.25rem 1.5rem;">
                        Rp {{ number_format($laporan->sum('total_harga'), 0, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection