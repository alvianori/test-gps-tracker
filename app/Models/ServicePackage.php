<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicePackage extends Model
{
    protected $fillable = ['name', 'price', 'description', 'status'];
    protected $casts = [
        'price' => 'integer',
    ];

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = (int) str_replace(['.', ','], '', $value);
    }

    public function features()
    {
        return $this->belongsToMany(Feature::class, 'feature_service_package');
    }
    public function companies()
    {
        return $this->hasMany(Company::class, 'service_package_id');
    }
}
