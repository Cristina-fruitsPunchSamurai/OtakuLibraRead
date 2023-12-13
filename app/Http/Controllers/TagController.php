<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    //*** Affiche tous les tags
    public function index()
    {
        $tags = Tag::all();

        return response()->json($tags);
    }

    //** Affiche tous les mangas asscoiés à un tag particulier */
    // public function show()
    // {

    // }

    //*** Ajoute un tag à la DB
    public function store(Request $request)
    {
        $dataValidated = $request->validate(
            [
                'name' => 'required| string | unique:tags|max:100',
            ]
        );

        $existingTag = Tag::where('name', $dataValidated['name'])->first();

        if ($existingTag)
            {
                return response()->json(['error' => 'Tag already exists'], 409);
            }

        $newTag = Tag::create(
            [
                'name' => $dataValidated['name']
            ]
        );

        return response()->json($newTag);



    }


}
