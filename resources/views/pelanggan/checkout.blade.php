@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<section class="section bg-light" style="min-height: 80vh; padding-top: 3rem;">
    <div class="section-container" style="max-width: 1000px;">
        
        <h2 class="section-title" style="margin-bottom: 2rem; font-size: 2rem;">
            <i class="fas fa-credit-card" style="color: var(--accent); margin-right: 0.5rem;"></i> Checkout Pesanan
        </h2>

        <form method="POST" action="{{ route('pelanggan.checkout.proses') }}" enctype="multipart/form-data" id="checkoutForm">
            @csrf

            <div class="checkout-grid">
                
                <!-- KOLOM KIRI: Ringkasan Pesanan & Ongkir -->
                <div>
                    <div class="checkout-box">
                        <h3 class="checkout-box-title">Ringkasan Pesanan</h3>

                        <div class="checkout-items">
                            @foreach($items as $item)
                                <div class="checkout-item">
                                    <span>{{ $item->jumlah }}x {{ $item->produk->nama }}</span>
                                    <strong>{{ $item->subtotal_formatted }}</strong>
                                </div>
                            @endforeach
                        </div>

                        <!-- Rincian Biaya -->
                        <div style="border-top: 1px solid #f3f4f6; padding-top: 1rem; margin-top: 1rem; display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.95rem;">
                            <div style="display: flex; justify-content: space-between; color: var(--text-muted);">
                                <span>Subtotal Makanan</span>
                                <span id="subtotalDisplay" data-subtotal="{{ $total }}">{{ 'Rp ' . number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; color: var(--text-muted);">
                                <span>Biaya Pengiriman (Ongkir)</span>
                                <span id="ongkirDisplay">Rp 0</span>
                            </div>
                        </div>

                        <!-- Input tersembunyi untuk dikirim ke Controller -->
                        <input type="hidden" name="ongkir" id="inputOngkir" value="0">
                        <input type="hidden" name="total_keseluruhan" id="inputTotalKeseluruhan" value="{{ $total }}">

                        <div class="checkout-total" style="margin-top: 1rem;">
                            <span>Total Pembayaran</span>
                            <strong id="totalDisplay">{{ 'Rp ' . number_format($total, 0, ',', '.') }}</strong>
                        </div>
                    </div>

                    <!-- Tombol Batal / Kembali -->
                    <div style="display: flex; gap: 1rem;">
                        <button type="button" class="btn-secondary btn-full" id="btnBatalPesanan" style="padding: 0.8rem; border-radius: 8px; cursor: pointer; border: 1px solid #d1d5db; font-weight: 600;">
                            <i class="fas fa-times"></i> Batal Pesanan
                        </button>
                    </div>
                </div>

                <!-- KOLOM KANAN: Pengiriman & Pembayaran -->
                <div>
                    <div class="checkout-box">
                        <h3 class="checkout-box-title">Informasi Pengiriman & Pembayaran</h3>

                        <!-- Pilihan Wilayah / Ongkir (Tangerang & Jakarta) -->
                        <div class="form-group" style="margin-bottom: 1.25rem;">
                            <label for="wilayah" style="display:block; font-weight:600; margin-bottom:0.5rem; font-size:0.9rem;">Wilayah Pengiriman</label>
                            <select name="wilayah" id="wilayah" class="form-input" required style="width:100%; padding:0.75rem; border:1px solid #d1d5db; border-radius:8px; outline:none; background:#fff;">
                                <option value="" data-ongkir="0">-- Pilih Wilayah Tujuan --</option>
                                
                                <!-- KOTA / KABUPATEN TANGERANG -->
                                <optgroup label="Tangerang">
                                    <option value="tangerang_terdekat" data-ongkir="10000">Ciledug & Sekitarnya (Karang Tengah / Larangan) (Rp 10.000)</option>
                                    <option value="tangerang_tengah" data-ongkir="15000">Tangerang Pusat / Karawaci / Cikokol / Ciputat (Rp 15.000)</option>
                                    <option value="tangerang_terjauh" data-ongkir="20000">BSD / Gading Serpong / Alam Sutera / Bintaro (Rp 20.000)</option>
                                </optgroup>

                                <!-- DKI JAKARTA -->
                                <optgroup label="Jakarta">
                                    <option value="jakarta_terdekat" data-ongkir="12000">Jakarta Barat Terdekat (Meruya / Joglo / Petukangan) (Rp 12.000)</option>
                                    <option value="jakarta_menengah" data-ongkir="18000">Jakarta Barat Lainnya (Cengkareng / Kebon Jeruk / Kembangan) (Rp 18.000)</option>
                                    <option value="jakarta_terjauh" data-ongkir="25000">Jakarta Pusat / Jakarta Selatan (Menteng / Senayan) (Rp 25.000)</option>
                                </optgroup>
                            </select>
                        </div>

                        <!-- Alamat Lengkap -->
                        <div class="form-group" style="margin-bottom: 1.25rem;">
                            <label for="alamat_pengiriman" style="display:block; font-weight:600; margin-bottom:0.5rem; font-size:0.9rem;">Detail Alamat</label>
                            <textarea id="alamat_pengiriman" name="alamat_pengiriman" class="form-input auto-resize" rows="2" required placeholder="Contoh: Jl. Inpres V No.62, RT 01/02...">{{ old('alamat_pengiriman', $user->alamat ?? '') }}</textarea>
                            @error('alamat_pengiriman')
                                <span class="form-error" style="color:#ef4444; font-size:0.8rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- No Telepon -->
                        <div class="form-group" style="margin-bottom: 1.25rem;">
                            <label for="no_telepon" style="display:block; font-weight:600; margin-bottom:0.5rem; font-size:0.9rem;">Nomor Telepon</label>
                            <input type="text" id="no_telepon" name="no_telepon" class="form-input" value="{{ old('no_telepon', $user->no_telepon ?? '') }}" required placeholder="Contoh: 081234567890" style="width:100%; padding:0.75rem; border:1px solid #d1d5db; border-radius:8px; outline:none;">
                            @error('no_telepon')
                                <span class="form-error" style="color:#ef4444; font-size:0.8rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Metode Pembayaran -->
                        <div class="form-group" style="margin-bottom: 1.25rem;">
                            <label style="display:block; font-weight:600; margin-bottom:0.5rem; font-size:0.9rem;">Metode Pembayaran</label>

                            <div class="payment-options">
                                
                                <!-- COD -->
                                <label class="payment-option">
                                    <div class="payment-option-content">
                                        <input type="radio" name="metode_pembayaran" value="cod" {{ old('metode_pembayaran', 'cod') === 'cod' ? 'checked' : '' }} required>
                                        <i class="fas fa-hand-holding-dollar"></i>
                                        <div>
                                            <strong>COD</strong>
                                            <p>Bayar langsung di tempat saat pesanan tiba</p>
                                        </div>
                                    </div>
                                </label>

                                <!-- QRIS -->
                                <label class="payment-option">
                                    <div class="payment-option-content">
                                        <input type="radio" name="metode_pembayaran" value="qris" {{ old('metode_pembayaran') === 'qris' ? 'checked' : '' }} required>
                                        <i class="fas fa-qrcode"></i>
                                        <div>
                                            <strong>QRIS</strong>
                                            <p>Scan kode QR untuk pembayaran instan</p>
                                        </div>
                                        <button type="button" id="showQrisBtn" class="btn-show-qris" @if(old('metode_pembayaran') !== 'qris') style="display:none;" @endif>
                                            <i class="fas fa-eye"></i> Lihat QR
                                        </button>
                                    </div>
                                </label>

                                <!-- Transfer Bank -->
                                <label class="payment-option">
                                    <div class="payment-option-content" style="flex-wrap: wrap;">
                                        <div style="display: flex; align-items: center; gap: 1rem; width: 100%;">
                                            <input type="radio" name="metode_pembayaran" value="transfer" {{ old('metode_pembayaran') === 'transfer' ? 'checked' : '' }} required>
                                            <i class="fas fa-building-columns"></i>
                                            <div>
                                                <strong>Transfer Bank</strong>
                                                <p>Virtual Account (BCA, BNI, Mandiri)</p>
                                            </div>
                                        </div>

                                        <div id="bankSelection" class="bank-selection" style="width: 100%; @if(old('metode_pembayaran') !== 'transfer') display:none; @endif">
                                            <label for="bank" style="font-size:0.85rem; margin-bottom:0.25rem;">Pilih Bank Tujuan</label>
                                            <select name="bank" id="bank" class="form-input" style="width:100%; padding:0.6rem; border:1px solid #d1d5db; border-radius:6px;">
                                                <option value="">-- Pilih Bank --</option>
                                                <option value="bca" {{ old('bank') === 'bca' ? 'selected' : '' }}>BCA</option>
                                                <option value="bni" {{ old('bank') === 'bni' ? 'selected' : '' }}>BNI</option>
                                                <option value="mandiri" {{ old('bank') === 'mandiri' ? 'selected' : '' }}>Mandiri</option>
                                            </select>

                                            <div id="vaContainer" class="va-container" style="margin-top:0.75rem; @if(old('bank')) display:block; @else display:none; @endif">
                                                <span style="font-size:0.8rem; color:var(--text-muted);">Nomor Virtual Account:</span>
                                                <div class="va-box">
                                                    <span id="nomorVA"></span>
                                                    <button type="button" class="copy-btn" onclick="copyVA()">Salin</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </label>

                            </div>
                        </div>

                        <!-- Upload Bukti Pembayaran -->
                        <div class="form-group" id="buktiPembayaranGroup" style="margin-bottom: 1.25rem; @if(!in_array(old('metode_pembayaran'), ['qris', 'transfer'])) display:none; @endif">
                            <label for="bukti_pembayaran" style="display:block; font-weight:600; margin-bottom:0.5rem; font-size:0.9rem;">Upload Bukti Pembayaran</label>
                            <input type="file" id="bukti_pembayaran" name="bukti_pembayaran" class="form-input" accept="image/*,.pdf" style="width:100%; padding:0.5rem; border:1px solid #d1d5db; border-radius:8px;">
                            <small style="display:block; margin-top:4px; color:var(--text-muted); font-size:0.75rem;">Format JPG, PNG, atau PDF. Maksimal 2 MB.</small>
                            
                            <div id="previewContainer" style="display:none; margin-top:10px;">
                                <img id="previewImage" src="" alt="Preview Bukti" style="max-width:150px; border-radius:6px; border:1px solid #ddd;">
                            </div>
                        </div>

                        <!-- Catatan -->
                        <div class="form-group" style="margin-bottom: 1.5rem;">
                            <label for="catatan" style="display:block; font-weight:600; margin-bottom:0.5rem; font-size:0.9rem;">Catatan Pesanan (Opsional)</label>
                            <textarea id="catatan" name="catatan" class="form-input auto-resize" rows="2" placeholder="Contoh: Level pedas 3, kuah dipisah...">{{ old('catatan') }}</textarea>
                        </div>

                        <!-- Tombol Submit -->
                        <button type="submit" class="btn-red btn-full" style="justify-content: center; padding: 0.9rem; font-size: 1rem; border-radius: 8px;">
                            Buat Pesanan Sekarang <i class="fas fa-check-circle"></i>
                        </button>
                    </div>
                </div>

            </div>
        </form>
    </div>
</section>

<!-- Form Tersembunyi untuk Batal Pesanan -->
<form id="batalPesananForm" action="{{ route('pelanggan.keranjang.kosongkan') }}" method="POST" style="display: none;">
    @csrf
</form>

<!-- Modal QRIS -->
<div id="qrisModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.6); z-index:9999; justify-content:center; align-items:center;">
    <div style="background:#fff; padding:2rem; border-radius:16px; max-width:360px; width:90%; text-align:center; position:relative;">
        <button type="button" id="closeQrisModal" style="position:absolute; top:10px; right:15px; border:none; background:none; font-size:24px; cursor:pointer;">&times;</button>
        <h3 style="margin-bottom:1rem; font-size:1.25rem; font-weight:800;">Scan QRIS Pembayaran</h3>
        <img src="{{ asset('images/qris.jpg') }}" alt="QRIS" style="width:100%; max-width:220px; margin:0 auto 1rem auto; border-radius:8px;">
        <p style="font-size:0.85rem; color:var(--text-muted);">Gunakan aplikasi e-wallet atau m-banking apa saja untuk memindai kode QR di atas.</p>
    </div>
</div>

<style>
textarea.auto-resize {
    resize: none;
    overflow: hidden;
    min-height: 80px;
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    outline: none;
    font-family: inherit;
    font-size: 0.95rem;
}
textarea.auto-resize:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
}
</style>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const wilayahSelect = document.getElementById('wilayah');
    const subtotalDisplay = document.getElementById('subtotalDisplay');
    const ongkirDisplay = document.getElementById('ongkirDisplay');
    const totalDisplay = document.getElementById('totalDisplay');
    const inputOngkir = document.getElementById('inputOngkir');
    const inputTotalKeseluruhan = document.getElementById('inputTotalKeseluruhan');

    const subtotalValue = parseFloat(subtotalDisplay.getAttribute('data-subtotal')) || 0;

    function formatRupiah(angka) {
        return 'Rp ' + angka.toLocaleString('id-ID');
    }

    if (wilayahSelect) {
        wilayahSelect.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const ongkir = parseFloat(selectedOption.getAttribute('data-ongkir')) || 0;
            const totalKeseluruhan = subtotalValue + ongkir;

            ongkirDisplay.textContent = formatRupiah(ongkir);
            totalDisplay.textContent = formatRupiah(totalKeseluruhan);

            inputOngkir.value = ongkir;
            inputTotalKeseluruhan.value = totalKeseluruhan;
        });
    }

    // Auto-resize Textarea
    const autoResizeTextareas = document.querySelectorAll('textarea.auto-resize');
    autoResizeTextareas.forEach(textarea => {
        adjustHeight(textarea);
        textarea.addEventListener('input', function () { adjustHeight(this); });
    });
    function adjustHeight(el) {
        el.style.height = 'auto';
        el.style.height = (el.scrollHeight) + 'px';
    }

    // Metode Pembayaran & Logika Lainnya
    const paymentRadios = document.querySelectorAll('input[name="metode_pembayaran"]');
    const showQrisBtn = document.getElementById('showQrisBtn');
    const qrisModal = document.getElementById('qrisModal');
    const closeQrisModal = document.getElementById('closeQrisModal');
    const buktiGroup = document.getElementById('buktiPembayaranGroup');
    const buktiInput = document.getElementById('bukti_pembayaran');
    const previewContainer = document.getElementById('previewContainer');
    const previewImage = document.getElementById('previewImage');
    const bankSelection = document.getElementById('bankSelection');
    const bankSelect = document.getElementById('bank');
    const vaContainer = document.getElementById('vaContainer');
    const nomorVA = document.getElementById('nomorVA');
    const btnBatalPesanan = document.getElementById('btnBatalPesanan');
    const batalPesananForm = document.getElementById('batalPesananForm');

    if (btnBatalPesanan && batalPesananForm) {
        btnBatalPesanan.addEventListener('click', function(e) {
            e.preventDefault();
            if (confirm("Yakin ingin membatalkan pesanan? Keranjang belanja Anda akan dikosongkan.")) {
                batalPesananForm.submit();
            }
        });
    }

    function togglePaymentFields() {
        const selected = document.querySelector('input[name="metode_pembayaran"]:checked');
        if (selected && selected.value === 'qris') {
            showQrisBtn.style.display = 'inline-flex';
        } else {
            showQrisBtn.style.display = 'none';
        }

        if (selected && (selected.value === 'qris' || selected.value === 'transfer')) {
            buktiGroup.style.display = 'block';
            buktiInput.setAttribute('required', 'required');
        } else {
            buktiGroup.style.display = 'none';
            buktiInput.removeAttribute('required');
            buktiInput.value = '';
            previewContainer.style.display = 'none';
        }

        if (selected && selected.value === 'transfer') {
            bankSelection.style.display = 'block';
        } else {
            bankSelection.style.display = 'none';
            vaContainer.style.display = 'none';
            if(bankSelect) bankSelect.value = '';
        }
    }

    paymentRadios.forEach(radio => { radio.addEventListener('change', togglePaymentFields); });
    togglePaymentFields();

    if (showQrisBtn) {
        showQrisBtn.addEventListener('click', function (e) { e.preventDefault(); qrisModal.style.display = 'flex'; });
    }
    if (closeQrisModal) {
        closeQrisModal.addEventListener('click', function () { qrisModal.style.display = 'none'; });
    }
    qrisModal.addEventListener('click', function (e) { if (e.target === qrisModal) qrisModal.style.display = 'none'; });

    buktiInput.addEventListener('change', function () {
        const file = this.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function (e) {
                previewImage.src = e.target.result;
                previewContainer.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            previewContainer.style.display = 'none';
        }
    });

    function generateVA(bank) {
        const prefixes = { bca: '014', bni: '009', mandiri: '008' };
        if (!prefixes[bank]) return '';
        return prefixes[bank] + Date.now().toString().slice(-10) + Math.floor(Math.random() * 900 + 100);
    }

    function updateVA() {
        const bank = bankSelect.value;
        if (!bank) {
            vaContainer.style.display = 'none';
            nomorVA.textContent = '';
            return;
        }
        nomorVA.textContent = generateVA(bank);
        vaContainer.style.display = 'block';
    }

    window.copyVA = function () {
        const va = nomorVA.textContent;
        if (!va) return;
        navigator.clipboard.writeText(va).then(() => alert('Nomor Virtual Account berhasil disalin!'));
    };

    if (bankSelect) { bankSelect.addEventListener('change', updateVA); }
    if (bankSelect && bankSelect.value) { updateVA(); }
});
</script>
@endpush