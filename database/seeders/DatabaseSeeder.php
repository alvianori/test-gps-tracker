<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // Urutan seeder penting untuk menghindari masalah foreign key
            BusinessTypeSeeder::class,
            CompanySeeder::class,
            DepartmentSeeder::class,
            PositionSeeder::class,
            RolePermissionSeeder::class,
            SalesRoleSeeder::class, // Tambahkan role sales
            UserSeeder::class,
            SalesUserSeeder::class, // Tambahkan user dengan role sales
            FleetCategorySeeder::class,
            FleetSeeder::class,
            CustomerCategorySeeder::class,
            CustomerSeeder::class,
            GpsDeviceSeeder::class,
            GpsTrackSeeder::class,
        ]);
    }
}
