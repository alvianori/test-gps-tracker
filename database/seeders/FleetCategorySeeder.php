<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FleetCategory;

class FleetCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Mobil Operasional', 'description' => 'Mobil untuk operasional sehari-hari'],
            ['name' => 'Truk', 'description' => 'Truk untuk angkutan barang'],
            ['name' => 'Motor', 'description' => 'Motor untuk kebutuhan cepat'],
        ];

        foreach ($categories as $cat) {
            FleetCategory::create($cat);
        }
    }
}
