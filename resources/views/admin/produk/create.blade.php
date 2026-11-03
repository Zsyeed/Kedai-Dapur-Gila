@extends('layouts.admin')

@section('page-title', 'Tambah Produk')

@section('content')
<div class="admin-card" style="max-width:700px;">
    <div class="admin-card-header">
        <h3 class="admin-card-title">Tambah Produk Baru</h3>
        <a href="{{ route('admin.produk.index') }}" class="btn-sm btn-outline">Kembali</a>
    </div>

    <form method="POST" action="{{ route('admin.produk.store') }}" enctype="multipart/form-data">
        @csrf

        {{-- Kode Menu Otomatis (Readonly) --}}
        <div class="form-group">
            <label for="kode_menu">Kode Menu</label>
            <input type="text" id="kode_menu" class="form-input" value="{{ \App\Models\Produk::generateKodeMenu() }}" readonly>
            <small style="color:#666;">
                Kode menu dibuat otomatis oleh sistem.
            </small>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
            <div class="form-group">
                <label for="nama">Nama Produk</label>
                <input type="text" id="nama" name="nama" class="form-input" value="{{ old('nama') }}" required>
                @error('nama')
                    <span class="alert-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="kategori">Kategori</label>
                <select id="kategori" name="kategori" class="form-select" required>
                    <option value="Ramen"
                        {{ old('kategori', 'Ramen') === 'Ramen' ? 'selected' : '' }}>
                        Ramen
                    </option>
                    <option value="Minuman"
                        {{ old('kategori') === 'Minuman' ? 'selected' : '' }}>
                        Minuman
                    </option>
                </select>
                @error('kategori')
                    <span class="alert-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" class="form-input" rows="3">{{ old('deskripsi') }}</textarea>
            @error('deskripsi')
                <span class="alert-danger">{{ $message }}</span>
            @enderror
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
            <div class="form-group">
                <label for="harga">Harga (Rp)</label>
                <input type="number" id="harga" name="harga" class="form-input" value="{{ old('harga') }}" min="1000" required>
                @error('harga')
                    <span class="alert-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="stok">Stok</label>
                <input type="number" id="stok" name="stok" class="form-input" value="{{ old('stok', 0) }}" min="1" required>
                @error('stok')
                    <span class="alert-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" class="form-select">
                    <option value="tersedia"
                        {{ old('status', 'tersedia') === 'tersedia' ? 'selected' : '' }}>
                        Tersedia
                    </option>
                    <option value="habis"
                        {{ old('status') === 'habis' ? 'selected' : '' }}>
                        Habis
                    </option>
                </select>
                @error('status')
                    <span class="alert-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="gambar">Gambar</label>
                <input type="file" id="gambar" name="gambar" class="form-input" accept="image/*">
                @error('gambar')
                    <span class="alert-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div style="display:flex;gap:1.5rem;">
            <label class="form-check">
                <input type="checkbox" name="is_terlaris"  value="1" {{ old('is_terlaris') ? 'checked' : '' }}>
                <span>Terlaris</span>
            </label>

            <label class="form-check">
                <input type="checkbox" name="is_baru"  value='1' {{ old('is_baru') ? 'checked' : '' }}>
                <span>Menu Baru</span>
            </label>
        </div>

        <div style="margin-top:1.5rem;display:flex;gap:0.75rem;">
            <button type="submit" class="btn-primary">Simpan</button>
            <a href="{{ route('admin.produk.index') }}" class="btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection