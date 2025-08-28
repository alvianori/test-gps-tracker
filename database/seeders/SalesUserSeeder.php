<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SalesUserSeeder extends Seeder
{
    public function run(): void
    {
        // Sales untuk PT Tracking Indonesia
        $sales1 = User::create([
            'name' => 'Sales Tracking',
            'email' => 'sales@tracking.id',
            'username' => 'salestracking',
            'password' => Hash::make('password'),
            'company_id' => 1,
            'department_id' => 2, // Marketing
            'position_id' => 4, // Staff Marketing
        ]);

        $sales1->assignRole('sales');

        UserDetail::create([
            'user_id' => $sales1->id,
            'address' => 'Jl. Sales No. 1',
        ]);

        // Sales untuk PT Logistik Cepat
        $sales2 = User::create([
            'name' => 'Sales Logistik',
            'email' => 'sales@logistikcepat.id',
            'username' => 'saleslogistik',
            'password' => Hash::make('password'),
            'company_id' => 2,
            'department_id' => 6, // Marketing
            'position_id' => 9, // Staff Marketing
        ]);

        $sales2->assignRole('sales');

        UserDetail::create([
            'user_id' => $sales2->id,
            'address' => 'Jl. Sales No. 2',
        ]);
    }
}