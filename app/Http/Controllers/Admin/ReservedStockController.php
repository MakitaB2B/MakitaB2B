<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\ReservedStocks;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
class ReservedStockController extends Controller
{
    public function index(){
        $result=ReservedStocks::paginate(20,['item','itemdescription','category','reftype','order','customer','customername','reserved','updated_at']);
        return view('Admin.reserved_stock',compact('result'));
    }
    public function uploadReservedStocks() {
        if(request()->has('rscsv')){
            $data=array_map('str_getcsv', file(request()->rscsv));

            $header=$data[0];
            $header = array_map('strtolower', $header);
            $header = array_map(function($value) {
                $value = preg_replace('/^\x{FEFF}/u', '', $value);
                return str_replace(' ', '', $value);
            }, $header);

            $databaseName = env('DB_DATABASE');
            $tableName = "{$databaseName}.reserved_stocks";

            $columns = DB::select("SHOW COLUMNS FROM $tableName");

            $columnNames = array_map(function($column) {
                if(!in_array($column->Field, ['created_at', 'updated_at'])){
                return $column->Field;
            }
            }, $columns);
            $columnNames = array_filter($columnNames);

            $headercheck=$header;
            unset($headercheck[array_search('duedate', $headercheck)]);

            $header_diff = array_diff( $headercheck, $columnNames);

            if(!empty($header_diff)){
                $header_diff_text=implode(', ', $header_diff);
                return 'These columns cannont be uploaded - '.$header_diff_text;
            }
               
            unset($data[0]);
            ReservedStocks::truncate();
            foreach ($data as $value) {
                set_time_limit(0);
                $reservedStockData=array_combine($header,$value);
                unset($reservedStockData["duedate"]);
                ReservedStocks::create($reservedStockData);
            }
            return redirect('admin/reserved-stock');
        }else{
            return 'No File not there';
        }
    }
    public function searchReservedStock(Request $request){
        $searchValue=$request->searchtxt;
        $searchType=$request->searchtype;
        $type = match($searchType){
            'item'=>'item',
            'description'=>'itemdescription',
            'customer'=>'customer',
            'name'=>'customername',
            default => 'item',
        };

        $searchResult=ReservedStocks::where($type,'LIKE','%'.$searchValue."%")
        ->get(['item','itemdescription','category','reftype','order','customer','customername','reserved','updated_at']);
        if(($searchResult->count())>0 ){
            $output="";
            foreach ($searchResult as $key => $data) {
                $output.='<tr>'.
                '<td>'.($key+1).'</td>'.
                '<td>'.$data->item.'</td>'.
                '<td>'.$data->itemdescription.'</td>'.
                '<td>'.$data->category.'</td>'.
                '<td>'.$data->reftype.'</td>'.
                '<td>'.$data->order.'</td>'.
                '<td>'.$data->customer.'</td>'.
                '<td>'.$data->customername.'</td>'.
                '<td>'.$data->reserved.'</td>'.
                '<td>'.\Carbon\Carbon::parse($data->updated_at)->format('d M Y H:i:s' ).'</td>'.
                '</tr>';
                }
        return Response($output);
        }else{
            echo "No Record Found";
        }
    }
    public function reservedStockFilterGuardian(Request $request){
        $sortType=$request->sorttype;
        $type = match($sortType){
            'category'=>'category',
            'refertype'=>'reftype',
            default => 'category',
        };
        $rsfg=ReservedStocks::select($type)->distinct()->get();
        if(($rsfg->count())>0 ){
            $html='<option value="">Please Select</option>';
            foreach ($rsfg as $key => $data) {
                $html.='<option value="'.$data->$type.'">'.$data->$type.'</option>';
            }
            echo $html;
        }else{
                echo "No Record Found";
        }
    }
    public function filterReservedStock(Request $request){
        $sortType=$request->sorttype;
        $sortChild=$request->sortchild;
        $type = match($sortType){
            'category'=>'category',
            'refertype'=>'reftype',
            default => 'category',
        };
        $searchResult=ReservedStocks::where($type, '=', $sortChild)
        ->get(['item','itemdescription','category','reftype','order','customer','customername','reserved','updated_at']);
        if(($searchResult->count())>0 ){
            $output="";
            foreach ($searchResult as $key => $data) {
                $output.='<tr>'.
                '<td>'.($key+1).'</td>'.
                '<td>'.$data->item.'</td>'.
                '<td>'.$data->itemdescription.'</td>'.
                '<td>'.$data->category.'</td>'.
                '<td>'.$data->reftype.'</td>'.
                '<td>'.$data->order.'</td>'.
                '<td>'.$data->customer.'</td>'.
                '<td>'.$data->customername.'</td>'.
                '<td>'.$data->reserved.'</td>'.
                '<td>'.\Carbon\Carbon::parse($data->updated_at)->format('d M Y H:i:s' ).'</td>'.
                '</tr>';
                }
        return Response($output);
        }else{
            echo "No Record Found";
        }
    }
    public function fetchReserveStockByItem($item){
        $decripedItemID = Crypt::decrypt($item);
        $reserveStockDetails=ReservedStocks::where('item', '=', $decripedItemID)
        ->get(['item','itemdescription','category','reftype','order','customer','customername','reserved','updated_at']);
        return view('Admin.reserved_stock_by_item',compact('reserveStockDetails'));

    }
}
