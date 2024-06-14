<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\EmployeeLeaveApplicationService;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Auth;

class EmployeeLeaveApplicationController extends Controller
{
    protected $employeeLeaveApplicationService;
    public function __construct(EmployeeLeaveApplicationService $employeeLeaveApplicationService)
    {
        $this->employeeLeaveApplicationService=$employeeLeaveApplicationService;
    }
    public function index(){
        $result=$this->employeeLeaveApplicationService->getAuthEmployeeLeaveApplicationList();
        return view('Admin.leave_application',compact('result'));
    }
    public function manageLeaveApllication($empLvApSlug=''){
        if($empLvApSlug>0){
            $decripedeEmpLeaveSlug=Crypt::decrypt($empLvApSlug);
            $arr=$this->employeeLeaveApplicationService->findBySlug($decripedeEmpLeaveSlug);
            $result['leave_type']=$arr[0]->leave_type;
            $result['comments']=$arr[0]->comments ;
            $result['from_date']=$arr[0]->from_date;
            $result['to_date']=$arr[0]->to_date;
            $result['employee_slug']=$arr[0]->employee_slug;
            $result['emp_leave_apply_slug']=Crypt::encrypt($arr[0]->emp_leave_apply_slug);
        }else{
            $result['leave_type']='';
            $result['comments']='';
            $result['from_date']='';
            $result['to_date']='';
            $result['emp_leave_apply_slug']=Crypt::encrypt(0);
        }
        $result['leave_type_list']=$this->employeeLeaveApplicationService->getLeaveTypesList();
        return view('Employee.manage_leave_application',$result);
    }
}
