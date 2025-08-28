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
        $this->update(['active' => true]);
    }

    public function deactivate()
    {
        $this->update(['active' => false]);
    }
}
