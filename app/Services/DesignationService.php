<?php
namespace App\Services;
use App\Models\Admin\Designation;
use Illuminate\Support\Facades\DB;
class DesignationService{
    public function getAllDesignations(){
        return Designation::with('department:id,name')->orderBy('id','desc')->get();
    }
    public function findDesignationBySlug($slug){
        return Designation::where(['designation_slug'=>$slug])->get();
    }
    public function createOrUpdateDesignation($id,$request,$slug){
        $operate=Designation::updateOrCreate(
            ['id' =>$id],
            ['department_id'=> $request->department_id,'designation_name'=>$request->designation_name,
            'designation_slug'=>$slug,'status'=>$request->status,'created_by'=>'Name']
         );
         if($operate){
            return true;
         }
    }
    public function findActiveDepartments(){
        return DB::table('departments')->where(['status'=>1])->get();
    }
    public function getDesignationsByDepertmant($departmentID){
        return Designation::where('department_id',$departmentID)->get(['id','designation_name']);
    }

}
?>
