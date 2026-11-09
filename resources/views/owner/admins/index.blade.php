@extends('layouts.owner')

@section('page-title', 'Kelola Admin')

@section('content') 
<div class="admin-card-header" style="margin-bottom:1.5rem; display:flex; justify-content:space-between; align-items:center;">
    <form method="GET" action="{{ route('owner.admins.index') }}" style="display:flex; gap:0.5rem; align-items:center;">
        <div class="search-input-wrapper">
            <i class="fas fa-search search-icon"></i>
            <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari admin..." class="search-input">
        </div>
        <button type="submit" class="btn-sm btn-outline">
            <i class="fas fa-filter"></i> Cari
        </button>
    </form>              
    <a href="{{ route('owner.admins.create') }}" class="btn-primary btn-sm" style="display:inline-flex; align-items:center; gap:0.5rem;">
        <i class="fas fa-plus"></i> Tambah Admin
    </a>
</div>

<div class="admin-card">
    <div class="admin-table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No Telepon</th>
                    <th style="width: 120px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($admins as $admin)
                <tr>
                    <td style="font-weight: 500;">{{ $admin->nama }}</td>
                    <td>{{ $admin->email }}</td>
                    <td>{{ $admin->no_telepon }}</td>
                    <td>
                        <div style="display:flex; gap:6px;">
                            <a href="{{ route('owner.admins.edit', $admin->id) }}" class="btn-sm btn-outline" title="Edit">
                                <i class="fas fa-pen"></i>
                            </a>
                            <form action="{{ route('owner.admins.destroy', $admin->id) }}" method="POST" style="margin:0;" onsubmit="return confirm('Yakin hapus admin ini?')">
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
</div>
@endsection