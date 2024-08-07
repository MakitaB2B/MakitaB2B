<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeLeaveApplication extends Model
{
    use HasFactory;
    protected $fillable=['id','employee_slug','leave_type','leave_reason','from_date','to_date','approval_status','responsedby_empslug','response_datetime','emp_leave_apply_slug'];
    public function employee(){
        return $this->belongsTo('App\Models\Admin\Employee','employee_slug','employee_slug');
    }
    public function leaveType(){
        return $this->belongsTo('App\Models\Admin\LeaveType','leave_type','id');
    }
}
