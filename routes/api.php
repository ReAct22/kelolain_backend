<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProdukController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\InvoiceController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\OwnerDashboardController;
use App\Http\Controllers\API\OwnerKataTerlarangController;
use App\Http\Controllers\API\PusatBantuanController;
use App\Http\Controllers\API\OwnerPusatBantuanController;
use App\Http\Controllers\API\ProdukSeoController;
use App\Http\Controllers\API\OwnerSeoController;
use App\Http\Controllers\API\OwnerLandingPageController;
use App\Http\Controllers\API\LandingPageController;
use App\Http\Controllers\API\OwnerUserController;
use App\Http\Controllers\API\OwnerBackupController;

// Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Public — Landing Page & SEO (Marketing)
Route::get('/landing-page', [LandingPageController::class, 'index']);
Route::get('/page-seo/{pageKey}', [LandingPageController::class, 'pageSeo']);

// Protected routes (User)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Profile
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);

    // Category
    Route::apiResource('categories', CategoryController::class);

    // Produk
    Route::apiResource('produks', ProdukController::class);

    // Produk SEO
    Route::get('/produks/{id}/seo', [ProdukSeoController::class, 'show']);
    Route::put('/produks/{id}/seo', [ProdukSeoController::class, 'update']);

    // Invoice
    Route::apiResource('invoices', InvoiceController::class);

    // Dashboard User
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Pusat Bantuan (User)
    Route::prefix('pusat-bantuan')->group(function () {
        Route::get('/kategori', [PusatBantuanController::class, 'kategori']);
        Route::get('/faq', [PusatBantuanController::class, 'faq']);
        Route::get('/tiket', [PusatBantuanController::class, 'daftarTiket']);
        Route::post('/tiket', [PusatBantuanController::class, 'buatTiket']);
        Route::get('/tiket/{id}', [PusatBantuanController::class, 'detailTiket']);
    });
});

// Protected routes (Owner only)
Route::middleware(['auth:sanctum', 'owner'])->prefix('owner')->group(function () {

    // Dashboard Owner
    Route::get('/dashboard', [OwnerDashboardController::class, 'index']);

    // === User Management ===
    Route::get('/users/stats', [OwnerUserController::class, 'stats']);
    Route::get('/users', [OwnerUserController::class, 'index']);
    Route::get('/users/{id}', [OwnerUserController::class, 'show']);
    Route::put('/users/{id}', [OwnerUserController::class, 'update']);
    Route::delete('/users/{id}', [OwnerUserController::class, 'destroy']);

    // === Backup Otomatis ===
    Route::post('/backup/jalankan', [OwnerBackupController::class, 'jalankan']);
    Route::get('/backup/status', [OwnerBackupController::class, 'status']);
    Route::get('/backup', [OwnerBackupController::class, 'index']);
    Route::get('/backup/{tanggal}/download/{jenis}', [OwnerBackupController::class, 'download']);

    // Kata Terlarang CRUD
    Route::apiResource('kata-terlarang', OwnerKataTerlarangController::class);

    // Handle Pelanggaran Produk
    Route::post('/produks/{id}/pelanggaran', [ProdukController::class, 'handlePelanggaran']);

    // Pusat Bantuan (Owner)
    Route::prefix('pusat-bantuan')->group(function () {

        // Kategori Bantuan
        Route::get('/kategori', [OwnerPusatBantuanController::class, 'indexKategori']);
        Route::post('/kategori', [OwnerPusatBantuanController::class, 'storeKategori']);
        Route::put('/kategori/{id}', [OwnerPusatBantuanController::class, 'updateKategori']);
        Route::delete('/kategori/{id}', [OwnerPusatBantuanController::class, 'destroyKategori']);

        // FAQ
        Route::get('/faq', [OwnerPusatBantuanController::class, 'indexFaq']);
        Route::post('/faq', [OwnerPusatBantuanController::class, 'storeFaq']);
        Route::put('/faq/{id}', [OwnerPusatBantuanController::class, 'updateFaq']);
        Route::delete('/faq/{id}', [OwnerPusatBantuanController::class, 'destroyFaq']);

        // Tiket Bantuan
        Route::get('/tiket', [OwnerPusatBantuanController::class, 'indexTiket']);
        Route::get('/tiket/{id}', [OwnerPusatBantuanController::class, 'detailTiket']);
        Route::post('/tiket/{id}/balas', [OwnerPusatBantuanController::class, 'balasTiket']);
        Route::put('/tiket/{id}/status', [OwnerPusatBantuanController::class, 'updateStatusTiket']);
    });

    // === SEO (Marketing) ===

    // Produk SEO (read-only, list semua produk dari semua user)
    Route::get('/produk-seo', [OwnerSeoController::class, 'indexProdukSeo']);
    Route::get('/produk-seo/{id}', [OwnerSeoController::class, 'showProdukSeo']);

    // Page SEO (CRUD)
    Route::get('/page-seo', [OwnerSeoController::class, 'indexPageSeo']);
    Route::post('/page-seo', [OwnerSeoController::class, 'storePageSeo']);
    Route::get('/page-seo/{id}', [OwnerSeoController::class, 'showPageSeo']);
    Route::put('/page-seo/{id}', [OwnerSeoController::class, 'updatePageSeo']);
    Route::delete('/page-seo/{id}', [OwnerSeoController::class, 'destroyPageSeo']);

    // === Landing Page Builder (Marketing) ===
    // {jenis} hanya menerima: hero, promo, feature, testimonial
    Route::prefix('landing-page')->group(function () {
        Route::get('/{jenis}', [OwnerLandingPageController::class, 'index']);
        Route::post('/{jenis}', [OwnerLandingPageController::class, 'store']);
        Route::get('/{jenis}/{id}', [OwnerLandingPageController::class, 'show']);
        Route::put('/{jenis}/{id}', [OwnerLandingPageController::class, 'update']);
        Route::delete('/{jenis}/{id}', [OwnerLandingPageController::class, 'destroy']);
    });
});
