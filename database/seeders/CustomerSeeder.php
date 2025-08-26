<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\CustomerCategory;
use App\Models\Area;
use App\Models\Company;
use Faker\Factory as Faker;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $categories = CustomerCategory::all();
        $areas = Area::all();
        $companies = Company::all();

        for ($i = 0; $i < 20; $i++) {
            Customer::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->phoneNumber,
                'customer_category_id' => $categories->random()->id,
                'area_id' => $areas->random()->id,
                'company_id' => $companies->random()->id,
            ]);
        }
    }
}
