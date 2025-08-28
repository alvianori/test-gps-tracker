<?php

namespace Database\Seeders;

use App\Models\Fleet;
use Illuminate\Database\Seeder;

class FleetSeeder extends Seeder
{
    public function run(): void
    {
        $fleets = [
            // Untuk PT Tracking Indonesia (company_id = 1)
            [
                'name' => 'Truk Fuso 01',
                'plate_number' => 'B 1234 ABC',
                'machine_number' => 'FE74P-123456',
                'fleet_category_id' => 1, // Truk
                'company_id' => 1
            ],
            [
                'name' => 'Bus Pariwisata 01',
                'plate_number' => 'B 2345 BCD',
                'machine_number' => 'FE74P-234567',
                'fleet_category_id' => 2, // Bus
                'company_id' => 1
            ],
            [
                'name' => 'Mobil Operasional 01',
                'plate_number' => 'B 3456 CDE',
                'machine_number' => 'FE74P-345678',
                'fleet_category_id' => 3, // Mobil
                'company_id' => 1
            ],
            
            // Untuk PT Logistik Cepat (company_id = 2)
            [
                'name' => 'Truk Box 01',
                'plate_number' => 'B 4567 DEF',
                'machine_number' => 'FE74P-456789',
                'fleet_category_id' => 1, // Truk
                'company_id' => 2
            ],
            [
                'name' => 'Motor Kurir 01',
                'plate_number' => 'B 5678 EFG',
                'machine_number' => 'FE74P-567890',
                'fleet_category_id' => 4, // Motor
                'company_id' => 2
            ],
        ];

        foreach ($fleets as $fleet) {
            Fleet::create($fleet);
        }
    }
}