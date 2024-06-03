<?php

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class CustomerLogin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $guard='customer';
    public function customer(){
        return $this->hasOne('App\Models\Front\Customer','customer_slug','customer_slug');
    }
}
