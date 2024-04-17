<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionEmployees extends Model
{
    use HasFactory;
    protected $fillable=['employee_slug','permission_slug','created_by'];
    public $timestamp=false;
}
