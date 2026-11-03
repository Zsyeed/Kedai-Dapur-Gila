<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun — Dapur Gila</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    <style>
        /* Reset & Base Styles */
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
            background-color: #C22020; /* Warna merah identitas DapurGila */
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

        /* BAGIAN KANAN: FORM REGISTER */
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

        /* Overrides style internal bawaan auth-card lama agar menyatu dengan tema putih */
        .auth-card {
            background: #fcfcfc !important;
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

        /* Responsive Breakpoint */
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
            <p class="welcome-subtitle">Silakan buat akun Anda untuk mulai memesan.</p>

            <div class="auth-card">
                <div class="auth-header">
                    <div class="auth-logo">
                        <i class="fas fa-fire" style="color:#C22020; font-size:1.5rem;"></i>
                        <span class="font-display" style="font-size:1.35rem; font-weight:700; color: #1a1a1a;">Ramen Dapur Gila</span>
                    </div>
                    <p style="font-size:0.85rem; margin-top:0.35rem;">Buat akun baru untuk mulai memesan</p>
                </div>

                <form method="POST" action="{{ route('register') }}" novalidate>
                    @csrf

                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" id="nama" name="nama"
                               class="form-input @error('nama') is-invalid @enderror"
                               value="{{ old('nama') }}" required placeholder="Nama lengkap Anda" style="color: #333333;">
                        @error('nama')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email"
                               class="form-input @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" required placeholder="nama@email.com" style="color: #333333;">
                        @error('email')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-password">
                            <input type="password" id="password" name="password"
                                   class="form-input @error('password') is-invalid @enderror"
                                   required placeholder="Buat password baru" style="color: #333333;">
                            <button type="button" class="btn-toggle-pw" onclick="togglePw('password', this)" aria-label="Toggle password" style="color: #666666;">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <div class="input-password">
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                   class="form-input @error('password_confirmation') is-invalid @enderror"
                                   required placeholder="Ulangi password baru" style="color: #333333;">
                            <button type="button" class="btn-toggle-pw" onclick="togglePw('password_confirmation', this)" aria-label="Toggle password" style="color: #666666;">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn-primary btn-full" style="padding:0.85rem; font-size:0.92rem; border-radius:10px; background-color: #C22020; border: none; color: #fff; cursor: pointer; margin-top: 0.5rem;">
                        Daftar
                    </button>
                </form>

                <div class="auth-footer" style="margin-top:1.75rem; color: #666666;">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" style="color:#C22020; font-weight:700;">Masuk</a>
                </div>
            </div>

        </div>
    </div>

</div>

<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>