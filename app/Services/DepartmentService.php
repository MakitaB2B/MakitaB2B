<?php
namespace App\Services;
use App\Models\Admin\Department;
class DepartmentService{
    public function getAllDepartments(){
        return Department::orderBy('id','desc')->get();
    }
    public function findDepartmentBySlug($slug){
        return Department::where(['department_slug'=>$slug])->get();
    }
    public function createOrUpdateDepartment($id,$request,$slug){
        $operate=Department::updateOrCreate(
            ['id' =>$id],
            ['name'=> $request->name,'status'=>$request->status,
            'department_slug'=>$slug, 'created_by'=>'Name']
         );
         if($operate){
            return true;
         }
    }

}
?>
