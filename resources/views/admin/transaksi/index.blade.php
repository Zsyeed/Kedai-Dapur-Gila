@extends('layouts.admin')

@section('page-title', 'Kelola Transaksi')

@section('content')
<div class="admin-card-header" style="margin-bottom:1.5rem;">
    <form method="GET" action="{{ route('admin.transaksi.index') }}" style="display:flex; gap:0.5rem; align-items:center; flex-wrap: wrap;">
        <div class="search-input-wrapper">
            <i class="fas fa-search search-icon"></i>
            <input type="text"
                   name="cari"
                   value="{{ request('cari') }}"
                   placeholder="Cari kode transaksi..."
                   class="search-input">
        </div>
        <select name="status" class="form-select form-select-sm status-select">
            <option value="">Semua Status</option>
            <option value="menunggu" {{ request('status') === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
            <option value="diproses" {{ request('status') === 'diproses' ? 'selected' : '' }}>Diproses</option>
            <option value="diantar" {{ request('status') === 'diantar' ? 'selected' : '' }}>Sedang Dikirim</option>
            <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
            <option value="dibatalkan" {{ request('status') === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
        </select>
        
        <!-- Pertahankan nilai per_page saat melakukan filter/pencarian -->
        @if(request('per_page'))
            <input type="hidden" name="per_page" value="{{ request('per_page') }}">
        @endif

        <button type="submit" class="btn-sm btn-outline">
            <i class="fas fa-filter"></i> Cari
        </button>
    </form>
</div>

<div class="admin-card">
    <div class="admin-table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Pelanggan</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Pembayaran</th>
                    <th>Bukti</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksi as $t)
                    <tr>
                        <!-- Kode -->
                        <td>
                            <a href="{{ route('admin.transaksi.show', $t) }}"
                               class="text-accent">
                                {{ $t->kode_transaksi }}
                            </a>
                        </td>

                        <!-- Pelanggan -->
                        <td>{{ $t->user->nama }}</td>

                        <!-- Items -->
                        <td>{{ $t->detailTransaksi->count() }} menu</td>

                        <!-- Total -->
                        <td>{{ $t->total_harga_formatted }}</td>

                        <!-- Metode Pembayaran -->
                        <td>
                            <span class="badge badge-neutral" style="text-transform:capitalize;">
                                {{ $t->metode_pembayaran }}
                            </span>
                        </td>

                        <!-- Bukti Pembayaran -->
                        <td>
                            @if($t->bukti_pembayaran)
                                <a href="{{ asset('storage/' . $t->bukti_pembayaran) }}"
                                   target="_blank"
                                   class="btn-sm btn-outline"
                                   title="Lihat Bukti Pembayaran">
                                    <i class="fas fa-image"></i> Lihat
                                </a>
                            @else
                                <span style="color:var(--text-muted); font-size:0.8rem;">
                                    -
                                </span>
                            @endif
                        </td>

                        <!-- Status -->
                        <td>
                            <span class="badge badge-{{ $t->status_color }}">
                                {{ $t->status_label }}
                            </span>
                        </td>

                        <!-- Tanggal -->
                        <td style="color:var(--text-muted); font-size:0.82rem;">
                            {{ $t->created_at->locale('id')->isoFormat('D MMM, HH:mm') }}
                        </td>

                        <!-- Aksi -->
                        <td>
                            <a href="{{ route('admin.transaksi.show', $t) }}"
                               class="btn-sm btn-outline"
                               title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" style="text-align:center; padding:2rem; color:var(--text-muted);">
                            Belum ada transaksi.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Bagian Pagination & Dropdown Limit Baris -->
    @if($transaksi->hasPages() || $transaksi->total() > 0)
        <div style="padding: 1.25rem 1.5rem; border-top: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; background: #f8fafc;">
            
            <!-- Kiri: Dropdown Pilih Jumlah Tampilan & Info Total -->
            <div style="display: flex; align-items: center; gap: 0.75rem; font-size: 0.85rem; color: var(--text-muted);">
                <span>Menampilkan</span>
                <form method="GET" action="{{ route('admin.transaksi.index') }}" id="perPageForm" style="display: inline-flex; align-items: center;">
                    @if(request('cari'))
                        <input type="hidden" name="cari" value="{{ request('cari') }}">
                    @endif
                    @if(request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif

                    <select name="per_page" onchange="document.getElementById('perPageForm').submit()" style="padding: 0.35rem 0.6rem; border: 1px solid #d1d5db; border-radius: 6px; background: #fff; font-size: 0.85rem; outline: none; cursor: pointer;">
                        <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                        <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                    </select>
                </form>
                <span>dari total <strong>{{ $transaksi->total() }}</strong> data</span>
            </div>

            <!-- Kanan: Tombol Panah Navigasi Saja (< >) -->
            <div class="pagination-arrows-only">
                @if ($transaksi->onFirstPage())
                    <span class="page-btn disabled" title="Halaman Sebelumnya">‹</span>
                @else
                    <a href="{{ $transaksi->previousPageUrl() }}" class="page-btn" title="Halaman Sebelumnya">‹</a>
                @endif

                @if ($transaksi->hasMorePages())
                    <a href="{{ $transaksi->nextPageUrl() }}" class="page-btn" title="Halaman Selanjutnya">›</a>
                @else
                    <span class="page-btn disabled" title="Halaman Selanjutnya">›</span>
                @endif
            </div>

        </div>
    @endif
</div>
@endsection