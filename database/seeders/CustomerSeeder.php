<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            // Untuk PT Tracking Indonesia (company_id = 1)
            [
                'name' => 'PT Maju Bersama',
                'email' => 'info@majubersama.com',
                'phone' => '021-5551234',
                'address' => 'Jl. Raya Maju No. 123, Jakarta',
                'customer_category_id' => 1, // Perusahaan
                'company_id' => 1,
            ],
            [
                'name' => 'Dinas Perhubungan DKI Jakarta',
                'email' => 'dishub@jakarta.go.id',
                'phone' => '021-5552345',
                'address' => 'Jl. Raya Pemerintah No. 456, Jakarta',
                'customer_category_id' => 3, // Pemerintah
                'company_id' => 1,
            ],
            
            // Untuk PT Logistik Cepat (company_id = 2)
            [
                'name' => 'PT Sukses Selalu',
                'email' => 'info@suksesselalu.com',
                'phone' => '021-5553456',
                'address' => 'Jl. Raya Sukses No. 789, Jakarta',
                'customer_category_id' => 1, // Perusahaan
                'company_id' => 2,
            ],
            [
                'name' => 'PT Pertamina',
                'email' => 'info@pertamina.co.id',
                'phone' => '021-5554567',
                'address' => 'Jl. Raya BUMN No. 101, Jakarta',
                'customer_category_id' => 4, // BUMN
                'company_id' => 2,
            ],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}