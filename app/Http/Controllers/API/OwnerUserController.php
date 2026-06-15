<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class OwnerUserController extends Controller
{
    use ApiResponse;

    /**
     * Statistik untuk card di halaman User (Total User, User Aktif, Admin, User Diblokir)
     */
    public function stats()
    {
        $stats = [
            'total_user'     => User::count(),
            'user_aktif'     => User::where('status', 'aktif')->count(),
            'admin'          => User::where('role', 'admin')->count(),
            'user_diblokir'  => User::where('status', 'blokir')->count(),
        ];

        return $this->success($stats, 'Statistik user');
    }

    /**
     * List user dengan search, filter peran, filter status, dan pagination.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Search by nama atau email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        // Filter by peran
        if ($request->filled('role') && $request->role !== 'semua') {
            $query->where('role', $request->role);
        }

        // Filter by status
        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        $perPage = $request->input('per_page', 10);
        $users   = $query->latest()->paginate($perPage);

        return $this->success($users, 'Data user');
    }

    /**
     * Detail satu user.
     */
    public function show(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return $this->notFound('User tidak ditemukan');
        }

        return $this->success($user, 'Detail user');
    }

    /**
     * Update peran (role) dan status user.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return $this->notFound('User tidak ditemukan');
        }

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
            'role'        => 'sometimes|in:user,owner,admin,manager,staff',
            'status'      => 'sometimes|in:aktif,nonaktif,blokir',
            'password'    => 'sometimes|string|min:8',
        ]);

        $data = [];
        if ($request->filled('name'))        $data['name']        = $request->name;
        if ($request->filled('nama_bisnis')) $data['nama_bisnis'] = $request->nama_bisnis;
        if ($request->filled('email'))       $data['email']       = $request->email;
        if ($request->filled('no_hp'))       $data['no_hp']       = $request->no_hp;
        if ($request->filled('role'))        $data['role']        = $request->role;
        if ($request->filled('status'))      $data['status']      = $request->status;
        if ($request->filled('password'))    $data['password']    = Hash::make($request->password);

        $user->update($data);

        return $this->success($user->fresh(), 'User berhasil diupdate');
    }

    /**
     * Hapus (soft delete) user.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return $this->notFound('User tidak ditemukan');
        }

        $user->delete();

        return $this->success(null, 'User berhasil dihapus');
    }
}