@extends('layouts.owner')

@section('page-title', 'Laporan Penjualan')

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <p class="text-muted mb-0">
                Daftar seluruh transaksi penjualan
            </p>
        </div>
    </div>

    {{-- Filter --}}
    <div class="export-periode-form">

        {{-- Select Option --}}
        <form action="{{ route('owner.laporan.index') }}" method="GET" style="display:flex;gap:0.5rem;">
            <select name="filter"
                    class="form-select form-select-sm"
                    style="width:auto;"
                    onchange="this.form.submit()">

                <option value="">Semua Periode</option>

                <option value="hari"
                    {{ request('filter') == 'hari' ? 'selected' : '' }}>
                    Hari Ini
                </option>

                <option value="minggu"
                    {{ request('filter') == 'minggu' ? 'selected' : '' }}>
                    Minggu
                </option>

                <option value="bulan"
                    {{ request('filter') == 'bulan' ? 'selected' : '' }}>
                    Bulan
                </option>
                
            </select>
        </form>

        {{-- Export PDF --}}
        <a href="{{ route('owner.laporan.pdf', request()->query()) }}"
        class="btn-primary">
            <i class="fa-solid fa-file-pdf"></i>
            Export PDF
        </a>

    </div>

    {{-- Card --}}
    <div class="card border-0 shadow-sm rounded-4">

        {{-- Card Header --}}
        <div class="card-header bg-white border-0 pt-4 px-4">
            <h4 class="mb-0 fw-semibold">
                Data Penjualan
            </h4>
        </div>

        {{-- Table --}}
        <div class="admin-card">
            <div class="admin-table-wrap">

                <table class="data-table">

                    {{-- Header --}}

                    <thead class="table-light">
                        <tr>
                            <th class="py-3">#</th>
                            <th class="py-3">Kode Transaksi</th>
                            <th class="py-3">Tanggal</th>
                            <th class="py-3 text-end">Total Harga</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($laporan as $item)
                        <tr>
                            <td class="fw-semibold">
                                #{{ $item->id }}
                            </td>

                            <td>
                                <span class="badge bg-light text-dark border px-3 py-2">
                                    {{ $item->kode_transaksi }}
                                </span>
                            </td>

                            <td>
                                {{ $item->created_at->format('d M Y') }}
                            </td>

                            <td class="text-end fw-bold text-success">
                                Rp {{ number_format($item->total_harga, 0, ',', '.') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                Belum ada data penjualan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                    {{-- Footer --}}
                    <tfoot>
                        <tr class="table-light">
                            <th colspan="2" class="text-end">
                                Total Pendapatan
                            </th>

                            <th class="text-end text-success fw-bold">
                                Rp {{ number_format($laporan->sum('total_harga'), 0, ',', '.') }}
                            </th>
                        </tr>
                    </tfoot>

                </table>

            </div>
        </div>
    </div>
</div>
@endsection