<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\ItemPrice;
use App\Models\Admin\ItemMasterIgst;
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
        }
    }

    public function indexItemMasterWithIGST(Request $request){
        $result=ItemMasterIgst::paginate(20,['item','description','alternate_item','item_code','hsn_india','bcd','igst','factory','coo']);
        return view('Admin.item_master_igst',compact('result'));
    }

    public function uploadItemMasterWithIGST(Request $request) {


        if(request()->has('imwigst')){
            $data=array_map('str_getcsv', file(request()->imwigst));
            $header=$data[0];
            unset($data[0]);
            ItemMasterIgst::truncate();
            foreach ($data as $value) {
                set_time_limit(0);
                // dd(array_combine($header,$value));
                $stockData=array_combine($header,$value);
                ItemMasterIgst::create($stockData);
            }
            $msg='Item Master With IGST sucessfully updated';
            $request->session()->flash('message',$msg);
            return redirect('admin/item/item-master-hsn');
        }else{
            return 'No File not there';
        }

        // if (request()->has('imwigst')) {
        //     $data = array_map('str_getcsv', file(request()->imwigst));

        //     $header = array_map('trim', array_shift($data));

        //     ItemMasterIgst::truncate(); // Clear the table before inserting new data
        //     set_time_limit(0);
        //     $batchSize = 5000;
        //     $allItemMasterIGSTData = [];

        //     foreach ($data as $index => $row) {

        //         $itemMastrIGSTData = array_combine($header, $row);


        //         // Ensure numeric values are properly converted, and empty fields are treated as NULL
        //         foreach ($itemMastrIGSTData as $key => $value) {

        //             if(!empty($key)){
        //                         $consistentRecord[$key] = $key=="item" ||$key=="description" || $key=="alternate_item" || $key=="item_code" || $key=="hsn_india" || $key=="bcd" || $key=="igst" || $key=="factory" || $key=="coo"  ? intval(str_replace(',', '', $itemMastrIGSTData[$key])) : $itemMastrIGSTData[$key] ;

        //             }
        //         }


        //         $allItemMasterIGSTData[] = $consistentRecord;



        //         if (count($allItemMasterIGSTData) >= $batchSize) {
        //             ItemMasterIgst::create($allItemMasterIGSTData);
        //             $allItemMasterIGSTData = []; // Reset the batch array
        //         }
        //     }

        //     // Insert any remaining data
        //     if (!empty($allItemMasterIGSTData)) {
        //         ItemMasterIgst::create($allItemMasterIGSTData);
        //     }

        //     $msg='Item Master With IGST sucessfully updated';
        //     $request->session()->flash('message',$msg);
        //     return redirect('admin/item/item-master-hsn');
        // }
    }
    public function searchItemMasterIGST(Request $request){
        $searchValue=$request->searchtxt;
        $searchFrom=$request->searchFrom;
        $searchType=$request->searchtype;
        $type = match($searchType){
            'item'=>'item',
            'description'=>'description',
            'hsnindia'=>'hsn_india',
            default => 'item',
        };
        $searchResult=ItemMasterIgst::where($type,'LIKE','%'.$searchValue."%")->get(['item','description','alternate_item','item_code','hsn_india','bcd','igst','factory','coo']);
        if(($searchResult->count())>0 ){
            $output="";
            foreach ($searchResult as $key => $data) {
                $output.='<tr>'.
                '<td>'.$data->item.'</td>'.
                '<td>'.$data->description.'</td>'.
                '<td>'.$data->item_code.'</td>'.
                '<td>'.$data->hsn_india.'</td>'.
                '<td>'.$data->bcd.'</td>'.
                '<td>'.$data->igst.'</td>'.
                '<td>'.$data->factory.'</td>'.
                '<td>'.$data->coo.'</td>'.
                '<td>'.$data->alternate_item.'</td>'.
                '</tr>';
                }
        return Response($output);
        }else{
            echo "No Record Found";
        }
    }


}
