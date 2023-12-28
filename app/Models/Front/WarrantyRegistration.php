<?php

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarrantyRegistration extends Model
{
    use HasFactory;
    protected $primarykey="id";

    public function model(){
        return $this->hasMany('App\Models\Admin\ProductModel','id','model_number');
    }
}
