<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MangaController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FavoriteController;

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

/*----------------------------------- Authentication ----------------------------------*/
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);


/*----------------------------------- Protected routes ----------------------------------*/
//je demande au middleware d'authentifier le user en utilisant sanctum (avec un jwt)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/profile', [ProfileController::class, 'updateProfile']);
    Route::get('/favorite', [FavoriteController::class, 'showFavorites']);
    Route::post('/favorite/{mangaId}', [FavoriteController::class, 'addFavorite']);
});


/*----------------------------------- Mangas ----------------------------------*/
Route::get('/mangas', [MangaController::class, 'index']);
Route::post('/mangas', [MangaController::class, 'store']);
Route::get('manga/{id}', [MangaController::class, 'show']);
Route::delete('manga/{id}', [MangaController::class, 'destroy']);
Route::put('manga/{id}', [MangaController::class, 'update']);


/*----------------------------------- Tags ----------------------------------*/
Route::get('/tags', [TagController::class, 'index']);
Route::post('/tags', [TagController::class, 'store']);
Route::put('/tag/{id}', [TagController::class, 'update']);
