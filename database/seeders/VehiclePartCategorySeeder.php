<?php

namespace Database\Seeders;

use App\Models\VehiclePartCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehiclePartCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $categories = [
            ['name' => 'Engine', 'description' => 'Engine parts'],
            ['name' => 'Transmission', 'description' => 'Transmission parts'],
            ['name' => 'Suspension', 'description' => 'Suspension parts'],
            ['name' => 'Brakes', 'description' => 'Brake parts'],
            ['name' => 'Exhaust', 'description' => 'Exhaust parts'],
            ['name' => 'Electrical', 'description' => 'Electrical parts'],
            ['name' => 'Interior', 'description' => 'Interior parts'],
            ['name' => 'Exterior', 'description' => 'Exterior parts'],
            ['name' => 'Wheels', 'description' => 'Wheel parts'],
            ['name' => 'Tires', 'description' => 'Tire parts'],
        ];

        foreach ($categories as $category) {
            VehiclePartCategory::create($category);
        }
    }
}
