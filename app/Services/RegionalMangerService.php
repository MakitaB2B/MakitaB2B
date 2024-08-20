<?php
namespace App\Services;
use Illuminate\Support\Str;
use App\Models\Admin\RegionalManager;

class RegionalMangerService{

    public function rm_slug(){
   
        return Str::slug(rand().rand());
    }

    public function listRm(){

    return RegionalManager::orderBy('id')->get(['rm_name']);
   
    }

    public function rmNames(){

        return RegionalManager::orderBy('id')->get(['rm_name']);
       
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
