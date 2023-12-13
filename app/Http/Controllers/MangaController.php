<?php

namespace App\Http\Controllers;

use App\Models\Manga;
use App\Models\Author;
use App\Models\Tag;
use Illuminate\Http\Request;

class MangaController extends Controller
{
    //*** Affiche tous les mangas avec tous leurs tags et auteurs associés
    public function index()
    {
        $mangas = Manga::with('authors')->with('tags')->orderBy('title', 'asc')->get();

        return response()->json($mangas);
    }


    //*** Affiche un manga avec tous ses tags et auteurs associés
    public function show(string $id) {
        $manga = Manga::with('authors')->with('tags')->find($id);

        return response()->json($manga);
    }

    //store a new manga
    public function store(Request $request){
        try{
        //on valide nos données du formulaire
        $dataValidated = $request->validate([
            'title' => 'required| string | unique:mangas|max:100',
            'status' => 'required| in:ongoing,completed,dropped',
            'description' => 'required| string',
            'picture' => 'required| string',
            'author_firstname' => 'required| string',
            "author_lastname" => 'required| string',
            //Un tableau des id des tags car parfois il y a un et parfois plusieurs tags associés
            'tagIdArray' => 'required| array'
        ]);

        $existingManga = Manga::where('title', $dataValidated['title'])->first();

        if($existingManga){
            return response()->json(['error' => 'Manga already exists'], 409);
        }

        $newManga = Manga::create([
            'title'=> $dataValidated['title'],
            'status' => $dataValidated['status'],
            'description' => $dataValidated['description'],
            'picture' => $dataValidated['picture'],
            ]);

        // On cherche si l'auteur avec ce firstname et lastname existe
        $existingAuthor = Author::where('firstname', $dataValidated['author_firstname'])->where('lastname', $dataValidated['author_lastname'])->first();

        //Si le mangaka existe déjà
        if ($existingAuthor){
            $existingAuthorId = $existingAuthor->id;
            $newManga-> authors()->attach($existingAuthorId);
        } else {
            $newAuthor = Author::create([
                'firstname' => $dataValidated['author_firstname'],
                'lastname' => $dataValidated['author_lastname'],
            ]);
            $newManga->authors()->attach($newAuthor->id);
        }
        //J'associe le tag
        foreach($dataValidated['tagIdArray'] as $tag){
            $newManga->tags()->attach($tag);
        }

        return response()->json($newManga);

    } catch (ValidationException $e) {
        return response()->json(['error' => 'Validation failed', 'errors' => $e->errors()], 422);
    }catch (\Exception $e) {
        return response()->json(['error' => 'Manga not created'], 409);
    };
    }
     //supprimer manga
    public function destroy(string $id) {
        try {
            $manga = Manga::findOrFail($id)->delete();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Manga not found'], 404);
        }


        return response()->json('The manga has been deleted');
    }

     //****!!! pour associer un tag à un manga
     //JE recupe le le manga $manga= App\Manga::first();
     //$tag = App\Tag::where('name', 'seinen')->first();
     // $manga->tags()->attach($tag)
     //or detach pour  l'enlever
     //*/

}
