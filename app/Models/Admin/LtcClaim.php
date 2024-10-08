<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LtcClaim extends Model
{
    use HasFactory;

    // public function employee(){
    //     return $this->hasOne('App\Models\Admin\Employee','employee_slug','full_name','created_at');
    // }


    public function employee(){
        return $this->belongsTo('App\Models\Admin\Employee','employee_slug','employee_slug');
    }
}
