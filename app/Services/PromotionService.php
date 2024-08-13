<?php
namespace App\Services;
use Illuminate\Support\Str;
use App\Models\Admin\Promotion;
use App\Models\Admin\BranchStocks;

class PromotionService{
    public function promotion_slug(){
   
      return Str::slug(rand().rand());

    }

    public function getPromoCount(){

      return Promotion::count(['id']);

    }

    public function modeldetailSearch($query){

        $results = BranchStocks::whereIn('item',  $query)->get(['item','description']);

        return response()->json($results);
    }

   
    public function searchData($query)
    {

        $results = BranchStocks::where('item', 'LIKE', "%{$query}%")->get(['item']);

        return response()->json($results);
    }
   

}
?>
