<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FuelTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Disable foreign key checks
        Schema::disableForeignKeyConstraints();

        // Truncate the table before seeding
        DB::table('fuel_types')->truncate();

        // Re-enable foreign key checks
        Schema::enableForeignKeyConstraints();

        $fuelTypes = [
            'Petrol',
            'Diesel',
            'Electric',
            'Hybrid',
            'CNG (Compressed Natural Gas)',
            'LPG (Liquefied Petroleum Gas)',
            'Ethanol',
            'Bio-diesel',
            'Hydrogen',
            'Methanol',
            'Propane'
        ];

        foreach ($fuelTypes as $fuelType) {
            DB::table('fuel_types')->insert([
                'name' => $fuelType,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}