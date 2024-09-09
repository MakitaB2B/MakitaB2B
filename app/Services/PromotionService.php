<?php
namespace App\Services;
use Illuminate\Support\Str;
use App\Models\Admin\Promotion;
use App\Models\Admin\BranchStocks;
use App\Models\Admin\ItemPrice;
use Illuminate\Support\Facades\DB;
use Exception;
 
class PromotionService{

    public function listPromotions(){

      return Promotion::select('promo_code','from_date','to_date','status', DB::raw('GROUP_CONCAT(model_no ORDER BY model_no ASC) AS model_no_array'))
      ->where('product_type', 'Offer Product')
      ->groupBy('promo_code','from_date','to_date','status')
      ->orderBy('promo_code','desc')
      ->get();
    
    }

    public function activePromotion(){

      return Promotion::select('promo_code')
      ->where('status', 'active')
      ->distinct()
      ->orderBy('promo_code', 'DESC')
      ->get();

    }

    public function promotion_slug(){
   
      return Str::slug(rand().rand());

    }

    public function getPromoCount(){

      // return Promotion::count(['id']); //  return Promotion::max('promo_code');

      return Promotion::selectRaw('MAX(CAST(promo_code AS UNSIGNED)) as max_promo_code')->pluck('max_promo_code')->first();

    }

    public function createOrUpdatePromo($data){

      try {
        DB::transaction(function () use ($data) {

           $promotion = Promotion::insert($data);
        
         }); 
        } catch (Exception $e) {

          return $e->getMessage();

        }

    }

    public function UpdatePromo($promocode,$status,$emp_no){

      Promotion::where('promo_code', $promocode)->update(['status'=> $status,'modified_by'=>$emp_no]);
      return Promotion::where('promo_code', $promocode) ->groupBy('promo_code', 'status')->get(['promo_code', 'status']);
     
    }

