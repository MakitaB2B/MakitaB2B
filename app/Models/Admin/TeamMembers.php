<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamMembers extends Model
{
    use HasFactory;

    public function employee(){
        return $this->hasOne('App\Models\Admin\Employee','employee_slug','team_owner');
    }
}
