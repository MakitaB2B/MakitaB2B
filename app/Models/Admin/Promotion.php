<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function reservedStock(){
        return $this->hasMany('App\Models\Admin\ReservedStocks','item','model_no');
    }

    public function setFromDateAttribute($value)
    {
        $this->attributes['from_date'] = \Carbon\Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    }

    public function setToDateAttribute($value)
    {
        $this->attributes['to_date'] = \Carbon\Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    }

    // public function setPriceAttribute($value)
    // {
    //     $cleanedValue = str_replace(',', '', $value);
    //     $this->attributes['price'] = is_numeric($cleanedValue) ? $cleanedValue : 0;
    // }


    public function setPriceAttribute($value){
        $this->attributes['price']=str_replace(",", "",$value);
    }

    public function getPriceAttribute($value)
    {
        return str_replace(",", "",$value);
    }
    
}
