<?php
namespace App\Services;
use App\Models\Admin\EmployeeLeaveApplication;
use Illuminate\Support\Facades\DB;

class EmployeeLeaveApplicationService{
    public function getAuthEmployeeLeaveApplicationList(){
        $dbQuery=EmployeeLeaveApplication::get();
        if($dbQuery){
            return $dbQuery;
        }
    }
    public function findBySlug($slug){
        return EmployeeLeaveApplication::where(['emp_leave_apply_slug'=>$slug])->get();
    }
    public function getLeaveTypesList(){
        return DB::table('leave_types')->where('status','Active')->get();
    }
    public function createOrUpdateLeaveApplication($id,$request,$employeeSlug,$employeeLeaveSlug){
        $operate=EmployeeLeaveApplication::updateOrCreate(
            ['id' =>$id],
            ['employee_slug'=> $employeeSlug,'leave_type'=>$request->leave_type,
            'comments'=>$request->comments, 'from_date'=>$request->from_date,
            'to_date'=>$request->to_date,'emp_leave_apply_slug'=>$employeeLeaveSlug]
         );
         if($operate){
            return true;
         }
    }
    public function getAllEmpLeaveApplicationService(){
        return EmployeeLeaveApplication::with(['leaveType:id,name','employee:slug,name,employee_id'])->
        select('comments','from_date','to_date','approval_status','emp_leave_apply_slug','employee_slug','leave_type')->get();
    }
    public function updateLeaveApplicationStatus($status,$slug){
       $updateStatus= EmployeeLeaveApplication::where('emp_leave_apply_slug', $slug)->update(['approval_status' => $status]);
       if($updateStatus){
        return 1;
       }

    }

}
?>
