<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Superadmin
        $superadmin = User::create([
            'name' => 'superadmin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('password123'),
        ]);
        $superadmin->assignRole('superadmin');

        // Company
        $company = User::create([
            'name' => 'company',
            'email' => 'company@gmail.com',
            'password' => Hash::make('password123'),
        ]);
        $company->assignRole('company');

        // Sales
        $sales = User::create([
            'name' => 'sales',
            'email' => 'sales@gmail.com',
            'password' => Hash::make('password123'),
        ]);
        $sales->assignRole('sales');
    }
}
