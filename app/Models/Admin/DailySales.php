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
        'sub_category'
    ];

    public function setFyAttribute($value)
    {
    $cleanedValue = preg_replace('/[^0-9\-]/', '', $value);
    if (preg_match('/^\d{4}-\d{4}$/', $cleanedValue)) {
        $parts = explode('-', $cleanedValue);
        $cleanedValue = $parts[0] . '-' . substr($parts[1], 2); // Extract 'YYYY' and 'YY'
        $this->attributes['fy'] = $cleanedValue;
    }
    else if (preg_match('/^\d{4}-\d{2}$/', $cleanedValue)) {
        $this->attributes['fy'] = $cleanedValue;
    } 
    else {
        throw new \InvalidArgumentException("Invalid FY format. Expected 'YYYY-YY' or 'YYYY-YYYY'.");
    }
    }
    
    public function getFyAttribute($value)
    {
        return $value;
    }

    public function setYearAttribute($value)
    {
        $cleanedValue = preg_replace('/[^0-9]/', '', $value);
    
        if (preg_match('/^\d{4}$/', $cleanedValue)) {
            $this->attributes['year'] = $cleanedValue;
        } else {
            $this->attributes['year'] = null; 
        }
    }
    
    public function getYearAttribute($value)
    {
        return $value; 
    }

    public function setMonthAttribute($value)
    {
        $cleanedValue = preg_replace('/[^0-9]/', '', $value);
        if (preg_match('/^([1-9]|1[0-2])$/', $cleanedValue)) {
            $this->attributes['month'] = intval($cleanedValue); 
        } else {
            $this->attributes['month'] = null; 
        }
    }

    public function getMonthAttribute($value)
    {
        return $value; 
    }

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
        $this->attributes['date'] = \Carbon\Carbon::parse($value)->format('Y-m-d');   // $this->attributes['date'] = \Carbon\Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    
    }

    public function getDateAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y');
    }

    public function setSalesPersonAttribute($value)
    {   

        $pattern = '/^MIN-\d{3}$/';
        $this->attributes['sales_person'] = preg_match($pattern,$value) === 1 ?  $value : null;
    }

    public function getSalesPersonAttribute($value)
    {
        return $value ?: null; 
    }

    public function setQAttribute($value)
    {
        $cleanedValue = strtoupper($value);

    if (preg_match('/^Q[1-4]$/', $cleanedValue)) {
        $this->attributes['q'] = $cleanedValue; 
    } else {
        throw new \InvalidArgumentException("Invalid value for Q. Allowed values are Q1, Q2, Q3, Q4.");
    }
    }

    public function getQAttribute($value)
    {
        return $value; // Return the stored value
    }

    public function setSalesPersonNameAttribute($value)
    {
        if (preg_match('/^[a-zA-Z\s]+$/', $value)) {
            $this->attributes['sales_person_name'] = ucwords(strtolower($value));
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

    $cleanedValue = strtolower(trim($value));

    $this->attributes['sub_category'] = match ($cleanedValue) {
        'xgt', 'hwg', 'lxt' => $cleanedValue,
        '', '-', '0', 'n/a', '#n/a' => null,      
        default => throw new \InvalidArgumentException("Invalid sub-category. Allowed values are 'xgt', 'xwg', 'lxt'."),
    };
    }

    public function getSubCategoryAttribute($value)
    {
        return $value ? strtoupper($value) : null; 
    }

    public function setCategoryAttribute($value)
    {
     $cleanedValue = strtolower(trim($value));

    $this->attributes['category'] = match ($cleanedValue) {
        '', '-', '0', 'n/a',' ' => null,              
        'acc', 'accessories' => 'acc',         
        'tool', 'tools' => 'tool',           
        'spare', 'spares' => 'spare',          
        default => throw new \InvalidArgumentException("Invalid category. Allowed values are 'acc', 'tool', 'spare'."),
    };
   }

    public function getCategoryAttribute($value)
    {
        return $value ? strtoupper($value) : null; 
    }

    public function setCustomerNameAttribute($value)
    { 
        $this->attributes['customer_name'] = ($value === 'N/A' || $value ==='0' || $value ===' ' || $value === '#N/A') ? null : $value; 
    }

    public function getCustomerNameAttribute($value)
    {
        return $value;  
    }

    public function setRegionAttribute($value)
    { 
        $value = strtoupper(trim($value));
        $this->attributes['region'] = ($value === 'N/A' || $value ==='0' || $value ===' ' || $value === '#N/A' || $value === '-') ? null : $value; 
    }

    public function getRegionAttribute($value)
    {
        return $value;  
    }

    public function setStateAttribute($value)
    { 
        $this->attributes['state'] = ($value === 'N/A' || $value ==='0' || $value ===' ' || $value === '#N/A' || $value === '-') ? null : ucwords(strtolower($value)); 
    }

    public function getStateAttribute($value)  
    {
        return ucwords(strtolower($value)) ?? null;    
    }

    public function setWhBranchAttribute($value)
    {
        $cleanedValue = strtolower(trim($value));
    
        if (preg_match('/^[a-zA-Z]{2}$/', $cleanedValue)) {
            $this->attributes['wh_branch'] = $cleanedValue; 
        } elseif ($cleanedValue === 'n/a' || $cleanedValue === '0' || $cleanedValue === '' || $cleanedValue === '#n/a') {
            $this->attributes['wh_branch'] = null; 
        } else {
            throw new \InvalidArgumentException("Invalid branch code. Must be exactly 2 alphabetic characters.");
        }
    }
    
    public function getWhBranchAttribute($value)
    {
        return $value ? strtoupper($value) : null; 
    }
    
    public function setCategoryTypeAttribute($value)
    {
        $cleanedValue = strtolower(trim($value));
    
        if (preg_match('/^[a-zA-Z]+$/', $cleanedValue)) {
            $this->attributes['category_type'] = strtoupper($cleanedValue); 
        } elseif ($cleanedValue === 'n/a' || $cleanedValue === '0' || $cleanedValue === '' || $cleanedValue === '#n/a' || $cleanedValue === '-') {
            $this->attributes['category_type'] = null;
        } else {
            throw new \InvalidArgumentException("Invalid category type. Only alphabetic characters are allowed.");
        }
    }
    
    public function getCategoryTypeAttribute($value)
    {
        return $value ? strtoupper($value) : null; 
    }
    

}
