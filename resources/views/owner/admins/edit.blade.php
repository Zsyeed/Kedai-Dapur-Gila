@extends('layouts.owner')

@section('page-title', 'Edit Admin')

@section('content')
<div class="admin-card" style="max-width:700px;">
    <div class="admin-card-header">
        <div>
            <h3 class="admin-card-title">Edit Data Admin</h3>
            <p class="admin-card-subtitle">Perbarui profil admin atau ganti password jika diperlukan.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('owner.admins.update', $admin) }}" class="styled-form">
        @csrf
        @method('PUT')

        {{-- Error Handling yang lebih clean --}}
        @if ($errors->any())
        <div class="custom-alert">
            <i class="fas fa-exclamation-circle"></i>
            <span>Mohon periksa kembali inputan Anda.</span>
        </div>
        @endif

        <div class="form-section">
            <h4 class="section-title">Informasi Pribadi</h4>
            <div class="form-grid">
                <div class="form-group">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama" id="nama"
                        class="form-input @error('nama') is-invalid @enderror"
                        value="{{ old('nama', $admin->nama) }}" placeholder="Nama Lengkap" required>
                    @error('nama') <span class="error-text">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Alamat Email</label>
                    <input type="email" name="email" id="email"
                        class="form-input @error('email') is-invalid @enderror"
                        value="{{ old('email', $admin->email) }}" placeholder="email@dapurgila.com" required>
                    @error('email') <span class="error-text">{{ $message }}</span> @enderror
                </div>

                <div class="form-group full-width">
                    <label for="no_telepon" class="form-label">No. Telepon</label>
                    <input type="text" name="no_telepon" id="no_telepon"
                        class="form-input @error('no_telepon') is-invalid @enderror"
                        value="{{ old('no_telepon', $admin->no_telepon) }}" placeholder="08xxxxxxxx">
                </div>
            </div>
        </div>

        <div class="form-section">
            <h4 class="section-title">Keamanan <small>(Kosongkan jika tidak ingin ganti password)</small></h4>
            <div class="form-grid">
                <div class="form-group">
                    <label for="password" class="form-label">Password Baru</label>
                    <input type="password" name="password" id="password"
                        class="form-input @error('password') is-invalid @enderror" placeholder="••••••••">
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="form-input" placeholder="••••••••">
                </div>
            </div>
        </div>

        <div style="margin-top:1.5rem;display:flex;gap:0.75rem;">
            <button type="submit" class="btn-primary">Update</button>
            <a href="{{ route('owner.admins.index') }}" class="btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection