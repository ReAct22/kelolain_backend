<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $produks = Produk::with('category')
            ->where('user_id', $request->user()->id)
            ->get();

        return response()->json([
            'message' => 'Data produk',
            'data'    => $produks,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'nama_produk' => 'required|string|max:255',
            'harga'       => 'required|integer',
            'stok'        => 'required|integer',
            'deskripsi'   => 'nullable|string',
            'gambar'      => 'nullable|image|max:2048',
            'status'      => 'nullable|in:aktif,nonaktif',
        ]);

        $gambar = null;
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar')->store('produks', 'public');
        }

        $produk = Produk::create([
            'user_id'     => $request->user()->id,
            'category_id' => $request->category_id,
            'nama_produk' => $request->nama_produk,
            'harga'       => $request->harga,
            'stok'        => $request->stok,
            'deskripsi'   => $request->deskripsi,
            'gambar'      => $gambar,
            'status'      => $request->status ?? 'aktif',
        ]);

        return response()->json([
            'message' => 'Produk berhasil dibuat',
            'data'    => $produk,
        ], 201);
    }

    public function show(Request $request, $id)
    {
        $produk = Produk::with('category')
            ->where('user_id', $request->user()->id)
            ->findOrFail($id);

        return response()->json([
            'message' => 'Detail produk',
            'data'    => $produk,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'sometimes|exists:categories,id',
            'nama_produk' => 'sometimes|string|max:255',
            'harga'       => 'sometimes|integer',
            'stok'        => 'sometimes|integer',
            'deskripsi'   => 'nullable|string',
            'gambar'      => 'nullable|image|max:2048',
            'status'      => 'nullable|in:aktif,nonaktif',
        ]);

        $produk = Produk::where('user_id', $request->user()->id)->findOrFail($id);

        if ($request->hasFile('gambar')) {
            if ($produk->gambar) Storage::disk('public')->delete($produk->gambar);
            $produk->gambar = $request->file('gambar')->store('produks', 'public');
        }

        $produk->update($request->except('gambar'));

        return response()->json([
            'message' => 'Produk berhasil diupdate',
            'data'    => $produk,
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $produk = Produk::where('user_id', $request->user()->id)->findOrFail($id);
        if ($produk->gambar) Storage::disk('public')->delete($produk->gambar);
        $produk->delete();

        return response()->json([
            'message' => 'Produk berhasil dihapus',
        ]);
    }
}
