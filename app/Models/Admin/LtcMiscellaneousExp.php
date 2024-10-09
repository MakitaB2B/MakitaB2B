<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LtcMiscellaneousExp extends Model
{
    use HasFactory;

    protected $fillable = [
        'ltc_miscellaneous_slug',
        'ltc_claim_applications_slug',
        'employee_slug',
        'ltc_claim_id',  // Ensure this is added
        'courier_bill',
        'xerox_stationary',
        'office_expense',
        'monthly_mobile_bills',
        'remarks',
    ];

    public function employee(){
        return $this->belongsTo('App\Models\Admin\Employee','employee_slug','full_name','employee_slug');
    }
}
