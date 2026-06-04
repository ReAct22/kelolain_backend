<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:255',
            'nama_bisnis' => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'no_hp'       => 'required|string|max:20|unique:users,no_hp',
            'tgl_lahir'   => 'required|date|before:today',
            'password'    => 'required|string|min:8|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'        => 'Nama lengkap wajib diisi.',
            'name.max'             => 'Nama lengkap maksimal 255 karakter.',
            'nama_bisnis.required' => 'Nama bisnis wajib diisi.',
            'nama_bisnis.max'      => 'Nama bisnis maksimal 255 karakter.',
            'email.required'       => 'Email wajib diisi.',
            'email.email'          => 'Format email tidak valid.',
            'email.unique'         => 'Email sudah terdaftar.',
            'no_hp.required'       => 'Nomor HP wajib diisi.',
            'no_hp.max'            => 'Nomor HP maksimal 20 karakter.',
            'no_hp.unique'         => 'Nomor HP sudah terdaftar.',
            'tgl_lahir.required'   => 'Tanggal lahir wajib diisi.',
            'tgl_lahir.date'       => 'Format tanggal lahir tidak valid.',
            'tgl_lahir.before'     => 'Tanggal lahir harus sebelum hari ini.',
            'password.required'    => 'Password wajib diisi.',
            'password.min'         => 'Password minimal 8 karakter.',
            'password.confirmed'   => 'Konfirmasi password tidak cocok.',
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
