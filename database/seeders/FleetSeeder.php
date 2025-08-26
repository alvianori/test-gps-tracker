<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fleet;
use App\Models\FleetCategory;
use App\Models\Company;
use App\Models\StaffCompany;
use Faker\Factory as Faker;

class FleetSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $categories = FleetCategory::all();
        $companies = Company::all();

        foreach ($categories as $category) {
            foreach ($companies as $company) {
                // Ambil staff yang belum punya fleet di perusahaan ini
                $availableStaffs = StaffCompany::where('company_id', $company->id)
                    ->whereDoesntHave('fleet')
                    ->get();

                // Buat 2 fleet per kategori per company
                for ($i = 0; $i < 2; $i++) {
                    $staff = $availableStaffs->shift(); // ambil staff yang belum punya fleet

                    Fleet::create([
                        'name' => $faker->word . ' ' . $faker->randomNumber(3),
                        'plate_number' => strtoupper($faker->bothify('?? ### ??')),
                        'machine_number' => strtoupper($faker->bothify('##########')),
                        'fleet_category_id' => $category->id,
                        'company_id' => $company->id,
                        'staff_company_id' => $staff?->id, // null jika tidak ada staff tersisa
                    ]);
                }
            }
        }
    }
}
