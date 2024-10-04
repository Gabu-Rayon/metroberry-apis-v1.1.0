<?php

namespace Database\Seeders;

use App\Models\Repair;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RepairSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void{
        $repairs = [
            [
                'name' => 'Electrical',
                'description' => 'Electrical Repair',
            ],
            [
                'name' => 'Mechanical',
                'description' => 'Mechanical Repair',
            ],
        ];

        foreach ($repairs as $repair) {
            Repair::create($repair);
        }
    }
}
