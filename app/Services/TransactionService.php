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
    public function getTransactionDetails($orderid){

        return Transaction::where('order_id',$orderid)
        ->select('from_date','to_date','price_type','offer_type','mrp','dlp','stock','offer_qty','order_qty','promo_code','rm_name','dealer_code','dealer_name','product_type')
        // ->selectRaw('(branch_stocks.cb01 + branch_stocks.dl01 + branch_stocks.gh01 + branch_stocks.gj01 + branch_stocks.id01 + branch_stocks.jm01 + branch_stocks.ka01 + branch_stocks.kl01 + branch_stocks.mh01 + branch_stocks.pn01 + branch_stocks.py01 + branch_stocks.rd01 + branch_stocks.tn01 + branch_stocks.vd01 + branch_stocks.wb01) as total_stock')
        
        ->get();
        // return Transaction::with('reservedStock:id,item,reserved')
        // ->join('item_prices', 'promotions.model_no', '=', 'item_prices.Item')
        // ->join('branch_stocks', 'promotions.model_no', '=', 'branch_stocks.item')
        // ->where('promo_code',$promocode)
        // ->select(
        //  'promotions.from_date','promotions.promo_code','promotions.to_date','promotions.product_type','promotions.model_no','promotions.model_desc','promotions.price_type','promotions.offer_type','item_prices.mrp','item_prices.dlp','promotions.qty','promotions.price'
        //   )
        //   ->selectRaw(
        //     '(branch_stocks.cb01 + branch_stocks.dl01 + branch_stocks.gh01 + branch_stocks.gj01 + branch_stocks.id01 + branch_stocks.jm01 + branch_stocks.ka01 + branch_stocks.kl01 + branch_stocks.mh01 + branch_stocks.pn01 + branch_stocks.py01 + branch_stocks.rd01 + branch_stocks.tn01 + branch_stocks.vd01 + branch_stocks.wb01) as total_stock'
        // )
        // ->get()
        // ->map(function ($item) {
        //   $item->total_reserved = $item->reservedStock->sum('reserved');
        //   $item->stock = $item->total_stock - $item->reservedStock->sum('reserved');
        //   return $item;
        //  });

    }

    // public function createOrUpdateLeaveApllicationService(){
      
    // }
    // public function getAllEmpLeaveApplicationService(){
 
    // }
  

}
?>
