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

        $result=ItemPrice::paginate(20,['Item','Item Description','U/M','DLP','LP','MRP','BEST']);
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

        $searchResult=ItemPrice::where($column,'LIKE',"$searchQuery")->get(['id','Item','Item Description','U/M','DLP','LP','MRP','BEST']);
        if(($searchResult->count())>0 ){
            $output="";
            if($searchFrom=='itempg'){
                $routeTo="items/";
            }

            foreach ($searchResult as $key => $data) {
                $output.='<tr>'.
                '<td>'.$data->Item.'</td>'.
                '<td>'.$data->{'Item Description'}.'</td>'.
                '<td>'.$data->{'U/M'}.'</td>'.
                '<td>'.$data->{'DLP'}.'</td>'.
                '<td title="'.$data->{'LP'}.'">'.$data->descriptionsystem.'</td>'.
                '<td>'.$data->{'MRP'}.'</td>'.
                '<td>'.$data->{'BEST'}.'</td>'.
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
        // if (request()->has('mycsv')) {

        // }
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

        $filteredData = array_map(function ($row) use ( $header,$data, $header_diff) {
            if ($row === $data[0]) {
                return array_map('trim',array_values(array_diff($row, $header_diff)));
            }
            $indexesToRemove = array_keys(array_intersect($data[0], $header_diff));
            foreach ($indexesToRemove as $index) {
                unset($row[$index]);
            }
            dd(count($header),count(array_map('trim',array_values($row))));
            return array_combine($header,array_map('trim',array_values($row)));  
            }, $data);



        dd(      $header_diff ,   $filteredData);

        ItemPrice::truncate(); 
        set_time_limit(0);
        $batchSize = 5000;
        $allStockData = [];

        // if(!empty($header_diff)){
        //     $header_diff_text=implode(', ', $header_diff);
        //     return 'These columns cannont be uploaded  - '.$header_diff_text;
        // }

        dd($header, $header_diff);


    }    



    
}
