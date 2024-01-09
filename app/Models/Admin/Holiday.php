<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    use HasFactory;
    protected $primarykey="id";
    protected $fillable=[
        'name',
        'notes',
        'from_date',
        'to_date',
        'slug',
        'type',
        'state',
    ];
    public function setNameAttribute($value){
        $this->attributes['name']=ucwords($value);
    }
    public function getFromDateAttribute($value){
        return date('d M Y',strtotime($value));
    }
    public function getToDateAttribute($value){
        return date('d M Y',strtotime($value));
    }
    public function holidayType(){
        return $this->hasMany('App\Models\Admin\HolidayType','id','type');
    }
    public function stateData(){
        return $this->hasMany('App\Models\Admin\State','id','state');
    }
}
