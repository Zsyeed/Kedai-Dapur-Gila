<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan — Ramen Dapur Gila</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/pesanan1.css') }}">
</head>
<body>

    <!-- Nav -->
    <nav class="nav-main">
        <div class="nav-container">
            <a href="{{ route('beranda') }}" class="nav-brand">
                <i class="fas fa-fire"></i>
                <span class="font-display">DapurGila</span>
            </a>
            <div class="nav-links" id="navLinks">
                <a href="{{ route('beranda') }}" class="nav-link">Beranda</a>
                <a href="{{ route('pelanggan.menu') }}" class="nav-link">Menu</a>
            </div>
            <div class="nav-actions">
                <div class="nav-dropdown" id="navDropdown">
                    <button class="btn-nav btn-outline" onclick="toggleDropdown()">
                        <i class="fas fa-user-circle"></i>
                        <span>{{ auth()->user()->nama }}</span>
                        <i class="fas fa-chevron-down" style="font-size: 0.6rem;margin-left: 0.15rem;"></i>
                    </button>
                    <div class="dropdown-menu" id="dropdownMenu">
                        <a href="{{ route('pelanggan.pesanan') }}" class="dropdown-item"><i class="fas fa-receipt"></i> Pesanan Saya</a>
                        <form method="POST" action="{{ route('logout') }}" style="width:100%;">
                            @csrf
                            <button type="submit" class="dropdown-item" style="width:100%;text-align:left;color:#f87171;">
                                <i class="fas fa-sign-out-alt"></i> Keluar
                            </button>
                        </form>
                    </div>
                </div>
                <button class="nav-toggle" onclick="toggleNav()" aria-label="Toggle menu">
                    <i class="fas fa-bars" id="navToggleIcon"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="page-content">
        <a href="{{ route('pelanggan.pesanan') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali ke Pesanan
        </a>

        <div class="detail-header">
            <div>
                <h2 class="page-title font-display">{{ $transaksi->kode_transaksi }}</h2>
                <p class="page-subtitle" style="margin-bottom:0;">
                    {{ $transaksi->created_at->locale('id')->isoFormat('D MMMM Y, HH:mm') }}
                </p>
            </div>
            <span class="badge badge-{{ $transaksi->status_color }}" style="font-size:0.85rem;padding:0.4rem 0.9rem;">
                {{ $transaksi->status_label }}
            </span>
        </div>

        <div class="detail-grid">
            <!-- Item Pesanan -->
            <div class="detail-box">
                <h3 class="detail-box-title">Item Pesanan</h3>
                @foreach($transaksi->detailTransaksi as $detail)
                    <div class="detail-item">
                        <div>
                            <strong>{{ $detail->jumlah }}x {{ $detail->produk->nama }}</strong>
                            <span style="display:block;font-size:0.76rem;color:var(--muted);">{{ $detail->produk->harga_formatted }} / porsi</span>
                        </div>
                        <span style="font-weight:600;">{{ $detail->subtotal_formatted }}</span>
                    </div>
                @endforeach
                <div class="detail-total">
                    <span>Total</span>
                    <span style="color:var(--accent-light);">{{ $transaksi->total_harga_formatted }}</span>
                </div>
            </div>

            <!-- Info Pengiriman -->
            <div class="detail-box">
                <h3 class="detail-box-title">Info Pengiriman</h3>
                <div class="detail-row">
                    <span>Alamat</span>
                    <span>{{ $transaksi->alamat_pengiriman }}</span>
                </div>
                <div class="detail-row">
                    <span>Nomor Telepon</span>
                    <span>{{ $transaksi->no_telepon }}</span>
                </div>
                <div class="detail-row">
                    <span>Pembayaran</span>
                    <span style="text-transform:capitalize;">{{ $transaksi->metode_pembayaran }}</span>
                </div>
                @if($transaksi->catatan)
                    <div class="detail-row">
                        <span>Catatan</span>
                        <span>{{ $transaksi->catatan }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function toggleNav() {
            const links = document.getElementById('navLinks');
            const icon = document.getElementById('navToggleIcon');
            links.classList.toggle('open');
            if (links.classList.contains('open')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            } else {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        }
        function toggleDropdown() {
            document.getElementById('dropdownMenu').classList.toggle('show');
        }
        document.addEventListener('click', function(e) {
            const dd = document.getElementById('navDropdown');
            const menu = document.getElementById('dropdownMenu');
            if (dd && menu && !dd.contains(e.target)) {
                menu.classList.remove('show');
            }
        });
    </script>
</body>
</html>