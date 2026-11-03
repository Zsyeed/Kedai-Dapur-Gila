@extends('layouts.app')

@section('title', 'Profil')

@section('content')
<section class="section">
    <div class="section-container" style="max-width:700px;">
        <h2 class="section-title font-display" style="margin-bottom:2rem;">
            <i class="fas fa-user-circle"></i> Profil Saya
        </h2>

        <div class="checkout-box" style="margin-bottom:1.5rem;">
            <h3 class="checkout-box-title">Informasi Akun</h3>
            <form method="POST" action="{{ route('pelanggan.profil.update') }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" name="nama" class="form-input" value="{{ old('nama', $user->nama) }}" required>
                    @error('nama')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-input" value="{{ old('email', $user->email) }}" required>
                    @error('email')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="no_telepon">No. Telepon</label>
                    <input type="text" id="no_telepon" name="no_telepon" class="form-input" value="{{ old('no_telepon', $user->no_telepon) }}">
                    @error('no_telepon')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea id="alamat" name="alamat" class="form-input" rows="3">{{ old('alamat', $user->alamat) }}</textarea>
                    @error('alamat')<span class="form-error">{{ $message }}</span>@enderror
                </div>

                <button type="submit" class="btn-primary">Simpan Perubahan</button>
            </form>
        </div>

        <div class="checkout-box">
            <h3 class="checkout-box-title">Ubah Password</h3>
            <form method="POST" action="{{ route('pelanggan.profil.password') }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="password_lama">Password Lama</label>
                    <div class="input-password">
                        <input type="password" id="password_lama" name="password_lama" class="form-input" required>
                        <button type="button" class="btn-toggle-pw" onclick="togglePw('password_lama', this)"><i class="fas fa-eye"></i></button>
                    </div>
                    @error('password_lama')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="password_baru">Password Baru</label>
                    <div class="input-password">
                        <input type="password" id="password_baru" name="password_baru" class="form-input" required>
                        <button type="button" class="btn-toggle-pw" onclick="togglePw('password_baru', this)"><i class="fas fa-eye"></i></button>
                    </div>
                    @error('password_baru')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="password_baru_confirmation">Konfirmasi Password Baru</label>
                    <div class="input-password">
                        <input type="password" id="password_baru_confirmation" name="password_baru_confirmation" class="form-input" required>
                        <button type="button" class="btn-toggle-pw" onclick="togglePw('password_baru_confirmation', this)"><i class="fas fa-eye"></i></button>
                    </div>
                    @error('password_baru_confirmation')<span class="form-error">{{ $message }}</span>@enderror
                </div>

                <button type="submit" class="btn-primary">Ubah Password</button>
            </form>
        </div>
    </div>
</section>
@endsection