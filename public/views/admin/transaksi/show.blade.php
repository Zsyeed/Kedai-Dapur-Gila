@extends('layouts.admin')

@section('page-title', 'Detail Transaksi')

@section('content')
<a href="{{ route('admin.transaksi.index') }}"
   class="btn-back"
   style="margin-bottom:1.5rem; display:inline-flex; align-items:center; gap:0.5rem; text-decoration:none;">
    <i class="fas fa-arrow-left"></i> Kembali
</a>

<div class="checkout-grid" style="display:flex; flex-direction:column; gap:1.5rem;">

    <div class="admin-card" style="padding: 24px; box-sizing: border-box; background: #fff; border-radius: 8px; border: 1px solid #000;">
        <div class="admin-card-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 1px solid #000;">
            <h3 class="admin-card-title" style="margin: 0; font-weight: bold;">{{ $transaksi->kode_transaksi }}</h3>
            <span class="badge badge-{{ $transaksi->status_color }}"
                  style="font-size:0.85rem; padding:0.4rem 1rem; border-radius: 20px;">
                {{ $transaksi->status_label }}
            </span>
        </div>

        <div class="detail-info" style="display: flex; flex-direction: column; gap: 0.75rem;">
            <div class="detail-row" style="display: flex; gap: 0.5rem;">
                <span style="min-width: 130px; color: #000; font-weight: 600;">Pelanggan :</span>
                <span style="font-weight: 500;">{{ $transaksi->user->nama }}</span>
            </div>

            <div class="detail-row" style="display: flex; gap: 0.5rem;">
                <span style="min-width: 130px; color: #000; font-weight: 600;">Tanggal :</span>
                <span style="font-weight: 500;">{{ $transaksi->created_at->locale('id')->isoFormat('D MMMM Y, HH:mm') }}</span>
            </div>

            <div class="detail-row" style="display: flex; gap: 0.5rem;">
                <span style="min-width: 130px; color: #000; font-weight: 600;">Pembayaran :</span>
                <span style="text-transform:capitalize; font-weight: 500;">
                    {{ $transaksi->metode_pembayaran }}
                </span>
            </div>

            <div class="detail-row" style="display: flex; gap: 0.5rem;">
                <span style="min-width: 130px; color: #000; font-weight: 600;">Alamat :</span>
                <span style="font-weight: 500;">{{ $transaksi->alamat_pengiriman }}</span>
            </div>

            <div class="detail-row" style="display: flex; gap: 0.5rem;">
                <span style="min-width: 130px; color: #000; font-weight: 600;">Nomor Telepon :</span>
                <span style="font-weight: 500;">{{ $transaksi->no_telepon }}</span>
            </div>

            @if($transaksi->catatan)
                <div class="detail-row" style="display: flex; gap: 0.5rem;">
                    <span style="min-width: 130px; color: #000; font-weight: 600;">Catatan :</span>
                    <span style="font-weight: 500;">{{ $transaksi->catatan }}</span>
                </div>
            @endif

            {{-- Bukti Pembayaran --}}
            @if($transaksi->bukti_pembayaran)
                <div class="detail-row" style="display: flex; gap: 0.5rem; align-items: flex-start;">
                    <span style="min-width: 130px; color: #000; font-weight: 600;">Bukti Pembayaran :</span>
                    <div>
                        <a href="{{ asset('storage/' . $transaksi->bukti_pembayaran) }}"
                           target="_blank"
                           class="btn-sm btn-outline"
                           style="display:inline-flex; align-items: center; gap: 4px; text-decoration: none;">
                            <i class="fas fa-eye"></i> Lihat Bukti
                        </a>
                    </div>
                </div>
            @elseif(in_array($transaksi->metode_pembayaran, ['qris', 'transfer']))
                <div class="detail-row" style="display: flex; gap: 0.5rem;">
                    <span style="min-width: 130px; color: #000; font-weight: 600;">Bukti Pembayaran :</span>
                    <span style="color:#a0aec0; font-style:italic;">
                        Belum diupload
                    </span>
                </div>
            @endif
        </div>
    </div>

    <div class="admin-card" style="padding: 24px; box-sizing: border-box; background: #fff; border-radius: 8px; border: 1px solid #000;">
        <h3 class="admin-card-title" style="margin: 0 0 1rem 0; font-weight: bold; border-bottom: 1px solid #000; padding-bottom: 0.5rem;">Update Status</h3>

        @if(in_array($transaksi->status, ['menunggu', 'diproses', 'diantar']))
            <form method="POST" action="{{ route('admin.transaksi.update-status', $transaksi) }}" style="margin-bottom: 1.5rem;">
                @csrf
                @method('PUT')

                <div class="form-group" style="margin-bottom: 1rem; display: flex; flex-direction: column; gap: 6px;">
                    <label for="status" style="font-weight: 600; font-size: 0.9rem;">Ubah Status</label>
                    <select id="status" name="status" class="form-select" style="max-width: 300px; border: 1px solid #000;" required>
                        @if($transaksi->status === 'menunggu')
                            <option value="">Pilih status...</option>
                            <option value="diproses">Diproses</option>
                            <option value="dibatalkan">Dibatalkan</option>
                        @elseif($transaksi->status === 'diproses')
                            <option value="">Pilih status...</option>
                            <option value="diantar">Diantar</option>
                            <option value="dibatalkan">Dibatalkan</option>
                        @elseif($transaksi->status === 'diantar')
                            <option value="">Pilih status...</option>
                            <option value="selesai">Selesai</option>
                            <option value="dibatalkan">Dibatalkan</option>
                        @endif
                    </select>
                </div>

                <button type="submit" class="btn-primary btn-sm">
                    Update Status
                </button>
            </form>
        @else
            <p style="color:#2d3748; margin-bottom: 1.5rem; background: #f7fafc; padding: 12px; border-radius: 6px; border: 1px solid #000;">
                Transaksi sudah {{ strtolower($transaksi->status_label) }}, tidak bisa diubah.
            </p>
        @endif

        <div style="border-top: 1px solid #000; padding-top: 1.5rem;">
            <h4 style="font-size:0.9rem; font-weight: bold; color:#000; margin: 0 0 1rem 0;">
                Item Pesanan
            </h4>

            <div style="display: flex; flex-direction: column; gap: 0.75rem; margin-bottom: 1.5rem;">
                @foreach($transaksi->detailTransaksi as $d)
                    <div class="checkout-item" style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="color: #2d3748;">{{ $d->jumlah }}x {{ $d->produk->nama }}</span>
                        <span style="font-weight: 500; color: #2d3748;">{{ $d->subtotal_formatted }}</span>
                    </div>
                @endforeach
            </div>

            <div class="checkout-total" style="display: flex; justify-content: space-between; align-items: center; border-top: 2px dashed #000; padding-top: 1rem;">
                <span style="font-size: 1.05rem; font-weight: 600;">Total</span>
                <strong style="font-size: 1.2rem; color: #000;">{{ $transaksi->total_harga_formatted }}</strong>
            </div>
        </div>
    </div>
</div>
@endsection