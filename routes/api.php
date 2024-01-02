<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MangaController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//User routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

//Protected routes
//je demande au middleware d'authentifier le user en utilisant sanctum (avec un jwt)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/profile', [ProfileController::class, 'updateProfile']);
});
// Route::get('/dashboard', [DashboardController::class, 'profile'])->middleware('auth:sanctum');
// Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
// Route::put('/profile/{id}', [ProfileController::class, 'updateProfile'])->middleware('auth:sanctum');

//Manga routes
Route::get('/mangas', [MangaController::class, 'index']);
Route::post('/mangas', [MangaController::class, 'store']);
Route::get('manga/{id}', [MangaController::class, 'show']);
Route::delete('manga/{id}', [MangaController::class, 'destroy']);
Route::put('manga/{id}', [MangaController::class, 'update']);

//Tag Routes
Route::get('/tags', [TagController::class, 'index']);
Route::post('/tags', [TagController::class, 'store']);
Route::put('/tag/{id}', [TagController::class, 'update']);
