<?php
namespace App\Services;
use App\Models\Admin\LtcMiscellaneousExp;

class LtcMiscellaneousExpService{
  
    public function getMiscExp(){
        return LtcMiscellaneousExp::where(['status'=> 'Active'])->select('ltc_misc_type')->get();
    }
}
?>