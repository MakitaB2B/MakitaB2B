<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    protected $fillable=['name','permission_slug','status','created_by'];

    public function users(){
        return $this->belongsToMany(Employee::class,'permission_employees');
    }

    public function roles(){
        return $this->belongsToMany(Role::class,'roles_permissions');
    }
}
