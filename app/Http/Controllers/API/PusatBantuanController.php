<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use App\Models\KategoriBantuan;
use App\Models\Faq;
use App\Models\TiketBantuan;
use Illuminate\Http\Request;

class PusatBantuanController extends Controller
{
    use ApiResponse;

    // === KATEGORI BANTUAN ===
    public function kategori()
    {
        $kategori = KategoriBantuan::aktif()->get();

        return $this->success($kategori, 'Data kategori bantuan');
    }

    // === FAQ ===
    public function faq(Request $request)
    {
        $query = Faq::with('kategori')->aktif();

        // Filter by kategori
        if ($request->filled('kategori_id')) {
            $query->where('kategori_bantuan_id', $request->kategori_id);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('pertanyaan', 'like', '%' . $search . '%')
                  ->orWhere('jawaban', 'like', '%' . $search . '%');
            });
        }

        $faqs = $query->get();

        return $this->success($faqs, 'Data FAQ');
    }

    // === TIKET BANTUAN ===
    public function daftarTiket(Request $request)
    {
        $query = TiketBantuan::with('kategori')
            ->where('user_id', $request->user()->id);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $perPage = $request->input('per_page', 10);
        $tiket   = $query->latest()->paginate($perPage);

        return $this->success($tiket, 'Data tiket bantuan');
    }

    public function buatTiket(Request $request)
    {
        $request->validate([
            'kategori_bantuan_id' => 'nullable|exists:kategori_bantuan,id',
            'subjek'              => 'required|string|max:255',
            'pesan'               => 'required|string',
            'prioritas'           => 'nullable|in:rendah,sedang,tinggi',
        ]);

        $tiket = TiketBantuan::create([
            'user_id'             => $request->user()->id,
            'kategori_bantuan_id' => $request->kategori_bantuan_id,
            'no_tiket'            => TiketBantuan::generateNoTiket(),
            'subjek'              => $request->subjek,
            'pesan'               => $request->pesan,
            'status'              => 'menunggu',
            'prioritas'           => $request->prioritas ?? 'sedang',
        ]);

        return $this->created(
            $tiket->load('kategori'),
            'Tiket bantuan berhasil dibuat'
        );
    }

    public function detailTiket(Request $request, string $id)
    {
        $tiket = TiketBantuan::with('kategori')
            ->where('user_id', $request->user()->id)
            ->find($id);

        if (!$tiket) {
            return $this->notFound('Tiket tidak ditemukan');
        }

        return $this->success($tiket, 'Detail tiket bantuan');
    }
}