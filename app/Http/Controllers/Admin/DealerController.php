<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DealerController extends Controller
{
    public function index(){
        return view('Admin.dealer_master'); 
    }

}
