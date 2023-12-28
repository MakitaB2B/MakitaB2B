<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\LocationService;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Auth;

class LocationController extends Controller
{
    protected $locationService;
    public function __construct(LocationService $locationService){
        $this->locationService=$locationService;
    }
    public function index(){
        $locationList=$this->locationService->getAllLocationWithStateAndCity();
        return view('Admin.locations',compact('locationList'));
    }
    public function manageLocation($locationSlug = '')
    {
        if ($locationSlug > 0) {
            $decripedLocationSlug = Crypt::decrypt($locationSlug);
            $arr = $this->locationService->findLocationBySlug($decripedLocationSlug);
            $result['state_id'] = $arr[0]->state_id;
            $result['city_id'] = $arr[0]->city_id;
            $result['address'] = $arr[0]->address;
            $result['pin_code'] = $arr[0]->pin_code;
            $result['status'] = $arr[0]->status;
            $result['location_slug'] = Crypt::encrypt($arr[0]->location_slug);
            $cityByState=$this->locationService->getCitiesByState($arr[0]->state_id);
            $result['citiesbystate']=$cityByState;
        } else {
            $result['state_id'] = '';
            $result['city_id'] = '';
            $result['address'] = '';
            $result['pin_code'] = '';
            $result['status'] = '';
            $result['citiesbystate']='';
            $result['location_slug'] = Crypt::encrypt(0);
        }
        $result['allstates']=$this->locationService->findActiveStates();
        return view('Admin.manage_location', $result);
    }
    public function manageLopcationProcess(Request $request){
        $decripedSlug = Crypt::decrypt($request->location_slug);
        if($decripedSlug>0){
            $rowData=$this->locationService->findLocationBySlug($decripedSlug);
            $id=$rowData[0]->id;
            $locationSlug=$rowData[0]->location_slug;
        }else{
            $id=0;
            $locationSlug=Str::slug(rand().rand());
        }
        $data = $request->validate([
            'address' => 'required|min:2|max:250',
            'status' => 'required|numeric',
            'state_id' => 'numeric|required',
        ]);
        if($data){
            $dataOparateEmpSlug=Auth::guard('admin')->user()->employee_slug;
            $createUpdateAction=$this->locationService->createOrUpdateLocation($id,$request,$locationSlug,$dataOparateEmpSlug);
            if($createUpdateAction){
                if($decripedSlug>0){
                    $msg='Location sucessfully updated';
                 }
                 else{
                    $msg='Location sucessfully inserted';
                 }
                $request->session()->flash('message',$msg);
                return redirect('admin/location');
            }
         }
    }
}
