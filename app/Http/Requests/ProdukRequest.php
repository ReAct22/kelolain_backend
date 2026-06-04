<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProdukRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            'category_id' => ($isUpdate ? 'sometimes' : 'required') . '|exists:categories,id',
            'nama_produk' => ($isUpdate ? 'sometimes' : 'required') . '|string|max:255',
            'harga'       => ($isUpdate ? 'sometimes' : 'required') . '|integer|min:0',
            'stok'        => ($isUpdate ? 'sometimes' : 'required') . '|integer|min:0',
            'deskripsi'   => 'nullable|string',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'      => 'nullable|in:aktif,nonaktif',
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists'   => 'Kategori tidak ditemukan.',
            'nama_produk.required' => 'Nama produk wajib diisi.',
            'nama_produk.max'      => 'Nama produk maksimal 255 karakter.',
            'harga.required'       => 'Harga wajib diisi.',
            'harga.integer'        => 'Harga harus berupa angka.',
            'harga.min'            => 'Harga tidak boleh negatif.',
            'stok.required'        => 'Stok wajib diisi.',
            'stok.integer'         => 'Stok harus berupa angka.',
            'stok.min'             => 'Stok tidak boleh negatif.',
            'gambar.image'         => 'File harus berupa gambar.',
            'gambar.mimes'         => 'Format gambar harus jpg, jpeg, png, atau webp.',
            'gambar.max'           => 'Ukuran gambar maksimal 2MB.',
            'status.in'            => 'Status harus aktif atau nonaktif.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status'  => false,
            'message' => 'Validasi gagal',
            'errors'  => $validator->errors(),
        ], 422));
    }
}
