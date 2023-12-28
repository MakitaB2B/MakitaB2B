<?php
namespace App\Services;
use App\Models\Admin\EmployeeWorkExperience;
class EmployeeWorkExperienceService{

    public function findEmployeeWorkExpByEmpSlug($empSlug){
        return EmployeeWorkExperience::where(['emloyee_slug'=>$empSlug])->get();
    }
    public function findEmployeeWorkExpBySlug($eweSlug){
        return EmployeeWorkExperience::where(['ewe_slug'=>$eweSlug])->get();
    }
    public function empWorkExpDelete($empWorkExpSlug){
        $delete=EmployeeWorkExperience::where('ewe_slug',$empWorkExpSlug)->delete();
        if($delete)
        return true;
    }
}
?>
