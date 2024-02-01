<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Models\Admin\ProductModelVariant;
use App\Models\Admin\FscBranchStock;
use App\Models\Admin\BranchStocks;
use Illuminate\Pagination\Paginator;
use App\Models\Admin\ReplacedParts;


class BranchStockController extends Controller
{
    public function index(){
        $result=BranchStocks::with('reservedStock:id,item,reserved')->paginate(20,['item','description','grandtotal','id','updated_at']);
        return view('Admin.branch_stock',compact('result'));
    }
    public function getBranchStockDetails($pmvSlug){
        $decodedID=Crypt::decrypt($pmvSlug);
        $result['stockDetails']=BranchStocks::where('id','=',$decodedID)->get();

        $item=$result['stockDetails'][0]->item;
        $result['replacedParts']=ReplacedParts::where('oldno', '=', $item)->orWhere('replace1', '=', $item)
        ->orWhere('replace2', '=', $item)->orWhere('replaced3', '=', $item)
        ->get(['oldno','replace1','replace2','replaced3']);

        return view('Admin.manage_stock_records',$result);
    }
    public function searchStock(Request $request){
        $searchValue=$request->searchtxt;
        $searchFrom=$request->searchFrom;
        $searchResult=BranchStocks::where('item','LIKE','%'.$searchValue."%")->with('reservedStock:id,item,reserved')->get(['id','item','description','grandtotal','updated_at']);
        if(($searchResult->count())>0 ){
            $output="";
            if($searchFrom=='stockpg'){
                $routeTo="branch-stock-details/";
            }elseif($searchFrom=='mngStockRecord'){
                $routeTo="";
            }
            foreach ($searchResult as $key => $data) {
                $totalReservedQty = 0;
                $reserveQtyStr = $data->reservedStock->pluck('reserved')->implode('+');
                $explodeRQ = explode('+', $reserveQtyStr);
                foreach ($explodeRQ as $rq) {
                    $totalReservedQty += (int) $rq;
                }
                $output.='<tr>'.
                '<td>'.($key+1).'</td>'.
                '<td>'.$data->item.'</td>'.
                '<td>'.$data->description.'</td>'.
                '<td>'.$data->grandtotal.'</td>'.
                '<td>'.'<a href= "'.'reserve-stock-fetchby-item/'.Crypt::encrypt($data->item).'" target="_blank">'.$totalReservedQty.'</a>'.'</td>'.
                '<td>'.'<a href= "'.$routeTo.Crypt::encrypt($data->id).'"> <i class="nav-icon fas fa-eye"></i> </a>'.'</td>'.
                '<td>'.\Carbon\Carbon::parse($data->updated_at)->format('d M Y H:i:s' ).'</td>'.
                '</tr>';
                }
        return Response($output);
        }else{
            echo "No Record Found";
        }
    }
    public function updateBranchStock(Request $request){
        $fbsSlug=trim($request->fbsSlug);
        $stockRawData=trim($request->stockValue);
        $split_data = explode('-', $stockRawData);
        $fieldName = trim($split_data[0]);
        $splitAgain = explode(':', $split_data[1]);
        $stockValue=trim($splitAgain[1]);
        $updateStock= FscBranchStock::where('fscbs_slug', '=', $fbsSlug)->
                update([$fieldName=>$stockValue]);
        if($updateStock){
            echo "Done";
        }else{
            echo "No";
        }
    }
    public function uploadDailyStocks() {
        if(request()->has('mycsv')){
            $data=array_map('str_getcsv', file(request()->mycsv));
            $count=count($data);
            $lastRow=$count-1;
            $header=$data[0];
            unset($data[0],$data[$lastRow]);
            BranchStocks::truncate();
            foreach ($data as $value) {
                set_time_limit(0);
                // dd(array_combine($header,$value));
                $stockData=array_combine($header,$value);
                BranchStocks::create($stockData);
            }
            return redirect('admin/branch-stock');
        }else{
            return 'No File not there';
        }
    }
}
