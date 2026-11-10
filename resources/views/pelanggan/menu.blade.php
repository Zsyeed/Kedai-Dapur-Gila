@extends('layouts.app')

@section('title', 'Menu')

@section('content')
<section class="menu-section bg-light" style="min-height: 80vh;">
    <div class="section-container">
        <div class="section-header" style="margin-bottom:1.5rem;">
            <div>
                <h2 class="section-title">Menu Favorit Dapur Gila</h2>
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
                <select name="sort" onchange="this.form.submit()" form="sortForm">
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
                    <!-- Menggunakan 'featured-card' agar desainnya 100% sama dengan Beranda -->
                    <div class="featured-card">
                        <div class="img-wrapper">
                            <img src="{{ $item->gambar_url }}" alt="{{ $item->nama }}" class="featured-img">
                            @if($item->is_terlaris)
                                <span class="badge-card badge-terlaris">Terlaris</span>
                            @elseif($item->is_baru)
                                <span class="badge-card badge-baru">Baru</span>
                            @endif
                        </div>
                        <div class="featured-body">
                            <span class="featured-cat">{{ $item->kategori }}</span>
                            <h3 class="featured-name">{{ $item->nama }}</h3>
                            <p class="featured-desc">{{ Str::limit($item->deskripsi, 55) }}</p>
                            
                            <div class="featured-bottom">
                                <span class="featured-price">{{ $item->harga_formatted }}</span>
                                @auth
                                    <form method="POST" action="{{ route('pelanggan.keranjang.tambah') }}" style="margin:0;">
                                        @csrf
                                        <input type="hidden" name="produk_id" value="{{ $item->id }}">
                                        <button type="submit" class="btn-add-square" title="Tambah ke keranjang">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="btn-add-square" title="Login untuk pesan">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div style="margin-top: 3rem; display: flex; justify-content: center;">
                {{ $produk->withQueryString()->links() }}
            </div>
        @else
            <!-- Tampilan Saat Menu Kosong / Tidak Ditemukan -->
            <div class="empty-state">
                <i class="fas fa-bowl-food"></i>
                <h3>Menu tidak ditemukan</h3>
                <p>Coba gunakan kata kunci pencarian yang lain.</p>
            </div>
        @endif
    </div>
</section>
@endsection