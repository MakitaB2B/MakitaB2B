<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LtcClaimApplication extends Model
{
    use HasFactory;

    protected $fillable = [
    'ltc_claim_applications_slug',
    'ltc_claim_id',
    'employee_slug',
    'ltc_month',
    'ltc_year',
    'manager_slug',
    'claim_amount',
    'total_claim_amount'

    ];
    // ltc_claim_applications_slug

    public function employee(){
        return $this->belongsTo('App\Models\Admin\Employee','employee_slug','employee_slug');
    }
    public function manager_name(){
        return $this->belongsTo('App\Models\Admin\Employee','manager_approved_by','employee_slug');
    }

    public function hr_name(){
        return $this->belongsTo('App\Models\Admin\Employee','hr_approved_by','employee_slug');
    }

    public function payed_by(){
        return $this->belongsTo('App\Models\Admin\Employee','payment_by','employee_slug');
    }
    
    public function ltcClaims(){
        return $this->hasMany('App\Models\Admin\LtcClaim', 'ltc_claim_applications_slug', 'ltc_claim_applications_slug');
    }

    public function ltcMiscellaneousExp()
    {
        return $this->hasOne('App\Models\Admin\LtcMiscellaneousExp', 'ltc_claim_applications_slug', 'ltc_claim_applications_slug');
    }


}
