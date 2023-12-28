<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $primarykey="id";
    protected $fillable=[
        'state_id',
        'name',
        'status',
        'city_slug',
        'created_by',
    ];

    public function state(){
        return $this->hasMany('App\Models\Admin\State','id','state_id');
    }
}
