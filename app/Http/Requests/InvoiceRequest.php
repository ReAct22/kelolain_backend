<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class InvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_pelanggan'    => 'required|string|max:255',
            'no_hp_pelanggan'   => 'nullable|string|max:20',
            'total_bayar'       => 'required|integer|min:0',
            'metode_bayar'      => 'required|in:cash,transfer,qris',
            'catatan'           => 'nullable|string',
            'items'             => 'required|array|min:1',
            'items.*.produk_id' => 'required|exists:produks,id',
            'items.*.qty'       => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_pelanggan.required'    => 'Nama pelanggan wajib diisi.',
            'nama_pelanggan.max'         => 'Nama pelanggan maksimal 255 karakter.',
            'no_hp_pelanggan.max'        => 'Nomor HP maksimal 20 karakter.',
            'total_bayar.required'       => 'Total bayar wajib diisi.',
            'total_bayar.integer'        => 'Total bayar harus berupa angka.',
            'total_bayar.min'            => 'Total bayar tidak boleh negatif.',
            'metode_bayar.required'      => 'Metode bayar wajib dipilih.',
            'metode_bayar.in'            => 'Metode bayar harus cash, transfer, atau qris.',
            'items.required'             => 'Item produk wajib diisi.',
            'items.array'                => 'Format items tidak valid.',
            'items.min'                  => 'Minimal 1 item produk.',
            'items.*.produk_id.required' => 'Produk wajib dipilih.',
            'items.*.produk_id.exists'   => 'Produk tidak ditemukan.',
            'items.*.qty.required'       => 'Jumlah item wajib diisi.',
            'items.*.qty.integer'        => 'Jumlah item harus berupa angka.',
            'items.*.qty.min'            => 'Jumlah item minimal 1.',
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