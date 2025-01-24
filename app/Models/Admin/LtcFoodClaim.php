<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LtcFoodClaim extends Model
{
    use HasFactory;

    protected $fillable = [
        'ltc_food_claims_slug',
        'ltc_claim_applications_slug',
        'employee_slug',
        'ltc_date',
        'ltc_day',
        'in_time',
        'out_time',
        'food_exp',
        'food_exp_bill',
        ];

        public function setLtcDateAttribute($value)
        {
            $this->attributes['ltc_date'] = \Carbon\Carbon::parse($value)->format('Y-m-d'); 

        }
     
        public function getLtcDateAttribute($value)
        {
            return \Carbon\Carbon::parse($value)->format('d m Y');
        }

        public function setLtcDayAttribute($value)  
        {
         $cleanedValue = strtolower($value);
        $this->attributes['category'] = match ($cleanedValue) {
            '', '-', '0', 'n/a',' ' => null,              
            'acc', 'accessories' => 'ACC',        
            'tool', 'tools' => 'TOOL',          
            'spare', 'spares' => 'SPARE',          
            default => throw new \InvalidArgumentException("Invalid category. Allowed values are 'acc', 'tool', 'spare'."),
        };
       }
     
        public function getLtcDayAttribute($value)
        {
            return $value ? strtoupper($value) : null;
        }

        
}


// public function setYearAttribute($value)
// {
//     $cleanedValue = preg_replace('/[^0-9]/', '', $value);

//     if (preg_match('/^\d{4}$/', $cleanedValue)) {
//         $this->attributes['year'] = $cleanedValue;
//     } else {
//         $this->attributes['year'] = null;
//     }
// }

// public function getYearAttribute($value)
// {
//     return $value;
// }
