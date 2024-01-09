<?php
namespace App\Services;
use App\Models\Admin\Holiday;
use Illuminate\Support\Facades\DB;
class HolidayService{
    public function getAllHolidays(){
        return Holiday::with('holidayType:id,name','stateData:id,name')->orderBy('id','desc')->get();
    }
    public function findBySlug($slug){
        return Holiday::where(['slug'=>$slug])->get();
    }
    public function fetchAllHolidayTypes(){
        return DB::table('holiday_types')->get();
    }
    public function fetchAllStates(){
        return DB::table('states')->get();
    }
    public function createOrUpdateHoliday($id,$request,$slug){
        $operate=Holiday::updateOrCreate(
            ['id' =>$id],
            ['name'=> $request->name,'notes'=>$request->holiday_notes,
            'from_date'=>$request->from_date, 'to_date'=>$request->to_date,
            'slug'=>$slug,'type'=>$request->holidaytype,'state'=>$request->state]
         );
         if($operate){
            return true;
         }
    }

}
?>
