<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehicleClasses = [
            ['name' => 'A', 'min_passengers' => 1, 'max_passengers' => 4],
            ['name' => 'B', 'min_passengers' => 4, 'max_passengers' => 6],
            ['name' => 'C', 'min_passengers' => 7, 'max_passengers' => 14],
            ['name' => 'D', 'min_passengers' => 14, 'max_passengers' => 28],
            ['name' => 'E', 'min_passengers' => 29, 'max_passengers' => 32],
        ];

        DB::table('vehicle_classes')->insert($vehicleClasses);
    }
}