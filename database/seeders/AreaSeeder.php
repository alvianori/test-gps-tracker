<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Area;
use App\Models\Company;
use App\Models\User;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $company = Company::first();
        $user = User::first();

        $areas = [
            ['name' => 'Semarang Barat', 'description' => 'Wilayah kecamatan Semarang Barat'],
            ['name' => 'Semarang Timur', 'description' => 'Wilayah kecamatan Semarang Timur'],
            ['name' => 'Semarang Tengah', 'description' => 'Wilayah kecamatan Semarang Tengah'],
            ['name' => 'Semarang Utara', 'description' => 'Wilayah kecamatan Semarang Utara'],
            ['name' => 'Semarang Selatan', 'description' => 'Wilayah kecamatan Semarang Selatan'],
            ['name' => 'Tembalang', 'description' => 'Wilayah kecamatan Tembalang'],
            ['name' => 'Pedurungan', 'description' => 'Wilayah kecamatan Pedurungan'],
            ['name' => 'Genuk', 'description' => 'Wilayah kecamatan Genuk'],
            ['name' => 'Banyumanik', 'description' => 'Wilayah kecamatan Banyumanik'],
            ['name' => 'Gunungpati', 'description' => 'Wilayah kecamatan Gunungpati'],
        ];

        foreach ($areas as $area) {
            Area::create([
                'companies_id' => $company?->id,
                'users_id' => $user?->id,
                'name' => $area['name'],
                'description' => $area['description'],
            ]);
        }
    }
}
