<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        return response()->json([
            'message' => 'Data profile',
            'user'    => $request->user(),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'     => 'sometimes|string|max:255',
            'email'    => 'sometimes|email|unique:users,email,' . $request->user()->id,
            'password' => 'sometimes|string|min:6|confirmed',
        ]);

        $user = $request->user();

        if ($request->name) $user->name = $request->name;
        if ($request->email) $user->email = $request->email;
        if ($request->password) $user->password = Hash::make($request->password);

        $user->save();

        return response()->json([
            'message' => 'Profile berhasil diupdate',
            'user'    => $user,
        ]);
    }
}
