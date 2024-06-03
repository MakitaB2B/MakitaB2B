<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToolserviceCostestimationCxs extends Model
{
    use HasFactory;
    protected $fillable=['id','service_slug','trn','costestimation_file','status','reason_if_rejected','costestimation_slug','lastupdated_byemp'];
}
