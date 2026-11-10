@extends('layouts.app')

@section('title', 'Detail Pesanan #' . $transaksi->kode_transaksi)

@section('content')
<section class="section bg-light" style="min-height: 80vh; padding-top: 3rem;">
    <div class="section-container" style="max-width: 1000px;">
        
        <!-- Tombol Kembali -->
        <a href="{{ route('pelanggan.pesanan') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Pesanan
        </a>

        <!-- Header Detail -->
        <div class="detail-header">
            <div>
                <h2 class="section-title font-display" style="font-size: 2rem; margin-bottom: 0.25rem;">
                    #{{ $transaksi->kode_transaksi }}
                </h2>
                <p style="color: var(--text-muted); font-size: 0.9rem; margin: 0;">
                    <i class="far fa-calendar-alt" style="margin-right: 4px;"></i>
                    {{ $transaksi->created_at->locale('id')->isoFormat('D MMMM Y, HH:mm') }}
                </p>
            </div>
            <span class="badge badge-{{ $transaksi->status_color }}" style="font-size: 0.85rem; padding: 0.4rem 1rem;">
                {{ $transaksi->status_label }}
            </span>
        </div>

        <div class="detail-grid">
            
            <!-- KOLOM KIRI: Item Pesanan & Rincian Biaya -->
            <div>
                <div class="detail-box">
                    <h3 class="detail-box-title">Daftar Item Pesanan</h3>
                    
                    @foreach($transaksi->detailTransaksi as $detail)
                        <div class="detail-item">
                            <div>
                                <strong style="display: block; font-size: 0.95rem; color: var(--text-main);">
                                    {{ $detail->jumlah }}x {{ $detail->produk->nama }}
                                </strong>
                                <span style="font-size: 0.8rem; color: var(--text-muted);">
                                    {{ $detail->produk->harga_formatted }} / porsi
                                </span>
                            </div>
                            <span style="font-weight: 700; color: var(--text-main);">
                                {{ $detail->subtotal_formatted }}
                            </span>
                        </div>
                    @endforeach

                    <!-- Rincian Subtotal, Ongkir & Total -->
                    <div style="border-top: 1px solid #f3f4f6; padding-top: 1rem; margin-top: 1rem;">
                        <div class="detail-summary-row">
                            <span>Subtotal Makanan</span>
                            <span>{{ 'Rp ' . number_format($transaksi->detailTransaksi->sum(function($item) { return $item->jumlah * $item->harga; }), 0, ',', '.') }}</span>
                        </div>
                        <div class="detail-summary-row">
                            <span>Biaya Pengiriman (Ongkir)</span>
                            <span>{{ 'Rp ' . number_format($transaksi->ongkir ?? 0, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="detail-total">
                        <span>Total Pembayaran</span>
                        <span>{{ $transaksi->total_harga_formatted }}</span>
                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN: Info Pengiriman & Pembayaran -->
            <div>
                <div class="detail-box">
                    <h3 class="detail-box-title">Informasi Pengiriman & Pembayaran</h3>

                    <div class="detail-row">
                        <span>Alamat Tujuan</span>
                        <span>{{ $transaksi->alamat_pengiriman }}</span>
                    </div>

                    <div class="detail-row">
                        <span>Nomor Telepon</span>
                        <span>{{ $transaksi->no_telepon }}</span>
                    </div>

                    <div class="detail-row">
                        <span>Metode Bayar</span>
                        <span style="text-transform: uppercase; font-weight: 700;">{{ $transaksi->metode_pembayaran }}</span>
                    </div>

                    @if($transaksi->catatan)
                        <div class="detail-row">
                            <span>Catatan</span>
                            <span>{{ $transaksi->catatan }}</span>
                        </div>
                    @endif

                    <!-- Jika ada bukti pembayaran (QRIS / Transfer) -->
                    @if($transaksi->bukti_pembayaran)
                        <div style="margin-top: 1.5rem; border-top: 1px solid #f3f4f6; padding-top: 1rem;">
                            <span style="display: block; font-weight: 600; color: var(--text-muted); margin-bottom: 0.5rem; font-size: 0.9rem;">
                                Bukti Pembayaran:
                            </span>
                            <a href="{{ asset('storage/' . $transaksi->bukti_pembayaran) }}" target="_blank" title="Klik untuk memperbesar">
                                <img src="{{ asset('storage/' . $transaksi->bukti_pembayaran) }}" alt="Bukti Pembayaran" style="max-width: 100%; max-height: 200px; border-radius: 8px; border: 1px solid #ddd; object-fit: cover;">
                            </a>
                        </div>
                    @endif
                </div>
            </div>

        </div>

    </div>
</section>
@endsection