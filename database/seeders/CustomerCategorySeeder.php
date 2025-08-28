<?php

namespace Database\Seeders;

use App\Models\CustomerCategory;
use Illuminate\Database\Seeder;

class CustomerCategorySeeder extends Seeder
{
    public function run(): void
    {
        // Kategori untuk PT Tracking Indonesia (company_id = 1)
        $categoriesCompany1 = [
            ['name' => 'Perusahaan', 'description' => 'Pelanggan berbentuk perusahaan', 'company_id' => 1],
            ['name' => 'Perorangan', 'description' => 'Pelanggan perorangan', 'company_id' => 1],
            ['name' => 'Pemerintah', 'description' => 'Instansi pemerintah', 'company_id' => 1],
            ['name' => 'BUMN', 'description' => 'Badan Usaha Milik Negara', 'company_id' => 1],
            ['name' => 'Lainnya', 'description' => 'Kategori lainnya', 'company_id' => 1],
        ];
        
        // Kategori untuk PT Logistik Cepat (company_id = 2)
        $categoriesCompany2 = [
            ['name' => 'Perusahaan', 'description' => 'Pelanggan berbentuk perusahaan', 'company_id' => 2],
            ['name' => 'Perorangan', 'description' => 'Pelanggan perorangan', 'company_id' => 2],
            ['name' => 'Pemerintah', 'description' => 'Instansi pemerintah', 'company_id' => 2],
            ['name' => 'BUMN', 'description' => 'Badan Usaha Milik Negara', 'company_id' => 2],
            ['name' => 'Lainnya', 'description' => 'Kategori lainnya', 'company_id' => 2],
        ];

        foreach ($categoriesCompany1 as $category) {
            CustomerCategory::create($category);
        }
        
        foreach ($categoriesCompany2 as $category) {
            CustomerCategory::create($category);
        }
    }
}