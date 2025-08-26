<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            BusinessTypeSeeder::class,
            CompanySeeder::class,
            StaffPositionSeeder::class,
            UserSeeder::class,
            StaffCompanySeeder::class,
            CustomerCategorySeeder::class,
            AreaSeeder::class,
            CustomerSeeder::class,
            FleetCategorySeeder::class,
            FleetSeeder::class,
        ]);
    }
}
