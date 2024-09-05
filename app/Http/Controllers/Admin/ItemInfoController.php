<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\ItemPrice;
use Illuminate\Support\Facades\Log;

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

    public function uploadDailyItem() {

   if (request()->has('mycsv')) {
    $data = array_map('str_getcsv', file(request()->mycsv));
    
    $header = array_map('trim', array_shift($data));
    
    ItemPrice::truncate(); // Clear the table before inserting new data
    set_time_limit(0);
    $batchSize = 5000;
    $allStockData = [];

    foreach ($data as $index => $row) {
       
        $stockData = array_combine($header, $row);

       
        // Ensure numeric values are properly converted, and empty fields are treated as NULL
        foreach ($stockData as $key => $value) {

            if(!empty($key)){
                        $consistentRecord[$key] = $key=="MRP" ||$key=="LP" || $key=="DLP" || $key=="BEST" ? intval(str_replace(',', '', $stockData[$key])) : $stockData[$key] ;
                         
                        }
        }

       
        $allStockData[] = $consistentRecord;

       

        if (count($allStockData) >= $batchSize) {
            ItemPrice::insert($allStockData);
            $allStockData = []; // Reset the batch array
        }
    }

    // Insert any remaining data
    if (!empty($allStockData)) {
        ItemPrice::insert($allStockData);
    }
    return redirect('admin/items');
   }}
    
}
