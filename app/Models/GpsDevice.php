<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GpsDevice extends Model
{
    //
    protected $fillable = [
        'name',
        'serial_number',
        'model',
        'provider',
        'company_id'
    ];
}
