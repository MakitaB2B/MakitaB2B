<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BtaExpensesBreakups extends Model
{
    use HasFactory;

    // protected $fillable=['emp_slug','bta_application_id','starting_date_time','ending_date_time','number_of_days','place_of_visit','purpose_of_visit','total_expenses','status','advance_amount','balance_amount','is_group_bt','manager_slug','manager_approved_by','advanced_paid_by','hr_approved_by','accountdep_approved_by','bta_slug','created_by','updated_at'];

    // public function employee(){
    //     return $this->hasOne('App\Models\Admin\Employee','employee_slug','emp_slug');
    // }

}