<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    //*** Affiche tous les tags
    public function index() {
        $tags = Tag::all();

        return response()->json($tags);
    }

    //*** Affiche tous les mangas asscoiés à un tag particulier */
    public function show(string $id) {
        $tag = Tag::with('mangas')->find($id);

        return response()->json($tag);
    }

    //*** Ajoute un tag à la DB
    public function store(Request $request) {
        try {
            //Je valide les données
            $dataValidated = $request->validate(
                [
                    'name' => 'required| string | unique:tags|max:100',
                ]
            );

            //Je crée un nouveau tag
            $newTag = new Tag();
            $newTag->name = $dataValidated['name'];
            $newTag->save();

            return response()->json($newTag);

        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 409);
        }
    }

    //*** Met à jour un tag */
    public function update(Request $request , string $id) {
        try{
            $dataValidated = $request->validate(
                [
                    'name' => 'required| string | unique:tags|max:100',
                ]
            );
            $updatedTag = Tag::where('id', $id)->firstOrFail()->update($dataValidated);


            if ($updatedTag > 0) {
            return response()->json("Tag was updated successfully", 200);
            } else {
                return response()->json("Tag could not be updated", 400);
            }
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    //*** Supprime un tag
    public function destroy(string $id) {
        try {
            $tag = Tag::findOrFail($id)->delete();
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 409);
        }
    }

}
