<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use App\Models\KategoriBantuan;
use App\Models\Faq;
use App\Models\TiketBantuan;
use Illuminate\Http\Request;

class OwnerPusatBantuanController extends Controller
{
    use ApiResponse;

    // === KATEGORI BANTUAN ===
    public function indexKategori()
    {
        $kategori = KategoriBantuan::orderBy('urutan')->get();
        return $this->success($kategori, 'Data kategori bantuan');
    }

    public function storeKategori(Request $request)
    {
        $request->validate([
            'nama'       => 'required|string|max:255',
            'ikon'       => 'nullable|string|max:100',
            'deskripsi'  => 'nullable|string',
            'urutan'     => 'nullable|integer',
            'is_aktif'   => 'nullable|boolean',
        ]);

        $kategori = KategoriBantuan::create([
            'nama'      => $request->nama,
            'ikon'      => $request->ikon,
            'deskripsi' => $request->deskripsi,
            'urutan'    => $request->urutan ?? 0,
            'is_aktif'  => $request->is_aktif ?? true,
        ]);

        return $this->created($kategori, 'Kategori bantuan berhasil dibuat');
    }

    public function updateKategori(Request $request, string $id)
    {
        $kategori = KategoriBantuan::find($id);

        if (!$kategori) {
            return $this->notFound('Kategori tidak ditemukan');
        }

        $request->validate([
            'nama'      => 'sometimes|string|max:255',
            'ikon'      => 'nullable|string|max:100',
            'deskripsi' => 'nullable|string',
            'urutan'    => 'nullable|integer',
            'is_aktif'  => 'nullable|boolean',
        ]);

        $data = [];
        if ($request->filled('nama'))     $data['nama']      = $request->nama;
        if ($request->filled('ikon'))     $data['ikon']      = $request->ikon;
        if ($request->has('deskripsi'))   $data['deskripsi'] = $request->deskripsi;
        if ($request->filled('urutan'))   $data['urutan']    = $request->urutan;
        if ($request->has('is_aktif'))    $data['is_aktif']  = $request->boolean('is_aktif');

        $kategori->update($data);

        return $this->success($kategori, 'Kategori bantuan berhasil diupdate');
    }

    public function destroyKategori(string $id)
    {
        $kategori = KategoriBantuan::find($id);

        if (!$kategori) {
            return $this->notFound('Kategori tidak ditemukan');
        }

        if ($kategori->faqs()->count() > 0 || $kategori->tiketBantuan()->count() > 0) {
            return $this->error('Kategori tidak bisa dihapus karena masih memiliki FAQ atau tiket.', 422);
        }

        $kategori->delete();

        return $this->success(null, 'Kategori bantuan berhasil dihapus');
    }

    // === FAQ ===
    public function indexFaq(Request $request)
    {
        $query = Faq::with('kategori');

        if ($request->filled('kategori_id')) {
            $query->where('kategori_bantuan_id', $request->kategori_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('pertanyaan', 'like', '%' . $search . '%')
                  ->orWhere('jawaban', 'like', '%' . $search . '%');
            });
        }

        return $this->success($query->orderBy('urutan')->get(), 'Data FAQ');
    }

    public function storeFaq(Request $request)
    {
        $request->validate([
            'kategori_bantuan_id' => 'nullable|exists:kategori_bantuan,id',
            'pertanyaan'          => 'required|string|max:255',
            'jawaban'             => 'required|string',
            'urutan'              => 'nullable|integer',
            'is_aktif'            => 'nullable|boolean',
        ]);

        $faq = Faq::create([
            'kategori_bantuan_id' => $request->kategori_bantuan_id,
            'pertanyaan'          => $request->pertanyaan,
            'jawaban'             => $request->jawaban,
            'urutan'              => $request->urutan ?? 0,
            'is_aktif'            => $request->is_aktif ?? true,
        ]);

        return $this->created($faq->load('kategori'), 'FAQ berhasil dibuat');
    }

    public function updateFaq(Request $request, string $id)
    {
        $faq = Faq::find($id);

        if (!$faq) {
            return $this->notFound('FAQ tidak ditemukan');
        }

        $request->validate([
            'kategori_bantuan_id' => 'nullable|exists:kategori_bantuan,id',
            'pertanyaan'          => 'sometimes|string|max:255',
            'jawaban'             => 'sometimes|string',
            'urutan'              => 'nullable|integer',
            'is_aktif'            => 'nullable|boolean',
        ]);

        $data = [];
        if ($request->has('kategori_bantuan_id')) $data['kategori_bantuan_id'] = $request->kategori_bantuan_id;
        if ($request->filled('pertanyaan'))        $data['pertanyaan']          = $request->pertanyaan;
        if ($request->filled('jawaban'))           $data['jawaban']             = $request->jawaban;
        if ($request->filled('urutan'))            $data['urutan']              = $request->urutan;
        if ($request->has('is_aktif'))             $data['is_aktif']            = $request->boolean('is_aktif');

        $faq->update($data);

        return $this->success($faq->load('kategori'), 'FAQ berhasil diupdate');
    }

    public function destroyFaq(string $id)
    {
        $faq = Faq::find($id);

        if (!$faq) {
            return $this->notFound('FAQ tidak ditemukan');
        }

        $faq->delete();

        return $this->success(null, 'FAQ berhasil dihapus');
    }

    // === TIKET BANTUAN ===
    public function indexTiket(Request $request)
    {
        $query = TiketBantuan::with(['user', 'kategori']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by prioritas
        if ($request->filled('prioritas')) {
            $query->where('prioritas', $request->prioritas);
        }

        // Search by no_tiket atau subjek
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_tiket', 'like', '%' . $search . '%')
                  ->orWhere('subjek', 'like', '%' . $search . '%');
            });
        }

        $perPage = $request->input('per_page', 15);
        $tiket   = $query->latest()->paginate($perPage);

        return $this->success($tiket, 'Data tiket bantuan');
    }

    public function detailTiket(string $id)
    {
        $tiket = TiketBantuan::with(['user', 'kategori'])->find($id);

        if (!$tiket) {
            return $this->notFound('Tiket tidak ditemukan');
        }

        return $this->success($tiket, 'Detail tiket bantuan');
    }

    public function balasTiket(Request $request, string $id)
    {
        $tiket = TiketBantuan::find($id);

        if (!$tiket) {
            return $this->notFound('Tiket tidak ditemukan');
        }

        $request->validate([
            'balasan' => 'required|string',
            'status'  => 'nullable|in:menunggu,dalam_proses,selesai,ditutup',
        ]);

        $tiket->update([
            'balasan'    => $request->balasan,
            'status'     => $request->status ?? 'dalam_proses',
            'dibalas_at' => now(),
        ]);

        return $this->success($tiket->load(['user', 'kategori']), 'Tiket berhasil dibalas');
    }

    public function updateStatusTiket(Request $request, string $id)
    {
        $tiket = TiketBantuan::find($id);

        if (!$tiket) {
            return $this->notFound('Tiket tidak ditemukan');
        }

        $request->validate([
            'status' => 'required|in:menunggu,dalam_proses,selesai,ditutup',
        ]);

        $tiket->update(['status' => $request->status]);

        return $this->success($tiket, 'Status tiket berhasil diupdate');
    }
}
