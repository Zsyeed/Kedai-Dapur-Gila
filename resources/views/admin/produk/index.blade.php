@extends('layouts.admin')

@section('page-title', 'Kelola Produk')

@section('content')
<div class="admin-card-header" style="margin-bottom:1.5rem;">
    <div class="search-input" style="max-width:300px;">
        <i class="fas fa-search"></i>
        <form method="GET" action="{{ route('admin.produk.index') }}" style="display:flex;gap:0.5rem;">
            <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari produk..." class="form-input" style="padding-left:2.5rem;">
            <select name="status" class="form-select form-select-sm" style="width:auto;">
                <option value="">Semua Status</option>
                <option value="tersedia" {{ request('status') === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                <option value="habis" {{ request('status') === 'habis' ? 'selected' : '' }}>Habis</option>
            </select>
            <button type="submit" class="btn-sm btn-outline"><i class="fas fa-filter"></i>Cari</button>
        </form>
    </div>
    <a href="{{ route('admin.produk.create') }}" class="btn-primary btn-sm">
        <i class="fas fa-plus"></i> Tambah Produk
    </a>
</div>

<div class="admin-card">
    <div class="admin-table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width:60px;">Gambar</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Status</th>
                    <th>Label</th>
                    <th style="width:120px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($produk as $p)
                    <tr>
                        <td>
                            <img src="{{ $p->gambar_url }}" alt="{{ $p->nama }}" style="width:48px;height:48px;border-radius:8px;object-fit:cover;">
                        </td>
                        <td><strong>{{ $p->nama }}</strong></td>
                        <td><span class="badge badge-neutral">{{ $p->kategori }}</span></td>
                        <td>{{ $p->harga_formatted }}</td>
                        <td>{{ $p->stok }}</td>
                        <td><span class="badge badge-{{ $p->status === 'tersedia' ? 'success' : 'danger' }}">{{ ucfirst($p->status) }}</span></td>
                        <td>
                            @if($p->is_terlaris)<span class="badge badge-warning" style="margin-right:2px;">Terlaris</span>@endif
                            @if($p->is_baru)<span class="badge badge-info">Baru</span>@endif
                        </td>
                        <td>
                            <div style="display:flex; gap:6px; justify-content:center;">
                                <a href="{{ route('admin.produk.edit', $p) }}" class="btn-sm btn-outline" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>

                                <form method="POST"
                                    action="{{ route('admin.produk.destroy', $p) }}" onsubmit="return confirm('Hapus produk ini?')" style="margin:0;">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn-sm btn-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="pagination">{{ $produk->withQueryString()->links() }}</div>
</div>
@endsection