<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\FSCService;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Auth;

class FactoryServiceStationController extends Controller
{

    protected $fscService;
    public function __construct(FSCService $fscService){
        $this->fscService=$fscService;
    }
    public function index(){
        $fscList=$this->fscService->getAllFSCWithStateCity();
        return view('Admin.service_station',compact('fscList'));
    }
    public function manageFSC($fscSlug=''){
        if ($fscSlug > 0) {
            $decripedFscSlug = Crypt::decrypt($fscSlug);
            $arr = $this->fscService->findFSCBySlug($decripedFscSlug);
            $result['state_id'] = $arr[0]->state_id;
            $result['city_id'] = $arr[0]->city_id;
            $result['center_name'] = $arr[0]->center_name;
            $result['phone'] = $arr[0]->phone;
            $result['email'] = $arr[0]->email;
            $result['center_address'] = $arr[0]->center_address;
            $result['status'] = $arr[0]->status;
            $result['fsc_slug'] = Crypt::encrypt($arr[0]->fsc_slug);
            $cityByState=$this->fscService->getCitiesByState($arr[0]->city_id);
            $result['citiesbystate']=$cityByState;
        } else {
            $result['state_id'] = '';
            $result['city_id'] = '';
            $result['center_name'] = '';
            $result['phone'] = '';
            $result['email'] = '';
            $result['center_address'] = '';
            $result['status'] = '';
            $result['fsc_slug'] = Crypt::encrypt(0);
            $result['citiesbystate']='';
        }
        $result['states']=$this->fscService->fetchAllStates();
        return view('Admin.manage_fsc',$result);
     }
     public function manageFSCProcess(Request $request){

        $decripedSlug = Crypt::decrypt($request->fsc_slug);
        if($decripedSlug>0){
            $rowData=$this->fscService->findFSCBySlug($decripedSlug);
            $id=$rowData[0]->id;
            $fscSlug=$rowData[0]->fsc_slug;
        }else{
            $id=0;
            $fscSlug=Str::slug(rand().rand());
        }
        $data = $request->validate([
            'name' => 'required|min:2|max:250|unique:roles,name,'.$id,
        ]);
        if($data){
            $dataOparateEmpSlug=Auth::guard('admin')->user()->employee_slug;
            $createUpdateAction=$this->fscService->createOrUpdateFSC($id,$request,$fscSlug,$dataOparateEmpSlug);
            if($createUpdateAction){
                if($decripedSlug>0){
                    $msg='FSC sucessfully updated';
                 }
                 else{
                    $msg='FSC sucessfully inserted';
                 }
                $request->session()->flash('message',$msg);
                return redirect('admin/factory-service-center');
            }
         }
    }
    public function manageFSCServiceExecutive($fscSlug){
        $decripedFscSlug = Crypt::decrypt($fscSlug);
        $result['allExcByFsc']=$this->fscService->findFSCExcutivesByFscSlug($decripedFscSlug);
        $result['allEmp']=$this->fscService->fetchAllEpmloyees();
        $result['fscExc']=$fscSlug;
        return view('Admin.manage_fsc_executive',$result);
    }
    public function manageFSCServiceExecutiveProcess(Request $request){
        $data = $request->validate([
            'fscexecutive'=>'required|array',
        ]);
        if($data){
            $dataOparateEmpSlug=Auth::guard('admin')->user()->employee_slug ;
            $fscSlug=Crypt::decrypt($request->input('fscSlug'));
            $createUpdateAction=$this->fscService->createOrUpdateFSCExcecutive($request,$dataOparateEmpSlug,$fscSlug);
            if($createUpdateAction){
                $msg='FSC Executive operation sucessfully executed';
                $request->session()->flash('message',$msg);
                return redirect('admin/factory-service-center');
            }
         }
    }
}
