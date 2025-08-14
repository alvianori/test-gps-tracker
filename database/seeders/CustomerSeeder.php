<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'category_customer_id' => 1,
                'name_customer' => 'Andi Pratama',
                'email' => 'andi@example.com',
                'number' => '081234567890',
                'address' => 'Jl. Mawar No. 1, Jakarta',
                'npwp' => '12.345.678.9-012.345'
            ],
            [
                'category_customer_id' => 2,
                'name_customer' => 'PT Maju Jaya',
                'email' => 'contact@majujaya.com',
                'number' => '0219876543',
                'address' => 'Jl. Melati No. 5, Bandung',
                'npwp' => '98.765.432.1-987.654'
            ],
        ];

        Customer::insert($data);
    }
}
