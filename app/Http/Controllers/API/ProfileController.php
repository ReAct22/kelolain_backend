<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    use ApiResponse;

    public function show(Request $request)
    {
        return $this->success($request->user(), 'Data profile');
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'name'        => 'sometimes|string|max:255',
            'nama_bisnis' => 'sometimes|string|max:255',
            'email'       => [
                'sometimes',
                'email',
                Rule::unique('users', 'email')->ignore($user->id)->whereNull('deleted_at'),
            ],
            'no_hp'       => [
                'sometimes',
                'string',
                'max:20',
                Rule::unique('users', 'no_hp')->ignore($user->id)->whereNull('deleted_at'),
            ],
            'tgl_lahir'   => 'sometimes|date|before:today',
            'password'    => 'sometimes|string|min:8|confirmed',
        ]);

        $data = [];

        if ($request->filled('name'))        $data['name']        = $request->name;
        if ($request->filled('nama_bisnis')) $data['nama_bisnis'] = $request->nama_bisnis;
        if ($request->filled('email'))       $data['email']       = $request->email;
        if ($request->filled('no_hp'))       $data['no_hp']       = $request->no_hp;
        if ($request->filled('tgl_lahir'))   $data['tgl_lahir']   = $request->tgl_lahir;
        if ($request->filled('password'))    $data['password']    = Hash::make($request->password);

        $user->update($data);

        return $this->success($user->fresh(), 'Profile berhasil diupdate');
    }
}
