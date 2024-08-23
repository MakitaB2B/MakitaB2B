<?php
namespace App\Services;
use Illuminate\Support\Str;
use App\Models\Admin\Promotion;
// use App\Models\Admin\EmployeeLeaveApplication;
// use App\Models\Admin\LeaveType;
// use App\Models\Admin\Team;
// use Illuminate\Support\Facades\DB;

class TransactionService{

    public function transaction_slug(){
   
        return Str::slug(rand().rand());
    }

    public function order_id(){

        return Str::slug(rand());
    }

    public function getAuthEmployeeLeaveApplicationList(){
   
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
