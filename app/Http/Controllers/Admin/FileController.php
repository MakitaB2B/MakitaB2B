<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Services\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Admin\Sms;
use Auth;

class FileController extends Controller
{

    public function uploadFilesView(){

        return view('Admin.multiplefileuload');
    }
    public function uploadFiles(Request $request)
    {
        $request->validate([
            'files.*' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        dd($request->file('files'));
    
        $uploadedFiles = [];
        if ($request->hasfile('files')) {
            foreach ($request->file('files') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('uploads', $filename, 'public');
                $uploadedFiles[] = $path;
            }
        }
    
        return response()->json(['uploadedFiles' => $uploadedFiles]);
    }
     

}


//-------------------

// Route::post('/upload-files', [FileUploadController::class, 'uploadFiles'])->name('file.upload');
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Storage;

// public function uploadFiles(Request $request)
// {
//     // Validate the uploaded files
//     $request->validate([
//         'files.*' => 'mimes:jpg,jpeg,png,pdf,docx|max:2048',  // Adjust file types and max size as needed
//     ]);

//     $uploadedFiles = [];
    
//     // Check if files were uploaded
//     if ($request->hasFile('files')) {
//         foreach ($request->file('files') as $file) {
//             // Store each file in the 'uploads' directory and collect its path
//             $path = $file->store('uploads');
//             $uploadedFiles[] = $path;
//         }
//     }

//     // Return the uploaded file paths as a response (or any other success message)
//     return response()->json([
//         'success' => true,
//         'files' => $uploadedFiles
//     ]);
// }



//-------------


// namespace App\Http\Controllers;

// use Illuminate\Http\Request;

// class TravelManagementController extends Controller
// {
//     public function showForm()
//     {
//         return view('travelmanagement.ltc_claim_form');
//     }

//     public function submitClaim(Request $request)
//     {
//         $validatedData = $request->validate([
//             'company_vehicle_no' => 'nullable|exists:vehicles,vehicle_no',
//             'fuel_amount' => 'required|numeric',
//             'opening_meter' => 'nullable|numeric',
//             'closing_meter' => 'nullable|numeric',
//             'fuel_claim' => 'nullable|numeric',
//             'in_time' => 'required|date_format:H:i',
//             'out_time' => 'required|date_format:H:i',
//             'meal_exp' => 'required|string',
//             'miscellaneous_label' => 'required|string',
//             'miscellaneous_amount' => 'required|numeric',
//             'vehicle_attachment.*' => 'nullable|file|mimes:jpg,png,pdf,docx',
//             'miscellaneous_attachment.*' => 'nullable|file|mimes:jpg,png,pdf,docx',
//         ]);

//         // Process the data, store in database, handle file uploads, etc.

//         return redirect()->back()->with('success', 'Claim submitted successfully!');
//     }
// }
