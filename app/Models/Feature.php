<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $fillable = ['name', 'description'];

    public function servicePackages()
    {
        return $this->belongsToMany(ServicePackage::class, 'feature_service_package')
                    ->withTimestamps();
    }
}
