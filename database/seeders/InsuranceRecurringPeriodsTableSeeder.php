<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InsuranceRecurringPeriodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('insurance_recurring_periods')->insert([
            [
                'period' => 'Monthly',
                'description' => 'Recurring every month',
                'status' => true,
                'created_by' => 1, // Assuming user ID 1 exists
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'period' => 'Quarterly',
                'description' => 'Recurring every three months',
                'status' => true,
                'created_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'period' => 'Annually',
                'description' => 'Recurring every year',
                'status' => true,
                'created_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}