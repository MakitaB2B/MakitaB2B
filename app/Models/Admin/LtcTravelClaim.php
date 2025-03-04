<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LtcTravelClaim extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $keyType = 'string'; // Ensures primary key is treated as a string

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function travelFiles()
    {
        return $this->hasMany(LtcFiles::class, 'ltc_travel_claims_slug', 'fileable_id')
                ->where('file_type', 'travel');
    }

}