    public function getPromoDeatils($promocode){

      //-------------with out substracting stock--------------------
      // return Promotion::with('reservedStock:id,item,reserved')
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
     //-------------with out substracting stock--------------------

    //--------------working code---------
  
      // return Promotion::with('reservedStock:id,item,reserved')
      // ->join('item_prices', 'promotions.model_no', '=', 'item_prices.Item')
      // ->join('branch_stocks', 'promotions.model_no', '=', 'branch_stocks.item')
      // ->leftJoin(DB::raw('(SELECT model_no, IFNULL(SUM(order_qty), 0) as total_order_qty FROM transactions GROUP BY model_no) as t'), function ($join) {
      //     $join->on('promotions.model_no', '=', 't.model_no');
      // })
      // ->where('promotions.promo_code', $promocode)
      // ->select(
      //     'promotions.from_date', 'promotions.promo_code', 'promotions.to_date', 'promotions.product_type',
      //     'promotions.model_no', 'promotions.model_desc', 'promotions.price_type', 'promotions.offer_type',
      //     'item_prices.mrp', 'item_prices.dlp', 'promotions.qty', 'promotions.price'
      // )
      // ->addSelect(DB::raw('
      //     (branch_stocks.cb01 + branch_stocks.dl01 + branch_stocks.gh01 + branch_stocks.gj01 + branch_stocks.id01 +
      //      branch_stocks.jm01 + branch_stocks.ka01 + branch_stocks.kl01 + branch_stocks.mh01 + branch_stocks.pn01 +
      //      branch_stocks.py01 + branch_stocks.rd01 + branch_stocks.tn01 + branch_stocks.vd01 + branch_stocks.wb01) as total_stock'
      // ))
      // ->addSelect('t.total_order_qty')
      // ->get()
      // ->map(function ($item) {
      //     $item->total_reserved = $item->reservedStock->sum('reserved');
      //     $item->stock = $item->total_stock - $item->total_reserved - $item->total_order_qty;
      //     return $item;
      // });


      return Promotion::with('reservedStock:id,item,reserved')
      ->join('item_prices', 'promotions.model_no', '=', 'item_prices.Item')
      ->join('branch_stocks', 'promotions.model_no', '=', 'branch_stocks.item')
      ->leftJoin(DB::raw('(SELECT model_no, IFNULL(SUM(order_qty), 0) as total_order_qty FROM transactions GROUP BY model_no) as t'), function ($join) {
          $join->on('promotions.model_no', '=', 't.model_no');
      })
      ->where('promotions.promo_code', $promocode)
      ->select(
          'promotions.from_date', 'promotions.promo_code', 'promotions.to_date', 'promotions.product_type',
          'promotions.model_no', 'promotions.model_desc', 'promotions.price_type', 'promotions.offer_type',
          'item_prices.mrp', 'item_prices.dlp', 'promotions.qty', 'promotions.price'
      )
      ->addSelect(DB::raw('
          (branch_stocks.cb01 + branch_stocks.dl01 + branch_stocks.gh01 + branch_stocks.gj01 + branch_stocks.id01 +
           branch_stocks.jm01 + branch_stocks.ka01 + branch_stocks.kl01 + branch_stocks.mh01 + branch_stocks.pn01 +
           branch_stocks.py01 + branch_stocks.rd01 + branch_stocks.tn01 + branch_stocks.vd01 + branch_stocks.wb01) as total_stock'
      ))
      ->addSelect('t.total_order_qty')
      ->get()
      ->map(function ($item) {
          $item->total_reserved = $item->reservedStock->sum('reserved');
          $item->stock = $item->total_stock - $item->total_reserved - $item->total_order_qty;
          return $item;
      });






      //-------------------working code---------

      // return Promotion::with('reservedStock:id,item,reserved')
      // ->join('item_prices', 'promotions.model_no', '=', 'item_prices.Item')
      // ->join('branch_stocks', 'promotions.model_no', '=', 'branch_stocks.item')
      // ->leftJoin('transactions', 'promotions.model_no', '=', 'transactions.model_no')
      // ->where('promotions.promo_code', $promocode)
      // ->where('transactions.status', '!=','cancel')
      // ->select(
      //     'promotions.from_date', 'promotions.promo_code', 'promotions.to_date', 'promotions.product_type',
      //     'promotions.model_no', 'promotions.model_desc', 'promotions.price_type', 'promotions.offer_type',
      //     'item_prices.mrp', 'item_prices.dlp', 'promotions.qty', 'promotions.price'
      // )
      // ->selectRaw(
      //     '(branch_stocks.cb01 + branch_stocks.dl01 + branch_stocks.gh01 + branch_stocks.gj01 + branch_stocks.id01 + branch_stocks.jm01 + branch_stocks.ka01 + branch_stocks.kl01 + branch_stocks.mh01 + branch_stocks.pn01 + branch_stocks.py01 + branch_stocks.rd01 + branch_stocks.tn01 + branch_stocks.vd01 + branch_stocks.wb01) as total_stock'
      // )
      // ->selectRaw(
      //     'IFNULL(SUM(transactions.order_qty), 0) as total_order_qty'
      // )
      // ->groupBy(
      //     'promotions.from_date', 'promotions.promo_code', 'promotions.to_date', 'promotions.product_type',
      //     'promotions.model_no', 'promotions.model_desc', 'promotions.price_type', 'promotions.offer_type',
      //     'item_prices.mrp', 'item_prices.dlp', 'promotions.qty', 'promotions.price'
      //     ,'branch_stocks.cb01', 'branch_stocks.dl01', 'branch_stocks.gh01', 'branch_stocks.gj01',
      //     'branch_stocks.id01', 'branch_stocks.jm01', 'branch_stocks.ka01', 'branch_stocks.kl01',
      //     'branch_stocks.mh01', 'branch_stocks.pn01', 'branch_stocks.py01', 'branch_stocks.rd01',
      //     'branch_stocks.tn01', 'branch_stocks.vd01', 'branch_stocks.wb01'
      // )
      // ->get()
      // ->map(function ($item) {
      //     $item->total_reserved = $item->reservedStock->sum('reserved');
      //     $item->stock = $item->total_stock - $item->total_reserved - $item->total_order_qty;
      //     return $item;
      // });
  



      // $promo = Promotion::with('reservedStock:id,item,reserved')
      // ->join('item_prices', 'promotions.model_no', '=', 'item_prices.Item')
      // ->join('branch_stocks', 'promotions.model_no', '=', 'branch_stocks.item')
      // ->leftJoin('transactions', 'promotions.model_no', '=', 'transactions.model_no')
      // ->where('promotions.promo_code', $promocode)
      // ->where('transactions.status', '!=','cancel')
      // ->select(
      //     'promotions.from_date', 'promotions.promo_code', 'promotions.to_date', 'promotions.product_type',
      //     'promotions.model_no', 'promotions.model_desc', 'promotions.price_type', 'promotions.offer_type',
      //     'item_prices.mrp', 'item_prices.dlp', 'promotions.qty', 'promotions.price'
      // )
      // ->selectRaw(
      //     '(branch_stocks.cb01 + branch_stocks.dl01 + branch_stocks.gh01 + branch_stocks.gj01 + branch_stocks.id01 + branch_stocks.jm01 + branch_stocks.ka01 + branch_stocks.kl01 + branch_stocks.mh01 + branch_stocks.pn01 + branch_stocks.py01 + branch_stocks.rd01 + branch_stocks.tn01 + branch_stocks.vd01 + branch_stocks.wb01) as total_stock'
      // )
      // ->selectRaw(
      //     'IFNULL(SUM(transactions.order_qty), 0) as total_order_qty'
      // )
      // ->groupBy(
      //     'promotions.from_date', 'promotions.promo_code', 'promotions.to_date', 'promotions.product_type',
      //     'promotions.model_no', 'promotions.model_desc', 'promotions.price_type', 'promotions.offer_type',
      //     'item_prices.mrp', 'item_prices.dlp', 'promotions.qty', 'promotions.price'
      //     ,'branch_stocks.cb01', 'branch_stocks.dl01', 'branch_stocks.gh01', 'branch_stocks.gj01',
      //     'branch_stocks.id01', 'branch_stocks.jm01', 'branch_stocks.ka01', 'branch_stocks.kl01',
      //     'branch_stocks.mh01', 'branch_stocks.pn01', 'branch_stocks.py01', 'branch_stocks.rd01',
      //     'branch_stocks.tn01', 'branch_stocks.vd01', 'branch_stocks.wb01'
      // )
      // ->get()
      // ->map(function ($item) {
      //     $item->total_reserved = $item->reservedStock->sum('reserved');
      //     $item->stock = $item->total_stock - $item->total_reserved - $item->total_order_qty;
      //     return $item;
      // });

      // dd($promo);
    }

    public function getPromoDeatilsWithStock($promocode){
      return Promotion::with('reservedStock:id,item,reserved')
      ->join('item_prices', 'promotions.model_no', '=', 'item_prices.Item')
      ->join('branch_stocks', 'promotions.model_no', '=', 'branch_stocks.item')
      ->where('promo_code',$promocode)
      ->select(
       'promotions.from_date','promotions.promo_code','promotions.to_date','promotions.product_type','promotions.model_no','promotions.model_desc','promotions.price_type','promotions.offer_type','item_prices.mrp','item_prices.dlp','item_prices.best','promotions.qty','promotions.price','promotions.status','branch_stocks.dl01','branch_stocks.gj01','branch_stocks.kl01','branch_stocks.ka01','branch_stocks.mh01','branch_stocks.tn01'
        )
        ->selectRaw(
          '(branch_stocks.cb01 + branch_stocks.dl01 + branch_stocks.gh01 + branch_stocks.gj01 + branch_stocks.id01 + branch_stocks.jm01 + branch_stocks.ka01 + branch_stocks.kl01 + branch_stocks.mh01 + branch_stocks.pn01 + branch_stocks.py01 + branch_stocks.rd01 + branch_stocks.tn01 + branch_stocks.vd01 + branch_stocks.wb01) as total_stock'
      )
      ->get()
      ->map(function ($item) {
        $item->total_reserved = $item->reservedStock->sum('reserved');
        $item->stock = $item->total_stock - $item->reservedStock->sum('reserved');
        return $item;
       });
    }

    public function modeldetailSearch($query){

      $result = BranchStocks::with('reservedStock:id,item,reserved')
      ->join('item_prices', 'branch_stocks.item', '=', 'item_prices.Item')
      ->whereIn('item_prices.Item', $query)
      ->select(
          'item_prices.Item as item',
          'item_prices.Item Description as description',
          'item_prices.MRP as mrp',
          'item_prices.DLP as dlp',
          'item_prices.Best as best'
      )
      ->selectRaw(
          '(branch_stocks.cb01 + branch_stocks.dl01 + branch_stocks.gh01 + branch_stocks.gj01 + branch_stocks.id01 + branch_stocks.jm01 + branch_stocks.ka01 + branch_stocks.kl01 + branch_stocks.mh01 + branch_stocks.pn01 + branch_stocks.py01 + branch_stocks.rd01 + branch_stocks.tn01 + branch_stocks.vd01 + branch_stocks.wb01) as total_stock'
      )
      ->get()
      ->map(function ($item) {
          $item->total_reserved = $item->reservedStock->sum('reserved');
          // $item->stock = $item->total_stock - $item->reservedStock->sum('reserved');
          return $item;
      });

      return response()->json($result);

    }

    public function modeldetailSingleSearch($query){

      $results = ItemPrice::where('Item', $query)->get(['DLP as dlp', 'Best as best']);

      return $results["0"]["dlp"]."-".$results["0"]["best"];
    }

    public function searchData($query) {

     $results = BranchStocks::join('item_prices', 'branch_stocks.item', '=', 'item_prices.Item')->where('item_prices.Item', 'LIKE', "%{$query}%")->get(['item_prices.Item as item']);

     return response()->json($results);
    }
   

}
?>
