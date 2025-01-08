<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    use HasFactory;
    protected $guarded = [];

    public function employee(){
        return $this->hasOne('App\Models\Admin\Employee','employee_no','ordered_by');
    }
}
