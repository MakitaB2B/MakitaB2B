<?php
namespace App\Services;
use Illuminate\Support\Str;
use App\Models\Admin\DealerCancelledOrder;
use Illuminate\Support\Facades\DB;

class DealerCancelledService{

    public function dealer_cancelled_slug(){
   
        return Str::slug(rand().rand());
    }

    public function Create($dealer_code, $promo_code,$cancelled_date){

       return DealerCancelledOrder::Create([
        'dealer_cancel_order_slug' =>$this->dealer_cancelled_slug() ,
        'dealer_code' => $dealer_code,
        'promo_code' => $promo_code,
        'cancelled_date' => $cancelled_date
        ]);
   
    }

}
?>
