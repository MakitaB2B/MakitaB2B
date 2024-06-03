<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToolsService extends Model
{
    use HasFactory;
    protected $fillable=['id','cx_slug','trn','sr_date','service_center','tools_issue','model','tools_sl_no','repairer','delear_customer_name','contact_number',
    'model','tools_sl_no','receive_date_time','estimation_date_time','duration_a_b','cost_estimation','est_date_confirm_cx','repair_complete_date_time','duration_c_d',
    'handover_date_time','status','total_hour_for_repair','repair_parts_details','reason_for_over_48h','part_number_reason_for_delay','sr_slug'];
    public function employee(){
        return $this->belongsTo('App\Models\Admin\Employee','employee_slug','repairer');
    }
    public function fscBranch(){
        return $this->hasOne('App\Models\Admin\FactoryServiceCenters','fsc_slug','service_center');
    }
    public function waranty(){
        return $this->hasOne('App\Models\Front\WarrantyRegistration','machine_serial_number','tools_sl_no');
    }
}
