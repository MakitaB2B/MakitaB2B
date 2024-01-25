<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class AdminLogin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
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

}
