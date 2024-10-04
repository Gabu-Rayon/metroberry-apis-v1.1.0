<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * 
     * 
     */
    public function run(): void
    {
        $this->call([RoleAndPermissionSeeder::class]);
        // $this->call([PermissionsGroupSeeder::class]);
        $this->call([UserSeeder::class]);
        $this->call([BillingRatesSeeder::class]);
        $this->call([ServiceTypeSeeder::class]);
        $this->call([ServiceTypeCategorySeeder::class]);
        $this->call([RepairSeeder::class]);
        $this->call([RepairCategorySeeder::class]);
        $this->call([VehiclePartCategorySeeder::class]);
        // $this->call([VehiclePartSeeder::class]);
        $this->call([VehicleClassSeeder::class]);
        $this->call(LanguagesTableSeeder::class);
    }
}
