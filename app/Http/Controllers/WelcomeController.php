<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WelcomeController extends Controller
{
 
    public function welcome(Request $request)
    {
        return view('welcome');
    }


    public function image(Request $request){

      
        if ($request["avatar"]) {
            // Get the uploaded file
            $file = $request["avatar"];
    
            // Ensure $file is an instance of UploadedFile
            if ($file instanceof \Illuminate\Http\UploadedFile) {
                // Get the original file name
                $originalName = $file->getClientOriginalName();
    
                // Store the file (for example, in the 'uploads' directory)
                $path = Storage::disk('s3')->putFileAs('uploads', $file, $originalName)
    
                // Further processing...
    
                return response()->json(['message' => 'File uploaded successfully', 'path' => $path]);
            } 


    }
   
 
}
