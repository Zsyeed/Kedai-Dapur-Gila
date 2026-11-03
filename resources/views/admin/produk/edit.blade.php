@extends('layouts.admin')

@section('page-title', 'Edit Produk')

@section('content')
<div class="admin-card" style="max-width:700px; padding: 24px; box-sizing: border-box;">
    
    <div class="admin-card-header" style="margin-bottom: 20px;">
        <h3 class="admin-card-title" style="margin: 0;">Edit Produk</h3>
    </div>

    <form method="POST" action="{{ route('admin.produk.update', $produk) }}" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 16px;">
        @csrf
        @method('PUT')

        {{-- Kode Menu (Readonly) --}}
        <div class="form-group" style="display: flex; flex-direction: column; gap: 6px;">
            <label for="kode_menu" style="font-weight: bold;">Kode Menu</label>
            <input
                type="text"
                id="kode_menu"
                class="form-input"
                value="{{ $produk->kode_menu }}"
                readonly
            >
            <small style="color:#666;">
                Kode menu tidak dapat diubah.
            </small>
        </div>

        @if ($errors->any())
            <div class="alert-danger" style="padding: 12px; margin-bottom: 10px;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
            <div class="form-group" style="display: flex; flex-direction: column; gap: 6px;">
                <label for="nama" style="font-weight: bold;">Nama Produk</label>
                <input
                    type="text"
                    id="nama"
                    name="nama"
                    class="form-input"
                    value="{{ old('nama', $produk->nama) }}"
                    required
                >
                @error('nama')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group" style="display: flex; flex-direction: column; gap: 6px;">
                <label for="kategori" style="font-weight: bold;">Kategori</label>
                <select
                    id="kategori"
                    name="kategori"
                    class="form-select"
                    required
                >
                    <option value="Ramen"
                        {{ old('kategori', $produk->kategori) === 'Ramen' ? 'selected' : '' }}>
                        Ramen
                    </option>
                    <option value="Minuman"
                        {{ old('kategori', $produk->kategori) === 'Minuman' ? 'selected' : '' }}>
                        Minuman
                    </option>
                </select>
                @error('kategori')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-group" style="display: flex; flex-direction: column; gap: 6px;">
            <label for="deskripsi" style="font-weight: bold;">Deskripsi</label>
            <textarea
                id="deskripsi"
                name="deskripsi"
                class="form-input"
                rows="3"
            >{{ old('deskripsi', $produk->deskripsi) }}</textarea>
            @error('deskripsi')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
            <div class="form-group" style="display: flex; flex-direction: column; gap: 6px;">
                <label for="harga" style="font-weight: bold;">Harga (Rp)</label>
                <input
                    type="number"
                    id="harga"
                    name="harga"
                    class="form-input"
                    value="{{ old('harga', $produk->harga) }}"
                    min="1000"
                    required
                >
                @error('harga')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group" style="display: flex; flex-direction: column; gap: 6px;">
                <label for="stok" style="font-weight: bold;">Stok</label>
                <input
                    type="number"
                    id="stok"
                    name="stok"
                    class="form-input"
                    value="{{ old('stok', $produk->stok) }}"
                    min="0"
                    required
                >
                @error('stok')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
            <div class="form-group" style="display: flex; flex-direction: column; gap: 6px;">
                <label for="status" style="font-weight: bold;">Status</label>
                <select id="status" name="status" class="form-select">
                    <option value="tersedia"
                        {{ old('status', $produk->status) === 'tersedia' ? 'selected' : '' }}>
                        Tersedia
                    </option>
                    <option value="habis"
                        {{ old('status', $produk->status) === 'habis' ? 'selected' : '' }}>
                        Habis
                    </option>
                </select>
                @error('status')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group" style="display: flex; flex-direction: column; gap: 6px;">
                <label for="gambar" style="font-weight: bold;">Ganti Gambar</label>
                <input
                    type="file"
                    id="gambar"
                    name="gambar"
                    class="form-input"
                    accept="image/*"
                >

                @if ($produk->gambar)
                    <img
                        src="{{ ($produk->gambar_url) }}"
                        alt="{{ $produk->nama }}"
                        style="width:80px;height:80px;border-radius:8px;object-fit:cover;margin-top:0.5rem;"
                    >
                @endif

                @error('gambar')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div style="display:flex;gap:1.5rem; margin-top: 5px;">
            <label class="form-check" style="display: flex; align-items: center; gap: 6px;">
                <input
                    type="checkbox"
                    name="is_terlaris"
                    value="1"
                    {{ old('is_terlaris', $produk->is_terlaris) ? 'checked' : '' }}
                >
                <span>Terlaris</span>
            </label>

            <label class="form-check" style="display: flex; align-items: center; gap: 6px;">
                <input
                    type="checkbox"
                    name="is_baru"
                    value='1'
                    {{ old('is_baru', $produk->is_baru) ? 'checked' : '' }}
                >
                <span>Menu Baru</span>
            </label>
        </div>

        <div style="margin-top:1rem;display:flex;gap:0.75rem;">
            <button type="submit" class="btn-primary">Update</button>
            <a href="{{ route('admin.produk.index') }}" class="btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection