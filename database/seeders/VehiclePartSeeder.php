<?php

namespace Database\Seeders;

use App\Models\VehiclePart;
use App\Models\VehiclePartCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehiclePartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $category = VehiclePartCategory::where('name', 'Engine')->first();

        $part = [
            'name' => 'Engine Oil',
            'sku' => 'ENGOIL001',
            'category_id' => $category->id,
            'brand' => 'Castrol',
            'model_number' => 'SYNTEC',
            'price' => 25.99,
            'quantity' => 100,
            'condition' => 'New',
            'compatibility' => 'All vehicles',
            'notes' => 'High performance oil',
        ];

        VehiclePart::create($part);
    }
}
