<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsCategories extends Model
{
    use HasFactory;
    protected $primarykey="id";
    protected $fillable=[
        'category_name',
        'category_slug',
        'parent_category_id',
        'category_image',
        'status',
    ];
    public function setCategoryNameAttribute($value){
        $this->attributes['category_name']=strtolower($value);
    }
    public function getCategoryNameAttribute($value)
    {
        return ucwords($value);
    }

    // Define the self-referencing relationship
    public function children()
    {
        return $this->hasMany(ProductsCategories::class, 'parent_category_id');
    }

    public function parent()
    {
        return $this->belongsTo(ProductsCategories::class, 'parent_category_id');
    }

}
