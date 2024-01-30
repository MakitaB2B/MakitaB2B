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


class BranchStockController extends Controller
{
    public function index(){
        // $result =  DB::table('fsc_branch_stock')
        //         ->leftJoin('product_model_variant', 'fsc_branch_stock.model_variant_id', '=', 'product_model_variant.id')
        //         ->leftJoin('fsc_branch', 'fsc_branch_stock.fsc_branch_id', '=', 'fsc_branch.id')
        //         ->get()
        //         ->groupBy('model_variant_id')
        //         ->sortByDesc(function ($scores, $key) {
        //             return $scores->count();
        //         });
        // $result=DB::table('product_model_variant')->offset(0)->limit(10)->get(['item','description','total_stock','pmv_slug']);

        // $result=ProductModelVariant::paginate(20,['item','description','total_stock','pmv_slug']);
        $result=BranchStocks::paginate(20,['item','description','grandtotal','id','updated_at']);
        return view('Admin.branch_stock',compact('result'));
    }
    public function getBranchStockDetails($pmvSlug){
        // $decodedPmvSlug=Crypt::decrypt($pmvSlug);
        // $result['mvDetails']=DB::table('product_model_variant')->where('pmv_slug',$decodedPmvSlug)->get(['id','item','total_stock']);
        // $modelVariId=$result['mvDetails'][0]->id;
        // $result['stockDetails']=DB::table('fsc_branch_stock')->where('model_variant_id',$modelVariId)
        // ->leftJoin('fsc_branch', 'fsc_branch_stock.fsc_branch_id', '=', 'fsc_branch.id')
        // ->select('fsc_branch_stock.id','fsc_branch_stock.fscbs_slug','fsc_branch_stock.main','fsc_branch_stock.demo_in','fsc_branch_stock.demo_out','fsc_branch_stock.service_room','fsc_branch_stock.show_room','fsc_branch.place_short_code')
        // ->get();
        $decodedID=Crypt::decrypt($pmvSlug);
        $result['stockDetails']=BranchStocks::where('id','=',$decodedID)->get();
        return view('Admin.manage_stock_records',$result);
    }
    public function searchStock(Request $request){
        $searchValue=$request->searchtxt;
        $searchFrom=$request->searchFrom;
        $searchResult=BranchStocks::where('item','LIKE','%'.$searchValue."%")
        ->orWhere('description', 'like', "%{$searchValue}%")->get(['id','item','description','grandtotal','updated_at']);
        if(($searchResult->count())>0 ){
            $output="";
            if($searchFrom=='stockpg'){
                $routeTo="branch-stock-details/";
            }elseif($searchFrom=='mngStockRecord'){
                $routeTo="";
            }
            foreach ($searchResult as $key => $data) {
                $output.='<tr>'.
                '<td>'.($key+1).'</td>'.
                '<td>'.$data->item.'</td>'.
                '<td>'.$data->description.'</td>'.
                '<td>'.$data->grandtotal.'</td>'.
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
            // unset($data[0],$data[1],$data[2],$data[$lastRow]);
            unset($data[0],$data[$lastRow]);

            BranchStocks::truncate();

            foreach ($data as $value) {
                set_time_limit(0);
                // dd(array_combine($header,$value));
                $stockData=array_combine($header,$value);
                BranchStocks::create($stockData);
            }
            // return redirect('admin/branch-stock');
            // return 'Done';

            // $msg='Stock Sucessfully updated';
            // $request->session()->flash('message',$msg);


        }else{
            return 'No File not there';
        }

    }
}
