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
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('password123'),
        ]);

        // Company
        User::create([
            'name' => 'Company User',
            'email' => 'company@gmail.com',
            'password' => Hash::make('password123'),
        ]);

        // Sales
        User::create([
            'name' => 'Sales User',
            'email' => 'sales@gmail.com',
            'password' => Hash::make('password123'),
        ]);
    }
}
