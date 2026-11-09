@extends('layouts.app')

@section('title', 'Menu')

@section('content')
<section class="section">
    <div class="section-container">
        <div class="section-header" style="margin-bottom:2rem;">
            <div>
                <h2 class="section-title font-display">Menu Favorit Dapur Gila</h2>
                <p class="section-subtitle">Ramen fusion dengan cita rasa Indonesia</p>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="filter-bar">
            <form method="GET" action="{{ route('pelanggan.menu') }}" class="filter-search">
                <div class="search-input">
                    <i class="fas fa-search"></i>
                    <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari ramen..." class="form-input">
                </div>
            </form>
            <div class="filter-sort">
                <select name="sort" class="form-select form-select-sm" onchange="this.form.submit()" form="sortForm">
                    <option value="terbaru" {{ $sort === 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                    <option value="termurah" {{ $sort === 'termurah' ? 'selected' : '' }}>Termurah</option>
                    <option value="termahal" {{ $sort === 'termahal' ? 'selected' : '' }}>Termahal</option>
                    <option value="terlaris" {{ $sort === 'terlaris' ? 'selected' : '' }}>Terlaris</option>
                </select>
                <form id="sortForm" method="GET" action="{{ route('pelanggan.menu') }}" style="display:none;">
                    <input type="hidden" name="cari" value="{{ request('cari') }}">
                </form>
            </div>
        </div>

        <!-- Menu Grid -->
        @if($produk->isNotEmpty())
            <div class="menu-grid">
                @foreach($produk as $item)
                    <div class="menu-card">
                        <div class="menu-card-img">
                            <img src="{{ $item->gambar_url }}" alt="{{ $item->nama }}">
                            @if($item->is_terlaris)
                                <span class="menu-badge menu-badge-hot">Terlaris</span>
                            @elseif($item->is_baru)
                                <span class="menu-badge menu-badge-new">Baru</span>
                            @endif
                        </div>
                        <div class="menu-card-body">
                            <span class="menu-card-cat">{{ $item->kategori }}</span>
                            <h3 class="menu-card-title">{{ $item->nama }}</h3>
                            <p class="menu-card-desc">{{ Str::limit($item->deskripsi, 55) }}</p>
                            <div class="menu-card-bottom">
                                <span class="menu-card-price">{{ $item->harga_formatted }}</span>
                                @auth
                                    <form method="POST" action="{{ route('pelanggan.keranjang.tambah') }}">
                                        @csrf
                                        <input type="hidden" name="produk_id" value="{{ $item->id }}">
                                        <button type="submit" class="btn-add-cart" title="Tambah ke keranjang">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="btn-add-cart" title="Login untuk pesan">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="pagination">
                {{ $produk->withQueryString()->links() }}
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-bowl-food"></i>
                <h3>Menu tidak ditemukan</h3>
                <p>Coba ubah filter pencarian Anda.</p>
            </div>
        @endif
    </div>
</section>
@endsection