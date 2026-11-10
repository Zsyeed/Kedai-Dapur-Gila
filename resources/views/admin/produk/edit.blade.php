@extends('layouts.admin')

@section('page-title', 'Edit Produk')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    
    <div class="admin-card" style="background: #fff; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 1px 3px rgba(0,0,0,0.05); padding: 2rem;">
        
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 1px solid #f3f4f6;">
            <h3 style="margin: 0; font-size: 1.25rem; font-weight: 700; color: #111827;">Edit Produk</h3>
            <a href="{{ route('admin.produk.index') }}" class="btn-sm btn-outline" style="padding: 0.4rem 0.85rem; border: 1px solid #d1d5db; border-radius: 6px; background: #fff; color: #374151; font-size: 0.85rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem;">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <form method="POST" action="{{ route('admin.produk.update', $produk) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @if ($errors->any())
                <div style="background: #fef2f2; border: 1px solid #fca5a5; color: #991b1b; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.85rem;">
                    <ul style="margin: 0; padding-left: 1.25rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Kode Menu (Readonly) -->
            <div style="margin-bottom: 1.25rem;">
                <label for="kode_menu" style="display: block; font-weight: 600; font-size: 0.9rem; color: #374151; margin-bottom: 0.5rem;">Kode Menu</label>
                <input type="text" id="kode_menu" value="{{ $produk->kode_menu }}" readonly style="width: 100%; padding: 0.65rem 0.75rem; border: 1px solid #d1d5db; border-radius: 8px; background: #f9fafb; color: #6b7280; font-size: 0.9rem; outline: none;">
                <small style="display: block; color: #9ca3af; font-size: 0.8rem; margin-top: 0.35rem;">
                    Kode menu tidak dapat diubah.
                </small>
            </div>

            <!-- Nama & Kategori -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.25rem;">
                <div>
                    <label for="nama" style="display: block; font-weight: 600; font-size: 0.9rem; color: #374151; margin-bottom: 0.5rem;">Nama Produk <span style="color: #dc2626;">*</span></label>
                    <input type="text" id="nama" name="nama" value="{{ old('nama', $produk->nama) }}" required style="width: 100%; padding: 0.65rem 0.75rem; border: 1px solid #d1d5db; border-radius: 8px; font-size: 0.9rem; outline: none; box-sizing: border-box;">
                    @error('nama')
                        <span style="display: block; color: #dc2626; font-size: 0.8rem; margin-top: 0.35rem;">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="kategori" style="display: block; font-weight: 600; font-size: 0.9rem; color: #374151; margin-bottom: 0.5rem;">Kategori <span style="color: #dc2626;">*</span></label>
                    <select id="kategori" name="kategori" required style="width: 100%; padding: 0.65rem 0.75rem; border: 1px solid #d1d5db; border-radius: 8px; background: #fff; font-size: 0.9rem; outline: none; box-sizing: border-box;">
                        <option value="Makanan" {{ old('kategori', $produk->kategori) === 'Makanan' ? 'selected' : '' }}>Makanan</option>
                        <option value="Minuman" {{ old('kategori', $produk->kategori) === 'Minuman' ? 'selected' : '' }}>Minuman</option>
                    </select>
                    @error('kategori')
                        <span style="display: block; color: #dc2626; font-size: 0.8rem; margin-top: 0.35rem;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Deskripsi dengan Auto-Resize -->
            <div style="margin-bottom: 1.25rem;">
                <label for="deskripsi" style="display: block; font-weight: 600; font-size: 0.9rem; color: #374151; margin-bottom: 0.5rem;">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="3" style="width: 100%; padding: 0.65rem 0.75rem; border: 1px solid #d1d5db; border-radius: 8px; font-size: 0.9rem; outline: none; box-sizing: border-box; resize: none; overflow: hidden; line-height: 1.5;">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                @error('deskripsi')
                    <span style="display: block; color: #dc2626; font-size: 0.8rem; margin-top: 0.35rem;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Harga & Stok -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.25rem;">
                <div>
                    <label for="harga" style="display: block; font-weight: 600; font-size: 0.9rem; color: #374151; margin-bottom: 0.5rem;">Harga (Rp) <span style="color: #dc2626;">*</span></label>
                    <input type="number" id="harga" name="harga" value="{{ old('harga', $produk->harga) }}" min="1000" required style="width: 100%; padding: 0.65rem 0.75rem; border: 1px solid #d1d5db; border-radius: 8px; font-size: 0.9rem; outline: none; box-sizing: border-box;">
                    @error('harga')
                        <span style="display: block; color: #dc2626; font-size: 0.8rem; margin-top: 0.35rem;">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="stok" style="display: block; font-weight: 600; font-size: 0.9rem; color: #374151; margin-bottom: 0.5rem;">Stok <span style="color: #dc2626;">*</span></label>
                    <input type="number" id="stok" name="stok" value="{{ old('stok', $produk->stok) }}" min="0" required style="width: 100%; padding: 0.65rem 0.75rem; border: 1px solid #d1d5db; border-radius: 8px; font-size: 0.9rem; outline: none; box-sizing: border-box;">
                    @error('stok')
                        <span style="display: block; color: #dc2626; font-size: 0.8rem; margin-top: 0.35rem;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Status & Ganti Gambar -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                <div>
                    <label for="status" style="display: block; font-weight: 600; font-size: 0.9rem; color: #374151; margin-bottom: 0.5rem;">Status Ketersediaan</label>
                    <select id="status" name="status" style="width: 100%; padding: 0.65rem 0.75rem; border: 1px solid #d1d5db; border-radius: 8px; background: #fff; font-size: 0.9rem; outline: none; box-sizing: border-box;">
                        <option value="tersedia" {{ old('status', $produk->status) === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="habis" {{ old('status', $produk->status) === 'habis' ? 'selected' : '' }}>Habis</option>
                    </select>
                    @error('status')
                        <span style="display: block; color: #dc2626; font-size: 0.8rem; margin-top: 0.35rem;">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="gambar" style="display: block; font-weight: 600; font-size: 0.9rem; color: #374151; margin-bottom: 0.5rem;">Ganti Gambar</label>
                    <input type="file" id="gambar" name="gambar" accept="image/*" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 8px; background: #f9fafb; font-size: 0.85rem; box-sizing: border-box; margin-bottom: 0.5rem;">
                    
                    @if ($produk->gambar)
                        <div style="display: flex; align-items: center; gap: 0.75rem; margin-top: 0.5rem;">
                            <img src="{{ $produk->gambar_url }}" alt="{{ $produk->nama }}" style="width: 50px; height: 50px; border-radius: 6px; object-fit: cover; border: 1px solid #d1d5db;">
                            <span style="font-size: 0.8rem; color: #6b7280;">Gambar saat ini</span>
                        </div>
                    @endif

                    @error('gambar')
                        <span style="display: block; color: #dc2626; font-size: 0.8rem; margin-top: 0.35rem;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Checkbox Spesial -->
            <div style="display: flex; gap: 2rem; margin-bottom: 2rem; background: #f9fafb; padding: 1rem 1.25rem; border-radius: 8px; border: 1px solid #e5e7eb;">
                <label style="display: inline-flex; align-items: center; gap: 0.5rem; cursor: pointer; font-size: 0.9rem; font-weight: 500; color: #374151;">
                    <input type="checkbox" name="is_terlaris" value="1" {{ old('is_terlaris', $produk->is_terlaris) ? 'checked' : '' }} style="width: 16px; height: 16px; accent-color: var(--accent, #dc2626);">
                    <span>Produk Terlaris</span>
                </label>

                <label style="display: inline-flex; align-items: center; gap: 0.5rem; cursor: pointer; font-size: 0.9rem; font-weight: 500; color: #374151;">
                    <input type="checkbox" name="is_baru" value="1" {{ old('is_baru', $produk->is_baru) ? 'checked' : '' }} style="width: 16px; height: 16px; accent-color: var(--accent, #dc2626);">
                    <span>Menu Baru</span>
                </label>
            </div>

            <!-- Tombol Aksi -->
            <div style="display: flex; gap: 0.75rem; border-top: 1px solid #f3f4f6; padding-top: 1.25rem;">
                <button type="submit" class="btn-primary" style="padding: 0.65rem 1.5rem; background: var(--accent, #dc2626); color: #fff; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                    Update Produk
                </button>
                <a href="{{ route('admin.produk.index') }}" class="btn-secondary" style="padding: 0.65rem 1.25rem; background: #f3f4f6; color: #374151; border: 1px solid #d1d5db; border-radius: 8px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center;">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Script Auto-Resize Textarea -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const textarea = document.getElementById('deskripsi');
        if (textarea) {
            textarea.style.height = 'auto';
            textarea.style.height = textarea.scrollHeight + 'px';

            textarea.addEventListener('input', function () {
                this.style.height = 'auto';
                this.style.height = this.scrollHeight + 'px';
            });
        }
    });
</script>
@endsection