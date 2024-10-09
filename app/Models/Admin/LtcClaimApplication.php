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
    'claim_amount'

    ];
    // ltc_claim_applications_slug

    public function employee(){
        return $this->belongsTo('App\Models\Admin\Employee','employee_slug','employee_slug');
    }
}
