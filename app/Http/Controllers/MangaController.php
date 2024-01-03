<?php

namespace App\Http\Controllers;

use App\Models\Manga;
use App\Models\Author;
use App\Models\Tag;
use Illuminate\Http\Request;

class MangaController extends Controller
{
/*---------------------- Affiche tous les mangas avec tous leurs tags et auteurs associés -------------------------------*/

    public function index() {
        $mangas = Manga::with('authors')->with('tags')->orderBy('title', 'asc')->get();

        return response()->json($mangas, 200);
    }


/*---------------------- Affiche UN manga avec tous ses tags et auteurs associés -------------------------------*/

    public function show(string $id) {
        $manga = Manga::with('authors')->with('tags')->find($id);

        return response()->json($manga, 200);
    }

/*---------------------- Enregistre un nouveau manga dans la base de données -------------------------------*/

    public function store(Request $request) {
        try{
            //on valide nos données du formulaire
            $dataValidated = $request->validate([
                'title' => 'required| string | unique:mangas|max:100',
                'status' => 'required| in:ongoing,completed,dropped',
                'description' => 'required| string',
                'picture' => 'required| string',
                'author_firstname' => 'required| string',
                "author_lastname" => 'string',
                //Un tableau des id des tags car parfois il y a un et parfois plusieurs tags associés
                'tagIdArray' => 'required| array'
            ]);

            $existingManga = Manga::where('title', $dataValidated['title'])->first();

            if ($existingManga){
                throw new GeneralJsonException(message: 'This manga already exists');
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

            return response()->json(['message' => 'Manga created successfully'], 201, $newManga);

        } catch (\Exception $e) {
        \Log::error('Error when creating the new record: ' . $e->getMessage());
        return response()->json(['error' => 'Error when creating the new record'], 500);
        }
    }

/*---------------------- Affiche 5 mangas aléatoirement -------------------------------*/
    public function randomMangas(){
        try {
            $randomMangas = Manga::inRandomOrder()->limit(5)->get();

            return response()->json($randomMangas, 200);

        }catch(\Exception $e){
            \Log::error('Error when displaying random mangas' . $e->getMessage());
            return response()->json(['error' => 'Error when displaying random mangas'], 500);
        }

    }

/*---------------------- Supprime un manga -------------------------------*/

    public function destroy(string $id) {
        try {
            $manga = Manga::findOrFail($id)->delete();
            return response()->json('The manga has been deleted', 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Manga not found'], 404);
        }
    }

/*---------------------- Met à jour un manga -------------------------------*/

    public function update(Request $request, string $id) {
        try {
            $validatedData = $request->validate([
            'title' => 'string|unique:mangas|max:100',
            'status' => 'in:ongoing,completed,dropped',
            'description' => 'string',
            'picture' => 'string',
            'author_firstname' => 'string',
            'author_lastname' => 'string',
            'tagIdArray' => 'array'
            ]);

            //Est-ce que le manga existe ?
            $manga = Manga::findOrFail($id);
            //Si oui, je le modifie
            $updatedManga = $manga->update([
                // Pourquoi '??' : If the key exists, it takes the value from $validatedData['title']; otherwise, it uses the default value, which is the current value of $manga->title.
                'title' => $validatedData['title'] ?? $manga->title,
                'status'  => $validatedData['status'] ?? $manga->status,
                'description'  => $validatedData['description'] ?? $manga->description,
                'picture'  => $validatedData['picture'] ?? $manga->picture,
                ]);

            $updatedManga = $manga->fresh();

            //isset — Determine si la veriable est déclaré et différente de null
            if (isset($validatedData['author_firstname']) || isset ($validatedData['author_lastname'])) {
                $updatedAuthor = Author::firstOrCreate(
                    [
                        'firstname'=> $validatedData['author_firstname'],
                        'lastname' => $validatedData['author_lastname'],
                    ]
                    );
                    $manga->authors()->sync([$updatedAuthor->id]);
                }

                if (isset($validatedData['tagIdArray'])) {
                    //avec pluck je recupere les id des tags déjà associés au manga et je les convertis en tableau
                    $existingTags = $manga->tags()->pluck('id')->toArray();
                    //Je combine les tags existants et les nouveaux tags en supprimant des evetuelles duplications
                    $newTags = array_unique(array_merge($existingTags, $validatedData['tagIdArray']));
                    //Je met à jour les associations
                    $manga->tags()->sync($newTags);
                }

                $manga->save();

            return response()->json('Manga updated successfully', 200);

        } catch (\Exception $e) {
                \Log::error($e);
                // Log additional information or customize the log message if needed
                return response()->json(['error' => 'Manga not found', 'exception' => $e->getMessage()], 404);
        }
    }

/*---------------------- Supprime un tag d'un manga -------------------------------*/

        public function detachTag(Request $request, string $id) {
            try {
                $validatedData = $request->validate([
                'tagIdArray' => 'required|array'
                ]);

                $manga = Manga::findOrFail($id);

                //Je supprime les tags de ce manga avec detach qui supprime l'association, contraire d'attach par exemple
                foreach($validatedData['tagIdArray'] as $tag){
                    $eraseTag = $manga->tags()->detach($tag);
                }

                return response()->json('Tag erased successfully', 200);

            } catch (\Exception $e) {
                \Log::error($e);
                // Log additional information or customize the log message if needed
                return response()->json(['error' => 'exception', 'message' => $e->getMessage()], 404);
            }

        }
}
