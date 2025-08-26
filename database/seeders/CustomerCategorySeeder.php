<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CustomerCategory;

class CustomerCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Retail', 'description' => 'Pelanggan retail biasa'],
            ['name' => 'Wholesale', 'description' => 'Pelanggan grosir besar'],
            ['name' => 'VIP', 'description' => 'Pelanggan prioritas tinggi'],
        ];

        foreach ($categories as $cat) {
            CustomerCategory::create($cat);
        }
    }
}
