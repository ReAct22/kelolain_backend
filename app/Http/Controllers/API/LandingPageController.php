<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use App\Models\HeroSection;
use App\Models\PromoBanner;
use App\Models\Feature;
use App\Models\Testimonial;
use App\Models\PageSeo;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    use ApiResponse;

    /**
     * Ambil semua section aktif untuk render landing page (public, tanpa auth).
     */
    public function index()
    {
        $data = [
            'hero'         => HeroSection::aktif()->get(),
            'promo'        => PromoBanner::aktif()->sedangBerjalan()->get(),
            'feature'      => Feature::aktif()->get(),
            'testimonial'  => Testimonial::aktif()->get(),
            'seo'          => PageSeo::aktif()->where('page_key', 'homepage')->first(),
        ];

        return $this->success($data, 'Data landing page');
    }

    /**
     * Ambil SEO meta untuk halaman statis tertentu (public, tanpa auth).
     * Contoh: GET /page-seo/pricing
     */
    public function pageSeo(string $pageKey)
    {
        $seo = PageSeo::aktif()->where('page_key', $pageKey)->first();

        if (!$seo) {
            return $this->notFound('SEO halaman tidak ditemukan');
        }

        return $this->success($seo, 'Data SEO halaman');
    }
}
