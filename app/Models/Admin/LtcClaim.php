<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LtcClaim extends Model
{
    use HasFactory;

    // public function employee(){
    //     return $this->hasOne('App\Models\Admin\Employee','employee_slug','full_name','created_at');
    // }


    public function employee(){
        return $this->belongsTo('App\Models\Admin\Employee','employee_slug','full_name','employee_slug');
    }

    public function ltcClaimApplication(){
        return $this->belongsTo('App\Models\Admin\LtcClaimApplication', 'ltc_claim_applications_slug', 'ltc_claim_applications_slug');
    }


}
