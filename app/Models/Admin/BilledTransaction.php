<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BilledTransaction extends Model
{
    use HasFactory;
    protected $guarded=[];
    public $timestamps = false;

    protected $table = 'billed_transactions';


    // public function setQtyInvoicedAttribute($value){
    //     dd($value);
        // $this->attributes['billed_qty'] = (int) $value;
    // }

    public function setQtyInvoicedAttribute($value) {
 
    $this->attributes['Qty Invoiced'] = (int) str_replace([',', ' '], '', $value);

    }


    public function getNameAttribute($value)
    {
        return (int) $value;
    }

}
