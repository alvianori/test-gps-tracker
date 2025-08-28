<?php

namespace Database\Seeders;

use App\Models\BusinessType;
use Illuminate\Database\Seeder;

class BusinessTypeSeeder extends Seeder
{
    public function run(): void
    {
        $businessTypes = [
            ['name' => 'Transportasi', 'description' => 'Perusahaan yang bergerak di bidang transportasi'],
            ['name' => 'Logistik', 'description' => 'Perusahaan yang bergerak di bidang logistik'],
            ['name' => 'Manufaktur', 'description' => 'Perusahaan yang bergerak di bidang manufaktur'],
            ['name' => 'Pertambangan', 'description' => 'Perusahaan yang bergerak di bidang pertambangan'],
            ['name' => 'Konstruksi', 'description' => 'Perusahaan yang bergerak di bidang konstruksi'],
        ];

        foreach ($businessTypes as $businessType) {
            BusinessType::create($businessType);
        }
    }
}