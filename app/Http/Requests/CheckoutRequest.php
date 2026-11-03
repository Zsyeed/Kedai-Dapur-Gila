<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Models\User;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isPelanggan();
    }

    public function rules(): array
    {
        return [
            'alamat_pengiriman' => 'required|string|min:10|max:500',
            'no_telepon'      => 'required|string|max:20',
            'metode_pembayaran' => 'required|in:transfer,qris,cod',
            'catatan'           => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'alamat_pengiriman.required' => 'Alamat pengiriman wajib diisi.',
            'alamat_pengiriman.min'      => 'Alamat terlalu singkat, minimal 10 karakter.',
            'no_telepon.required'      => 'Nomor telepon wajib diisi.',
            'no_telepon.max'           => 'Nomor telepon terlalu panjang, maksimal 20 karakter.',
            'metode_pembayaran.required' => 'Pilih metode pembayaran.',
        ];
    }
}