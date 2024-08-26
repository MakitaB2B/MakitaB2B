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

       return Transaction::insert($data);
    }

    public function allTransactions(){

       return Transaction::select('order_id', \DB::raw('SUM(order_price) as total_price'),'status','created_at','promo_code','rm_name','dealer_code','dealer_name')
        ->groupBy('order_id', 'promo_code','rm_name','dealer_code','dealer_name','status', 'created_at')
        ->orderBy('order_id', 'asc') 
        ->get();
 
    }
    public function getLeaveTypesList(){
     
    }
    public function createOrUpdateLeaveApllicationService(){
      
    }
    public function getAllEmpLeaveApplicationService(){
 
    }
  

}
?>
