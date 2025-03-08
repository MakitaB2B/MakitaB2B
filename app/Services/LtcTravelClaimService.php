<?php
namespace App\Services;
use App\Models\Admin\LtcTravelClaim;

class LtcTravelClaimService{
  
    // public function getEndingMeter($employeeSlug){
    //     $endingMeter=LtcTravelClaim::where(['employee_slug'=> $employeeSlug])->whereIn('type_of_transport', ['2-Wheeler', '4-Wheeler'])->get();
    //     $endingMeter->type_of_transport->max('closing_meter');
    //     $endingMeter->type_of_transport->max('closing_meter');
    //     dd($endingMeter);
    //     return LtcTravelClaim::where(['employee_slug'=> $employeeSlug])->max('closing_meter');
    // }
}
?>