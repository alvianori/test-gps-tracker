<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Company;
use App\Models\StaffPosition;
use App\Models\StaffCompany;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class StaffCompanySeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan role shield tersedia
        $adminRole = Role::firstOrCreate(['name' => 'admin_company']);
        $salesRole = Role::firstOrCreate(['name' => 'sales']);

        $adminPosition = StaffPosition::firstOrCreate(['name' => 'admin_company']);
        $salesPosition = StaffPosition::firstOrCreate(['name' => 'sales']);

        $companies = Company::all();

        foreach ($companies as $company) {
            // Seeder untuk Admin Company
            $adminUser = User::updateOrCreate(
                ['email' => 'admin@' . strtolower(str_replace(' ', '', $company->name)) . '.com'],
                [
                    'name' => 'Admin ' . $company->name,
                    'username' => strtolower(str_replace(' ', '', $company->name)) . '_admin',
                    'password' => Hash::make('password'),
                ]
            );

            StaffCompany::updateOrCreate(
                [
                    'user_id' => $adminUser->id,
                    'company_id' => $company->id,
                ],
                [
                    'staff_position_id' => $adminPosition->id,
                    'phone' => '08123456789',
                    'address' => 'Alamat ' . $company->name,
                ]
            );

            // Tambahkan role Shield
            $adminUser->syncRoles([$adminRole]);

            // Seeder untuk Sales
            $salesUser = User::updateOrCreate(
                ['email' => 'sales@' . strtolower(str_replace(' ', '', $company->name)) . '.com'],
                [
                    'name' => 'Sales ' . $company->name,
                    'username' => strtolower(str_replace(' ', '', $company->name)) . '_sales',
                    'password' => Hash::make('password'),
                ]
            );

            StaffCompany::updateOrCreate(
                [
                    'user_id' => $salesUser->id,
                    'company_id' => $company->id,
                ],
                [
                    'staff_position_id' => $salesPosition->id,
                    'phone' => '08129876543',
                    'address' => 'Alamat ' . $company->name,
                ]
            );

            // Tambahkan role Shield
            $salesUser->syncRoles([$salesRole]);
        }
    }
}
