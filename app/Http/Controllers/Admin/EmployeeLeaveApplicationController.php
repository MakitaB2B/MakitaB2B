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
        $role= Auth::guard('admin')->user()->hasRole('super-admin1944305928');
        if($role==true){
        $result['leaveApplications']=$this->employeeLeaveApplicationService->getAuthEmployeeLeaveApplicationList();
        $result['canChangeStatus']=1;
        }else{
            $empSlug= Auth::guard('admin')->user()->employee_slug;
            $checkIfTeamOwner=$this->employeeLeaveApplicationService->checkIfTeamOwner($empSlug);
            if($checkIfTeamOwner==1){
                $result['leaveApplications']=$this->employeeLeaveApplicationService->getLeaveApplicationByTeamOwner($empSlug);
                $result['canChangeStatus']=1;
            }
            if($checkIfTeamOwner==''){
                $result['leaveApplications']=$this->employeeLeaveApplicationService->getLeaveApplicationListByEmployee($empSlug);
                $result['canChangeStatus']=0;
            }
        }
        return view('Admin.leave_application',$result);
    }
    public function manageLeaveApllication($empLvApSlug=''){
        if($empLvApSlug>0){
            $decripedeEmpLeaveSlug=Crypt::decrypt($empLvApSlug);
            $arr=$this->employeeLeaveApplicationService->findBySlug($decripedeEmpLeaveSlug);
            $result['leave_type']=$arr[0]->leave_type;
            $result['leave_reason']=$arr[0]->leave_reason ;
            $result['from_date']=$arr[0]->from_date;
            $result['to_date']=$arr[0]->to_date;
            $result['employee_slug']=$arr[0]->employee_slug;
            $result['emp_leave_apply_slug']=Crypt::encrypt($arr[0]->emp_leave_apply_slug);
        }else{
            $result['leave_type']='';
            $result['leave_reason']='';
            $result['from_date']='';
            $result['to_date']='';
            $result['emp_leave_apply_slug']=Crypt::encrypt(0);
        }
        $result['leave_types']=$this->employeeLeaveApplicationService->getAllLeaveTypes();
        return view('Admin.apply_leave_application',$result);
    }
    public function createOrUpdateLeaveApllication(Request $request){
        $decripedSlug= Crypt::decrypt($request->slug);
        if($decripedSlug>0){
            $rowData=$this->employeeLeaveApplicationService->findBySlug($decripedSlug);
            $id=$rowData[0]->id;
            $slug=$rowData[0]->slug;
        }else{
            $id=0;
            $slug=Str::slug($request->name.rand());
        }
        $data= $request->validate([
             'leave_type'=>'required|integer',
             'leave_reason'=>'required|min:2',
             'from_date'=>'required',
             'to_date'=>'required',
         ]);

         if($data){
            $empSlug=Auth::guard('admin')->user()->employee_slug;
            $createUpdateAction=$this->employeeLeaveApplicationService->createOrUpdateLeaveApllicationService($id,$request,$slug,$empSlug);
            if($createUpdateAction){
                if($decripedSlug>0){
                    $msg='Leave Application sucessfully updated';
                 }
                 else{
                    $msg='Leave Application sucessfully inserted';
                 }
                $request->session()->flash('message',$msg);
                return redirect('admin/employee/leave-application');
            }
         }
     }
     public function changeLeaveApplicationStatus(Request $request){
        $status=$request->status;
        $slug=$request->slug;
        $updatedByEmpSlug=Auth::guard('admin')->user()->employee_slug;
        $responseDatetime=date('Y-m-d H:i:s');
        $updateStatus=$this->employeeLeaveApplicationService->changeLeaveApplicationStatusService($status,$slug,$updatedByEmpSlug,$responseDatetime);
        if($updateStatus){
            echo "sucess";
        }
    }
}
