<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CityService;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Auth;

class CityController extends Controller
{
    protected $cityService;
    public function __construct(CityService $cityService){
        $this->cityService=$cityService;
    }
    public function prepareCitiesByStates(Request $request){
        $stateID=$request->stateID;
        $stateData=$this->cityService->getCitiesByState($stateID);
        $html='<option value="">Select State</option>';
        foreach($stateData as $list){
            $html.='<option value="'.$list->id.'">'.$list->name.'</option>';
        }
        echo $html;
    }
    public function index(){
        $cityList=$this->cityService->getAllCitiesWithState();
        return view('Admin.cities',compact('cityList'));
    }
    public function manageCity($citySlug = '')
    {
        if ($citySlug > 0) {
            $decripedCitySlug = Crypt::decrypt($citySlug);
            $arr = $this->cityService->findCityBySlug($decripedCitySlug);
            $result['state_id'] = $arr[0]->state_id;
            $result['name'] = $arr[0]->name;
            $result['status'] = $arr[0]->status;
            $result['city_slug'] = Crypt::encrypt($arr[0]->city_slug);
        } else {
            $result['state_id'] = '';
            $result['name'] = '';
            $result['status'] = '';
            $result['city_slug'] = Crypt::encrypt(0);
        }
        $result['allstates']=$this->cityService->findActiveStates();
        return view('Admin.manage_cities', $result);
    }
    public function manageCityProcess(Request $request){
        $decripedSlug = Crypt::decrypt($request->city_slug);
        if($decripedSlug>0){
            $rowData=$this->cityService->findCityBySlug($decripedSlug);
            $id=$rowData[0]->id;
            $citySlug=$rowData[0]->city_slug;
        }else{
            $id=0;
            $citySlug=Str::slug($request->name.rand());
        }
        $data = $request->validate([
            'name' => 'required|min:2|max:250',
            'status' => 'required|numeric',
            'state_id' => 'numeric|required',
        ]);
        if($data){
            $dataOparateEmpSlug=Auth::guard('admin')->user()->employee_slug ;
            $createUpdateAction=$this->cityService->createOrUpdateCity($id,$request,$citySlug,$dataOparateEmpSlug);
            if($createUpdateAction){
                if($decripedSlug>0){
                    $msg='City sucessfully updated';
                 }
                 else{
                    $msg='City sucessfully inserted';
                 }
                $request->session()->flash('message',$msg);
                return redirect('admin/city');
            }
         }
    }
}
