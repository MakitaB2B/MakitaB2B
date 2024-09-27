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

        $orderExists = Transaction::distinct()->pluck('order_id')->toArray();

        do {

            $orderId = Str::slug(rand());
    
        } while (in_array($orderId, $orderExists));
    
        return $orderId;
    }

    public function createOrUpdateTransac($data){

         try {
            DB::transaction(function () use ($data) {
                
             Transaction::insert($data);
          
             });
             return true; 
        } catch (Exception $e) {
             return $e->getMessage();
         }return true;
  
    }

    public function allTransactions(){

    //    return Transaction::select('order_id', \DB::raw('SUM(order_price) as total_price'),'status','created_at','promo_code','rm_name','dealer_code','dealer_name','order_date')
    //     ->groupBy('order_id', 'promo_code','rm_name','dealer_code','dealer_name','status', 'created_at','order_date')
    //     ->orderBy('order_date', 'desc') 
    //     ->get();

    // return Transaction::select(
    //     'order_id', 
    //     \DB::raw('SUM(order_price) as total_price'),
    //     'promo_code',
    //     'rm_name',
    //     'dealer_code',
    //     'dealer_name',
    //     'order_qty',
    //     'billed_qty',
    //     'order_date',
    //     'created_at',
    //     \DB::raw("CASE
    //         WHEN COUNT(CASE WHEN status = 'billed' THEN 1 END) = COUNT(*) THEN 'billed'
    //         WHEN COUNT(CASE WHEN status = 'billed' THEN 1 END) > 0 AND COUNT(CASE WHEN status = 'open' THEN 1 END) > 0 THEN 'partially billed'
    //         ELSE MIN(status)
    //     END as status")
    // )
    // ->groupBy('order_id', 'promo_code', 'rm_name', 'dealer_code', 'dealer_name', 'order_date', 'created_at')
    // ->orderBy('order_date', 'desc')
    // ->get();

    // DB::enableQueryLog();
//   Transaction::select(
//         'order_id', 
//         \DB::raw('SUM(order_price) as total_price'),
//         'promo_code',
//         'rm_name',
//         'dealer_code',
//         'dealer_name',
        // 'order_qty',    
        // 'billed_qty',   
    //     'order_date',
    //     'created_at',
    //     \DB::raw("
    //         CASE
    //             -- All items are billed
    //             WHEN COUNT(CASE WHEN status = 'billed' THEN 1 END) = COUNT(*) THEN 'billed'
    //             -- Partially billed: when there is at least one billed and one open, OR billed_qty is not null for open
    //             WHEN COUNT(CASE WHEN status = 'billed' THEN 1 END) > 0 
    //                  AND (COUNT(CASE WHEN status = 'open' THEN 1 END) > 0 
    //                  OR COUNT(CASE WHEN status = 'open' AND billed_qty IS NOT NULL THEN 1 END) > 0) 
    //             THEN 'partially billed'
    //             -- Default to minimum status
    //             ELSE MIN(status)
    //         END as status
    //     ")
    // )
    // ->groupBy(
    //     'order_id', 
    //     'promo_code', 
    //     'rm_name', 
    //     'dealer_code', 
    //     'dealer_name', 
        // 'order_qty',  
        // 'billed_qty', 
    //     'order_date', 
    //     'created_at'
    // )
    // ->orderBy('order_date', 'desc')
    // ->get();

  return Transaction::select(
        'order_id', 
        DB::raw('SUM(order_price) as total_price'),
        'promo_code',
        'rm_name',
        'dealer_code',
        'dealer_name',
        'order_date',
        'created_at',
        DB::raw("
            CASE
                -- All items are billed
                WHEN COUNT(CASE WHEN status = 'billed' THEN 1 END) = COUNT(*) THEN 'billed'
                
                -- Partially billed: when there is at least one billed and at least one open, OR billed_qty is not null for open
                WHEN COUNT(CASE WHEN status = 'billed' THEN 1 END) > 0 
                     AND (
                         COUNT(CASE WHEN status = 'open' THEN 1 END) > 0 )
                         OR COUNT(CASE WHEN status = 'open' AND billed_qty IS NOT NULL THEN 1 END) > 0
                     
                THEN 'partially billed'
                
                -- Default to minimum status
                ELSE MIN(status)
            END as status
        ")
    )
    ->groupBy(
        'order_id', 
        'promo_code', 
        'rm_name', 
        'dealer_code', 
        'dealer_name', 
        'order_date', 
        'created_at'
    )
    ->orderBy('order_date', 'desc')
    ->get();
 
    }
    public function getTransactionDetails($orderid){

        return Transaction::join('branch_stocks', 'branch_stocks.item', '=', 'transactions.model_no')->where('order_id',$orderid)
        ->select('branch_stocks.description','order_id','transactions.created_at','promo_code','product_type','model_no','price_type','offer_type','order_qty','offer_price','promo_code','rm_name','dealer_code','dealer_name','product_type','model_no','order_price','order_id','status','stock','transactions.billed_qty')
        ->get();

    }

    public function UpdateTransaction($orderid,$status,$emp_no){

        Transaction::where('order_id',$orderid)->update(['status'=> $status,'modified_by'=>$emp_no]);
        return Transaction::where('order_id',$orderid) ->groupBy('order_id', 'status')->get(['order_id', 'status']);
       
    }
  

}
?>
