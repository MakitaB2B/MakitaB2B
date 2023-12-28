<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    protected $primarykey="id";
    protected $fillable=[
        'state_id',
        'city_id',
        'address',
        'pin_code',
        'location_slug',
        'created_by',
        'status',
    ];

    public function state(){
        return $this->hasMany('App\Models\Admin\State','id','state_id');
    }
    public function city(){
        return $this->hasMany('App\Models\Admin\City','id','city_id');
    }
}
