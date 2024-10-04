<?php

namespace Database\Seeders;

use App\Models\ServiceType;
use App\Models\ServiceTypeCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceTypeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $minor_services = [
            'Engine Oil',
            'Gearbox Oil',
            'Air Cleaner',
            'Oil Filter',
            'Air Filter',
            'Wiper',
            'Engine Coolant',
            'Brakes and Linings',
        ];

        $major_services = [
            'Engine Oil',
            'Gear Box Oil',
            'Air Cleaner',
            'Oil Filter',
            'Air Filter',
            'Wiper',
            'Engine Coolant',
            'Alternator',
            'Starter',
            'Battery',
            'Tyres',
            'Timing Chain',
            'Pulley Belt',
            'Spare Tyre',
            'Jack Wheel Spanner',
            'Head Lamps',
            'Parking Warning Lights',
            'Brakes and Linings',
            'Suspension Parts',
        ];

        $majorService = ServiceType::where('name', 'Major Service')->first();
        $minorService = ServiceType::where('name', 'Minor Service')->first();

        foreach ($minor_services as $service) {
            ServiceTypeCategory::create([
                'service_type_id' => $minorService->id,
                'name' => $service,
                'description' => 'This is a Minor service for ' . $service,
            ]);
        }

        foreach ($major_services as $service) {
            ServiceTypeCategory::create([
                'service_type_id' => $majorService->id,
                'name' => $service,
                'description' => 'This is a Major Service for ' . $service,
            ]);
        }
    }
}
