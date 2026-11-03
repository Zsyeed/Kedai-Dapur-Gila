<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('pelanggan.profil', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email,' . $user->id,
            'no_telepon'  => 'nullable|string|max:20',
            'alamat'      => 'nullable|string|max:500',
        ]);

        $user->update($request->only('nama', 'email', 'no_telepon', 'alamat'));

        return back()->with('success', 'Profil berhasil diupdate.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_lama'     => 'required|current_password',
            'password_baru'     => ['required', 'confirmed', Password::min(8)],
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->password_baru),
        ]);

        return back()->with('success', 'Password berhasil diubah.');
    }
}