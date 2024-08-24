<?php
namespace App\Services;
use Illuminate\Support\Str;
use App\Models\Admin\Transaction;

class TransactionService{

    public function transaction_slug(){
   
        return Str::slug(rand().rand());
    }

    public function order_id(){

        return Str::slug(rand());
    }

    public function createOrUpdateTransac($data){

        Transaction::insert($data);
    }

    public function findBySlug(){
 
    }
    public function getLeaveTypesList(){
     
    }
    public function createOrUpdateLeaveApllicationService(){
      
    }
    public function getAllEmpLeaveApplicationService(){
 
    }
  

}
?>
