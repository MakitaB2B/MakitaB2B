<?php
namespace App\Services;
use App\Models\Admin\State;

class StateService{
    public function getAllStates(){
        return State::orderBy('id','desc')->get();
    }
    public function findStateBySlug($slug){
        return State::where(['state_slug'=>$slug])->get();
    }
    public function createOrUpdateState($id,$request,$stateSlug,$dataOparateEmpSlug){
        $operate=State::updateOrCreate(
            ['id' =>$id],
            ['name'=> $request->name,'status'=>$request->status,
            'state_slug'=>$stateSlug, 'created_by'=>$dataOparateEmpSlug]
         );
         if($operate){
            return true;
         }
    }
}
?>
