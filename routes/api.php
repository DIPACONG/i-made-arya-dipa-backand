<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PhotoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes (Sesuai Bab 3.4.5 & 3.4.7 Modul)
|--------------------------------------------------------------------------
|
| Rute API dipisahkan dari web.php karena API tidak memerlukan sesi cookie
| biasa melainkan berbasis token (Laravel Sanctum).
|
*/

// ========================
// 1. PUBLIC ROUTES (Tamu / Pengunjung)
// ========================

// Autentikasi Pengguna
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Eksplorasi Kategori & Foto
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/photos', [PhotoController::class, 'index']);
Route::get('/photos/{id}', [PhotoController::class, 'show']);

// Checkout Transaksi Pelanggan
Route::post('/orders', [OrderController::class, 'store']);


// ========================
// 2. PROTECTED ROUTES (Memerlukan Token Sanctum / auth:sanctum)
// ========================
Route::middleware('auth:sanctum')->group(function () {
    // Profil & Logout
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Manajemen Foto (CRUD Admin)
    Route::post('/photos', [PhotoController::class, 'store']);
    // Untuk update multipart dengan method spoofing (_method=PUT) atau PUT/PATCH langsung
    Route::match(['put', 'patch', 'post'], '/photos/{id}/update', [PhotoController::class, 'update']);
    Route::match(['put', 'patch'], '/photos/{id}', [PhotoController::class, 'update']);
    Route::delete('/photos/{id}', [PhotoController::class, 'destroy']);

    // Manajemen Kategori Baru
    Route::post('/categories', [CategoryController::class, 'store']);

    // Manajemen Pesanan Admin
    Route::get('/orders', [OrderController::class, 'index']);
    Route::patch('/orders/{id}/status', [OrderController::class, 'updateStatus']);
});
