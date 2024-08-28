<?php
namespace App\Services;
use Illuminate\Support\Str;
use App\Models\Admin\Transaction;
use Illuminate\Support\Facades\DB;
use Exception;

class TransactionService{

    public function transaction_slug(){
   
        return Str::slug(rand().rand());
    }

    public function order_id(){

        return Str::slug(rand());
    }

    public function createOrUpdateTransac($data){
        
        try {
            DB::transaction(function () use ($data) {
              Transaction::insert($data);
            });
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
  
    }

    public function allTransactions(){

       return Transaction::select('order_id', \DB::raw('SUM(order_price) as total_price'),'status','created_at','promo_code','rm_name','dealer_code','dealer_name')
        ->groupBy('order_id', 'promo_code','rm_name','dealer_code','dealer_name','status', 'created_at')
        ->orderBy('order_id', 'asc') 
        ->get();
 
    }
    public function getTransactionDetails($orderid){

        return Transaction::where('order_id',$orderid)
        ->select('order_id','created_at','promo_code','product_type','model_no','price_type','offer_type','order_qty','offer_price','promo_code','rm_name','dealer_code','dealer_name','product_type','model_no','order_price','order_id','status')
        ->get();

    }

    public function UpdateTransaction($orderid,$status,$emp_no){

        Transaction::where('order_id',$orderid)->update(['status'=> $status,'modified_by'=>$emp_no]);
        return Transaction::where('order_id',$orderid) ->groupBy('order_id', 'status')->get(['order_id', 'status']);
       
    }

    // public function createOrUpdateLeaveApllicationService(){
      
    // }
    // public function getAllEmpLeaveApplicationService(){
 
    // }
  

}
?>
