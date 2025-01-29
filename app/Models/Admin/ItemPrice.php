<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemPrice extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function setDLPAttribute($value)
    {
        $cleanedValue = str_replace(',', '', $value);
        $this->attributes['DLP'] = is_numeric($cleanedValue) ? $cleanedValue : 0;
    }
 
    public function getDLPAttribute($value)
    {
        return is_numeric($value) ? number_format((float) $value, 2) : null; 
    }

    public function setLPAttribute($value)
    {
        $cleanedValue = str_replace(',', '', $value);
        $this->attributes['LP'] = is_numeric($cleanedValue) ? $cleanedValue : 0;
    }
 
    public function getLPAttribute($value)
    {
        return is_numeric($value) ? number_format((float) $value, 2) : null; 
    }

    public function setMRPAttribute($value)
    {
        $cleanedValue = str_replace(',', '', $value);
        $this->attributes['MRP'] = is_numeric($cleanedValue) ? $cleanedValue : 0;
    }
 
    public function getMRPAttribute($value)
    {
        return is_numeric($value) ? number_format((float) $value, 2) : null; 
    }

    public function setBESTAttribute($value)
    {
        $cleanedValue = str_replace(',', '', $value);
        $this->attributes['BEST'] = is_numeric($cleanedValue) ? $cleanedValue : 0;
    }
 
    public function getBESTAttribute($value)
    {
        return is_numeric($value) ? number_format((float) $value, 2) : null; 
    }

    
}
