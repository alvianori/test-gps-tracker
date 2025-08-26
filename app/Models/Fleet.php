<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fleet extends Model
{
    protected $fillable = [
        'name',
        'plate_number',
        'machine_number',
        'fleet_category_id',
        'staff_company_id',
        'company_id'
    ];

    public function category()
    {
        return $this->belongsTo(FleetCategory::class, 'fleet_category_id');
    }

    public function staff()
    {
        return $this->belongsTo(StaffCompany::class, 'staff_company_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
