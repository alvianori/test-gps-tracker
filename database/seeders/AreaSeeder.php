<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Area;
use Faker\Factory as Faker;

class AreaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            Area::create([
                'province' => $faker->state,
                'city' => $faker->city,
                'subdistrict' => $faker->citySuffix,
                'postal_code' => $faker->postcode,
                'street_name' => $faker->streetName,
                'house_number' => $faker->buildingNumber,
            ]);
        }
    }
}
