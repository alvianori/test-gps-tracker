<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CategoryCustomer;

class CategoryCustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name_category_customer' => 'Perorangan', 'description' => 'Customer individu'],
            ['name_category_customer' => 'Perusahaan', 'description' => 'Customer perusahaan atau instansi'],
            ['name_category_customer' => 'Pemerintah', 'description' => 'Customer dari instansi pemerintah'],
        ];

        CategoryCustomer::insert($data);
    }
}
