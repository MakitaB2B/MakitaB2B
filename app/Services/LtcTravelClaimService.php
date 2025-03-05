<?php
namespace App\Services;
use App\Models\Admin\LtcTravelClaim;

class LtcTravelClaimService{
  
    public function getEndingMeter($employeeSlug){
        return LtcTravelClaim::where(['employee_slug'=> $employeeSlug])->max('closing_meter');
    }
}
?>