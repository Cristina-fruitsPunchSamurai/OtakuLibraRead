<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function profile(){
        $user = Auth::user();

        return response()->json($user, 200);

        // return [
        //     //array with the data of the current logged in user
        //     'user' => auth()->user(),
        // ];
    }
}
