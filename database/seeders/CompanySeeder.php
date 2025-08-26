<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\BusinessType;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        $type1 = BusinessType::where('name', 'Perdagangan')->first();
        $type2 = BusinessType::where('name', 'Jasa')->first();

        Company::create([
            'name' => 'PT Maju Jaya',
            'address' => 'Jl. Sudirman No. 1, Jakarta',
            'phone' => '08129876501',
            'npwp' => '12.345.678.9-012.345',
            'business_type_id' => $type1?->id,
        ]);

        Company::create([
            'name' => 'CV Berkah Abadi',
            'address' => 'Jl. Merdeka No. 99, Bandung',
            'phone' => '08129876502',
            'npwp' => '98.765.432.1-098.765',
            'business_type_id' => $type2?->id,
        ]);
    }
}
