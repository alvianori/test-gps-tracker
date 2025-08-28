<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GpsTrack extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'gps_device_id',
        'latitude',
        'longitude',
        'speed',
        'course',
        'direction',
        'devices_timestamp'
    ];
    
    public function gpsDevice()
    {
        return $this->belongsTo(GpsDevice::class);
    }
}
