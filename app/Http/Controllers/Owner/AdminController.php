<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        // Mengambil user dengan role admin
        $admins = User::where('role', 'admin')->latest()->get();
        return view('owner.admins.index', compact('admins'));
    }

    public function create()
    {
        return view('owner.admins.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255', // Ganti 'name' jadi 'nama'
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'no_telepon' => 'nullable|string|max:20',
        ]);

        User::create([
            'nama' => $request->nama, // Ganti 'name' jadi 'nama'
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_telepon' => $request->no_telepon,
            'role' => 'admin',
            // 'kode_user' tidak perlu diisi karena sudah otomatis di Model (fungsi booted)
        ]);

        return redirect()->route('owner.admins.index')->with('success', 'Admin baru berhasil didaftarkan.');
    }

    public function edit($id)
    {
        $admin = User::findOrFail($id);
        return view('owner.admins.edit', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        $admin = User::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255', // Ganti 'name' jadi 'nama'
            'email' => 'required|string|email|max:255|unique:users,email,' . $admin->id,
            'no_telepon' => 'nullable|string|max:20',
        ]);

        $admin->nama = $request->nama;
        $admin->email = $request->email;
        $admin->no_telepon = $request->no_telepon;

        if ($request->filled('password')) {
            $request->validate(['password' => 'confirmed|min:8']);
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        return redirect()->route('owner.admins.index')->with('success', 'Data admin berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $admin = User::findOrFail($id);
        $admin->delete();

        return redirect()->route('owner.admins.index')->with('success', 'Akun admin telah dihapus.');
    }
}