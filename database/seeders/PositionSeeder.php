<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    public function run(): void
    {
        $positions = [
            // Untuk PT Tracking Indonesia (company_id = 1)
            ['company_id' => 1, 'name' => 'Direktur', 'description' => 'Direktur Perusahaan'],
            ['company_id' => 1, 'name' => 'Manager IT', 'description' => 'Manager Departemen IT'],
            ['company_id' => 1, 'name' => 'Staff IT', 'description' => 'Staff Departemen IT'],
            ['company_id' => 1, 'name' => 'Manager HRD', 'description' => 'Manager Departemen HRD'],
            ['company_id' => 1, 'name' => 'Staff HRD', 'description' => 'Staff Departemen HRD'],
            
            // Untuk PT Logistik Cepat (company_id = 2)
            ['company_id' => 2, 'name' => 'Direktur', 'description' => 'Direktur Perusahaan'],
            ['company_id' => 2, 'name' => 'Manager IT', 'description' => 'Manager Departemen IT'],
            ['company_id' => 2, 'name' => 'Staff IT', 'description' => 'Staff Departemen IT'],
            ['company_id' => 2, 'name' => 'Manager Logistik', 'description' => 'Manager Departemen Logistik'],
            ['company_id' => 2, 'name' => 'Staff Logistik', 'description' => 'Staff Departemen Logistik'],
        ];

        foreach ($positions as $position) {
            Position::create($position);
        }
    }
}