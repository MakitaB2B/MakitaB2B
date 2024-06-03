<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\EmployeeService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use App\Traits\HasPermissionsTrait;
use Auth;

class EmployeeController extends Controller
{
    protected $employeeService;
    public function __construct(EmployeeService $employeeService){
        $this->employeeService=$employeeService;
    }
    public function index(){
        $role= Auth::guard('admin')->user()->hasRole('super-admin1944305928');
        if($role==true){
            $employeeList=$this->employeeService->getAllEmployees();
        }else{
            $dataOparateEmpSlug=Auth::guard('admin')->user()->employee_slug;
            $employeeList=$this->employeeService->findEmployeeBySlug($dataOparateEmpSlug);
        }
        return view('Admin.employees',compact('employeeList'));
    }
    public function manageEmployee($employeeslug = '')
    {
        $departmentData=$this->employeeService->getAllDepartments();
        $statesData=$this->employeeService->getAllStates();
        if ($employeeslug > 0) {
            $decripedEmployeeslug = Crypt::decrypt($employeeslug);
            $arr = $this->employeeService->findEmployeeBySlug($decripedEmployeeslug);
            $result['employee_no'] = $arr[0]->employee_no;
            $result['full_name'] = $arr[0]->full_name;
            $result['father_name'] = $arr[0]->father_name;
            $result['mother_name'] = $arr[0]->mother_name;
            $result['dob'] = $arr[0]->dob;
            $result['age'] = $arr[0]->age;
            $result['sex'] = $arr[0]->sex;
            $result['marital_status'] = $arr[0]->marital_status;
            $result['photo'] = $arr[0]->photo;
            $result['phone_number'] = $arr[0]->phone_number;
            $result['alt_phone_number'] = $arr[0]->alt_phone_number;
            $result['personal_email'] = $arr[0]->personal_email;
            $result['official_email'] = $arr[0]->official_email;
            $result['current_address'] = $arr[0]->current_address;
            $result['permanent_address'] = $arr[0]->permanent_address;
            $result['department']=$departmentData;
            $result['department_id'] = $arr[0]->department_id;
            $result['designation_id'] = $arr[0]->designation_id;
            $result['joining_date'] = $arr[0]->joining_date;
            $result['states']=$statesData;
            $result['posting_state'] = $arr[0]->posting_state;
            $result['posting_city'] = $arr[0]->posting_city;
            $result['status'] = $arr[0]->status;
            $result['employee_slug'] = Crypt::encrypt($arr[0]->employee_slug);
            $designation=$this->employeeService->getDesignationsByDepartment($arr[0]->department_id);
            $result['designationbydep']=$designation;
            $cityByState=$this->employeeService->getCitiesByState($arr[0]->posting_state);
            $result['citiesbystate']=$cityByState;
        } else {
            $empCount=$this->employeeService->getEmpCount();
            $result['employee_no']=($empCount+1);
            $result['full_name'] = '';
            $result['father_name'] = '';
            $result['mother_name'] = '';
            $result['dob'] = '';
            $result['age'] = '';
            $result['sex'] = '';
            $result['marital_status'] = '';
            $result['photo'] = '';
            $result['phone_number'] = '';
            $result['alt_phone_number'] = '';
            $result['personal_email'] = '';
            $result['official_email'] = '';
            $result['current_address'] = '';
            $result['permanent_address'] = '';
            $result['department']=$departmentData;
            $result['designationbydep']='';
            $result['department_id'] = '';
            $result['designation_id'] = '';
            $result['joining_date'] = '';
            $result['states']=$statesData;
            $result['posting_state'] = '';
            $result['citiesbystate']='';
            $result['posting_city'] = '';
            $result['status'] = '';
            $result['employee_slug'] = Crypt::encrypt(0);
        }
        return view('Admin.manage_employee', $result);
    }
    public function manageEmployeeProcess(Request $request){
        $decripedSlug = Crypt::decrypt($request->employee_slug);
        if($decripedSlug>0){
            $rowData=$this->employeeService->findEmployeeBySlug($decripedSlug);
            $id=$rowData[0]->id;
            $slug=$rowData[0]->employee_slug;
            if($request->has('photo')){
                $photo=$rowData[0]->photo;
                if(Storage::exists($photo)){
                    Storage::delete($photo);
                    $photo=$request->file('photo')->store('mimes/employee');
                }
            }else{
                $photo=$rowData[0]->photo;
            }
        }else{
            $id=0;
            $slug=Str::slug($request->name.rand());
            if($request->has('photo')){
                $photo=$request->file('photo')->store('mimes/employee');
            }else{
                $photo='';
            }
        }
        $data = $request->validate([
            'full_name' => 'required|min:2|max:250',
            'status' => 'required|numeric',
        ]);
        if($data){
            $createUpdateAction=$this->employeeService->createOrUpdateEmployee($id,$request,$slug,$photo);
            if($createUpdateAction){
                if($decripedSlug>0){
                    $msg='Employee sucessfully updated';
                 }
                 else{
                    $msg='Employee sucessfully inserted';
                 }
                $request->session()->flash('message',$msg);
                return redirect('admin/employee');
            }
         }
    }
}
