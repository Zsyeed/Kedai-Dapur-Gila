@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
<section class="section">
    <div class="section-container" style="max-width:900px;">
        <h2 class="section-title font-display" style="margin-bottom:2rem;">
            <i class="fas fa-receipt"></i> Pesanan Saya
        </h2>

        @if($pesanan->isNotEmpty())
            <div class="pesanan-list">
                @foreach($pesanan as $t)
                    <div class="pesanan-card">
                        <div class="pesanan-card-header">
                            <div style="display:flex;align-items:center;gap:.75rem;">
                                <span class="pesanan-kode">{{ $t->kode_transaksi }}</span>
                                <span class="badge badge-{{ $t->status_color }}">{{ $t->status_label }}</span>
                            </div>
                            <a href="{{ route('pelanggan.pesanan.show', $t->id) }}" style="color:#ff5c5c;font-size:.78rem;font-weight:600;text-decoration:none;">
                                Detail <i class="fas fa-chevron-right" style="font-size:.65rem;"></i>
                            </a>
                        </div>
                        <div class="pesanan-card-body">
                            <span class="pesanan-date">{{ $t->created_at->locale('id')->isoFormat('D MMMM Y, HH:mm') }}</span>
                            <span class="pesanan-total">{{ $t->total_harga_formatted }}</span>
                        </div>
                        <div class="pesanan-card-footer">
                            <span><i class="fas fa-bowl-food"></i> {{ $t->detailTransaksi->count() }} menu &middot; {{ ucfirst($t->metode_pembayaran) }}</span>
                            @if($t->status === 'menunggu')
                                <form method="POST" action="{{ route('pelanggan.pesanan.batalkan', $t->id) }}" style="display:inline;" onsubmit="return confirm('Yakin ingin membatalkan pesanan {{ $t->kode_transaksi }}?')">
                                    @csrf
                                    <button type="submit" class="btn-secondary">
                                        <i class="fas fa-times-circle"></i> Batalkan
                                    </button>
                                </form>
                            @elseif($t->status === 'dibatalkan')
                                <span style="font-style:italic;">Dibatalkan</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="pagination">{{ $pesanan->withQueryString()->links() }}</div>
        @else
            <div class="empty-state">
                <i class="fas fa-receipt"></i>
                <h3>Belum ada pesanan</h3>
                <p>Mulai pesan ramen favoritmu sekarang!</p>
                <a href="{{ route('pelanggan.menu') }}" class="btn-primary">Lihat Menu</a>
            </div>
        @endif
    </div>
</section>
@endsection