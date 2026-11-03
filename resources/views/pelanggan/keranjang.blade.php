@extends('layouts.app')

@section('title', 'Keranjang')

@section('content')
<section class="section">
    <div class="section-container" style="max-width:900px;">
        <h2 class="section-title font-display" style="margin-bottom:2rem;">
            <i class="fas fa-shopping-bag"></i> Keranjang
        </h2>

        @if($items->isNotEmpty())
            <div class="cart-list">
                @foreach($items as $item)
                    <div class="cart-item">
                        <img src="{{ $item->produk->gambar_url }}" alt="{{ $item->produk->nama }}">
                        <div class="cart-item-info" style="flex:1;">
                            <h4>{{ $item->produk->nama }}</h4>
                            <span class="cart-item-price">{{ $item->produk->harga_formatted }}</span>
                        </div>
                        <form method="POST" action="{{ route('pelanggan.keranjang.update', $item->id) }}" style="display:inline;">
                            @csrf
                            @method('PUT')
                            <div class="qty-control">
                                <button type="button" class="qty-btn" onclick="changeQty(this, -1)">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" name="jumlah" value="{{ $item->jumlah }}" class="qty-value" min="1" max="{{ $item->produk->stok }}" readonly>
                                <button type="button" class="qty-btn" onclick="changeQty(this, 1)">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </form>
                        <span class="cart-item-subtotal">{{ $item->subtotal_formatted }}</span>
                        <form method="POST" action="{{ route('pelanggan.keranjang.hapus', $item->id) }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-remove-cart" title="Hapus">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>

            <!-- Cart Summary -->
            <div class="cart-summary">
                <div class="cart-summary-row">
                    <span>Total ({{ $items->count() }} item)</span>
                    <strong class="cart-total">{{ 'Rp ' . number_format($total, 0, ',', '.') }}</strong>
                </div>
                <a href="{{ route('pelanggan.checkout') }}" class="btn-primary btn-full" style="margin-top:1rem;">
                    Checkout <i class="fas fa-arrow-right"></i>
                </a>
                <a href="{{ route('pelanggan.menu') }}" class="btn-secondary btn-full" style="margin-top:0.5rem;text-align:center;display:block;">
                    Lanjut Belanja
                </a>
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-shopping-bag"></i>
                <h3>Keranjang kosong</h3>
                <p>Ayo mulai pilih ramen favoritmu!</p>
                <a href="{{ route('pelanggan.menu') }}" class="btn-primary">Lihat Menu</a>
            </div>
        @endif
    </div>
</section>
@endsection