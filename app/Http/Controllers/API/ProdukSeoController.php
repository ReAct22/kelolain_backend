<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use App\Models\Produk;
use App\Models\ProdukSeo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class ProdukSeoController extends Controller
{
    use ApiResponse;

    /**
     * Ambil data SEO produk milik user yang login.
     */
    public function show(Request $request, string $produkId)
    {
        $produk = Produk::where('user_id', $request->user()->id)->find($produkId);

        if (!$produk) {
            return $this->notFound('Produk tidak ditemukan');
        }

        $seo = $produk->seo;

        return $this->success($seo, 'Data SEO produk');
    }

    /**
     * Buat atau update data SEO produk milik user yang login.
     */
    public function update(Request $request, string $produkId)
    {
        $produk = Produk::where('user_id', $request->user()->id)->find($produkId);

        if (!$produk) {
            return $this->notFound('Produk tidak ditemukan');
        }

        $request->validate([
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords'    => 'nullable|string|max:255',
            'slug'             => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('produk_seo', 'slug')
                    ->ignore($produk->seo?->id)
                    ->whereNull('deleted_at'),
            ],
            'og_image'         => 'nullable|string|max:255',
        ]);

        $slug = $request->filled('slug')
            ? Str::slug($request->slug)
            : ($produk->seo->slug ?? Str::slug($produk->nama_produk) . '-' . $produk->id);

        $data = [
            'produk_id'        => $produk->id,
            'meta_title'       => $request->meta_title ?? $produk->seo?->meta_title,
            'meta_description' => $request->meta_description ?? $produk->seo?->meta_description,
            'meta_keywords'    => $request->meta_keywords ?? $produk->seo?->meta_keywords,
            'slug'             => $slug,
            'og_image'         => $request->og_image ?? $produk->seo?->og_image,
        ];

        $seo = ProdukSeo::updateOrCreate(
            ['produk_id' => $produk->id],
            $data
        );

        return $this->success($seo, 'SEO produk berhasil diperbarui');
    }
}
