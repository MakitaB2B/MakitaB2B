<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Dealer;
use Carbon\Carbon;
use Exception;

class DealerController extends Controller
{
    public function index(){
        return view('Admin.dealer_master'); 
    }

    public function uploadDealer(Request $request){

        if (request()->has('mycsv')) {
            $data = array_map('str_getcsv', file(request()->mycsv));
            $header = array_map('trim', array_shift($data));
            Dealer::truncate();
            set_time_limit(0);
            $batchSize = 5000;
            $dealerData = [];

          
            foreach ($data as $index => $row) {

            $stockData = array_combine($header, $row);

            foreach ($stockData as $key => $value) {
                
                if(!empty($key)){
                    
                    try{
                        $consistentRecord[$key] = $key=="Start Date" ||$key=="Registration Date" && !empty($stockData[$key]) ? Carbon::createFromFormat('m/d/Y',$stockData[$key] )->format('Y-m-d')
                        : $stockData[$key] ;
                    }
                     catch(Exception $e){
                        dd($key, $value);
                     }

                   }
                    
            }
            $dealerData[] = $consistentRecord;
        
            if (count($dealerData) >= $batchSize) {
                Dealer::insert($dealerData);
                $dealerData= []; // Reset the batch array
            }
        
        }
   // Insert any remaining data
        if (!empty($dealerData)) {
            Dealer::insert($dealerData);
            }
      return redirect('admin/dealers');

    }

    }}
