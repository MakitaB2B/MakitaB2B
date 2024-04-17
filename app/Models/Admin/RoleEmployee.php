<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleEmployee extends Model
{
    use HasFactory;
    protected $fillable=['employee_slug','role_slug','created_by'];
}
