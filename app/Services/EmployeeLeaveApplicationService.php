<?php
namespace App\Services;
use App\Models\Admin\EmployeeLeaveApplication;
use App\Models\Admin\LeaveType;
use App\Models\Admin\Team;
use Illuminate\Support\Facades\DB;

class EmployeeLeaveApplicationService{
    public function getAuthEmployeeLeaveApplicationList(){
        $dbQuery=DB::table('employee_leave_applications')->join('employees as e1', 'employee_leave_applications.employee_slug', '=', 'e1.employee_slug')
        ->join('leave_types', 'employee_leave_applications.leave_type', '=', 'leave_types.id')
        ->leftJoin('employees as e2', 'employee_leave_applications.responsedby_empslug', '=', 'e2.employee_slug')
        ->select('e1.full_name as employee_name','leave_types.name as leave_type_name','employee_leave_applications.from_date','employee_leave_applications.to_date',
        'employee_leave_applications.approval_status','employee_leave_applications.emp_leave_apply_slug','employee_leave_applications.response_datetime','employee_leave_applications.leave_reason','e2.full_name as responded_by_name') // Select all columns from leave_application or specify required columns
        ->orderBy('employee_leave_applications.created_at', 'desc')
        ->get();
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
    public function createOrUpdateLeaveApllicationService($id,$request,$slug,$empSlug){
        $operate=EmployeeLeaveApplication::updateOrCreate(
            ['id' =>$id],
            ['employee_slug'=> $empSlug,'leave_type'=>$request->leave_type,
            'leave_reason'=>$request->leave_reason, 'from_date'=>$request->from_date,
            'to_date'=>$request->to_date,'emp_leave_apply_slug'=>$slug]
         );
         if($operate){
            return true;
         }
    }
    public function getAllEmpLeaveApplicationService(){
        return EmployeeLeaveApplication::with(['leaveType:id,name','employee:slug,name,employee_id'])->
        select('leave_reason','from_date','to_date','approval_status','emp_leave_apply_slug','employee_slug','leave_type')->get();
    }
    public function updateLeaveApplicationStatus($status,$slug){
       $updateStatus= EmployeeLeaveApplication::where('emp_leave_apply_slug', $slug)->update(['approval_status' => $status]);
       if($updateStatus){
        return 1;
       }
    }
    public function getAllLeaveTypes(){
        return LeaveType::get(['name','id']);
    }
    public function checkIfTeamOwner($empSlug){
        return Team::where('team_owner', '=', $empSlug)->exists();
    }
    public function getLeaveApplicationByTeamOwner($empSlug){

        return $leaveApplications = DB::table('team_members')
        ->join('employee_leave_applications', 'team_members.team_member', '=', 'employee_leave_applications.employee_slug')
        ->join('employees as e1', 'employee_leave_applications.employee_slug', '=', 'e1.employee_slug')
        ->join('leave_types', 'employee_leave_applications.leave_type', '=', 'leave_types.id')
        ->leftJoin('employees as e2', 'employee_leave_applications.responsedby_empslug', '=', 'e2.employee_slug') // Left join to handle nulls
        ->select(
            'e1.full_name as employee_name',
            'leave_types.name as leave_type_name',
            'employee_leave_applications.from_date',
            'employee_leave_applications.to_date',
            'employee_leave_applications.approval_status',
            'employee_leave_applications.responsedby_empslug',
            'employee_leave_applications.response_datetime',
            'employee_leave_applications.leave_reason',
            'employee_leave_applications.emp_leave_apply_slug',
            'e2.full_name as responded_by_name' // Select the name of the responding employee
        )
        ->where('team_members.team_owner', '=', $empSlug)
        ->orderBy('employee_leave_applications.created_at', 'desc')
        ->get();

    }
    public function getLeaveApplicationListByEmployee($empSlug){
        $dbQuery=DB::table('employee_leave_applications')->join('employees as e1', 'employee_leave_applications.employee_slug', '=', 'e1.employee_slug')
        ->join('leave_types', 'employee_leave_applications.leave_type', '=', 'leave_types.id')
        ->leftJoin('employees as e2', 'employee_leave_applications.responsedby_empslug', '=', 'e2.employee_slug')
        ->where('employee_leave_applications.employee_slug', '=', $empSlug)
        ->select('e1.full_name as employee_name','leave_types.name as leave_type_name','employee_leave_applications.from_date','employee_leave_applications.to_date',
        'employee_leave_applications.approval_status','employee_leave_applications.emp_leave_apply_slug','employee_leave_applications.response_datetime','employee_leave_applications.leave_reason','e2.full_name as responded_by_name') // Select all columns from leave_application or specify required columns
        ->orderBy('employee_leave_applications.created_at', 'desc')
        ->get();
        if($dbQuery){
            return $dbQuery;
        }
    }
    public function changeLeaveApplicationStatusService($status,$slug,$updatedByEmpSlug,$responseDatetime){
        $updateQuery= EmployeeLeaveApplication::where('emp_leave_apply_slug', $slug)->update(['approval_status' => $status,'responsedby_empslug'=>$updatedByEmpSlug,'response_datetime'=>$responseDatetime]);
        if($updateQuery){
            return 1;
        }
    }

}
?>
