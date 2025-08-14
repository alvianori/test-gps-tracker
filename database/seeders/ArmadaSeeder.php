<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Armada;

class ArmadaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'category_armada_id' => 1,
                'customer_id' => 1,
                'name_car' => 'Honda Brio',
                'plate_number' => 'B 1234 ABC',
                'color' => 'Kuning',
                'year' => '2020',
                'frame_number' => 'FR1234567890',
                'machine_number' => 'MC1234567890',
                'driver' => 'Budi Santoso',
                'status' => 'Aktif',
                'keterangan' => 'Siap digunakan'
            ],
            [
                'category_armada_id' => 4,
                'customer_id' => 2,
                'name_car' => 'Toyota Avanza',
                'plate_number' => 'D 9876 XYZ',
                'color' => 'Hitam',
                'year' => '2022',
                'frame_number' => 'FR0987654321',
                'machine_number' => 'MC0987654321',
                'driver' => 'Slamet Riyadi',
                'status' => 'Aktif',
                'keterangan' => 'Baru service'
            ],
        ];

        Armada::insert($data);
    }
}
