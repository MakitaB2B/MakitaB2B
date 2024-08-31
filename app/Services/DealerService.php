<?php
namespace App\Services;
use Illuminate\Support\Str;
use App\Models\Admin\Dealer;

class DealerService{

    public function dealer_slug(){
   
        return Str::slug(rand().rand());
    }


    public function getDealersPaginated(){

        return Dealer::orderBy('created_at')->paginate(20,['Customer','Name','created_at']);
   
    }


    public function getDealers(){

        return Dealer::orderBy('Customer')->get(['Customer','Name']);
   
    }

    public function findBySlug(){

        return Promotion::select('promo_code','from_date','to_date','status', DB::raw('GROUP_CONCAT(model_no ORDER BY model_no ASC) AS model_no_array'))
        ->where('product_type', 'Offer Product')
        ->groupBy('promo_code','from_date','to_date','status')
        ->orderBy('promo_code','desc')
        ->get();
 
    }
  
  

}
?>
