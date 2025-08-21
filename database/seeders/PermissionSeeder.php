<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan semua permission sudah tergenerate
        if (Permission::count() === 0) {
            $this->command->warn('⚠️ Belum ada permission. Jalankan: php artisan shield:generate --all');
            return;
        }

        // Ambil role
        $superadmin = Role::firstOrCreate(['name' => 'superadmin', 'guard_name' => 'web']);
        $company    = Role::firstOrCreate(['name' => 'company', 'guard_name' => 'web']);
        $sales      = Role::firstOrCreate(['name' => 'sales', 'guard_name' => 'web']);

        // 🔹 1. Superadmin punya semua permission
        $superadmin->syncPermissions(Permission::all());

        // 🔹 2. Company hanya akses customer & armada
        $companyPermissions = Permission::whereIn('name', [
            'view_any_customer', 'view_customer', 'create_customer', 'update_customer', 'delete_customer',
            'view_any_armada', 'view_armada', 'create_armada', 'update_armada', 'delete_armada',
        ])->get();
        $company->syncPermissions($companyPermissions);

        // 🔹 3. Sales hanya akses customer (view & create saja)
        $salesPermissions = Permission::whereIn('name', [
            'view_any_customer', 'view_customer', 'create_customer',
        ])->get();
        $sales->syncPermissions($salesPermissions);

        $this->command->info('✅ PermissionSeeder selesai dijalankan!');
    }
}
