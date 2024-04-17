<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    protected $fillable=['id','team_name','team_owner','team_slug'];
    public function employee(){
        return $this->hasOne('App\Models\Admin\Employee','employee_slug','team_owner');
    }
}
