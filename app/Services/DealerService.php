<?php
namespace App\Services;
use Illuminate\Support\Str;
use App\Models\Admin\Dealer;

class DealerService{

    public function dealer_slug(){
   
        return Str::slug(rand().rand());
    }

    public function getDealers(){

        return Dealer::orderBy('dealer_code')->get(['dealer_code','dealer_name']);
   
    }
    public function findBySlug(){
 
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
