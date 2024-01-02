<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        //Si le token n'est pas inclut dans les headers on envoit une erreur
        if (!$request->expectsJson()) {
            return response()->json(['error' => 'Token not found'], 401);
        }

}
}
