<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemMasterIgst extends Model
{
    use HasFactory;
    protected $fillable=[
        'item',
        'description',
        'alternate_item',
        'item_code',
        'hsn_india',
        'bcd',
        'igst',
        'factory',
        'coo',
    ];
}
