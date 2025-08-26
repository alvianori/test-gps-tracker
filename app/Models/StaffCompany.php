<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffCompany extends Model
{
    protected $fillable = [
        'user_id',
        'company_id',
        'staff_position_id',
        'phone',
        'address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function position()
    {
        return $this->belongsTo(StaffPosition::class, 'staff_position_id');
    }
    public function fleet()
    {
        return $this->hasOne(Fleet::class);
    }
}
