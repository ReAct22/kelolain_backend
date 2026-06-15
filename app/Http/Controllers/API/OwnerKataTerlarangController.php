<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use App\Models\KataTerlarang;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OwnerKataTerlarangController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $query = KataTerlarang::query();

        // Filter by jenis
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        // Filter by is_aktif
        if ($request->filled('is_aktif')) {
            $query->where('is_aktif', $request->boolean('is_aktif'));
        }

        // Search
        if ($request->filled('search')) {
            $query->where('kata', 'like', '%' . $request->search . '%');
        }

        $kataList = $query->latest()->get();

        return $this->success($kataList, 'Data kata terlarang');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kata'       => [
                'required',
                'string',
                'max:255',
                Rule::unique('kata_terlarang', 'kata')->whereNull('deleted_at'),
            ],
            'jenis'      => 'required|in:nama_produk,kategori,keduanya',
            'keterangan' => 'nullable|string',
            'is_aktif'   => 'nullable|boolean',
        ]);

        $kata = KataTerlarang::create([
            'kata'       => strtolower(trim($request->kata)),
            'jenis'      => $request->jenis,
            'keterangan' => $request->keterangan,
            'is_aktif'   => $request->is_aktif ?? true,
        ]);

        return $this->created($kata, 'Kata terlarang berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $kata = KataTerlarang::find($id);

        if (!$kata) {
            return $this->notFound('Kata terlarang tidak ditemukan');
        }

        return $this->success($kata, 'Detail kata terlarang');
    }

    public function update(Request $request, string $id)
    {
        $kata = KataTerlarang::find($id);

        if (!$kata) {
            return $this->notFound('Kata terlarang tidak ditemukan');
        }

        $request->validate([
            'kata'       => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('kata_terlarang', 'kata')->ignore($id)->whereNull('deleted_at'),
            ],
            'jenis'      => 'sometimes|in:nama_produk,kategori,keduanya',
            'keterangan' => 'nullable|string',
            'is_aktif'   => 'nullable|boolean',
        ]);

        $data = [];
        if ($request->filled('kata'))     $data['kata']       = strtolower(trim($request->kata));
        if ($request->filled('jenis'))    $data['jenis']      = $request->jenis;
        if ($request->has('keterangan')) $data['keterangan']  = $request->keterangan;
        if ($request->has('is_aktif'))   $data['is_aktif']    = $request->boolean('is_aktif');

        $kata->update($data);

        return $this->success($kata, 'Kata terlarang berhasil diupdate');
    }

    public function destroy(string $id)
    {
        $kata = KataTerlarang::find($id);

        if (!$kata) {
            return $this->notFound('Kata terlarang tidak ditemukan');
        }

        $kata->delete();

        return $this->success(null, 'Kata terlarang berhasil dihapus');
    }
}
