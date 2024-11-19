<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\ReplacedParts;
use Illuminate\Support\Facades\DB;
class ReplacedPartsController extends Controller
{
    public function index(){
        $result=ReplacedParts::paginate(20,['oldno','replace1','replace2','replaced3','descriptionsystem','category','updated_at']);
        return view('Admin.replaced_parts',compact('result'));
    }
    public function uploadReplacedParts() {
        if(request()->has('rpf')){
            $data=array_map('str_getcsv', file(request()->rpf));

            $header=array_map('strtolower', $data[0]);
            $header = array_map(function($value) {
                $value = preg_replace('/^\x{FEFF}/u', '', $value);
                $value = str_replace(' ', '', $value);
                // return str_replace(' ', '', $value);
                // return $value !== "" ? $value : null;
                return $value !== "" ? $value : false;
            }, $header);

            unset($header[0], $header[1], $header[8]);
            // $header = array_filter($header);
            $header = array_values($header);


            // $databaseName = env('DB_DATABASE');
            // $tableName = "{$databaseName}.replaced_parts";

            // $columns = DB::select("SHOW COLUMNS FROM $tableName");

            // $columnNames = array_map(function($column) {
            //     if(!in_array($column->Field, ['created_at', 'updated_at'])){
            //     return $column->Field;
            // }
            // }, $columns);
            // $columnNames = array_filter($columnNames);

            // $header_diff = array_diff($header, $columnNames);
            // if(!empty($header_diff)){
            //     $header_diff_text=implode(', ', $header_diff);
            //     return 'These columns cannont be uploaded'.$header_diff_text;
            // }

            unset($data[0]);

            ReplacedParts::truncate();
            foreach ($data as $value) {
                set_time_limit(0);

                unset($value[0], $value[1], $value[8]);
                $value = array_values($value);

                $reservedStockData = array_combine($header,$value);

                $reservedStockData  = array_filter(  $reservedStockData , function ($value, $key) {
                    return !empty($key); 
                }, ARRAY_FILTER_USE_BOTH);

                ReplacedParts::create($reservedStockData);
            }
            return redirect('admin/replaced-parts');
        }else{
            return 'No File not there';
        }
    }
    public function searchReplacedParts(Request $request){
        $searchValue=$request->searchtxt;
        $searchType=$request->searchtype;
        if($searchType=='item'){
            $searchResult=ReplacedParts::where('oldno', '=', $searchValue)->orWhere('replace1', '=', $searchValue)
            ->orWhere('replace2', '=', $searchValue)->orWhere('replaced3', '=', $searchValue)
            ->get(['oldno','replace1','replace2','replaced3','descriptionsystem','category','updated_at']);
        }elseif($searchType=='description'){
            $searchResult=ReplacedParts::where('descriptionsystem', 'LIKE','%'.$searchValue."%")
            ->get(['oldno','replace1','replace2','replaced3','descriptionsystem','category','updated_at']);
        }
        if(($searchResult->count())>0 ){
            $output="";
            foreach ($searchResult as $key => $data) {
                $output.='<tr>'.
                '<td>'.($key+1).'</td>'.
                '<td>'.$data->oldno.'</td>'.
                '<td>'.$data->replace1.'</td>'.
                '<td>'.$data->replace2.'</td>'.
                '<td>'.$data->replaced3.'</td>'.
                '<td title="'.$data->descriptionsystem.'">'.$data->descriptionsystem.'</td>'.
                '<td>'.$data->category.'</td>'.
                '<td>'.\Carbon\Carbon::parse($data->updated_at)->format('d M Y H:i:s' ).'</td>'.
                '</tr>';
                }
        return Response($output);
        }else{
            echo "No Record Found";
        }
    }
    public function replacedPartsFilterGuardian(Request $request){
        $sortType=$request->sorttype;
        $type = match($sortType){
            'category'=>'category',
            default => 'category',
        };
        $rsfg=ReplacedParts::select($type)->distinct()->get();
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
    public function filterReplacedParts(Request $request){
        $sortType=$request->sorttype;
        $sortChild=$request->sortchild;
        $type = match($sortType){
            'category'=>'category',
            'refertype'=>'reftype',
            default => 'category',
        };
        $searchResult=ReplacedParts::where($type, '=', $sortChild)
        ->get(['oldno','replace1','replace2','replaced3','descriptionsystem','category','updated_at']);
        if(($searchResult->count())>0 ){
            $output="";
            foreach ($searchResult as $key => $data) {
                $output.='<tr>'.
                '<td>'.($key+1).'</td>'.
                '<td>'.$data->oldno.'</td>'.
                '<td>'.$data->replace1.'</td>'.
                '<td>'.$data->replace2.'</td>'.
                '<td>'.$data->replaced3.'</td>'.
                '<td>'.$data->descriptionsystem.'</td>'.
                '<td>'.$data->category.'</td>'.
                '<td>'.\Carbon\Carbon::parse($data->updated_at)->format('d M Y H:i:s' ).'</td>'.
                '</tr>';
                }
        return Response($output);
        }else{
            echo "No Record Found";
        }
    }
}
