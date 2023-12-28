<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $primarykey="id";
    protected $fillable=[
        'name',
        'status',
        'department_slug',
        'created_by',
    ];
    public function setNameAttribute($value){
        $this->attributes['name']=strtolower($value);
    }
    public function getNameAttribute($value)
    {
        return ucwords($value);
    }
}
