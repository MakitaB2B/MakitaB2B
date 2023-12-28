<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;
    protected $primarykey="id";
    protected $fillable=[
        'name',
        'status',
        'state_slug',
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
