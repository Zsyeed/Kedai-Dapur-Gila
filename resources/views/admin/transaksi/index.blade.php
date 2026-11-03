@extends('layouts.admin')

@section('page-title', 'Kelola Transaksi')

@section('content')
<div class="admin-card-header" style="margin-bottom:1.5rem;">
    <div class="search-input" style="max-width:350px;">
        <i class="fas fa-search"></i>
        <form method="GET" action="{{ route('admin.transaksi.index') }}" style="display:flex;gap:0.5rem;">
            <input type="text"
                   name="cari"
                   value="{{ request('cari') }}"
                   placeholder="Cari kode transaksi..."
                   class="form-input"
                   style="padding-left:2.5rem;">

            <select name="status" class="form-select form-select-sm" style="width:auto;">
                <option value="">Semua Status</option>
                <option value="menunggu" {{ request('status') === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                <option value="diproses" {{ request('status') === 'diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="diantar" {{ request('status') === 'diantar' ? 'selected' : '' }}>Sedang Dikirim</option>
                <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="dibatalkan" {{ request('status') === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
            </select>

            <button type="submit" class="btn-sm btn-outline">
                <i class="fas fa-filter"></i> Cari
            </button>
        </form>
    </div>
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

    <div class="pagination">
        {{ $transaksi->withQueryString()->links() }}
    </div>
</div>
@endsection