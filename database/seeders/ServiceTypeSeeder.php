<?php

namespace Database\Seeders;

use App\Models\ServiceType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void{
        ServiceType::firstOrCreate([
            'name' => 'Major Service',
            'description' => 'A major service is a comprehensive service that covers all areas of essential maintenance.'
        ]);

        ServiceType::firstOrCreate([
            'name' => 'Minor Service',
            'description' => 'A minor service is a basic service that covers all areas of essential maintenance.'
        ]);
    }
}
