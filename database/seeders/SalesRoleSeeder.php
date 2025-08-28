<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SalesRoleSeeder extends Seeder
{
    public function run(): void
    {
        // Create Sales role
        $salesRole = Role::create(['name' => 'sales']);
        
        // Assign permissions to Sales role
        $salesRole->givePermissionTo([
            // Customer permissions - full access
            'view_any_customer',
            'view_customer',
            'create_customer',
            'update_customer',
            
            // CustomerCategory permissions - view only
            'view_any_customer::category',
            'view_customer::category',
            
            // Fleet permissions - view only
            'view_any_fleet',
            'view_fleet',
            
            // GPS Device permissions - view only
            'view_any_gps::device',
            'view_gps::device',
            
            // GPS Track permissions - view only
            'view_any_gps::track',
            'view_gps::track',
        ]);
    }
}