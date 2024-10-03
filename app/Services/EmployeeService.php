<?php
namespace App\Services;
use App\Models\Admin\Employee;
use Illuminate\Support\Facades\DB;
class EmployeeService{
    public function getAllEmployees(){
        return Employee::orderBy('id','desc')->get();
    }
    public function findEmployeeBySlug($slug){
        return Employee::where(['employee_slug'=>$slug])->get();
    }
    public function getEmpCount(){
        return Employee::count(['id']);
    }
    public function getAllDepartments(){
        return DB::table('departments')->get();
    }
    public function getDesignationsByDepartment($depId){
        return DB::table('designations')->where('department_id',$depId)->get(['id','designation_name']);
    }
    public function getAllStates(){
        return DB::table('states')->get(['id','name']);
    }
    public function getCitiesByState($stateId){
        return DB::table('cities')->where('state_id',$stateId)->get(['id','name']);
    }
    public function createOrUpdateEmployee($id,$request,$slug,$photo){
        $operate=Employee::updateOrCreate(
            ['id' =>$id],
            ['employee_no'=> $request->employee_no,'full_name'=>$request->full_name,
            'father_name'=>$request->father_name,'mother_name'=>$request->mother_name,
            'dob'=>$request->dob,'age'=>$request->age,'sex'=>$request->sex,
            'marital_status'=>$request->marital_status,'photo'=>$photo,
            'phone_number'=>$request->phone_number,'alt_phone_number'=>$request->alt_phone_number,
            'personal_email'=>$request->personal_email,'official_email'=>$request->official_email,
            'current_address'=>$request->current_address,'permanent_address'=>$request->permanent_address,
            'department_id'=>$request->department_id,'designation_id'=>$request->designation_id,
            'joining_date'=>$request->joining_date,'posting_state'=>$request->posting_state,
            'posting_city'=>$request->posting_city,'employee_slug'=>$slug,'status'=>$request->status,
            'crated_by'=>'1']
         );
         if($operate){
            return true;
         }
    }

    public function getEmployeeByDesignation($designation,$department){

    return Employee::join('designations', 'employees.designation_id', '=', 'designations.id')
    ->join('departments', 'employees.department_id', '=', 'departments.id')
    ->where('designation_name', '=', $designation)
    ->where('name', '=', $department)
    ->select('employees.full_name','employees.official_email')
    ->get();

    }

}
?>
