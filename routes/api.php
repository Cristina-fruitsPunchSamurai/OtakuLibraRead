<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MangaController;
use App\Http\Controllers\TagController;

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
Route::post('/login', [UserController::class, 'login']);
Route::get('/dashboard');
Router::post('/register', [UserController::class, 'register']);

//Manga routes
Route::get('/mangas', [MangaController::class, 'index']);
Route::post('/mangas', [MangaController::class, 'store']);
Route::get('manga/{id}', [MangaController::class, 'show']);
Route::delete('manga/{id}', [MangaController::class, 'destroy']);

//Tag Routes
Route::get('/tags', [TagController::class, 'index']);
Route::post('/tags', [TagController::class, 'store']);
