<?php

namespace Database\Seeders;

use App\Models\GpsDevice;
use Illuminate\Database\Seeder;

class GpsDeviceSeeder extends Seeder
{
    public function run(): void
    {
        $devices = [
            // Untuk PT Tracking Indonesia (company_id = 1)
            [
                'name' => 'GPS-TRK-001',
                'serial_number' => 'GPS001-2023',
                'model' => 'GT06N',
                'provider' => 'Concox',
                'company_id' => 1,
            ],
            [
                'name' => 'GPS-BUS-001',
                'serial_number' => 'GPS002-2023',
                'model' => 'TK103B',
                'provider' => 'Coban',
                'company_id' => 1,
            ],
            [
                'name' => 'GPS-CAR-001',
                'serial_number' => 'GPS003-2023',
                'model' => 'GT06E',
                'provider' => 'Concox',
                'company_id' => 1,
            ],
            
            // Untuk PT Logistik Cepat (company_id = 2)
            [
                'name' => 'GPS-TRK-101',
                'serial_number' => 'GPS101-2023',
                'model' => 'TK103B',
                'provider' => 'Coban',
                'company_id' => 2,
            ],
            [
                'name' => 'GPS-MTR-101',
                'serial_number' => 'GPS102-2023',
                'model' => 'GT06N',
                'provider' => 'Concox',
                'company_id' => 2,
            ],
        ];

        foreach ($devices as $device) {
            GpsDevice::create($device);
        }
    }
}