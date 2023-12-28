<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Models\Admin\ProductModelVariant;
use App\Models\Admin\FscBranchStock;
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

        $result=ProductModelVariant::paginate(20,['item','description','total_stock','pmv_slug']);
        return view('Admin.branch_stock',compact('result'));
    }
    public function getBranchStockDetails($pmvSlug){
        $decodedPmvSlug=Crypt::decrypt($pmvSlug);
        $result['mvDetails']=DB::table('product_model_variant')->where('pmv_slug',$decodedPmvSlug)->get(['id','item','total_stock']);
        $modelVariId=$result['mvDetails'][0]->id;
        $result['stockDetails']=DB::table('fsc_branch_stock')->where('model_variant_id',$modelVariId)
        ->leftJoin('fsc_branch', 'fsc_branch_stock.fsc_branch_id', '=', 'fsc_branch.id')
        ->select('fsc_branch_stock.id','fsc_branch_stock.fscbs_slug','fsc_branch_stock.main','fsc_branch_stock.demo_in','fsc_branch_stock.demo_out','fsc_branch_stock.service_room','fsc_branch_stock.show_room','fsc_branch.place_short_code')
        ->get();
        return view('Admin.manage_stock_records',$result);
    }
    public function searchStock(Request $request){
        $searchValue=$request->searchtxt;
        $searchResult=DB::table('product_model_variant')->where('item','LIKE','%'.$searchValue."%")->get();
        if(($searchResult->count())>0 ){
            $output="";
            foreach ($searchResult as $key => $data) {
                $output.='<tr>'.
                '<td>'.($key+1).'</td>'.
                '<td>'.$data->item.'</td>'.
                '<td>'.$data->description.'</td>'.
                '<td>'.$data->total_stock.'</td>'.
                '<td>'.'<a href= "branch-stock-details/'.Crypt::encrypt($data->pmv_slug).'"> <i class="nav-icon fas fa-eye"></i> </a>'.'</td>'.
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
}
