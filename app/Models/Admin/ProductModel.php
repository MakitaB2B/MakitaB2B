<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    use HasFactory;
    protected $fillable=['id','model_number','description','warranty_period','category','product_code','status','model_slug','created_by'];
    public function employee(){
        return $this->hasOne('App\Models\Admin\Employee','employee_slug','created_by');
    }
}
