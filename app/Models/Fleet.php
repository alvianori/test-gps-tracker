<?php

namespace App\Models;

use App\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fleet extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'plate_number',
        'machine_number',
        'fleet_category_id',
        'company_id'
    ];
    
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new CompanyScope);
    }

    public function category()
    {
        return $this->belongsTo(FleetCategory::class, 'fleet_category_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function fleetUsers()
    {
        return $this->hasMany(FleetUser::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, FleetUser::class);
    }
}
