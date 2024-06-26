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
        $result['stockDetails']=BranchStocks::where('item','=',$decodedID)->get();
        if(count($result['stockDetails'])>0){
            $result['stockDetailsCount']=1;
            $item=$result['stockDetails'][0]->item;
            $result['replacedParts']=ReplacedParts::where('oldno', '=', $item)->orWhere('replace1', '=', $item)
            ->orWhere('replace2', '=', $item)->orWhere('replaced3', '=', $item)
            ->get(['oldno','replace1','replace2','replaced3']);
        }else{
            $result['errorMsg']=$decodedID." This item does not have nay record in Stock";
            $result['stockDetailsCount']=0;
        }
        return view('Admin.manage_stock_records',$result);
    }
    public function searchStock(Request $request){
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
        }
        if($type=='description'){
            $searchQuery='%'.$searchValue.'%';
        }
        $searchResult=BranchStocks::where($type,'LIKE',"$searchQuery")->with('reservedStock:id,item,reserved')->get(['id','item','description','grandtotal','updated_at']);
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
                if ($totalReservedQty>0){
                    $totalReserveData='<a href= "'.url('admin/reserve-stock-fetchby-item/').'/'.Crypt::encrypt($data->item).'" target="_blank" style="color:#00909E">'.$totalReservedQty.'</a>';
                }else{
                    $totalReserveData='<i style="color:#dc129c">'.$totalReservedQty.'</i>';
                }
                $output.='<tr>'.
                '<td>'.'<a href= "'.$routeTo.Crypt::encrypt($data->item).'" style="color:#00909E">'.$data->item.'</a>'.'</td>'.
                '<td>'.$data->description.'</td>'.
                '<td>'.number_format($data->grandtotal).'</td>'.
                '<td>'.$totalReserveData.'</td>'.
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
