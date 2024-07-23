<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\AwsS3V3\PortableVisibilityConverter;
use App\Models\Test;

class WelcomeController extends Controller
{
 
    public function welcome(Request $request)
    {
        return view('welcome');
    }


    public function image(Request $request) {
        $file1 = $request->file('image1');
        $file2 = $request->file('image2');


        $name=time().$file1->getClientOriginalName();
        $name2=time().$file2->getClientOriginalName();

        $path1='/uploads/'.$name;
        $path2='/uploads/'.$name2;

        Storage::disk('s3')->put($path1,file_get_contents($file1));
        Storage::disk('s3')->put($path2,file_get_contents($file2));
     
      
        $test=Test::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'image1' => Storage::disk('s3')->url($path1),
            'image2' => Storage::disk('s3')->url($path2),
        ]);
         
     
    
        return redirect("/");
    }
    

    public function show($id,Request $request){

        $test=Test::where('id',$id)->select("name","email","phone","image1","image2")->first();
        return view('singlepage',["test"=> $test]);
    // return Storage::disk('s3')->response('images/' . $image->filename);

    }    
   
 
}
