<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Traits\ApiResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponse;

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name'        => $request->name,
            'nama_bisnis' => $request->nama_bisnis,
            'email'       => $request->email,
            'no_hp'       => $request->no_hp,
            'tgl_lahir'   => $request->tgl_lahir,
            'password'    => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->created([
            'token' => $token,
            'user'  => $user,
        ], 'Register berhasil');
    }

    public function login(LoginRequest $request)
    {
        // Deteksi input email atau no_hp
        $field = str_contains($request->login, '@') ? 'email' : 'no_hp';
        $user  = User::where($field, $request->login)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->error('Email/No HP atau password salah.', 401);
        }

        // Hapus semua token lama — 1 akun hanya 1 device
        $user->tokens()->delete();

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->success([
            'token' => $token,
            'user'  => $user,
        ], 'Login berhasil');
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->success(null, 'Logout berhasil');
    }
}