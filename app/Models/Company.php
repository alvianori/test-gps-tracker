<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'address',
        'phone',
        'npwp',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'staff_companies')
            ->withPivot('staff_position_id', 'phone', 'address')
            ->withTimestamps();
    }

    public function staff()
    {
        return $this->hasMany(StaffCompany::class);
    }

    public function businessType()
    {
        return $this->belongsTo(BusinessType::class);
    }
}
