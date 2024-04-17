<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessModule extends Model
{
    use HasFactory;
    protected $fillable=['name','module_slug','status','created_by'];
}
