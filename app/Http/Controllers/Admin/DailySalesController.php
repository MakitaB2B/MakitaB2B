<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\DailySales;
use Illuminate\Support\Facades\DB;

class DailySalesController extends Controller
{
    public function index(){
        $result=DailySales::paginate(20,['date','fy','year','customer_name','wh_branch','region','state','sales_qty','unit_cost','sales_value','invoice_no','category_type','customer_order_number']);
        return view('Admin.daily_sales',compact('result'));
    }

    public function searchDailySales(Request $request) {
        $searchValue=strtoupper($request->searchtxt);
        dd($searchValue);
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

    public function uploadDailySalesReport() {
        if(request()->has('dailysalesreport')){
            $data=array_map('str_getcsv', file(request()->dailysalesreport));
        
            $header=$data[0];
            $header = array_map('strtolower', $header);
           
            $header = array_map(function($value) {
                $value = preg_replace('/^\x{FEFF}/u', '', $value);
                $value = preg_replace('/[^\w\s]/u', '', $value);  //preg_replace('/[^\w\s.-]/u', '', $value);
                $value =preg_replace('/\s+/', ' ', $value);
                $value = trim($value);
                $value =str_replace(' ', '_', $value);
                return $value;//str_replace(' ', '_', $value);
            }, $header);

            $headerValues=$header;
            
            $indexToRemove = array_search('sl_no', $header); // Find the index of 'sl_no'
            unset($header[$indexToRemove]); 
            $header = array_values($header);
     
            $databaseName = env('DB_DATABASE');
            $tableName = "{$databaseName}.daily_sales";

            $columns = DB::select("SHOW COLUMNS FROM $tableName");

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
            foreach ($data as $value) {
                set_time_limit(0);
                $stockData=array_combine($headerValues,$value);
                unset($stockData["sl_no"]);
                DailySales::create($stockData);

            }
            return redirect('admin/daily-sales');
        }else{
            return 'No File not there';
        }
    }
}
