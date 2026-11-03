<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Pelanggan — Dapur Gila</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    <style>
        /* Reset & Base Style overrides for the 50:50 white layout */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #ffffff;
        }
        
        .split-container {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        /* BAGIAN KIRI: BANNER MERAH */
        .banner-side {
            flex: 1;
            background-color: #C22020; /* Warna merah DapurGila */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            color: #ffffff;
            text-align: center;
        }

        .banner-content {
            max-width: 400px;
        }

        .brand-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 2rem;
            letter-spacing: -0.5px;
        }

        .image-box {
            background: #ffffff;
            padding: 24px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            display: inline-block;
        }

        .image-box img {
            max-width: 100%;
            height: auto;
            display: block;
            border-radius: 10px;
        }

        .tagline-main {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
        }

        .tagline-sub {
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 0.85);
            line-height: 1.6;
        }

        /* BAGIAN KANAN: FORM LOGIN */
        .form-side {
            flex: 1;
            background-color: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
        }

        .form-container {
            width: 100%;
            max-width: 420px;
        }

        .welcome-title {
            font-size: 2.2rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 0.5rem;
        }

        .welcome-subtitle {
            font-size: 0.95rem;
            color: #666666;
            margin-bottom: 2.5rem;
        }

        /* Menimpa CSS bawaan auth-card agar menyatu dengan background putih */
        .auth-card {
            background: #fcfcfc !important; /* warna card form lama */
            border: 1px solid #eeeeee !important;
            color: #333333 !important;
            box-shadow: 0 4px 20px rgba(0,0,0,0.02) !important;
        }

        .auth-header p {
            color: #666666 !important;
        }
        
        .form-group label {
            color: #444444 !important;
        }

        /* Responsive Mobile View */
        @media (max-width: 768px) {
            .split-container {
                flex-direction: column;
            }
            .banner-side {
                padding: 40px 20px;
            }
            .form-side {
                padding: 40px 20px;
            }
        }
    </style>
</head>
<body>

<div class="split-container">

    <div class="banner-side">
        <div class="banner-content">
            <div class="brand-title">DapurGila</div>
            
            <div class="image-box">
                <img src="{{ asset('images/ramen-house-illustration.png') }}" alt="Ramen House Illustration" onerror="this.src='https://images.unsplash.com/photo-1569718212165-3a8278d5f624?auto=format&fit=crop&w=400&q=80'">
            </div>
            
            <div class="tagline-main">Pedasnya Bikin Nagih!</div>
            <div class="tagline-sub">
                Nikmati sensasi ramen fusion terbaik dengan bumbu rahasia yang mengguncang lidah.
            </div>
        </div>
    </div>


    <div class="form-side">
        <div class="form-container">
            
            <h1 class="welcome-title">Selamat Datang</h1>
            <p class="welcome-subtitle">Silakan masuk ke akun Anda untuk mulai memesan.</p>

            @if(session('success'))
                <div class="alert alert-success" role="alert" style="margin-bottom: 1.5rem; width: 100%; background: rgba(46, 204, 113, 0.1); border: 1px solid #2ecc71; color: #2ecc71; padding: 1rem; border-radius: 12px; display: flex; align-items: center; gap: 0.75rem; box-sizing: border-box; font-size: 0.88rem;">
                    <i class="fas fa-check-circle" style="font-size: 1.1rem;"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="auth-card">
                <div class="auth-header">
                    <div class="auth-logo">
                        <i class="fas fa-fire" style="color:#C22020; font-size:1.5rem;"></i>
                        <span class="font-display" style="font-size:1.35rem; font-weight:700; color: #1a1a1a;">Ramen Dapur Gila</span>
                    </div>
                    <p style="font-size:0.85rem; margin-top:0.35rem;">Masukkan email dan password anda</p>
                </div>

                <form method="POST" action="{{ route('login') }}" novalidate>
                    @csrf

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email"
                               class="form-input @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" required autofocus
                               placeholder="nama@email.com" style="color: #333333;">
                        @error('email')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-password">
                            <input type="password" id="password" name="password"
                                   class="form-input @error('password') is-invalid @enderror"
                                   required placeholder="Masukkan password" style="color: #333333;">
                            <button type="button" class="btn-toggle-pw" onclick="togglePw('password', this)" aria-label="Toggle password" style="color: #666666;">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-row" style="justify-content:flex-start; margin-bottom:1.5rem;">
                        <label class="form-check" style="color: #555555;">
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span>Ingat saya</span>
                        </label>
                    </div>

                    <button type="submit" class="btn-primary btn-full" style="padding:0.85rem; font-size:0.92rem; border-radius:10px; background-color: #C22020; border: none; color: #fff; cursor: pointer;">
                        Masuk
                    </button>
                </form>

                <div class="auth-footer" style="margin-top:1.75rem; color: #666666;">
                    Belum punya akun?
                    <a href="{{ route('register') }}" style="color:#C22020; font-weight:700;">Daftar</a>
                </div>
            </div>

        </div>
    </div>

</div>

<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>