<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        $companies = [
            [
                'name' => 'PT Tracking Indonesia',
                'slug' => Str::slug('PT Tracking Indonesia'),
                'email' => 'info@tracking.id',
                'business_type_id' => 1, // Transportasi
                'address' => 'Jl. Raya Jakarta No. 123, Jakarta Pusat',
                'phone' => '021-12345678',
                'npwp' => '01.234.567.8-123.000'
            ],
            [
                'name' => 'PT Logistik Cepat',
                'slug' => Str::slug('PT Logistik Cepat'),
                'email' => 'info@logistikcepat.id',
                'business_type_id' => 2, // Logistik
                'address' => 'Jl. Raya Bandung No. 456, Bandung',
                'phone' => '022-87654321',
                'npwp' => '02.345.678.9-234.000'
            ],
        ];

        foreach ($companies as $company) {
            Company::create($company);
        }
    }
}