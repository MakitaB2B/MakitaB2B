<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetMaster extends Model
{
    use HasFactory;

    protected $fillable=['asset_tag','asset_type','make','model','serial_number','service_tag','specification','ram','hard_disk_type','hard_disk_size','processor',
    'operating_system_version','operating_system_serial_number','ms_office_version','ms_office_licence','vendor_name','invoice_number','invoice_date',
    'amount','warranty_period','warranty_expired_date','system_condition','service_replacement','system_password','invoice_copy','remarks','status','assetmaster_slug','updated_by'];
    public function employee(){
        return $this->hasOne('App\Models\Admin\Employee','employee_slug','updated_by');
    }
}
