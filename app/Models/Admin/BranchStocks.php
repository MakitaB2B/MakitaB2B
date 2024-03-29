<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchStocks extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function reservedStock(){
        return $this->hasMany('App\Models\Admin\ReservedStocks','item','item');
    }
}
