<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendingPo extends Model
{
    use HasFactory;
    protected $fillable=['vendorpo','vendor','name','po','line','item','itemdescription','cat','ordered','poorderdate','duedate','month'];
}
