<?php

namespace App\Models;

use App\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerCategory extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'description', 'company_id'];
    
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new CompanyScope);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
    
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
