<?php
namespace App\Services;
use App\Models\Admin\LtcMiscellaneousType;

class LtcMiscellaneousExpService{
  
    public function getMiscExp(){
        
    return LtcMiscellaneousType::where('status','Active')->pluck('ltc_misc_type');
    
    }
     
}
?>