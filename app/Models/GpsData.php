<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GpsData extends Model
{
    //
    protected $fillable = [
        'device_id',
        'latitude',
        'longitude',
        'speed',
        'course',
        'direction',
        'devices_timestamp',
    ];

    protected $casts = [
        'devices_timestamp' => 'datetime',
    ];
}
