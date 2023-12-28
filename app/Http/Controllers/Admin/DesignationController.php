<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\DesignationService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class DesignationController extends Controller
{
    protected $designationService;
    public function __construct(DesignationService $designationService){
        $this->designationService=$designationService;
    }
    public function index(){
        $designationList=$this->designationService->getAllDesignations();
        return view('Admin.designation',compact('designationList'));
    }
    public function manageDesignation($designationslug = '')
    {
        if ($designationslug > 0) {
            $decripedDesignationSlug = Crypt::decrypt($designationslug);
            $arr = $this->designationService->findDesignationBySlug($decripedDesignationSlug);
            $result['department_id'] = $arr[0]->department_id;
            $result['designation_name'] = $arr[0]->designation_name;
            $result['status'] = $arr[0]->status;
            $result['designation_slug'] = Crypt::encrypt($arr[0]->designation_slug);
        } else {
            $result['department_id'] = '';
            $result['designation_name'] = '';
            $result['status'] = '';
            $result['designation_slug'] = Crypt::encrypt(0);
        }
        $result['alldepartments']=$this->designationService->findActiveDepartments();
        return view('Admin.manage_designations', $result);
    }
    public function manageDesignationProcess(Request $request){
        $decripedSlug = Crypt::decrypt($request->designation_slug);
        if($decripedSlug>0){
            $rowData=$this->designationService->findDesignationBySlug($decripedSlug);
            $id=$rowData[0]->id;
            $slug=$rowData[0]->designation_slug;
        }else{
            $id=0;
            $slug=Str::slug($request->designation_name.rand());
        }
        $data = $request->validate([
            'designation_name' => 'required|min:2|max:250',
            'status' => 'required|numeric',
            'department_id' => 'numeric|required',
        ]);
        if($data){
            $createUpdateAction=$this->designationService->createOrUpdateDesignation($id,$request,$slug);
            if($createUpdateAction){
                if($decripedSlug>0){
                    $msg='Designation sucessfully updated';
                 }
                 else{
                    $msg='Designation sucessfully inserted';
                 }
                $request->session()->flash('message',$msg);
                return redirect('admin/designation');
            }
         }
    }
    public function prepareDesignationsByDepertmant(Request $request){
        $departmentID=$request->depID;
        $designationData=$this->designationService->getDesignationsByDepertmant($departmentID);
        $html='<option value="">Select Designation</option>';
        foreach($designationData as $list){
            $html.='<option value="'.$list->id.'">'.$list->designation_name.'</option>';
        }
        echo $html;
    }
}
