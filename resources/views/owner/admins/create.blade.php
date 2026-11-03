@extends('layouts.owner')

@section('page-title', 'Tambah Admin')

@section('content')
<div class="admin-card" style="max-width:700px;">
    <div class="admin-card-header">
        <div>
            <h3 class="admin-card-title">Tambah Admin Baru</h3>
            <p class="admin-card-subtitle">Daftarkan akun administrator baru untuk mengelola sistem.</p>
        </div>
    </div>

    <form action="{{ route('owner.admins.store') }}" method="POST" class="styled-form">
        @csrf

        {{-- Alert Error --}}
        @if ($errors->any())
        <div class="custom-alert">
            <i class="fas fa-exclamation-circle"></i>
            <div>
                <strong>Oops! Ada kesalahan:</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        <div class="form-section">
            <h4 class="section-title">Informasi Profil</h4>
            <div class="form-grid">
                <div class="form-group">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama" id="nama" class="form-input"
                        value="{{ old('nama') }}" placeholder="Nama Lengkap" required>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Alamat Email</label>
                    <input type="email" name="email" id="email" class="form-input"
                        value="{{ old('email') }}" placeholder="email@dapurgila.com" required>
                </div>

                <div class="form-group full-width">
                    <label for="no_telepon" class="form-label">No. Telepon</label>
                    <input type="text" name="no_telepon" id="no_telepon" class="form-input"
                        value="{{ old('no_telepon') }}" placeholder="08xxxxxxxx">
                </div>
            </div>
        </div>

        <div class="form-section">
            <h4 class="section-title">Kredensial Akun</h4>
            <div class="form-grid">
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div style="position:relative;">
                        <input type="password" name="password" id="password" class="form-input" placeholder="Masukkan password" style="padding-right:45px;" required>
                        <button type="button" onclick="togglePw('password', this)" aria-label="Toggle password" style=" position:absolute; right:12px; top:50%; transform:translateY(-50%); border:none; background:none; cursor:pointer; color:#666;">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <div style="position:relative;">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-input" placeholder="Ulangi password" style="padding-right:45px;" required>
                        <button type="button" onclick="togglePw('password_confirmation', this)" aria-label="Toggle password" style=" position:absolute; right:12px; top:50%; transform:translateY(-50%); border:none; background:none; cursor:pointer; color:#666;">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div style="margin-top:1.5rem;display:flex;gap:0.75rem;">
            <button type="submit" class="btn-primary">Simpan Admin</button>
            <a href="{{ route('owner.admins.index') }}" class="btn-secondary">Batal</a>
        </div>
    </form>
</div>
<script>
function togglePw(id, button)
{
    const input = document.getElementById(id);
    const icon = button.querySelector('i');

    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
</script>
@endsection