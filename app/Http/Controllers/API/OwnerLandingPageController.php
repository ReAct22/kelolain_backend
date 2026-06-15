<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use App\Models\HeroSection;
use App\Models\PromoBanner;
use App\Models\Feature;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class OwnerLandingPageController extends Controller
{
    use ApiResponse;

    /**
     * Mapping jenis section ke model.
     */
    protected function resolveModel(string $jenis): ?string
    {
        return match ($jenis) {
            'hero'        => HeroSection::class,
            'promo'       => PromoBanner::class,
            'feature'     => Feature::class,
            'testimonial' => Testimonial::class,
            default       => null,
        };
    }

    protected function validationRules(string $jenis, bool $isUpdate = false): array
    {
        $required = $isUpdate ? 'sometimes' : 'required';

        return match ($jenis) {
            'hero' => [
                'judul'       => "$required|string|max:255",
                'subjudul'    => 'nullable|string',
                'gambar'      => 'nullable|string|max:255',
                'tombol_teks' => 'nullable|string|max:100',
                'tombol_url'  => 'nullable|string|max:255',
                'is_aktif'    => 'nullable|boolean',
                'urutan'      => 'nullable|integer',
            ],
            'promo' => [
                'judul'           => "$required|string|max:255",
                'deskripsi'       => 'nullable|string',
                'gambar'          => 'nullable|string|max:255',
                'tombol_teks'     => 'nullable|string|max:100',
                'tombol_url'      => 'nullable|string|max:255',
                'mulai_tanggal'   => 'nullable|date',
                'selesai_tanggal' => 'nullable|date|after_or_equal:mulai_tanggal',
                'is_aktif'        => 'nullable|boolean',
                'urutan'          => 'nullable|integer',
            ],
            'feature' => [
                'judul'     => "$required|string|max:255",
                'deskripsi' => 'nullable|string',
                'ikon'      => 'nullable|string|max:100',
                'is_aktif'  => 'nullable|boolean',
                'urutan'    => 'nullable|integer',
            ],
            'testimonial' => [
                'nama'          => "$required|string|max:255",
                'jabatan'       => 'nullable|string|max:255',
                'nama_bisnis'   => 'nullable|string|max:255',
                'foto'          => 'nullable|string|max:255',
                'isi_testimoni' => "$required|string",
                'rating'        => 'nullable|integer|min:1|max:5',
                'is_aktif'      => 'nullable|boolean',
                'urutan'        => 'nullable|integer',
            ],
            default => [],
        };
    }

    /**
     * List semua data dari section tertentu (termasuk non-aktif).
     */
    public function index(Request $request, string $jenis)
    {
        $model = $this->resolveModel($jenis);

        if (!$model) {
            return $this->notFound('Jenis section tidak ditemukan');
        }

        $data = $model::orderBy('urutan')->latest()->get();

        return $this->success($data, "Data $jenis");
    }

    /**
     * Buat data baru pada section tertentu.
     */
    public function store(Request $request, string $jenis)
    {
        $model = $this->resolveModel($jenis);

        if (!$model) {
            return $this->notFound('Jenis section tidak ditemukan');
        }

        $rules = $this->validationRules($jenis);
        $request->validate($rules);

        $data = $request->only(array_keys($rules));

        if (array_key_exists('is_aktif', $data)) {
            $data['is_aktif'] = $request->boolean('is_aktif');
        } else {
            $data['is_aktif'] = true;
        }

        if (array_key_exists('urutan', $data) && $data['urutan'] === null) {
            $data['urutan'] = 0;
        }

        if ($jenis === 'testimonial' && !$request->filled('rating')) {
            $data['rating'] = 5;
        }

        $item = $model::create($data);

        return $this->created($item, ucfirst($jenis) . ' berhasil dibuat');
    }

    /**
     * Detail satu data pada section tertentu.
     */
    public function show(string $jenis, string $id)
    {
        $model = $this->resolveModel($jenis);

        if (!$model) {
            return $this->notFound('Jenis section tidak ditemukan');
        }

        $item = $model::find($id);

        if (!$item) {
            return $this->notFound(ucfirst($jenis) . ' tidak ditemukan');
        }

        return $this->success($item, "Detail $jenis");
    }

    /**
     * Update data pada section tertentu.
     */
    public function update(Request $request, string $jenis, string $id)
    {
        $model = $this->resolveModel($jenis);

        if (!$model) {
            return $this->notFound('Jenis section tidak ditemukan');
        }

        $item = $model::find($id);

        if (!$item) {
            return $this->notFound(ucfirst($jenis) . ' tidak ditemukan');
        }

        $rules = $this->validationRules($jenis, true);
        $request->validate($rules);

        $data = [];
        foreach (array_keys($rules) as $field) {
            if ($field === 'is_aktif') {
                if ($request->has('is_aktif')) {
                    $data['is_aktif'] = $request->boolean('is_aktif');
                }
                continue;
            }

            if ($request->has($field)) {
                $data[$field] = $request->input($field);
            }
        }

        $item->update($data);

        return $this->success($item, ucfirst($jenis) . ' berhasil diupdate');
    }

    /**
     * Hapus (soft delete) data pada section tertentu.
     */
    public function destroy(string $jenis, string $id)
    {
        $model = $this->resolveModel($jenis);

        if (!$model) {
            return $this->notFound('Jenis section tidak ditemukan');
        }

        $item = $model::find($id);

        if (!$item) {
            return $this->notFound(ucfirst($jenis) . ' tidak ditemukan');
        }

        $item->delete();

        return $this->success(null, ucfirst($jenis) . ' berhasil dihapus');
    }
}
