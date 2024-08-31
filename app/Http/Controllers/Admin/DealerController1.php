<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Dealer;
use Carbon\Carbon;
use App\Services\DealerService;
use Exception;

class DealerController extends Controller
{
    protected $dealerService;

    public function __construct(DealerService $dealerService){
      $this->dealerService=$dealerService;
    }

    public function index(){
        return view('Admin.dealer_master'); 
    }

    public function uploadDealer(Request $request){

        $columnsToRemove =[
            "Ship To",
            "Address [1]",
            "Address [2]",
            "Address [3]",
            "Address [4]",
            "City",
            "Description",
            "Postal/ZIP",
            "County",
            "Country",
            "Contact",
            "Phone",
            "Ship Site",
            "Salesperson",
            "GST Registered",
            "Provisional ID No",
            "Start Date",
            "GSTIN",
            "Registration Date",
            "State Code",
            "Status (Active/Deactive)"
        ];

        $exists = Dealer::distinct()->pluck('Customer')->toArray();

        if (request()->has('mycsv')) {
            $data = array_map('str_getcsv', file(request()->mycsv));
            $header = array_map('trim', array_shift($data));
            $header = array_diff( $header, $columnsToRemove);
            
            Dealer::truncate();
            set_time_limit(0);
            $batchSize = 1;
            $dealerData = [];

            foreach ($data as $index => $row) {

            $stockData = array_combine($header, $row);

            foreach ($stockData as $key => $value) {
            
            if(!empty($key)){

            $consistentRecord[$key] = ($key == "Start Date" || $key == "Registration Date") && !empty($stockData[$key]) ? Carbon::createFromFormat('d/m/Y', $stockData[$key])->format('Y-m-d') : (empty($stockData[$key]) ? null : $stockData[$key]);

            }
                    
            }
            $consistentRecord['dealer_slug'] =  $this->dealerService->dealer_slug();
            $dealerData[] = $consistentRecord;

            if (count($dealerData) >= $batchSize) {
               dd($dealerData);
                // if (!$exists) {
                Dealer::insert($dealerData);
                // }
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
