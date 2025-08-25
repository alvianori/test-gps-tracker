<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Company;
use App\Models\Sale;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // --- Superadmin ---
        $superadmin = User::create([
            'name' => 'superadmin',
            'username' => 'superadmin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('password123'),
        ]);
        $superadmin->assignRole('superadmin');

        // --- Company & User Admin ---
        $company = Company::create([
            'name' => 'PT Contoh Jaya',
            'email' => 'company@gmail.com',
            'telepon' => '08123456789',
            'address' => 'Jl. Raya No. 123',
        ]);

        $companyUser = User::create([
            'name' => 'Company Admin',
            'username' => 'company1',
            'email' => 'company1@gmail.com',
            'password' => Hash::make('password123'),
            'company_id' => $company->id,
        ]);
        $companyUser->assignRole('company');

        // --- Sales & User Sales ---
        $sales = Sale::create([
            'company_id' => $company->id,
            'sales_name' => 'Sales Satu',
            'role' => 'sales',
            'telepon' => '081298765432',
            'status' => 'aktif',
        ]);

        $salesUser = User::create([
            'name' => 'Sales User',
            'username' => 'sales1',
            'email' => 'sales1@gmail.com',
            'password' => Hash::make('password123'),
            'sales_id' => $sales->id,
        ]);
        $salesUser->assignRole('sales');
    }
}
