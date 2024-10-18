<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionEmail extends Model
{
    use HasFactory;

    public function sales_name(){
        return $this->hasOne('App\Models\Admin\Employee','employee_slug','sales_slug');
    }
}
