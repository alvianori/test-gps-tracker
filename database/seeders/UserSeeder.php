<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Superadmin
        $superadmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'username' => 'superadmin',
            'password' => Hash::make('password'),
            'company_id' => 1,
            'department_id' => 1, // IT
            'position_id' => 1, // Direktur
        ]);

        $superadmin->assignRole('super_admin');

        UserDetail::create([
            'user_id' => $superadmin->id,
            'address' => 'Jl. Admin No. 1',
        ]);

        // Admin untuk PT Tracking Indonesia
        $admin1 = User::create([
            'name' => 'Admin Tracking',
            'email' => 'admin@tracking.id',
            'username' => 'admintracking',
            'password' => Hash::make('password'),
            'company_id' => 1,
            'department_id' => 1, // IT
            'position_id' => 2, // Manager IT
        ]);

        $admin1->assignRole('admin');

        UserDetail::create([
            'user_id' => $admin1->id,
            'address' => 'Jl. Manager No. 1',
        ]);

        // Admin untuk PT Logistik Cepat
        $admin2 = User::create([
            'name' => 'Admin Logistik',
            'email' => 'admin@logistikcepat.id',
            'username' => 'adminlogistik',
            'password' => Hash::make('password'),
            'company_id' => 2,
            'department_id' => 5, // IT
            'position_id' => 7, // Manager IT
        ]);

        $admin2->assignRole('admin');

        UserDetail::create([
            'user_id' => $admin2->id,
            'address' => 'Jl. Manager No. 2',
        ]);

        // User biasa untuk PT Tracking Indonesia
        $user1 = User::create([
            'name' => 'User Tracking',
            'email' => 'user@tracking.id',
            'username' => 'usertracking',
            'password' => Hash::make('password'),
            'company_id' => 1,
            'department_id' => 1, // IT
            'position_id' => 3, // Staff IT
        ]);

        $user1->assignRole('user');

        UserDetail::create([
            'user_id' => $user1->id,
            'address' => 'Jl. Staff No. 1',
        ]);

        // User biasa untuk PT Logistik Cepat
        $user2 = User::create([
            'name' => 'User Logistik',
            'email' => 'user@logistikcepat.id',
            'username' => 'userlogistik',
            'password' => Hash::make('password'),
            'company_id' => 2,
            'department_id' => 5, // IT
            'position_id' => 8, // Staff IT
        ]);

        $user2->assignRole('user');

        UserDetail::create([
            'user_id' => $user2->id,
            'address' => 'Jl. Staff No. 2',
        ]);
    }
}
