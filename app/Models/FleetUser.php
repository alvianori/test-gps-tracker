<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FleetUser extends Model
{
    //
    protected $fillable = [
        'fleet_id',
        'user_id',
        'active',
        'assigned_at',
        'unassigned_at',
    ];


    public function fleet()
    {
        return $this->belongsTo(Fleet::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function activate()
    {
        // Deaktifkan semua penugasan lain untuk kendaraan ini sebelum mengaktifkan yang ini
        self::where('fleet_id', $this->fleet_id)
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
        static::creating(function ($fleetUser) {
            // Cek apakah kendaraan sudah pernah diinput sebelumnya
            $existingAssignment = self::where('fleet_id', $fleetUser->fleet_id)->first();
            if ($existingAssignment) {
                throw new \Exception('Kendaraan ini sudah memiliki penugasan pengguna. Tidak dapat menambahkan penugasan baru.');
            }
            
            // Jika penugasan baru diatur aktif, deaktifkan semua penugasan lain untuk user yang sama
            if ($fleetUser->active) {
                self::where('user_id', $fleetUser->user_id)
                    ->update(['active' => false]);
            }
        });
        
        // Validasi sebelum memperbarui penugasan
        static::updating(function ($fleetUser) {
            // Jika fleet_id berubah, cek apakah kendaraan baru sudah pernah diinput sebelumnya
            if ($fleetUser->isDirty('fleet_id')) {
                $existingAssignment = self::where('fleet_id', $fleetUser->fleet_id)
                    ->where('id', '!=', $fleetUser->id)
                    ->first();
                if ($existingAssignment) {
                    throw new \Exception('Kendaraan ini sudah memiliki penugasan pengguna. Tidak dapat mengubah penugasan.');
                }
            }
            
            // Jika penugasan diubah menjadi aktif, deaktifkan semua penugasan lain untuk user yang sama
            if ($fleetUser->active && $fleetUser->isDirty('active')) {
                self::where('user_id', $fleetUser->user_id)
                    ->where('id', '!=', $fleetUser->id)
                    ->update(['active' => false]);
            }
        });
    }
}
