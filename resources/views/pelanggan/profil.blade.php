@extends('layouts.app')

@section('title', 'Profil')

@section('content')
<section class="section" style="padding: 3rem 1rem; background-color: #f9fafb; min-height: 80vh;">
    <div style="max-width: 650px; margin: 0 auto;">
        
        <!-- Judul Halaman -->
        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 2rem;">
            <i class="fas fa-user-circle" style="font-size: 2rem; color: #dc2626;"></i>
            <h2 style="margin: 0; font-size: 1.75rem; font-weight: 700; color: #111827;">Profil Saya</h2>
        </div>

        <!-- Box 1: Informasi Akun -->
        <div style="background: #ffffff; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); padding: 2rem; margin-bottom: 2rem;">
            <h3 style="margin-top: 0; margin-bottom: 1.5rem; font-size: 1.15rem; font-weight: 600; color: #1f2937; border-bottom: 1px solid #f3f4f6; padding-bottom: 0.75rem;">Informasi Akun</h3>
            
            <form method="POST" action="{{ route('pelanggan.profil.update') }}">
                @csrf
                @method('PUT')

                <!-- Nama -->
                <div style="margin-bottom: 1.25rem;">
                    <label for="nama" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Nama</label>
                    <input type="text" id="nama" name="nama" value="{{ old('nama', $user->nama) }}" required style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 8px; font-size: 0.95rem; outline: none; box-sizing: border-box; background: #fff;">
                    @error('nama')<span style="display: block; color: #dc2626; font-size: 0.8rem; margin-top: 0.35rem;">{{ $message }}</span>@enderror
                </div>

                <!-- Email -->
                <div style="margin-bottom: 1.25rem;">
                    <label for="email" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 8px; font-size: 0.95rem; outline: none; box-sizing: border-box; background: #fff;">
                    @error('email')<span style="display: block; color: #dc2626; font-size: 0.8rem; margin-top: 0.35rem;">{{ $message }}</span>@enderror
                </div>

                <!-- No. Telepon -->
                <div style="margin-bottom: 1.25rem;">
                    <label for="no_telepon" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">No. Telepon</label>
                    <input type="text" id="no_telepon" name="no_telepon" value="{{ old('no_telepon', $user->no_telepon) }}" style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 8px; font-size: 0.95rem; outline: none; box-sizing: border-box; background: #fff;">
                    @error('no_telepon')<span style="display: block; color: #dc2626; font-size: 0.8rem; margin-top: 0.35rem;">{{ $message }}</span>@enderror
                </div>

                <!-- Alamat (Auto-Resize Textarea) -->
                <div style="margin-bottom: 1.5rem;">
                    <label for="alamat" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Alamat</label>
                    <textarea id="alamat" name="alamat" rows="2" style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 8px; font-size: 0.95rem; font-family: inherit; outline: none; box-sizing: border-box; background: #fff; resize: none; overflow: hidden; line-height: 1.5;">{{ old('alamat', $user->alamat) }}</textarea>
                    @error('alamat')<span style="display: block; color: #dc2626; font-size: 0.8rem; margin-top: 0.35rem;">{{ $message }}</span>@enderror
                </div>

                <button type="submit" style="background: #dc2626; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 8px; font-weight: 600; font-size: 0.95rem; cursor: pointer; transition: background 0.2s;">
                    Simpan Perubahan
                </button>
            </form>
        </div>

        <!-- Box 2: Ubah Password -->
        <div style="background: #ffffff; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); padding: 2rem;">
            <h3 style="margin-top: 0; margin-bottom: 1.5rem; font-size: 1.15rem; font-weight: 600; color: #1f2937; border-bottom: 1px solid #f3f4f6; padding-bottom: 0.75rem;">Ubah Password</h3>
            
            <form method="POST" action="{{ route('pelanggan.profil.password') }}">
                @csrf
                @method('PUT')

                <!-- Password Lama -->
                <div style="margin-bottom: 1.25rem;">
                    <label for="password_lama" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Password Lama</label>
                    <div style="position: relative;">
                        <input type="password" id="password_lama" name="password_lama" required style="width: 100%; padding: 0.75rem 2.5rem 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 8px; font-size: 0.95rem; outline: none; box-sizing: border-box; background: #fff;">
                        <button type="button" onclick="togglePw('password_lama', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #6b7280; cursor: pointer;">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password_lama')<span style="display: block; color: #dc2626; font-size: 0.8rem; margin-top: 0.35rem;">{{ $message }}</span>@enderror
                </div>

                <!-- Password Baru -->
                <div style="margin-bottom: 1.25rem;">
                    <label for="password_baru" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Password Baru</label>
                    <div style="position: relative;">
                        <input type="password" id="password_baru" name="password_baru" required style="width: 100%; padding: 0.75rem 2.5rem 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 8px; font-size: 0.95rem; outline: none; box-sizing: border-box; background: #fff;">
                        <button type="button" onclick="togglePw('password_baru', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #6b7280; cursor: pointer;">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password_baru')<span style="display: block; color: #dc2626; font-size: 0.8rem; margin-top: 0.35rem;">{{ $message }}</span>@enderror
                </div>

                <!-- Konfirmasi Password Baru -->
                <div style="margin-bottom: 1.5rem;">
                    <label for="password_baru_confirmation" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Konfirmasi Password Baru</label>
                    <div style="position: relative;">
                        <input type="password" id="password_baru_confirmation" name="password_baru_confirmation" required style="width: 100%; padding: 0.75rem 2.5rem 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 8px; font-size: 0.95rem; outline: none; box-sizing: border-box; background: #fff;">
                        <button type="button" onclick="togglePw('password_baru_confirmation', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #6b7280; cursor: pointer;">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password_baru_confirmation')<span style="display: block; color: #dc2626; font-size: 0.8rem; margin-top: 0.35rem;">{{ $message }}</span>@enderror
                </div>

                <button type="submit" style="background: #111827; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 8px; font-weight: 600; font-size: 0.95rem; cursor: pointer; transition: background 0.2s;">
                    Ubah Password
                </button>
            </form>
        </div>

    </div>
</section>

<!-- Script untuk Auto-Resize Textarea & Toggle Password -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const textarea = document.getElementById('alamat');
        if (textarea) {
            // Set tinggi awal saat halaman dimuat (jika sudah ada isinya)
            textarea.style.height = 'auto';
            textarea.style.height = textarea.scrollHeight + 'px';

            // Menyesuaikan tinggi secara otomatis saat diketik
            textarea.addEventListener('input', function () {
                this.style.height = 'auto';
                this.style.height = this.scrollHeight + 'px';
            });
        }
    });

    function togglePw(fieldId, btn) {
        const input = document.getElementById(fieldId);
        const icon = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endsection