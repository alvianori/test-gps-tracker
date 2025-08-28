<?php

namespace Database\Seeders;

use App\Models\FleetCategory;
use Illuminate\Database\Seeder;

class FleetCategorySeeder extends Seeder
{
    public function run(): void
    {
        // Kategori untuk PT Tracking Indonesia (company_id = 1)
        $categoriesCompany1 = [
            ['name' => 'Truk', 'description' => 'Kendaraan angkutan barang', 'company_id' => 1],
            ['name' => 'Bus', 'description' => 'Kendaraan angkutan penumpang', 'company_id' => 1],
            ['name' => 'Mobil', 'description' => 'Kendaraan operasional', 'company_id' => 1],
            ['name' => 'Motor', 'description' => 'Kendaraan operasional roda dua', 'company_id' => 1],
            ['name' => 'Alat Berat', 'description' => 'Kendaraan konstruksi dan pertambangan', 'company_id' => 1],
        ];
        
        // Kategori untuk PT Logistik Cepat (company_id = 2)
        $categoriesCompany2 = [
            ['name' => 'Truk', 'description' => 'Kendaraan angkutan barang', 'company_id' => 2],
            ['name' => 'Bus', 'description' => 'Kendaraan angkutan penumpang', 'company_id' => 2],
            ['name' => 'Mobil', 'description' => 'Kendaraan operasional', 'company_id' => 2],
            ['name' => 'Motor', 'description' => 'Kendaraan operasional roda dua', 'company_id' => 2],
            ['name' => 'Alat Berat', 'description' => 'Kendaraan konstruksi dan pertambangan', 'company_id' => 2],
        ];

        foreach ($categoriesCompany1 as $category) {
            FleetCategory::create($category);
        }
        
        foreach ($categoriesCompany2 as $category) {
            FleetCategory::create($category);
        }
    }
}