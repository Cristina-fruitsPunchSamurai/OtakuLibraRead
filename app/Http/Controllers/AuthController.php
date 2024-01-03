<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

/*----------------------------------- Authentication ----------------------------------*/
    public function login()
    {
        $credentials = Validator::make(request()->all(),
            [
                'email' => 'required|email',
                'password' => 'required|string',
            ])->validate();

        $user = User::where('email', $credentials['email'])->first();

        //premier argument le passe le mdp qui vient de la requête, et en deuxième je recupere le mdp de l'instance du model
        //return true si le password matches the hash , -> credentials ok
        if(Hash::check($credentials['password'], $user->password)){
            return[
                'token'=>$user->createToken(time())->plainTextToken
                //côté client je vais stocker ce plain text token
            ];

        }
    }

/*----------------------------------- Créer un nouveau user ----------------------------------*/
    public function register(Request $request)
    {
        $dataToValidate = Validator::make($request->all(),
        [
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => ['required', 'string', 'confirmed', Password::min(8)->mixedCase()->symbols()],
            //**!!!! Ajouter un field password_confirmation dans la requête !!!!
        ]);

        if($dataToValidate->fails()){
            return response()->json(['error' => $dataToValidate->errors()], 400);
        }

        $validatedData = $dataToValidate->validated();

        $newUser = User::create([
            'firstname' => $validatedData['firstname'],
            'lastname' => $validatedData['lastname'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            ]);

            return response()->json(['message' => 'User created successfully'], 201);
    }

    /*----------------------------------- Logout ----------------------------------*/

    public function logout(){
        auth()->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'User logged out successfully'], 200);
    }
}