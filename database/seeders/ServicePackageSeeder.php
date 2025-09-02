<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServicePackage;
use App\Models\Feature;

class ServicePackageSeeder extends Seeder
{
    public function run(): void
    {
        $basic = ServicePackage::create([
            'name' => 'Paket Basic',
            'price' => 50000,
            'description' => 'Servis ringan dan pengecekan standar',
            'status' => true,
        ]);

        $premium = ServicePackage::create([
            'name' => 'Paket Premium',
            'price' => 120000,
            'description' => 'Servis lengkap termasuk oli & garansi',
            'status' => true,
        ]);

        // Hubungkan fitur dengan paket
        $basic->features()->attach([1]);        // Gratis Cuci Motor
        $premium->features()->attach([1, 2, 3]); // Semua fitur
    }
}
