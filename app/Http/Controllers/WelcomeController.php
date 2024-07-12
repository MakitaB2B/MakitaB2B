<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
 
    public function welcome(Request $request)
    {

        if (request()->hasFile('avatar')) {
            $file = request('avatar');
            $filename = $file->getClientOriginalName();
            $file->storeAs('avatars/', $filename, 's3');
        }
        return view('welcome');
    }

   
 
}