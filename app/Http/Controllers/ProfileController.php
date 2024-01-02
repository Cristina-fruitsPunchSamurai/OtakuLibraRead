<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;


class ProfileController extends Controller
{
    public function updateProfile(Request $request){
        try {
            //Est-ce que le user est authenitfied
            if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
            }

            //Je recupère l'id du user connecté
            $id = Auth::id();

            //Est-ce que le user avec cet id existe? Si c'est le cas je vais modifier les fields reçus
            $user = User::findOrFail($id);

            $dataValidated = $request->validate([
            'firstname' => 'string|max:100',
            'lastname' => 'string|max:100',
            'email' => 'email',
            //'password' => ['string', 'confirmed', Password::min(8)->mixedCase()->symbols()],
            ]);


            $user->update([
                'firstname' => $dataValidated['firstname'] ?? $user->firstname,
                'lastname'=> $dataValidated['lastname'] ?? $user->lastname,
                'email' => $dataValidated['email'] ?? $user->email,
                //'password' => isset($dataValidated['password']) ? Hash::make($dataValidated['password']) : $user->password,
            ]);

            $user->save();

            return response()->json('User updated successfully', 200);
        }catch(\Exception $e){
            \Log::error($e);
            return response()->json(['error' => 'User not found', 'exception' => $e->getMessage()], 404);
        }

    }
}