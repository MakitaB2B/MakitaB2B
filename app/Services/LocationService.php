<?php
namespace App\Services;
use App\Models\Admin\Location;
use Illuminate\Support\Facades\DB;

class LocationService{
    public function getAllLocationWithStateAndCity(){
            return Location::with('state:id,name')->with('city:id,name')->orderBy('id','desc')->get();
    }
    public function findLocationBySlug($locationSlug){
        return Location::where(['location_slug'=>$locationSlug])->get();
    }
    public function findActiveStates(){
        return DB::table('states')->where(['status'=>1])->get();
    }
    public function createOrUpdateLocation($id,$request,$locationSlug,$dataOparateEmpSlug){
        $operate=Location::updateOrCreate(
            ['id' =>$id],
            ['state_id'=> $request->state_id,'city_id'=>$request->city_id,
            'address'=>$request->address,'pin_code'=>$request->pin_code,'location_slug'=>$locationSlug,'status'=>$request->status,'created_by'=>$dataOparateEmpSlug]
         );
         if($operate){
            return true;
         }
    }
    public function getCitiesByState($stateId){
        return DB::table('cities')->where('state_id',$stateId)->get(['id','name']);
    }
}
?>
