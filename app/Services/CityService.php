<?php
namespace App\Services;
use App\Models\Admin\City;
use Illuminate\Support\Facades\DB;

class CityService{
    public function getCitiesByState($stateID){
        return City::where('state_id',$stateID)->get(['id','name']);
    }
    public function getAllCitiesWithState(){
        return City::with('state:id,name')->orderBy('id','desc')->get();
    }
    public function findCityBySlug($citySlug){
        return City::where(['city_slug'=>$citySlug])->get();
    }
    public function findActiveStates(){
        return DB::table('states')->where(['status'=>1])->get();
    }
    public function createOrUpdateCity($id,$request,$citySlug,$dataOparateEmpSlug){
        $operate=City::updateOrCreate(
            ['id' =>$id],
            ['state_id'=> $request->state_id,'name'=>$request->name,
            'city_slug'=>$citySlug,'status'=>$request->status,'created_by'=>$dataOparateEmpSlug]
         );
         if($operate){
            return true;
         }
    }
}
?>
