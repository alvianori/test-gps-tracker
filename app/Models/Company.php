<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'business_type_id',
        'owner_id',
        'email',
        'address',
        'phone',
        'npwp',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function businessType()
    {
        return $this->belongsTo(BusinessType::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    public function positions()
    {
        return $this->hasMany(Position::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
    
    public function customerCategories()
    {
        return $this->hasMany(CustomerCategory::class);
    }
    
    public function fleetCategories()
    {
        return $this->hasMany(FleetCategory::class);
    }

    public function fleets()
    {
        return $this->hasMany(Fleet::class);
    }
}
