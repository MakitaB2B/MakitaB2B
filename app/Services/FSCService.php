<?php
namespace App\Services;
use App\Models\Admin\FactoryServiceCenters;
use App\Models\Admin\FscExecutive;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
class FSCService{
    public function getAllFSCWithStateCity(){
        return FactoryServiceCenters::with('state:id,name','city:id,name','employee:full_name,employee_slug')->orderBy('id','desc')->get();
    }
    public function getAllFSC(){
        return FactoryServiceCenters::latest()->get();
    }
    public function findFSCBySlug($slug){
        return FactoryServiceCenters::where(['fsc_slug'=>$slug])->get();
    }
    public function fetchAllStates(){
        return DB::table('states')->where(['status'=>1])->get(['name','id']);
    }
    public function getCitiesByState($stateId){
        return DB::table('cities')->where('state_id',$stateId)->get(['id','name']);
    }
    public function fetchAllEpmloyees(){
        return DB::table('employees')->where(['status'=>1])->get(['full_name','employee_slug','employee_no']);
    }
    public function createOrUpdateFSC($id,$request,$fscSlug,$dataOparateEmpSlug){
        $operate=FactoryServiceCenters::updateOrCreate(
            ['id' =>$id],
            ['state_id'=>$request->state,'city_id'=>$request->city,'center_name'=>$request->name,
            'phone'=>$request->phone,'email'=>$request->email,'center_address'=>$request->fsc_address,
            'status'=>$request->status,'created_by'=>$dataOparateEmpSlug,'fsc_slug'=>$fscSlug]
         );
         if($operate){
            return true;
         }
    }
    public function findFSCExcutivesByFscSlug($fscExeSlug){
        return FscExecutive::where(['fsc_slug'=>$fscExeSlug])->get();
    }
    public function createOrUpdateFSCExcecutive($request,$dataOparateEmpSlug,$fscSlug){
        // Team Members
        $serviceExecutiveCount=$request->input('serviceExecutiveCount');
        $updateServiceExecutive=$request->input('fscexecutive');
        if($serviceExecutiveCount>0){
        $serviceExecutiveBM=$request->input('fscexe_befor_modify');
        if($serviceExecutiveBM != $updateServiceExecutive){
                $serviceExecutiveArrayDiffToDelete=array_diff($serviceExecutiveBM,$updateServiceExecutive);
                $serviceExecutiveArrayDiffToInsert=array_diff($updateServiceExecutive,$serviceExecutiveBM);

                if(count($serviceExecutiveArrayDiffToInsert)>0){
                    foreach ($updateServiceExecutive as $fscExcData) {
                        $serviceExecutiveRecordsInsert[] = [
                            'fsc_slug' => $fscSlug,
                            'employee_slug' => Crypt::decrypt($fscExcData),
                            'created_by' => $dataOparateEmpSlug,
                            'fsc_excecutive_slug'=>rand().rand(),
                        ];
                    }
                    FscExecutive::insert($serviceExecutiveRecordsInsert);

                }
                if(count($serviceExecutiveArrayDiffToDelete)>0){
                    foreach($serviceExecutiveArrayDiffToDelete as $fscExcSlugDel){
                        FscExecutive::WHERE('employee_slug', $fscExcSlugDel)->WHERE('fsc_slug', $fscSlug)->first()->delete();
                    }
                }
            }

        }if($serviceExecutiveCount == 0){
            foreach ($updateServiceExecutive as $fscExcData) {
                $serviceExecutiveRecordsInsert[] = [
                    'fsc_slug' => $fscSlug,
                    'employee_slug' => Crypt::decrypt($fscExcData),
                    'created_by' => $dataOparateEmpSlug,
                    'fsc_excecutive_slug'=>rand().rand(),
                ];
            }
            FscExecutive::insert($serviceExecutiveRecordsInsert);
        }
        return true;
    }
}
?>
