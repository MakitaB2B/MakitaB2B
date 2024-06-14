<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\PendingPo;

class PendingPoController extends Controller
{
    public function index(){
        $result=PendingPo::paginate(20,['vendorpo','vendor','name','po','line','item','itemdescription','cat','ordered','poorderdate','duedate']);
        return view('Admin.pending_po',compact('result'));
    }
    public function uploadPendingPO(Request $request) {
        if(request()->has('ppof')){
            $data=array_map('str_getcsv', file(request()->ppof));
            $header=$data[0];
            unset($data[0]);
            PendingPo::truncate();
            foreach ($data as $value) {
                set_time_limit(0);
                // dd(array_combine($header,$value));
                $pendingPoData=array_combine($header,$value);
                PendingPo::create($pendingPoData);
            }
            $msg='Pending-PO File sucessfully Uploaded';
            $request->session()->flash('message',$msg);
            return redirect('admin/pending-po');
        }else{
            return 'No File not there';
        }
    }
    public function searchPendingPO(Request $request){
        $searchValue=$request->searchtxt;
        $searchFrom=$request->searchFrom;
        $searchType=$request->searchtype;
        $type = match($searchType){
            'item'=>'item',
            'description'=>'itemdescription',
            default => 'item',
        };
        $searchResult=PendingPo::where($type,'LIKE','%'.$searchValue."%")->get(['item','itemdescription','ordered','duedate']);
        if(($searchResult->count())>0 ){
            $output="";
            foreach ($searchResult as $key => $data) {
                $output.='<tr>'.
                '<td>'.$data->item.'</td>'.
                '<td>'.\Carbon\Carbon::parse($data->duedate)->format('d M Y' ).'</td>'.
                '<td>'.$data->itemdescription.'</td>'.
                '<td>'.$data->ordered.'</td>'.
                '</tr>';
                }
        return Response($output);
        }else{
            echo "No Record Found";
        }
    }
}
