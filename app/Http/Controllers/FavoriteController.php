<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class FavoriteController extends Controller
{
/*----------------------------------- Recupère les favoris d'un user ----------------------------------*/
    public function showFavorites(){
        try {
            //Vérifie que l'utilisateur est authentifié
            if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
            }
            //Je recupère l'id de l'utilisateur authentifié
            $id = Auth::id();
            //Je 'get' les mangas favoris de l'utilisateur avec cet id
            $user = User::find($id);
            $favoriteMangas = $user->favoriteMangas()->get();

            return response()->json($favoriteMangas, 200);
        } catch(\Exception $e){
            \Log::error('Error on favorite mangas ' . $e->getMessage());
            return response()->json(['error' => 'Error when displaying favorite mangas'], 500);
        }
    }

/*----------------------------------- Ajouter en favoris----------------------------------*/
    public function addFavorite(string $mangaId){
        try {
            //Vérifie que l'utilisateur est authentifié
            if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
            }
            //Je recupère l'id de l'utilisateur authentifié
            $id = Auth::id();
            $user = User::find($id);
            $mangaAddedToFavorite = $user->favoriteMangas()->attach($mangaId);

            return response()->json(['message' => 'Manga added to favorites'], 201);

        }catch(\Exception $e){
            \Log::error('Error on favorite mangas ' . $e->getMessage());
            return response()->json(['error' => 'Error when displaying favorite mangas'], 500);

        }
    }
/*----------------------------------- Supprimer un favoris ----------------------------------*/
    public function deleteFavorite(){

    }
}
