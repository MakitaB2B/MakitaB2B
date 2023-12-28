<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    use HasFactory;
    protected $primarykey="id";
    protected $fillable=[
        'department_id',
        'designation_name',
        'designation_slug',
        'status',
        'created_by',
    ];
    public function setDesignationNameAttribute($value){
        $this->attributes['designation_name']=strtolower($value);
    }
    public function getDesignationNameAttribute($value){
        return ucwords($value);
    }
    public function department(){
        return $this->hasMany('App\Models\Admin\Department','id','department_id');
    }
}
