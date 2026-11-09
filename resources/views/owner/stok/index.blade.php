@extends('layouts.owner')

@section('page-title', 'Stok Produk')

@section('content')
<style>
    /* CSS Khusus Badge Status Stok */
    .badge-status {
        padding: 0.4rem 0.85rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-block;
        text-align: center;
    }
    .status-habis {
        background-color: rgba(239, 68, 68, 0.15);
        color: #ef4444;
    }
    .status-menipis {
        background-color: rgba(245, 158, 11, 0.15);
        color: #d97706;
    }
    .status-aman {
        background-color: rgba(5, 150, 105, 0.15);
        color: #059669;
    }

    /* Tambahkan kelas ini untuk warna teks stok dinamis */
    .text-stok-kritis {
        font-weight: 700;
        font-size: 1rem;
        color: #ef4444;
    }
    .text-stok-normal {
        font-weight: 700;
        font-size: 1rem;
        color: var(--text-main);
    }
</style>

<!-- Kartu Utama Tabel Stok -->
<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title">
            <i class="fas fa-boxes" style="margin-right: 8px; color: var(--owner-color);"></i> Daftar Produk & Stok
        </h3>
    </div>

    <div class="admin-table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 70px;">Gambar</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th style="text-align: center;">Jumlah Stok</th>
                    <th>Status Stok</th>
                </tr>
            </thead>
            <tbody>
                @forelse($stok as $s)
                <tr>
                    <td>
                        <img src="{{ $s->gambar_url }}" alt="{{ $s->nama }}" style="width: 44px; height: 44px; border-radius: 8px; object-fit: cover;">
                    </td>
                    <td>
                        <strong style="color: var(--text-main);">{{ $s->nama }}</strong>
                    </td>
                    <td>
                        <span class="badge" style="background: #f1f5f9; color: var(--text-muted); border: 1px solid var(--border-color); padding: 0.25rem 0.6rem;">
                            {{ $s->kategori }}
                        </span>
                    </td>
                    <td style="font-weight: 500;">
                        {{ $s->harga_formatted }}
                    </td>
                    <td style="text-align: center;">
                        <span class="{{ $s->stok <= 5 ? 'text-stok-kritis' : 'text-stok-normal' }}">
                            {{ $s->stok }}
                        </span> 
                        <span style="font-size: 0.8rem; color: var(--text-muted);">Pcs</span>
                    </td>
                    <td>
                        @if($s->stok <= 0)
                            <span class="badge-status status-habis">Habis</span>
                        @elseif($s->stok <= 10)
                            <span class="badge-status status-menipis">Stok Menipis</span>
                        @else
                            <span class="badge-status status-aman">Aman</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 3rem; color: var(--text-muted);">
                        📭 Belum ada data produk di database.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection