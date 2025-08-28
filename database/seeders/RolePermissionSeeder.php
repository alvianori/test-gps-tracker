<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions for all resources
        $permissions = [
            // BusinessType permissions
            'view_business::type',
            'view_any_business::type',
            'create_business::type',
            'update_business::type',
            'delete_business::type',
            'delete_any_business::type',
            
            // Company permissions
            'view_company',
            'view_any_company',
            'create_company',
            'update_company',
            'delete_company',
            'delete_any_company',
            
            // Department permissions
            'view_department',
            'view_any_department',
            'create_department',
            'update_department',
            'delete_department',
            'delete_any_department',
            
            // Position permissions
            'view_position',
            'view_any_position',
            'create_position',
            'update_position',
            'delete_position',
            'delete_any_position',
            
            // User permissions
            'view_user',
            'view_any_user',
            'create_user',
            'update_user',
            'delete_user',
            'delete_any_user',
            
            // Fleet permissions
            'view_fleet',
            'view_any_fleet',
            'create_fleet',
            'update_fleet',
            'delete_fleet',
            'delete_any_fleet',
            
            // FleetCategory permissions
            'view_fleet::category',
            'view_any_fleet::category',
            'create_fleet::category',
            'update_fleet::category',
            'delete_fleet::category',
            'delete_any_fleet::category',
            
            // Customer permissions
            'view_customer',
            'view_any_customer',
            'create_customer',
            'update_customer',
            'delete_customer',
            'delete_any_customer',
            
            // CustomerCategory permissions
            'view_customer::category',
            'view_any_customer::category',
            'create_customer::category',
            'update_customer::category',
            'delete_customer::category',
            'delete_any_customer::category',
            
            // GpsDevice permissions
            'view_gps::device',
            'view_any_gps::device',
            'create_gps::device',
            'update_gps::device',
            'delete_gps::device',
            'delete_any_gps::device',
            
            // GpsTrack permissions
            'view_gps::track',
            'view_any_gps::track',
            'create_gps::track',
            'update_gps::track',
            'delete_gps::track',
            'delete_any_gps::track',
            
            // Shield permissions
            'view_shield::role',
            'view_any_shield::role',
            'create_shield::role',
            'update_shield::role',
            'delete_shield::role',
            'delete_any_shield::role',
            
            'view_shield::permission',
            'view_any_shield::permission',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        // Super Admin
        $superAdminRole = Role::create(['name' => 'super_admin']);
        $superAdminRole->givePermissionTo(Permission::all());
        
        // Admin
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo([
            'view_any_business::type',
            'view_business::type',
            'view_any_company',
            'view_company',
            'view_any_department',
            'view_department',
            'view_any_position',
            'view_position',
            'view_any_user',
            'view_user',
            'create_user',
            'update_user',
            'view_any_fleet',
            'view_fleet',
            'create_fleet',
            'update_fleet',
            'view_any_fleet::category',
            'view_fleet::category',
            'view_any_customer',
            'view_customer',
            'create_customer',
            'update_customer',
            'view_any_customer::category',
            'view_customer::category',
            'view_any_gps::device',
            'view_gps::device',
            'create_gps::device',
            'update_gps::device',
            'view_any_gps::track',
            'view_gps::track',
        ]);
        
        // User
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo([
            'view_any_fleet',
            'view_fleet',
            'view_any_gps::device',
            'view_gps::device',
            'view_any_gps::track',
            'view_gps::track',
        ]);
    }
}