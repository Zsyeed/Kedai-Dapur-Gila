@extends('layouts.owner')

@section('page-title', 'Kelola Admin')

@section('content') 
<div class="admin-card-header" style="margin-bottom:1.5rem;">
    <div class="search-input" style="max-width:300px;">
        <i class="fas fa-search"></i>
        <form method="GET" action="{{ route('owner.admins.index') }}" style="display:flex;gap:0.5rem;">
            <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari admin..." class="form-input" style="padding-left:2.5rem;">
            <button type="submit" class="btn-sm btn-outline"><i class="fas fa-filter"></i>Cari</button>
        </form>              
    </div>
        <a href="{{ route('owner.admins.create') }}" class="btn btn-primary">Tambah Admin</a>
</div>

<div class="admin-card">
    <div class="admin-table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No Telepon</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($admins as $admin)
                <tr>
                    <td>{{ $admin->nama }}</td>
                    <td>{{ $admin->email }}</td>
                    <td>{{ $admin->no_telepon }}</td>
                    <td>
                        <a href="{{ route('owner.admins.edit', $admin->id) }}" class="btn-sm btn-outline" style="margin-right:4px;" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('owner.admins.destroy', $admin->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus admin ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection