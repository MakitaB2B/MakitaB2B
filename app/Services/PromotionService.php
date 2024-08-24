<?php
namespace App\Services;
use Illuminate\Support\Str;
use App\Models\Admin\Promotion;
use App\Models\Admin\BranchStocks;
use App\Models\Admin\ItemPrice;
use Illuminate\Support\Facades\DB;
class PromotionService{

    public function listPromotions(){

      return Promotion::select('promo_code','from_date','to_date','status', DB::raw('GROUP_CONCAT(model_no ORDER BY model_no ASC) AS model_no_array'))
      ->where('product_type', 'Offer Product')
      ->groupBy('promo_code','from_date','to_date','status')
      ->orderBy('promo_code')
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

      Promotion::insert($data);
    }

    public function getPromoDeatils($promocode){
      return Promotion::with('reservedStock:id,item,reserved')
      ->join('item_prices', 'promotions.model_no', '=', 'item_prices.Item')
      ->join('branch_stocks', 'promotions.model_no', '=', 'branch_stocks.item')
      ->where('promo_code',$promocode)
      ->select(
       'promotions.from_date','promotions.promo_code','promotions.to_date','promotions.product_type','promotions.model_no','promotions.model_desc','promotions.price_type','promotions.offer_type','item_prices.mrp','item_prices.dlp','promotions.qty','promotions.price'
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
