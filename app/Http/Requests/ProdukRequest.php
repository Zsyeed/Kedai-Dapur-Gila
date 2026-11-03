<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProdukRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // otorisasi sudah di middleware role
    }

    public function rules(): array
    {
        $rules = [
            'nama'     => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
            'harga'    => 'required|integer|min:1000',
            'kategori' => 'required|string|max:100',
            'stok'     => 'required|integer|min:0',
            'status'   => 'required|in:tersedia,habis',
            'is_terlaris' => 'nullable|boolean',
            'is_baru'     => 'nullable|boolean',
        ];

        if ($this->isMethod('post')) {
            $rules['gambar'] = 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'nama.required'    => 'Nama produk wajib diisi.',
            'harga.required'   => 'Harga produk wajib diisi.',
            'harga.integer'    => 'Harga harus berupa angka.',
            'harga.min'        => 'Harga minimal Rp 1.000.',
            'stok.required'    => 'Stok wajib diisi.',
            'stok.integer'     => 'Stok harus berupa angka.',
            'gambar.image'     => 'File harus berupa gambar.',
            'gambar.max'       => 'Ukuran gambar maksimal 2MB.',
        ];
    }
}