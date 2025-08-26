<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BusinessType;

class BusinessTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            'Manufaktur',
            'Perdagangan',
            'Jasa',
        ];

        foreach ($types as $type) {
            BusinessType::updateOrCreate(['name' => $type]);
        }
    }
}
