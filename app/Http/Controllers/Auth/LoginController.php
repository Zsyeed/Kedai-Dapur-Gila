<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Tampilkan form login pelanggan
     */
    public function showLoginFormPelanggan()
    {
        return view('auth.login-pelanggan');
    }

    /**
     * Tampilkan form login admin/owner
     */
    public function showLoginFormAdmin()
    {
        return view('auth.login-admin');
    }

    /**
     * Proses login pelanggan
     */
    public function loginPelanggan(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // 1. Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => 'Email yang Anda masukkan salah.',
            ]);
        }

        // 2. Cek apakah password salah
        if (!Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'password' => 'Password yang Anda masukkan salah.',
            ]);
        }

        // 3. Jika email & password benar, coba login
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Cek role pelanggan
            if (!$AuthUser = Auth::user()->isPelanggan()) {
                Auth::logout();
                throw ValidationException::withMessages([
                    'email' => 'Akun ini bukan akun pelanggan.',
                ]);
            }

            return redirect()->route('pelanggan.beranda')->with('success', 'Login berhasil. Selamat datang, ' . Auth::user()->nama . '!');
        }
    }

    /**
     * Proses login admin/owner
     */
    public function loginAdmin(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // 1. Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => 'Email yang Anda masukkan salah.',
            ]);
        }

        // 2. Cek apakah password salah
        if (!Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'password' => 'Password yang Anda masukkan salah.',
            ]);
        }

        // 3. Jika email & password benar, coba login
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }

            if (Auth::user()->isOwner()) {
                return redirect()->route('owner.dashboard');
            }

            // Jika pelanggan coba login di sini, tolak
            Auth::logout();
            throw ValidationException::withMessages([
                'email' => 'Akun ini bukan akun admin/owner.',
            ]);
        }
    }

    /**
     * Logout (digunakan semua role)
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}