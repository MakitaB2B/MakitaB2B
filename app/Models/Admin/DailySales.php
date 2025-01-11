<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailySales extends Model
{
    use HasFactory;
    protected $fillable=[
        'date',
        'fy',
        'year',
        'month',
        'q',
        'category',
        'model_no_part_no',
        'description',
        'customer_no',
        'customer_name',
        'wh_branch',
        'region',
        'state',
        'sales_qty',
        'unit_cost',
        'sales_value',
        'invoice_no',
        'category_type',
        'customer_order_number',
        'sales_person',
        'sales_person_name',
    ];

    public function setSalesValueAttribute($value)
    {
        $cleanedValue = str_replace(',', '', $value);
        $this->attributes['sales_value'] = is_numeric($cleanedValue) ? $cleanedValue : 0;
    }

    public function getSalesValueAttribute($value)
    {
        return is_numeric($value) ? number_format((float) $value, 2) : null; //return $value ? number_format($value, 2) : null;
    }

    public function setUnitCostAttribute($value)
    {
        $cleanedValue = str_replace(',', '', $value);
        $this->attributes['unit_cost'] = is_numeric($cleanedValue) ? $cleanedValue : 0;
    }

    public function getUnitCostAttribute($value)
    {
        return is_numeric($value) ? number_format((float) $value, 2) : null; //return $value ? number_format($value, 2) : null;
    }

    public function setSalesQtyAttribute($value)
    {
        $cleanedValue = str_replace(',', '', $value);
        $this->attributes['sales_qty'] = is_numeric($cleanedValue) ? $cleanedValue : 0;
    }

    public function getSalesQtyAttribute($value)
    {
        return is_numeric($value) ? number_format((float) $value, 2) : null; //return $value ? number_format($value, 2) : null;
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = \Carbon\Carbon::parse($value)->format('Y-m-d');
        // $this->attributes['date'] = \Carbon\Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    }

    public function getDateAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y');
    }

    public function setSalesPersonAttribute($value)
    {   
        $this->attributes['sales_person'] = ($value === '0') ? null : $value;
    }

    public function getSalesPersonAttribute($value)
    {
        return $value ?: null; 
    }

    public function setSalesPersonNameAttribute($value)
    {
        
        if (preg_match('/^[a-zA-Z\s]+$/', $value)) {
            $this->attributes['sales_person_name'] = strtolower($value);
        } else {
            $this->attributes['sales_person_name'] = null;
        }
    }

    public function getSalesPersonNameAttribute($value)
    {
        return $value ? strtoupper($value) : null; // Convert to uppercase if not null
    }

    public function setSubCategoryAttribute($value)
    {
        $this->attributes['sub_category'] = ($value === '0' || $value === ' ') ? null : $value;
    }

    public function getSubCategoryAttribute($value)
    {
        return $value;
    }

    public function setCategoryAttribute($value)
    {
        $this->attributes['category'] = match (strtolower(trim($value))) {
            'a', '' => null, 
            'acc','accessories' => 'acc', 
            'tool','tools' => 'tool',           
            'spares','spare' => 'spare',        
            default => $value,   
        };
    }

    public function getCategoryAttribute($value)
    {
        return strtoupper($value);  
    }

    public function setCustomerNameAttribute($value)
    { 
        $this->attributes['customer_name'] = ($value === 'N/A' || '0' || ' ') ? null : $value; 
    }

    public function getCustomerNameAttribute($value)
    {
        return $value;  
    }

    public function setRegionAttribute($value)
    { 
        $this->attributes['region'] = ($value === 'N/A' || '0' || ' ') ? null : $value; 
    }

    public function getRegionAttribute($value)
    {
        return $value;  
    }

    public function setStateAttribute($value)
    { 
        $this->attributes['customer_name'] = ($value === 'N/A' || '0' || ' ') ? null : $value; 
    }

    public function getStateAttribute($value)
    {
        return $value;  
    }
}
