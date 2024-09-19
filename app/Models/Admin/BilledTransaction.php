<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BilledTransaction extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $table = 'billed_transactions';

    public function setBilledQtyAttribute($value){
        $this->attributes['billed_qty'] = (int) $value;
    }
    public function getNameAttribute($value)
    {
        return (int) $value;
    }
}
