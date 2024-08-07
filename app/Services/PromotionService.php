<?php
namespace App\Services;
use Illuminate\Support\Str;
use App\Models\Admin\Promotion;
use App\Models\Admin\BranchStocks;
use Illuminate\Support\Facades\Cache;
// use App\Models\Admin\LeaveType;
// use App\Models\Admin\Team;
// use Illuminate\Support\Facades\DB;

class PromotionService{
    public function promotion_slug(){
   
        return Str::slug(rand().rand());
    }

    public function getPromoCount(){
        return Promotion::count(['id']);
    }

    public function getModel(){

    //  return BranchStocks::select('item', 'description')
    //     ->groupBy('item')
    //     ->get();

    // $value = Cache::get('model_no');
    // dd($value);

    // $stocks = Cache::remember('model_no', 3600, function () {
    //     return BranchStocks::get(['item']);
    // });
    return BranchStocks::get(['item']);
    // pluck(['item', 'description']);
    // paginate(20000,['item', 'description']);
    //  return $stocks;
    }
    public function getLeaveTypesList(){
     
    }
    public function createOrUpdateLeaveApllicationService(){
      
    }
    public function getAllEmpLeaveApplicationService(){
 
    }
    public function updateLeaveApplicationStatus(){
    
    }
    public function getAllLeaveTypes(){
       
    }
    public function checkIfTeamOwner(){
        
    }
    public function getLeaveApplicationByTeamOwner(){


    }
    public function getLeaveApplicationListByEmployee(){
     
    }
    public function changeLeaveApplicationStatusService(){
 
    }

}
?>
