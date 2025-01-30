<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\ItemPrice;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ItemInfoController extends Controller
{

    public function index(Request $request){

        $result=ItemPrice::paginate(20,['Item','Item Description','Effective Date','U/M','DLP','LP','MRP','BEST','created_at']);
        return view('Admin.item_price',compact('result')); 
    }

    public function itemSearch(Request $request){
        $searchValue=strtoupper($request->searchtxt);
        $searchFrom=$request->searchFrom;
        $searchType=$request->searchtype;
        $type = match($searchType){
            'item'=>'item',
            'description'=>'description',
            default => 'item',
        };
        if($type=='item'){
            $searchQuery=$searchValue.'%';
            $column = 'Item';
        }
        if($type=='description'){
            $searchQuery='%'.$searchValue.'%';
            $column = 'Item Description';
        }

        $searchResult=ItemPrice::where($column,'LIKE',"$searchQuery")->get(['id','Item','Item Description','Effective Date','U/M','DLP','LP','MRP','BEST','created_at']);
        if(($searchResult->count())>0 ){
            $output="";
            if($searchFrom=='itempg'){
                $routeTo="items/";
            }

            foreach ($searchResult as $key => $data) {
                $output.='<tr>'.
                '<td>'.$data->Item.'</td>'.
                '<td>'.$data->{'Item Description'}.'</td>'.
                '<td>'.$data->{'Effective Date'}.'</td>'.
                '<td>'.$data->{'U/M'}.'</td>'.
                '<td>'.$data->{'DLP'}.'</td>'.
                '<td>'.$data->{'LP'}.'</td>'.
                '<td>'.$data->{'MRP'}.'</td>'.
                '<td>'.$data->{'BEST'}.'</td>'.
                '<td>'.$data->created_at.'</td>'.
                '</tr>';
                }
        return Response($output);
        }else{
            echo "No Record Found";
        }
    }

//     public function uploadDailyItem() {

//    if (request()->has('mycsv')) {
//     $data = array_map('str_getcsv', file(request()->mycsv));
    
//     $header = array_map('trim', array_shift($data));
    
//     ItemPrice::truncate(); 
//     set_time_limit(0);
//     $batchSize = 5000;
//     $allStockData = [];

//     foreach ($data as $index => $row) {
       
//         $stockData = array_combine($header, $row);

//         foreach ($stockData as $key => $value) {

//             if(!empty($key)){
//                         $consistentRecord[$key] = $key=="MRP" ||$key=="LP" || $key=="DLP" || $key=="BEST" ? intval(str_replace(',', '', $stockData[$key])) : $stockData[$key] ;
                         
//                         }
//         }

       
//         $allStockData[] = $consistentRecord;

       

//         if (count($allStockData) >= $batchSize) {
//             ItemPrice::insert($allStockData);
//             $allStockData = []; 
//         }
//     }

//     if (!empty($allStockData)) {
//         ItemPrice::insert($allStockData);
//     }
//     return redirect('admin/items');
//    }}



    public function uploadDailyItem(Request $request) {

        $validator = Validator::make($request->all(), [
            'mycsv' => 'required|file|mimes:csv,txt', // Ensure it's a CSV file
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if (request()->has('mycsv')) {

        $data = array_map('str_getcsv', file(request()->mycsv));
        $header=$data[0];
      
        $header = array_map(function($value) {
            $value = preg_replace('/^\x{FEFF}/u', '', $value);
            return trim($value); 
        }, $header);

        $databaseName = env('DB_DATABASE');
        $tableName = "{$databaseName}.item_prices";

        $columns = \DB::select("SHOW COLUMNS FROM $tableName");

        $columnNames = array_map(function($column) {
            if(!in_array($column->Field, ['created_at', 'updated_at'])){
            return $column->Field;
        }
        }, $columns);
        $columnNames = array_filter($columnNames);

        $header_diff = array_diff($header, $columnNames);
    
        if(!empty($header_diff)){
            $header_diff_text=implode(', ', $header_diff);
            return 'These columns cannont be uploaded  - '.$header_diff_text;
        }
           unset($data[0]);
        ItemPrice::truncate(); 
        set_time_limit(0);
        $batchSize = 5000;
        $allStockData = [];

        foreach ($data as $index => $row) {
       
        $stockData = array_combine($header, $row);

        foreach ($stockData as $key => $value) {
            if(!empty($key) && $key != "Effective Date"){

            $consistentRecord[$key] =  $key=="MRP" ||$key=="LP" || $key=="DLP" || $key=="BEST" ? intval(str_replace(',', '', $stockData[$key])) : $stockData[$key] ;  //$stockData[$key] ;
                         
            } 
            elseif ($key = "Effective Date") {
            $consistentRecord[$key] = \Carbon\Carbon::parse($value)->format('Y-m-d');
                // $date = \DateTime::createFromFormat('m/d/Y', $value);
                // $consistentRecord[$key] = $date ? $date->format('Y-m-d') : null;
            } 
            else {
               $consistentRecord[$key] = $value;
            }
            $consistentRecord["created_at"] = date('Y-m-d H:i:s');
            $consistentRecord["updated_at"] =  date('Y-m-d H:i:s');
        }
            $allStockData[] = $consistentRecord;

        if (count($allStockData) >= $batchSize) {
            ItemPrice::insert($allStockData);
            $allStockData = []; 
        }
    }

    if (!empty($allStockData)) {
        ItemPrice::insert($allStockData);
    }
        return redirect('admin/items');
    }

    }

 }    

