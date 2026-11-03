@extends('layouts.owner')

@section('page-title', 'Stok Produk')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4><i class="fas fa-boxes"></i> Daftar Produk & Stok</h4>
    </div>

    <div class="card shadow border-0">
        <div class="admin-card">
            <div class="admin-table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width: 60px;">Gambar</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th class="text-center">Stok</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stok as $s)
                        <tr>
                            <td>
                                <img src="{{ $s->gambar_url }}" alt="{{ $s->nama }}" style="width:48px;height:48px;border-radius:8px;object-fit:cover;">
                            </td>
                            <td><strong>{{ $s->nama }}</strong></td>
                            <td><span class="badge badge-neutral">{{ $s->kategori }}</span></td>
                            <td>{{ $s->harga_formatted }}</td>
                            <td class="text-center">
                                <h5 class="mb-0">
                                    {{-- Warna Badge Berubah Berdasarkan Jumlah Stok --}}
                                    <span class="badge {{ $s->stok <= 5 ? 'bg-danger' : 'bg-success' }}">
                                        {{ $s->stok }}
                                    </span>
                                </h5>
                            </td>
                            <td>
                                @if($s->stok <= 0)
                                    <span class="badge rounded-pill bg-danger">Habis</span>
                                @elseif($s->stok <= 10)
                                    <span class="badge rounded-pill bg-warning text-dark">Stok Menipis</span>
                                @else
                                    <span class="badge rounded-pill bg-info text-dark">Aman</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada data produk.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection