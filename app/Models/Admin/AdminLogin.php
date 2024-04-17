<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\HasPermissionsTrait;

class AdminLogin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasPermissionsTrait;
    protected $guard='admin';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'admin_slug',
        'employee_slug',
        'access_id',
        'password',
        'last_activity',
        'slug',
        'status',
        'admin_login_slug',
        'created_by',
    ];
     /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function employee(){
        return $this->hasMany('App\Models\Admin\Employee','employee_slug','employee_slug');
    }
    public function roles(){
        return $this->belongsToMany(Role::class,'role_employees','employee_slug','role_slug');
    }
    public function employeeRoles(){
        return $this->hasMany('App\Models\Admin\RoleEmployee','employee_slug','employee_slug');
    }
    public function employeePermission(){
        return $this->hasMany('App\Models\Admin\PermissionEmployees','employee_slug','employee_slug');
    }
    public function employeeAccessModules(){
        return $this->hasMany('App\Models\Admin\ModuleEmployee','employee_slug','employee_slug');
    }


}
