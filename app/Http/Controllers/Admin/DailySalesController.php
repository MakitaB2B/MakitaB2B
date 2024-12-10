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
        $searchFrom=$request->searchFrom;
        $searchType=$request->searchtype;

        $type = match($searchType){
            'customername'=>'customername',
            'invoice'=>'invoice',
            'ordernumber'=>'ordernumber',
            default => 'customername',
        };

        if($type=='customername'){
            $searchQuery='%'.$searchValue.'%';
            $column = 'customer_name';
        }
        if($type=='invoice'){
            $searchQuery='%'.$searchValue.'%';
            $column = 'invoice_no';
        }
        if($type=='ordernumber'){
            $searchQuery='%'.$searchValue.'%';
            $column = 'customer_order_number';
        }

        $searchResult=DailySales::where($column,'LIKE',"$searchQuery")
        ->orderby("date", "desc")
        ->get(['id','date','year','state','customer_name','sales_qty','unit_cost','sales_value','invoice_no','category_type','customer_order_number']);
        if(($searchResult->count())>0 ){
            $output="";
            if($searchFrom=='dailysalespg'){
                $routeTo="daily-sales/";
            }

            foreach ($searchResult as $key => $data) {
                $output.='<tr>'.
                '<td>'.$data->date.'</td>'.
                '<td>'.$data->year.'</td>'.
                '<td>'.$data->state.'</td>'.
                '<td>'.$data->customer_name.'</td>'.
                '<td title="'.$data->sales_qty.'">'.$data->sales_qty.'</td>'.
                '<td>'.$data->unit_cost.'</td>'.
                '<td>'.$data->sales_value.'</td>'.
                '<td>'.$data->invoice_no.'</td>'.
                '<td>'.$data->category_type.'</td>'.
                '<td>'.$data->customer_order_number.'</td>'.
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
