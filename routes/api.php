<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProdukController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\InvoiceController;
use App\Http\Controllers\API\DashboardController;

// Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Protected routes
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

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);
});
