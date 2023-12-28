<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeStiffDoc extends Model
{
    use HasFactory;
    protected $primarykey="id";
    protected $fillable=[
        'emp_slug','pf_uan_number','aadhar_card','pan_card','driving_licence','passport','sslc_marks_card',
        'puc_marks_card','degree_marks_card','higher_degree_marks_card','esd_slug','created_by',
    ];
}
