<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BilledTransactionService;
class BilledTransactionController extends Controller
{
    protected $billedTransactionService;
    public function __construct(BilledTransactionService $billedTransactionService){
        $this->billedTransactionService=$billedTransactionService;
    }

    public function index(Request $request){

    // $result=ItemPrice::paginate(20,['Item','Item Description','U/M','DLP','LP','MRP','BEST']);
    $result="";
    return view('Admin.billed_transactions',compact('result')); 

    }

    public function uploadBilledTransaction(Request $request){

        if (request()->has('mycsv')) {

        $data = array_map('str_getcsv', file(request()->mycsv));

        array_shift($data);

        $header = array_map('trim', array_shift($data));
           
    //         Dealer::truncate();
    //         set_time_limit(0);
            $batchSize = 1000;
            $dealerData = [];

            foreach ($data as $index => $row) {

            $billData = array_combine($header, $row);

            dd($billData);

    //         foreach ($stockData as $key => $value) {
            
    //         if(!empty($key) && $key=="Customer" || $key=="Name" || $key=="Status (Active/Deactive)"){

    //         $fieldKey = ($key == "Status (Active/Deactive)") ? 'status' : $key;

    //         $consistentRecord[$fieldKey] = ($key == "Start Date" || $key == "Registration Date") && !empty($stockData[$key]) ? Carbon::createFromFormat('d/m/Y', $stockData[$key])->format('Y-m-d') : (empty($stockData[$key]) ? null : $stockData[$key]);

    //         }
                    
            // }
    //         $consistentRecord['dealer_slug'] =  $this->dealerService->dealer_slug();
    //         $dealerData[] = $consistentRecord;
           
    //         if (count($dealerData) >= $batchSize) {
       
    //             $dealerData = $this->filter_dealer_code($dealerData);

    //             Dealer::insert($dealerData);
               
    //             $dealerData= []; 
    //         }
        
        }
           
    //     if (!empty($dealerData)) {
    //         $dealerData = $this->filter_dealer_code($dealerData);
    //         Dealer::insert($dealerData);
    //     }

    //     return redirect('admin/dealers');
      }
    }
}
