@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
<section class="section bg-light" style="min-height: 80vh; padding-top: 3rem;">
    <div class="section-container" style="max-width: 900px;">
        
        <h2 class="section-title" style="margin-bottom: 2rem; font-size: 2rem;">
            <i class="fas fa-receipt" style="color: var(--accent); margin-right: 0.5rem;"></i> Pesanan Saya
        </h2>

        @if($pesanan->isNotEmpty())
            <div class="pesanan-list">
                @foreach($pesanan as $t)
                    <div class="pesanan-card">
                        
                        <!-- Header Kartu: Kode & Status -->
                        <div class="pesanan-card-header">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <span class="pesanan-kode">#{{ $t->kode_transaksi }}</span>
                                <span class="badge badge-{{ $t->status_color }}">{{ $t->status_label }}</span>
                            </div>
                            <a href="{{ route('pelanggan.pesanan.show', $t->id) }}" style="color: var(--accent); font-size: 0.85rem; font-weight: 700; display: inline-flex; align-items: center; gap: 0.3rem;">
                                Detail Pesanan <i class="fas fa-arrow-right" style="font-size: 0.7rem;"></i>
                            </a>
                        </div>

                        <!-- Body Kartu: Tanggal & Total Harga -->
                        <div class="pesanan-card-body">
                            <span class="pesanan-date">
                                <i class="far fa-calendar-alt" style="margin-right: 4px;"></i> 
                                {{ $t->created_at->locale('id')->isoFormat('D MMMM Y, HH:mm') }}
                            </span>
                            <span class="pesanan-total">{{ $t->total_harga_formatted }}</span>
                        </div>

                        <!-- Footer Kartu: Jumlah Menu, Metode Pembayaran & Tombol Batal -->
                        <div class="pesanan-card-footer">
                            <span>
                                <i class="fas fa-bowl-food" style="margin-right: 4px; color: var(--accent);"></i> 
                                {{ $t->detailTransaksi->count() }} menu &middot; 
                                <strong style="text-transform: uppercase;">{{ $t->metode_pembayaran }}</strong>
                            </span>

                            <div>
                                @if($t->status === 'menunggu')
                                    <form method="POST" action="{{ route('pelanggan.pesanan.batalkan', $t->id) }}" style="display:inline;" onsubmit="return confirm('Yakin ingin membatalkan pesanan #{{ $t->kode_transaksi }}?')">
                                        @csrf
                                        <button type="submit" class="btn-batalkan">
                                            <i class="fas fa-times-circle"></i> Batalkan Pesanan
                                        </button>
                                    </form>
                                @elseif($t->status === 'dibatalkan')
                                    <span style="font-style: italic; color: #ef4444; font-weight: 600;">Pesanan Dibatalkan</span>
                                @endif
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div style="margin-top: 2.5rem; display: flex; justify-content: center;">
                {{ $pesanan->withQueryString()->links() }}
            </div>
        @else
            <!-- Tampilan Kosong -->
            <div class="empty-state" style="background: white; border-radius: 12px; border: 1px solid #f3f4f6; padding: 4rem 1rem;">
                <i class="fas fa-receipt" style="font-size: 3.5rem; color: #d1d5db; margin-bottom: 1rem;"></i>
                <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem;">Belum ada pesanan</h3>
                <p style="color: var(--text-muted); margin-bottom: 1.5rem;">Ayo mulai pesan ramen fusion favoritmu sekarang!</p>
                <a href="{{ route('pelanggan.menu') }}" class="btn-red" style="padding: 0.75rem 1.5rem; border-radius: 8px;">
                    Lihat Menu Dapur Gila
                </a>
            </div>
        @endif

    </div>
</section>
@endsection