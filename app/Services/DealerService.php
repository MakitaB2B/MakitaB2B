<?php
namespace App\Services;
use Illuminate\Support\Str;
use App\Models\Admin\Dealer;
use Illuminate\Support\Facades\DB;
class DealerService{

    public function dealer_slug(){
   
        return Str::slug(rand().rand());
    }

    public function getDealersPaginated(){

        return Dealer::orderBy('created_at')->paginate(20,['Customer','Name','created_at']);
   
    }

    public function getDealers(){

        return Dealer::where('status', '<>', 'block')
        ->orderBy('Customer')
        ->get(['Customer', 'Name']);


        // return Dealer::orderBy('Customer')->where('status','<>','block')->get(['Customer','Name']);
   
    }

    // public function findBySlug(){

    //     return Promotion::select('promo_code','from_date','to_date','status', DB::raw('GROUP_CONCAT(model_no ORDER BY model_no ASC) AS model_no_array'))
    //     ->where('product_type', 'Offer Product')
    //     ->groupBy('promo_code','from_date','to_date','status')
    //     ->orderBy('promo_code','desc')
    //     ->get();
 
    // }
  
    public function addcounts($customer){

    Dealer::where('Customer', $customer)->update([
        'cancelled_count' => DB::raw('COALESCE(cancelled_count, 0) + 1'),
        'updated_at' => now(),
    ]);

    $cancelledCount = Dealer::where('Customer', $customer)->value('cancelled_count');

    if( $cancelledCount>3){
        Dealer::where('Customer', $customer)->update(['status' => 'block']);
    }

    return $cancelledCount;

    }
  

}
?>
