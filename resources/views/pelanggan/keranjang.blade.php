@extends('layouts.app')

@section('title', 'Keranjang')

@section('content')
<section class="section bg-light" style="min-height: 80vh; padding-top: 3rem;">
    <div class="section-container" style="max-width: 1000px;">
        
        <h2 class="section-title" style="margin-bottom:2rem; font-size: 2rem;">
            <i class="fas fa-shopping-bag" style="color: var(--accent); margin-right: 0.5rem;"></i> Keranjang Belanja
        </h2>

        @if($items->isNotEmpty())
            <div class="cart-layout">
                
                <!-- Kiri: Daftar Produk -->
                <div class="cart-list">
                    @foreach($items as $item)
                        <div class="cart-item">
                            <img src="{{ $item->produk->gambar_url }}" alt="{{ $item->produk->nama }}">
                            
                            <div class="cart-item-info" style="flex:1;">
                                <h4>{{ $item->produk->nama }}</h4>
                                <span class="cart-item-price">{{ $item->produk->harga_formatted }} / porsi</span>
                            </div>
                            
                            <form method="POST" action="{{ route('pelanggan.keranjang.update', $item->id) }}" id="form-qty-{{ $item->id }}">
                                @csrf
                                @method('PUT')
                                <div class="qty-control">
                                    <button type="button" class="qty-btn" onclick="changeQty(this, -1, 'form-qty-{{ $item->id }}')">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" name="jumlah" value="{{ $item->jumlah }}" class="qty-value" min="1" max="{{ $item->produk->stok }}" readonly>
                                    <button type="button" class="qty-btn" onclick="changeQty(this, 1, 'form-qty-{{ $item->id }}')">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </form>

                            <span class="cart-item-subtotal">{{ $item->subtotal_formatted }}</span>
                            
                            <form method="POST" action="{{ route('pelanggan.keranjang.hapus', $item->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-remove-cart" title="Hapus dari keranjang" onclick="return confirm('Hapus menu ini dari keranjang?')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>

                <!-- Kanan: Ringkasan Harga -->
                <div class="cart-summary">
                    <h3>Ringkasan Pesanan</h3>
                    <div class="cart-summary-row">
                        <span style="color: var(--text-muted);">Total ({{ $items->count() }} menu)</span>
                        <strong class="cart-total">{{ 'Rp ' . number_format($total, 0, ',', '.') }}</strong>
                    </div>
                    
                    <a href="{{ route('pelanggan.checkout') }}" class="btn-primary btn-full">
                        Checkout Pesanan <i class="fas fa-arrow-right"></i>
                    </a>
                    <a href="{{ route('pelanggan.menu') }}" class="btn-secondary btn-full" style="margin-top: 0.75rem;">
                        <i class="fas fa-arrow-left"></i> Tambah Menu Lain
                    </a>
                </div>

            </div>
        @else
            <!-- Tampilan Saat Keranjang Kosong -->
            <div class="empty-state" style="background: white; border-radius: 12px; border: 1px solid #f3f4f6;">
                <i class="fas fa-shopping-basket"></i>
                <h3>Keranjang masih kosong</h3>
                <p>Ayo mulai pilih ramen fusion favoritmu sekarang!</p>
                <a href="{{ route('pelanggan.menu') }}" class="btn-red" style="margin-top: 1.5rem;">
                    Lihat Menu Dapur Gila
                </a>
            </div>
        @endif

    </div>
</section>
@endsection

@push('scripts')
<script>
    // Fungsi untuk menambah/mengurangi quantity dan otomatis submit form
    function changeQty(button, change, formId) {
        let input = button.parentElement.querySelector('.qty-value');
        let currentValue = parseInt(input.value);
        let max = parseInt(input.getAttribute('max'));
        let min = parseInt(input.getAttribute('min'));
        
        let newValue = currentValue + change;
        
        if (newValue >= min && newValue <= max) {
            input.value = newValue;
            // Otomatis submit form agar harga ter-update di database
            document.getElementById(formId).submit();
        } else if (newValue > max) {
            alert('Maaf, stok hanya tersisa ' + max + ' porsi.');
        }
    }
</script>
@endpush