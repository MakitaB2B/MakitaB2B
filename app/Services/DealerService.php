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

        return Dealer::orderBy('created_at')->paginate(20,['Customer','Name','status','commercial_status','created_at']);  //,'commercial_status',
   
    }

    public function getDealers(){

    return Dealer::where('status', '!=', 'Deactive')->where('commercial_status', '!=', 'block')->orWhereNull('status','commercial_status')->orderBy('Customer')->get(['Customer','Name']);   
   
    }

    // public function findBySlug(){

    //     return Promotion::select('promo_code','from_date','to_date','status', DB::raw('GROUP_CONCAT(model_no ORDER BY model_no ASC) AS model_no_array'))
    //     ->where('product_type', 'Offer Product')
    //     ->groupBy('promo_code','from_date','to_date','status')
    //     ->orderBy('promo_code','desc')
    //     ->get();
 
    // }
  
    public function addcounts($customer,$emp_no){

    Dealer::where('Customer', $customer)->update([
        'cancelled_count' => DB::raw('COALESCE(cancelled_count, 0) + 1'),
        'updated_at' => now(),
        'modified_by' => $emp_no
    ]);

    $cancelledCount = Dealer::where('Customer', $customer)->value('cancelled_count');

    if( $cancelledCount>3){
        Dealer::where('Customer', $customer)->update(['commercial_status' => 'block']);
    }

    return $cancelledCount;

    }
  

}
?>
