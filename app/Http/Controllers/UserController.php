<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!auth()->attempt($credentials)) {
            throw new GeneralJsonException(message: 'Invalid credentials');
        }

        $user = User::where('email', $credentials['email'])->first();

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function register()
    {
        $dataValidated = request()->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $dataValidated['name'],
            'email' => $dataValidated['email'],
            'password' => bcrypt($dataValidated['password'])
        ]);

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }
}