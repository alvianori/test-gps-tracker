<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CategoryArmada;

class CategoryArmadaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name_category_armada' => 'City Car', 'description' => 'Mobil kecil untuk perkotaan'],
            ['name_category_armada' => 'Hatchback', 'description' => 'Mobil kompak dengan pintu belakang'],
            ['name_category_armada' => 'Sedan', 'description' => 'Mobil penumpang dengan bagasi terpisah'],
            ['name_category_armada' => 'MPV', 'description' => 'Multi Purpose Vehicle untuk keluarga'],
            ['name_category_armada' => 'SUV', 'description' => 'Sport Utility Vehicle untuk segala medan'],
            ['name_category_armada' => 'Pickup', 'description' => 'Mobil bak terbuka untuk angkut barang'],
        ];

        CategoryArmada::insert($data);
    }
}
