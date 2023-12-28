<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $primarykey="id";
    protected $fillable=[
        'category_id',
        'model',
        'name',
        'product_slug',
        'product_price',
        'primary_image',
        'short_description',
        'long_description',
        'technical_info',
        'general_info',
        'support',
        'video_link',
        'keywords',
        'warranty',
        'status',
        'tax_id',
    ];
    public function setNameAttribute($value){
        $this->attributes['name']=strtolower($value);
    }
    public function getNameAttribute($value)
    {
        return ucwords($value);
    }
}
