<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            // Untuk PT Tracking Indonesia (company_id = 1)
            ['company_id' => 1, 'name' => 'IT', 'description' => 'Departemen Teknologi Informasi'],
            ['company_id' => 1, 'name' => 'HRD', 'description' => 'Departemen Sumber Daya Manusia'],
            ['company_id' => 1, 'name' => 'Finance', 'description' => 'Departemen Keuangan'],
            ['company_id' => 1, 'name' => 'Operations', 'description' => 'Departemen Operasional'],
            
            // Untuk PT Logistik Cepat (company_id = 2)
            ['company_id' => 2, 'name' => 'IT', 'description' => 'Departemen Teknologi Informasi'],
            ['company_id' => 2, 'name' => 'HRD', 'description' => 'Departemen Sumber Daya Manusia'],
            ['company_id' => 2, 'name' => 'Finance', 'description' => 'Departemen Keuangan'],
            ['company_id' => 2, 'name' => 'Logistics', 'description' => 'Departemen Logistik'],
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}