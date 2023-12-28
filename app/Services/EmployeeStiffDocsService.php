<?php
namespace App\Services;
use App\Models\Admin\EmployeeStiffDoc;
class EmployeeStiffDocsService{

    public function findEmployeeDocsByEmpSlug($slug){
        return EmployeeStiffDoc::where(['emp_slug'=>$slug])->get();
    }
    public function createOrUpdateEmployeeStiffDocs($id,$request,$esdSlug,$empSlug,
    $aadharCard,$panCard,$drivingLicence,$passport,$sslcMarksCard,$pucMarksCard,$degreeMarksCard,$higherDegreeMarksCard){
        $operate=EmployeeStiffDoc::updateOrCreate(
            ['id' =>$id],
            ['emp_slug'=> $empSlug,'pf_uan_number'=>$request->pf_uan_number,
            'aadhar_card'=>$aadharCard,'pan_card'=>$panCard,
            'driving_licence'=>$drivingLicence,'passport'=>$passport,'sslc_marks_card'=>$sslcMarksCard,
            'puc_marks_card'=>$pucMarksCard,'degree_marks_card'=>$degreeMarksCard,
            'higher_degree_marks_card'=>$higherDegreeMarksCard,'esd_slug'=>$esdSlug,'created_by'=>'1']
         );
         if($operate){
            return true;
         }
    }

}
?>
