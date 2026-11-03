@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<!-- Hero Section -->
<section class="hero">
    <div class="hero-bg">
        <div class="hero-gradient"></div>
        <div class="hero-pattern"></div>
    </div>
    <div class="hero-container">
        <div class="hero-content">
            <div class="hero-tag">Fusion Food &middot; Ramen &middot; Indonesia</div>
            <h1 class="hero-title font-display">Rasa Gila yang<br>Bikin Nagih</h1>
            <p class="hero-desc">Fusion ramen Jepang dengan cita rasa Indonesia yang berani dan otentik. Setiap mangkuk adalah petualangan rasa.</p>
            <div class="hero-actions">
                <a href="{{ route('pelanggan.menu') }}" class="btn-primary btn-lg">
                    Lihat Menu <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="hero-stats">
                <div class="hero-stat">
                    <strong>8</strong>
                    <span>Menu Varian</span>
                </div>
                <div class="hero-stat-divider"></div>
                <div class="hero-stat">
                    <strong>1k+</strong>
                    <span>Mangkuk Terjual</span>
                </div>
                <div class="hero-stat-divider"></div>
                <div class="hero-stat">
                    <strong>4.9</strong>
                    <span>Rating</span>
                </div>
            </div>
        </div>
        <div class="hero-card">
            @if($produkTerlaris->isNotEmpty())
                @php $featured = $produkTerlaris->first(); @endphp
                <div class="featured-card">
                    <img src="{{ $featured->gambar_url }}" alt="{{ $featured->nama }}" class="featured-img">
                    <span class="featured-badge">Terlaris</span>
                    <div class="featured-info">
                        <h3 class="featured-name">{{ $featured->nama }}</h3>
                        <p class="featured-desc">{{ Str::limit($featured->deskripsi, 60) }}</p>
                        <div class="featured-bottom">
                            <span class="featured-price">{{ $featured->harga_formatted }}</span>
                            @auth
                                <form method="POST" action="{{ route('pelanggan.keranjang.tambah') }}">
                                    @csrf
                                    <input type="hidden" name="produk_id" value="{{ $featured->id }}">
                                    <button type="submit" class="btn-add-cart" title="Tambah ke keranjang">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </form>
                            @endauth
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

<!-- Menu Terlaris -->
<section class="section">
    <div class="section-container">
        <div class="section-header">
            <div>
                <h2 class="section-title font-display">Menu Terlaris</h2>
                <p class="section-subtitle">Ramen paling banyak dipesan oleh pelanggan</p>
            </div>
            <a href="{{ route('pelanggan.menu', ['sort' => 'terlaris']) }}" class="btn-primary">
                Lihat Semua <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        <div class="menu-grid">
            @foreach($produkTerlaris as $item)
                <div class="menu-card">
                    <div class="menu-card-img">
                        <img src="{{ $item->gambar_url }}" alt="{{ $item->nama }}">
                        @if($item->is_terlaris)
                            <span class="menu-badge menu-badge-hot">Terlaris</span>
                        @endif
                    </div>
                    <div class="menu-card-body">
                        <h3 class="menu-card-title">{{ $item->nama }}</h3>
                        <p class="menu-card-desc">{{ Str::limit($item->deskripsi, 50) }}</p>
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
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Menu Baru -->
@if($produkBaru->isNotEmpty())
<section class="section" style="background:var(--bg-card);">
    <div class="section-container">
        <div class="section-header">
            <div>
                <h2 class="section-title font-display">Menu Baru</h2>
                <p class="section-subtitle">Coba kreasi terbaru dari Dapur Gila</p>
            </div>
            <a href="{{ route('pelanggan.menu', ['sort' => 'terbaru']) }}" class="btn-primary">
                Lihat Semua <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        <div class="menu-grid">
            @foreach($produkBaru as $item)
                <div class="menu-card">
                    <div class="menu-card-img">
                        <img src="{{ $item->gambar_url }}" alt="{{ $item->nama }}">
                        <span class="menu-badge menu-badge-new">Baru</span>
                    </div>
                    <div class="menu-card-body">
                        <h3 class="menu-card-title">{{ $item->nama }}</h3>
                        <p class="menu-card-desc">{{ Str::limit($item->deskripsi, 50) }}</p>
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
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection