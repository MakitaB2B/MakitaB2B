<?php
namespace App\Services;
use Illuminate\Support\Str;
use App\Models\Admin\Promotion;
use App\Models\Admin\BranchStocks;
use App\Models\Admin\ItemPrice;

class PromotionService{
    public function promotion_slug(){
   
      return Str::slug(rand().rand());

    }

    public function getPromoCount(){

      return Promotion::count(['id']);

    }

    public function modeldetailSearch($query){
        $results = BranchStocks::with('reservedStock:id,item,reserved')->join('item_prices', 'branch_stocks.item', '=', 'item_prices.Item')
        ->whereIn('item_prices.Item',  $query)
        ->get(['item_prices.Item as item', 'item_prices.Item Description as description','item_prices.MRP as mrp','item_prices.DLP as dlp','item_prices.Best as best']);
        return response()->json($results);
    }

    public function modeldetailSingleSearch($query){
      $results = ItemPrice::where('Item', $query)->get(['DLP as dlp', 'Best as best']);
      return $results["0"]["dlp"]."-".$results["0"]["best"];
    }

    public function searchData($query)
    {

        $results = BranchStocks::where('item', 'LIKE', "%{$query}%")->get(['item']);

        return response()->json($results);
    }
   

}
?>
