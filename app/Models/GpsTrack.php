<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GpsTrack extends Model
{
    //
    protected $fillable = [
        'gps_device_id',
        'latitude',
        'longitude',
        'speed',
        'course',
        'direction',
        'devices_timestamp'
    ];
}
