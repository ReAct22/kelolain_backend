<?php

<<<<<<< Updated upstream
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProdukController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\InvoiceController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\OwnerKataTerlarangController;

// Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

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

    // Invoice
    Route::apiResource('invoices', InvoiceController::class);

    // Dashboard User
    Route::get('/dashboard', [DashboardController::class, 'index']);
});

// Protected routes (Owner only)
Route::middleware(['auth:sanctum', 'owner'])->prefix('owner')->group(function () {

    // Kata Terlarang CRUD
    Route::apiResource('kata-terlarang', OwnerKataTerlarangController::class);

    // Handle Pelanggaran Produk
    Route::post('/produks/{id}/pelanggaran', [ProdukController::class, 'handlePelanggaran']);

});
=======
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
>>>>>>> Stashed changes
