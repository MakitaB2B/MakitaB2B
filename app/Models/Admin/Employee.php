<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $primarykey="id";
    protected $fillable=[
        'employee_no',
        'full_name',
        'father_name',
        'mother_name',
        'dob',
        'age',
        'sex',
        'marital_status',
        'photo',
        'phone_number',
        'alt_phone_number',
        'personal_email',
        'official_email','current_address','permanent_address','department_id','designation_id','joining_date',
        'posting_state','posting_city','employee_slug','status','crated_by'
    ];
}
