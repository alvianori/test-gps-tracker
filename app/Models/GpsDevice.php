<?php

namespace App\Models;

use App\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GpsDevice extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'serial_number',
        'model',
        'provider',
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
    
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
