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
        'ltc_claim_id',
        'employee_slug',
        'ltc_date',
        'ltc_day',
        'in_time',
        'out_time',
        'food_exp',
        'food_exp_bill',
        'claim_date'
        ];

        public function setLtcDateAttribute($value)
        {
            $this->attributes['ltc_date'] = \Carbon\Carbon::parse($value)->format('Y-m-d'); 

        }
     
        public function getLtcDateAttribute($value)
        {
            return \Carbon\Carbon::parse($value)->format('d-M-Y');
        }

        public function setLtcDayAttribute($value)  
        {
         $cleanedValue = strtolower($value);
            $this->attributes['ltc_day'] = match ($cleanedValue) {
                '', '-', '0', 'n/a',' ' => null,              
                'l' => 'On Leave',        
                'h' => 'Holiday',          
                'w' => 'Working Day', 
                'wh' => 'Working on Holiday',            
                default => throw new \InvalidArgumentException("Invalid category. Allowed values are L,H,W,WH"),
            };
        }
     
        public function getLtcDayAttribute($value)
        {
            return $value? $value : null;
            // return match ($value) {           
            //     'On Leave' => 'l',        
            //     'Holiday' => 'h',          
            //     'Working Day' => 'w', 
            //     'Working on Holiday' => 'wh',            
            //     default => throw new \InvalidArgumentException("Invalid category. Allowed values are On Leave,Holiday,Working Day,Working on Holiday"),
            // };
        }

        public function setInTimeAttribute($value)    
        {
            $seconds = strtotime($value);
            $this->attributes['in_time'] = $seconds;
        }  
        
        public function getInTimeAttribute($value)
        {
            return $value ? date("i:s", $value) : null;
            //return $value ? \Carbon\Carbon::createFromTimestamp($value)->format('i:s') : null;
        }

        public function setOutTimeAttribute($value)    
        {
            $seconds = strtotime($value);
            $this->attributes['out_time'] = $seconds;
        }  
        
        public function getOutTimeAttribute($value)
        {
            return $value ? date("i:s", $value) : null;
        }

        public function setFoodExpAttribute($value)   
        {
            $this->attributes['food_exp'] = (int)$value;
        }  
        
        public function getFoodExpAttribute($value)
        {
            return $value ? $value : null;
        }

        public function setFoodExpBillAttribute($value)    
        {
            $this->attributes['food_exp_bill'] = $value ?? null;
        }  
        
        public function getFoodExpBillAttribute($value)
        {
            return $value ? $value : null;
        }

}


