<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactoryServiceCenters extends Model
{
    use HasFactory;
    protected $fillable=['state_id','city_id','center_name','phone','email','center_address','status','created_by','fsc_slug','created_at','updated_at'];

    public function state(){
        return $this->hasMany('App\Models\Admin\State','id','state_id');
    }
    public function city(){
        return $this->hasMany('App\Models\Admin\City','id','city_id');
    }
    public function employee(){
        return $this->hasOne('App\Models\Admin\Employee','employee_slug','created_by');
    }
}
