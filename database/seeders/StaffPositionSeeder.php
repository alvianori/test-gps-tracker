<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StaffPosition;

class StaffPositionSeeder extends Seeder
{
    public function run(): void
    {
        $positions = [
            'admin_company',
            'sales',
        ];

        foreach ($positions as $position) {
            StaffPosition::updateOrCreate(['name' => $position]);
        }
    }
}
