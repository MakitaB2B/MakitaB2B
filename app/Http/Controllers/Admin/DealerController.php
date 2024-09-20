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

        $result=$this->dealerService->getDealersPaginated();

        return view('Admin.dealer_master',compact('result')); 
    }

    public function dealerSearch(Request $request){
        $searchValue=strtoupper($request->searchtxt);
        $searchFrom=$request->searchFrom;
        $searchType=$request->searchtype;
        $type = match($searchType){
            'customer'=>'customer',
            'name'=>'name',
            'email'=>'email',
            'status'=>'status',
            'commercial_status'=>'commercial_status',
            default => 'customer',
        };
        if($type=='customer'){
            $searchQuery=$searchValue.'%';
            $column = 'Customer';
        }
        if($type=='name'){
            $searchQuery='%'.$searchValue.'%';
            $column = 'Name';
        }
        if($type=='status'){
            $searchQuery='%'.$searchValue.'%';
            $column = 'status';
        }
        if($type=='commercial_status'){
            $searchQuery='%'.$searchValue.'%';
            $column = 'commercial_status';
        }

        if($type=='email'){
            $searchQuery='%'.$searchValue.'%';
            $column = 'E Mail ID';
        }

        $searchResult=Dealer::where($column,'LIKE',"$searchQuery")->get(['id','Customer','Name','E Mail ID','status','commercial_status','created_at']);
        if(($searchResult->count())>0 ){
            $output="";
            if($searchFrom=='itempg'){
                $routeTo="items/";
            }

            foreach ($searchResult as $key => $data) {
                $output.='<tr>'.
                '<td>'.$data->Customer.'</td>'.
                '<td>'.$data->Name.'</td>'.
                '<td>'.$data->{"E Mail ID"}.'</td>'.
                '<td>'.$data->status.'</td>'.
                '<td>'.$data->commercial_status.'</td>'.
                '<td>'.$data->created_at.'</td>'.
                '</tr>';
                }
        return Response($output);
        }else{
            echo "No Record Found";
        }
    }

    public function uploadDealer(Request $request){
          
        if (request()->has('mycsv')) {
            $data = array_map('str_getcsv', file(request()->mycsv));
            $header = array_map('trim', array_shift($data));
           
            Dealer::truncate();
            set_time_limit(0);
            $batchSize = 1000;
            $dealerData = [];

            foreach ($data as $index => $row) {

            $stockData = array_combine($header, $row);

            foreach ($stockData as $key => $value) {
            
            if(!empty($key) && $key=="Customer" || $key=="Name" || $key=="Status (Active/Deactive)" || $key=="E Mail ID"){

            $fieldKey = ($key == "Status (Active/Deactive)") ? 'status' : $key;

            $consistentRecord[$fieldKey] = ($key == "Start Date" || $key == "Registration Date") && !empty($stockData[$key]) ? Carbon::createFromFormat('d/m/Y', $stockData[$key])->format('Y-m-d') : (empty($stockData[$key]) ? null : $stockData[$key]);

            }
                    
            }
            $consistentRecord['dealer_slug'] =  $this->dealerService->dealer_slug();
            $dealerData[] = $consistentRecord;

           
            if (count($dealerData) >= $batchSize) {
       
                $dealerData = $this->filter_dealer_code($dealerData);

                Dealer::insert($dealerData);
               
                $dealerData= []; // Reset the batch array
            }
        
        }
           // Insert any remaining data
        if (!empty($dealerData)) {
            $dealerData = $this->filter_dealer_code($dealerData);
            Dealer::insert($dealerData);
        }

      return redirect('admin/dealers');

    }

    }


    public function filter_dealer_code($data){

        $dealerExists = Dealer::distinct()->pluck('Customer')->toArray();

        $filteredData = array_reduce($data, function($carry, $item) {  
            // If the customer value is not already in the carry array, add the item
            if (!isset($carry['seen'][$item['Customer']])) {
                $carry['seen'][$item['Customer']] = true;
                $carry['data'][] = $item;
            }
            return $carry;
        }, ['seen' => [], 'data' => []]);
        
        
        $filteredData = $filteredData['data'];

        $filteredArray = array_filter($filteredData, function($value) use ($dealerExists) {

            return !in_array($value["Customer"], $dealerExists);
        });

        return $filteredArray;
    }





}
