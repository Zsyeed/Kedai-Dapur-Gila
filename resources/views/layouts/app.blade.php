<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Ramen Dapur Gila')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/pelanggan.css') }}">
    @stack('styles')
</head>
<body>
    
    <!-- Notifikasi Sukses & Error dengan kelas .alert -->
    @if(session('success'))
        <div class="alert alert-success" style="background: #10b981; color: white; padding: 1rem; text-align: center; font-weight: 600;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger" style="background: #ef4444; color: white; padding: 1rem; text-align: center; font-weight: 600;">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    <!-- NAVIGASI -->
    <nav class="nav-main">
        <div class="nav-container">
            <a href="{{ route('beranda') }}" class="nav-brand">
                <i class="fas fa-fire" style="color:var(--accent-light);"></i>
                <span class="font-display" style="font-weight:700;">DapurGila</span>
            </a>

            <div class="nav-links" id="navLinks">
                <a href="{{ route('beranda') }}" class="nav-link {{ request()->routeIs('beranda') ? 'active' : '' }}">Beranda</a>
                <a href="{{ route('pelanggan.menu') }}" class="nav-link {{ request()->routeIs('pelanggan.menu') ? 'active' : '' }}">Menu</a>
            </div>

            <div class="nav-actions">
                @auth
                    @if(auth()->user()->isPelanggan())
                        <a href="{{ route('pelanggan.keranjang') }}" class="btn-nav" style="position:relative;">
                            <i class="fas fa-shopping-bag"></i>
                            @php $totalKeranjang = auth()->user()->total_keranjang; @endphp
                            @if($totalKeranjang > 0)
                                <span class="cart-badge">{{ $totalKeranjang }}</span>
                            @endif
                        </a>
                    @endif

                    <div class="nav-dropdown" id="navDropdown">
                        <button class="btn-nav" onclick="toggleDropdown()">
                            <i class="fas fa-user-circle"></i>
                            <span class="hidden sm:inline">{{ auth()->user()->nama }}</span>
                            <i class="fas fa-chevron-down" style="font-size:0.6rem;"></i>
                        </button>
                        <div class="dropdown-menu" id="dropdownMenu">
                            @if(auth()->user()->isPelanggan())
                                <a href="{{ route('pelanggan.profil') }}" class="dropdown-item"><i class="fas fa-user"></i> Profil</a>
                                <a href="{{ route('pelanggan.pesanan') }}" class="dropdown-item"><i class="fas fa-receipt"></i> Pesanan Saya</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}" style="width:100%;">
                                @csrf
                                <button type="submit" class="dropdown-item" style="color:#ef4444;">
                                    <i class="fas fa-sign-out-alt"></i> Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth

                <button class="nav-toggle" onclick="toggleNav()" aria-label="Toggle menu">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- KONTEN UTAMA -->
    <main>
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-brand">
                <div style="display:flex;align-items:center;gap:0.5rem;">
                    <i class="fas fa-fire" style="color:var(--accent-light);font-size:1.2rem;"></i>
                    <span class="font-display" style="font-size:1.1rem;font-weight:700;">Dapur Gila</span>
                </div>
                <p style="margin-top:0.5rem;">Fusion ramen dengan cita rasa Indonesia yang bikin nagih.</p>
            </div>
            <div class="footer-links">
                <h4>Navigasi</h4>
                <a href="{{ route('beranda') }}">Beranda</a>
                <a href="{{ route('pelanggan.menu') }}">Menu</a>
            </div>
            <div class="footer-links">
                <h4>Kontak</h4>
                <p><i class="fas fa-phone" style="width:16px;"></i> 0897-8525-539</p>
                <p><i class="fas fa-envelope" style="width:16px;"></i> info@dapurgila.id</p>
                <p><i class="fas fa-map-marker-alt" style="width:16px;"></i> Jl. Inpres V No.62 Tangerang</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 Ramen Dapur Gila. Semua hak dilindungi.</p>
        </div>
    </footer>

    <!-- SCRIPT DROPDOWN, MOBILE NAV, & AUTO-DISMISS NOTIFIKASI -->
    <script>
        function toggleDropdown() {
            document.getElementById("dropdownMenu").classList.toggle("show");
        }
        function toggleNav() {
            document.getElementById("navLinks").classList.toggle("show-nav");
        }
        window.onclick = function(event) {
            if (!event.target.closest('.nav-dropdown')) {
                var dropdowns = document.getElementsByClassName("dropdown-menu");
                for (var i = 0; i < dropdowns.length; i++) {
                    if (dropdowns[i].classList.contains('show')) {
                        dropdowns[i].classList.remove('show');
                    }
                }
            }
        }

        // Script untuk menghilangkan notifikasi secara otomatis setelah 3 detik
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');

            alerts.forEach(function(alert) {
                // Tunggu selama 1000 milidetik (1 detik)
                setTimeout(function() {
                    // Efek memudar perlahan (fade out)
                    alert.style.transition = 'opacity 0.5s ease-out';
                    alert.style.opacity = '0';

                    // Sembunyikan elemen setelah animasi selesai (0.5 detik kemudian)
                    setTimeout(function() {
                        alert.style.display = 'none';
                    }, 500);

                }, 1000); 
            });
        });
    </script>
    @stack('scripts')
</body>
</html>