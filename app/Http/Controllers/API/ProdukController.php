<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProdukRequest;
use App\Http\Traits\ApiResponse;
use App\Models\Category;
use App\Models\KataTerlarang;
use App\Models\ProductViolation;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Mail\ProdukPeringatanMail;

class ProdukController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $query = Produk::with('category')
            ->where('user_id', $request->user()->id);

        if ($request->filled('search')) {
            $query->where('nama_produk', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $sortBy       = $request->input('sort_by', 'created_at');
        $sortOrder    = $request->input('sort_order', 'desc');
        $allowedSorts = ['nama_produk', 'harga', 'stok', 'created_at'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder === 'asc' ? 'asc' : 'desc');
        }

        $perPage = $request->input('per_page', 15);
        $produks = $query->paginate($perPage);

        return $this->success($produks, 'Data produk');
    }

    public function store(ProdukRequest $request)
    {
        $user = $request->user();

        // Cek apakah user sedang dibanned tambah produk
        if ($user->isBannedProduk()) {
            $sampai = $user->banned_produk_sampai->format('d M Y H:i');
            return $this->error(
                "Anda tidak dapat menambahkan produk hingga {$sampai} karena melanggar kebijakan Kelolain.",
                403
            );
        }

        // Validasi harga tidak boleh 0
        if ((int) $request->harga === 0) {
            return $this->error('Harga produk tidak boleh Rp 0.', 422);
        }

        // Validasi nama produk tidak mengandung kata terlarang
        $kataNama = KataTerlarang::temukanKataTerlarang($request->nama_produk, 'nama_produk');
        if ($kataNama) {
            return $this->error("Nama produk mengandung kata terlarang: \"{$kataNama}\". Harap gunakan nama yang sesuai.", 422);
        }

        // Validasi kategori tidak terlarang
        $category = Category::find($request->category_id);
        if ($category) {
            $kataKategori = KataTerlarang::temukanKataTerlarang($category->nama_category, 'kategori');
            if ($kataKategori) {
                return $this->error("Kategori mengandung kata terlarang: \"{$kataKategori}\". Harap gunakan kategori yang sesuai.", 422);
            }
        }

        $gambar = null;
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar')->store('produks', 'public');
        }

        $produk = Produk::create([
            'user_id'     => $user->id,
            'category_id' => $request->category_id,
            'nama_produk' => $request->nama_produk,
            'harga'       => $request->harga,
            'stok'        => $request->stok,
            'deskripsi'   => $request->deskripsi,
            'gambar'      => $gambar,
            'status'      => $request->status ?? 'aktif',
        ]);

        return $this->created($produk->load('category'), 'Produk berhasil dibuat');
    }

    public function show(Request $request, string $id)
    {
        $produk = Produk::with('category')
            ->where('user_id', $request->user()->id)
            ->find($id);

        if (!$produk) {
            return $this->notFound('Produk tidak ditemukan');
        }

        return $this->success($produk, 'Detail produk');
    }

    public function update(ProdukRequest $request, string $id)
    {
        $user   = $request->user();
        $produk = Produk::where('user_id', $user->id)->find($id);

        if (!$produk) {
            return $this->notFound('Produk tidak ditemukan');
        }

        if ($request->filled('harga') && (int) $request->harga === 0) {
            return $this->error('Harga produk tidak boleh Rp 0.', 422);
        }

        if ($request->filled('nama_produk')) {
            $kataNama = KataTerlarang::temukanKataTerlarang($request->nama_produk, 'nama_produk');
            if ($kataNama) {
                return $this->error("Nama produk mengandung kata terlarang: \"{$kataNama}\". Harap gunakan nama yang sesuai.", 422);
            }
        }

        if ($request->filled('category_id')) {
            $category = Category::find($request->category_id);
            if ($category) {
                $kataKategori = KataTerlarang::temukanKataTerlarang($category->nama_category, 'kategori');
                if ($kataKategori) {
                    return $this->error("Kategori mengandung kata terlarang: \"{$kataKategori}\". Harap gunakan kategori yang sesuai.", 422);
                }
            }
        }

        if ($request->hasFile('gambar')) {
            if ($produk->gambar) {
                Storage::disk('public')->delete($produk->gambar);
            }
            $produk->gambar = $request->file('gambar')->store('produks', 'public');
        }

        $fields = ['category_id', 'nama_produk', 'harga', 'stok', 'deskripsi', 'status'];
        foreach ($fields as $field) {
            if ($request->filled($field)) {
                $produk->$field = $request->$field;
            }
        }

        $produk->save();

        return $this->success($produk->load('category'), 'Produk berhasil diupdate');
    }

    public function destroy(Request $request, string $id)
    {
        $produk = Produk::where('user_id', $request->user()->id)->find($id);

        if (!$produk) {
            return $this->notFound('Produk tidak ditemukan');
        }

        // Soft delete — gambar TIDAK dihapus, data masih bisa direstore
        $produk->delete();

        return $this->success(null, 'Produk berhasil dihapus');
    }

    /**
     * Handle pelanggaran produk — dipanggil oleh Owner
     */
    public function handlePelanggaran(Request $request, string $id)
    {
        $request->validate([
            'jenis_pelanggaran' => 'required|in:harga_nol,nama_tidak_sesuai,kategori_terlarang',
            'keterangan'        => 'nullable|string',
        ]);

        $produk = Produk::with('user')->find($id);

        if (!$produk) {
            return $this->notFound('Produk tidak ditemukan');
        }

        $user          = $produk->user;
        $peringatan_ke = $produk->jumlah_peringatan + 1;
        $is_final      = $peringatan_ke >= 3;

        // Buat log pelanggaran
        ProductViolation::create([
            'produk_id'         => $produk->id,
            'user_id'           => $user->id,
            'jenis_pelanggaran' => $request->jenis_pelanggaran,
            'keterangan'        => $request->keterangan ?? '-',
            'peringatan_ke'     => $peringatan_ke,
            'dikirim_at'        => now(),
        ]);

        // Kirim email peringatan
        Mail::to($user->email)->send(new ProdukPeringatanMail(
            $user,
            $produk,
            $peringatan_ke,
            $request->jenis_pelanggaran,
            $request->keterangan ?? '-'
        ));

        if ($is_final) {
            // Peringatan ke-3 — soft delete produk (gambar tetap disimpan) & banned user 30 hari
            $produk->delete();

            $user->update([
                'is_banned_produk'     => true,
                'banned_produk_sampai' => now()->addDays(30),
            ]);

            return $this->success(null,
                "Produk telah dihapus dan user {$user->name} dibanned 30 hari."
            );
        }

        // Peringatan ke-1 atau ke-2 — update jumlah peringatan & banned 1 hari
        $produk->update([
            'jumlah_peringatan'   => $peringatan_ke,
            'peringatan_terakhir' => now(),
            'is_banned'           => true,
            'banned_sampai'       => now()->addDay(),
        ]);

        $user->update([
            'is_banned_produk'     => true,
            'banned_produk_sampai' => now()->addDay(),
        ]);

        return $this->success([
            'peringatan_ke' => $peringatan_ke,
            'banned_sampai' => now()->addDay()->format('d M Y H:i'),
        ], "Peringatan ke-{$peringatan_ke} berhasil dikirim ke {$user->name}.");
    }
}
