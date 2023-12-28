<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\StateService;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Auth;

class StateController extends Controller
{
    protected $stateService;
    public function __construct(StateService $stateService){
        $this->stateService=$stateService;
    }
    public function index(){
        $stateRecords=$this->stateService->getAllStates();
        return view('Admin.states',compact('stateRecords'));
    }
    public function manageState($stateSlug = '')
    {
        if ($stateSlug > 0) {
            $decripedStateSlug = Crypt::decrypt($stateSlug);
            $arr = $this->stateService->findStateBySlug($decripedStateSlug);
            $result['name'] = $arr[0]->name;
            $result['status'] = $arr[0]->status;
            $result['state_slug'] = Crypt::encrypt($arr[0]->state_slug);
        } else {
            $result['name'] = '';
            $result['status'] = '';
            $result['state_slug'] = Crypt::encrypt(0);
        }
        return view('Admin.manage_states', $result);
    }
    public function manageStateProcess(Request $request){
        $decripedSlug = Crypt::decrypt($request->state_slug);
        $dataOparateEmpSlug=Auth::guard('admin')->user()->employee_slug ;
        if($decripedSlug>0){
            $rowData=$this->stateService->findStateBySlug($decripedSlug);
            $id=$rowData[0]->id;
            $stateSlug=$rowData[0]->state_slug;
        }else{
            $id=0;
            $stateSlug=Str::slug($request->name.rand());
        }
        $data = $request->validate([
            'name' => 'required|min:2|max:250',
            'status' => 'required|numeric',
        ]);
        if($data){
            $createUpdateAction=$this->stateService->createOrUpdateState($id,$request,$stateSlug,$dataOparateEmpSlug);
            if($createUpdateAction){
                if($decripedSlug>0){
                    $msg='State sucessfully updated';
                 }
                 else{
                    $msg='State sucessfully inserted';
                 }
                $request->session()->flash('message',$msg);
                return redirect('admin/state');
            }
         }
    }
}
