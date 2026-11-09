<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Owner — Dapur Gila') | Dapur Gila</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/owner.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    @stack('styles')
</head>
<body class="bg-body text-white font-body">

    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-sidebar" id="adminSidebar">
            <div class="sidebar-header">
                <a href="{{ route('owner.dashboard') }}" class="sidebar-brand">
                    <i class="fas fa-fire"></i>
                    <span class="font-display">DapurGila</span>
                </a>
                <span class="sidebar-badge sidebar-badge-owner">Owner</span>
            </div>

            <nav class="sidebar-nav">
                <a href="{{ route('owner.dashboard') }}" class="sidebar-link {{ request()->routeIs('owner.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i> Dashboard
                </a>
                <a href="{{ route('owner.stok.index') }}" class="sidebar-link {{ request()->routeIs('owner.stok.index') ? 'active' : '' }}">
                    <i class="fas fa-boxes"></i> Stok & Produk
                </a>
                <a href="{{ route('owner.laporan.index') }}" class="sidebar-link {{ request()->routeIs('owner.laporan.index') ? 'active' : '' }}">
                    <i class="fas fa-file-invoice"></i> Laporan
                </a>
                <a href="{{ route('owner.admins.index') }}" class="sidebar-link {{ request()->routeIs('owner.admins.index') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> Admin
                </a>
                <a href="{{ route('owner.saw') }}" class="sidebar-link {{ request()->routeIs('owner.saw') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar"></i> <span>Rekomendasi SAW</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <div class="sidebar-user">
                    <div class="sidebar-avatar sidebar-avatar-owner">
                        {{ strtoupper(substr(auth()->user()->nama, 0, 1)) }}
                    </div>
                    <div>
                        <div class="sidebar-user-name">{{ auth()->user()->nama }}</div>
                        <div class="sidebar-user-role">{{ auth()->user()->email }}</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="sidebar-logout" title="Keluar">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Area -->
        <div class="admin-main">
            <header class="admin-topbar">
                <button class="sidebar-toggle" onclick="toggleSidebar()" aria-label="Toggle sidebar">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="topbar-title font-display">@yield('page-title', 'Dashboard Owner')</div>
                <div class="topbar-right">
                    <a href="{{ route('beranda') }}" class="btn-sm btn-outline" target="_blank">
                        <i class="fas fa-external-link-alt"></i> Lihat Web
                    </a>
                </div>
            </header>

            <div class="admin-content">
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>