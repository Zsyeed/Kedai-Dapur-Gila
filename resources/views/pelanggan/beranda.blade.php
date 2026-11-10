@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<!-- HERO SECTION -->
<section class="hero-section">
    <div class="hero-container">
        
        <div class="hero-content">
            <div class="hero-tag">Fusion Food &middot; Ramen &middot; Indonesia</div>
            <h1 class="hero-title">Rasa Gila yang<br><span>Bikin Nagih</span></h1>
            <p class="hero-desc">Fusion ramen Jepang dengan cita rasa Indonesia yang berani dan otentik. Setiap mangkuk adalah petualangan rasa.</p>
            
            <a href="{{ route('pelanggan.menu') }}" class="btn-red">
                Lihat Menu <i class="fas fa-arrow-right"></i>
            </a>

            <div class="hero-stats">
                <div class="hero-stat"><strong>8</strong><span>Menu Varian</span></div>
                <div class="hero-divider"></div>
                <div class="hero-stat"><strong>1k+</strong><span>Terjual</span></div>
                <div class="hero-divider"></div>
                <div class="hero-stat"><strong>4.9</strong><span>Rating</span></div>
            </div>
        </div>

        <div style="flex: 1; display:flex; justify-content:center;">
            @if($produkTerlaris->isNotEmpty())
                @php $featured = $produkTerlaris->first(); @endphp
                <div class="featured-card" style="max-width: 340px;">
                    <div class="img-wrapper">
                        <img src="{{ $featured->gambar_url }}" alt="{{ $featured->nama }}" class="featured-img">
                        <span class="badge-card badge-terlaris">Terlaris</span>
                    </div>
                    <div class="featured-body">
                        <h3 class="featured-name">{{ $featured->nama }}</h3>
                        <p class="featured-desc">{{ Str::limit($featured->deskripsi, 60) }}</p>
                        <div class="featured-bottom">
                            <span class="featured-price">{{ $featured->harga_formatted }}</span>
                            @auth
                                <form method="POST" action="{{ route('pelanggan.keranjang.tambah') }}" style="margin:0;">
                                    @csrf
                                    <input type="hidden" name="produk_id" value="{{ $featured->id }}">
                                    <button type="submit" class="btn-add-square" title="Tambah ke keranjang"><i class="fas fa-plus"></i></button>
                                </form>
                            @endauth
                        </div>
                    </div>
                </div>
            @endif
        </div>

    </div>
</section>

<!-- MENU TERLARIS -->
<section class="menu-section">
    <div class="section-container">
        <div class="section-header">
            <div>
                <h2 class="section-title">Menu Terlaris</h2>
                <p class="section-subtitle">Ramen paling banyak dipesan oleh pelanggan</p>
            </div>
            <a href="{{ route('pelanggan.menu', ['sort' => 'terlaris']) }}" class="btn-red" style="padding: 0.6rem 1.2rem; font-size: 0.9rem;">
                Lihat Semua <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        
        <div class="menu-grid">
            @foreach($produkTerlaris as $item)
                <div class="featured-card">
                    <div class="img-wrapper">
                        <img src="{{ $item->gambar_url }}" alt="{{ $item->nama }}" class="featured-img">
                        @if($item->is_terlaris)
                            <span class="badge-card badge-terlaris">Terlaris</span>
                        @endif
                    </div>
                    <div class="featured-body">
                        <h3 class="featured-name">{{ $item->nama }}</h3>
                        <p class="featured-desc">{{ Str::limit($item->deskripsi, 50) }}</p>
                        <div class="featured-bottom">
                            <span class="featured-price">{{ $item->harga_formatted }}</span>
                            @auth
                                <form method="POST" action="{{ route('pelanggan.keranjang.tambah') }}" style="margin:0;">
                                    @csrf
                                    <input type="hidden" name="produk_id" value="{{ $item->id }}">
                                    <button type="submit" class="btn-add-square"><i class="fas fa-plus"></i></button>
                                </form>
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- MENU BARU -->
@if($produkBaru->isNotEmpty())
<section class="menu-section bg-light">
    <div class="section-container">
        <div class="section-header">
            <div>
                <h2 class="section-title">Menu Baru</h2>
                <p class="section-subtitle">Coba kreasi terbaru dari Dapur Gila</p>
            </div>
            <a href="{{ route('pelanggan.menu', ['sort' => 'terbaru']) }}" class="btn-red" style="padding: 0.6rem 1.2rem; font-size: 0.9rem;">
                Lihat Semua <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        
        <div class="menu-grid">
            @foreach($produkBaru as $item)
                <div class="featured-card">
                    <div class="img-wrapper">
                        <img src="{{ $item->gambar_url }}" alt="{{ $item->nama }}" class="featured-img">
                        <span class="badge-card badge-baru">Baru</span>
                    </div>
                    <div class="featured-body">
                        <h3 class="featured-name">{{ $item->nama }}</h3>
                        <p class="featured-desc">{{ Str::limit($item->deskripsi, 50) }}</p>
                        <div class="featured-bottom">
                            <span class="featured-price">{{ $item->harga_formatted }}</span>
                            @auth
                                <form method="POST" action="{{ route('pelanggan.keranjang.tambah') }}" style="margin:0;">
                                    @csrf
                                    <input type="hidden" name="produk_id" value="{{ $item->id }}">
                                    <button type="submit" class="btn-add-square"><i class="fas fa-plus"></i></button>
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