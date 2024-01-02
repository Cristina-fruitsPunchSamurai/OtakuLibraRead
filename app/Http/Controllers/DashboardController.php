<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function profile(){
        return [
            //array with the data of the current logged in user
            'user' => auth()->user(),
        ];
    }
}
