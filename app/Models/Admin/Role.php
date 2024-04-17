<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable=['name','role_slug','status','created_by'];

    public function permission(){
        return $this->belongsToMany(Permission::class,'roles_permissions');
    }
    public function users(){
        return $this->belongsToMany(Employee::class,'permission_employees');
    }
}
