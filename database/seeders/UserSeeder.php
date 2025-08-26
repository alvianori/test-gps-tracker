<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan role super_admin sudah ada
        $role = Role::firstOrCreate(['name' => 'super_admin']);

        // Update atau create user superadmin
        $user = User::updateOrCreate(
            ['username' => 'superadmin'], // kolom unik
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@example.com',
                'password' => Hash::make('password'), // ganti di production
            ]
        );

        // Assign role super_admin ke user
        if (!$user->hasRole('super_admin')) {
            $user->assignRole($role);
        }
    }
}
