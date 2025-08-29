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
                'name' => 'Atalanta',
                'code' => 'ATL001',
                'provider' => '+6281234567890',
                'company_id' => 1,
            ],
            [
                'name' => 'Poseidon',
                'code' => 'PSD001',
                'provider' => '+6281234567891',
                'company_id' => 1,
            ],
            [
                'name' => 'Hermes',
                'code' => 'HRM001',
                'provider' => '+6281234567892',
                'company_id' => 1,
            ],
            
            // Untuk PT Logistik Cepat (company_id = 2)
            [
                'name' => 'Zeus',
                'code' => 'ZS001',
                'provider' => '+6281234567893',
                'company_id' => 2,
            ],
            [
                'name' => 'Apollo',
                'code' => 'APL001',
                'provider' => '+6281234567894',
                'company_id' => 2,
            ],
        ];

        foreach ($devices as $device) {
            GpsDevice::create($device);
        }
    }
}