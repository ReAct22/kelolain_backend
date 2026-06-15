<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use App\Models\PageSeo;
use App\Models\ProdukSeo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class OwnerSeoController extends Controller
{
    use ApiResponse;

    // === PRODUK SEO (read-only, list semua) ===
    public function indexProdukSeo(Request $request)
    {
        $query = ProdukSeo::with(['produk.user', 'produk.category']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('meta_title', 'like', '%' . $search . '%')
                  ->orWhere('slug', 'like', '%' . $search . '%');
            });
        }

        $perPage = $request->input('per_page', 15);
        $data    = $query->latest()->paginate($perPage);

        return $this->success($data, 'Data SEO produk');
    }

    public function showProdukSeo(string $id)
    {
        $seo = ProdukSeo::with(['produk.user', 'produk.category'])->find($id);

        if (!$seo) {
            return $this->notFound('Data SEO produk tidak ditemukan');
        }

        return $this->success($seo, 'Detail SEO produk');
    }

    // === PAGE SEO (CRUD) ===
    public function indexPageSeo(Request $request)
    {
        $query = PageSeo::query();

        if ($request->filled('search')) {
            $query->where('page_key', 'like', '%' . $request->search . '%');
        }

        return $this->success($query->latest()->get(), 'Data SEO halaman');
    }

    public function storePageSeo(Request $request)
    {
        $request->validate([
            'page_key'         => 'required|string|max:100|unique:page_seo,page_key',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords'    => 'nullable|string|max:255',
            'slug'             => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('page_seo', 'slug')->whereNull('deleted_at'),
            ],
            'og_image'         => 'nullable|string|max:255',
            'is_aktif'         => 'nullable|boolean',
        ]);

        $page = PageSeo::create([
            'page_key'         => $request->page_key,
            'meta_title'       => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords'    => $request->meta_keywords,
            'slug'             => $request->filled('slug') ? Str::slug($request->slug) : Str::slug($request->page_key),
            'og_image'         => $request->og_image,
            'is_aktif'         => $request->is_aktif ?? true,
        ]);

        return $this->created($page, 'SEO halaman berhasil dibuat');
    }

    public function showPageSeo(string $id)
    {
        $page = PageSeo::find($id);

        if (!$page) {
            return $this->notFound('SEO halaman tidak ditemukan');
        }

        return $this->success($page, 'Detail SEO halaman');
    }

    public function updatePageSeo(Request $request, string $id)
    {
        $page = PageSeo::find($id);

        if (!$page) {
            return $this->notFound('SEO halaman tidak ditemukan');
        }

        $request->validate([
            'page_key'         => [
                'sometimes',
                'string',
                'max:100',
                Rule::unique('page_seo', 'page_key')->ignore($id)->whereNull('deleted_at'),
            ],
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords'    => 'nullable|string|max:255',
            'slug'             => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('page_seo', 'slug')->ignore($id)->whereNull('deleted_at'),
            ],
            'og_image'         => 'nullable|string|max:255',
            'is_aktif'         => 'nullable|boolean',
        ]);

        $data = [];
        if ($request->filled('page_key'))         $data['page_key']         = $request->page_key;
        if ($request->has('meta_title'))          $data['meta_title']       = $request->meta_title;
        if ($request->has('meta_description'))    $data['meta_description'] = $request->meta_description;
        if ($request->has('meta_keywords'))       $data['meta_keywords']    = $request->meta_keywords;
        if ($request->filled('slug'))             $data['slug']             = Str::slug($request->slug);
        if ($request->has('og_image'))            $data['og_image']         = $request->og_image;
        if ($request->has('is_aktif'))            $data['is_aktif']         = $request->boolean('is_aktif');

        $page->update($data);

        return $this->success($page, 'SEO halaman berhasil diupdate');
    }

    public function destroyPageSeo(string $id)
    {
        $page = PageSeo::find($id);

        if (!$page) {
            return $this->notFound('SEO halaman tidak ditemukan');
        }

        $page->delete();

        return $this->success(null, 'SEO halaman berhasil dihapus');
    }
}
