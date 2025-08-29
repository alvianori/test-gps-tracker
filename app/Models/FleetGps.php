<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FleetGps extends Model
{
    protected $fillable = [
        'fleet_id',
        'gps_device_id',
        'active',
        'assigned_at',
        'unassigned_at',
    ];

    public function fleet()
    {
        return $this->belongsTo(Fleet::class);
    }

    public function gpsDevice()
    {
        return $this->belongsTo(GpsDevice::class);
    }

    public function activate()
    {
        // Deaktifkan semua penugasan lain untuk GPS ini sebelum mengaktifkan yang ini
        self::where('gps_device_id', $this->gps_device_id)
            ->where('id', '!=', $this->id)
            ->update(['active' => false]);
            
        $this->update(['active' => true]);
    }

    public function deactivate()
    {
        $this->update(['active' => false]);
    }
    
    protected static function booted()
    {
        // Validasi sebelum membuat penugasan baru
        static::creating(function ($fleetGps) {
            // Cek apakah kendaraan sudah pernah diinput sebelumnya
            $existingAssignment = self::where('fleet_id', $fleetGps->fleet_id)->first();
            if ($existingAssignment) {
                throw new \Exception('Kendaraan ini sudah memiliki penugasan GPS. Tidak dapat menambahkan penugasan baru.');
            }
            
            // Jika penugasan baru diatur aktif, deaktifkan semua penugasan lain untuk GPS yang sama
            if ($fleetGps->active) {
                self::where('gps_device_id', $fleetGps->gps_device_id)
                    ->update(['active' => false]);
            }
        });
        
        // Validasi sebelum memperbarui penugasan
        static::updating(function ($fleetGps) {
            // Jika fleet_id berubah, cek apakah kendaraan baru sudah pernah diinput sebelumnya
            if ($fleetGps->isDirty('fleet_id')) {
                $existingAssignment = self::where('fleet_id', $fleetGps->fleet_id)
                    ->where('id', '!=', $fleetGps->id)
                    ->first();
                if ($existingAssignment) {
                    throw new \Exception('Kendaraan ini sudah memiliki penugasan GPS. Tidak dapat mengubah penugasan.');
                }
            }
            
            // Jika penugasan diubah menjadi aktif, deaktifkan semua penugasan lain untuk GPS yang sama
            if ($fleetGps->active && $fleetGps->isDirty('active')) {
                self::where('gps_device_id', $fleetGps->gps_device_id)
                    ->where('id', '!=', $fleetGps->id)
                    ->update(['active' => false]);
            }
        });
    }
}