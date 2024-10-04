<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BillingRatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('billing_rates')->insert([
            [
                'name' => 'Standard Rate',
                'rate_per_km' => 10.00,
                'rate_per_minute' => 1.50,
                'rate_by_car_class' => json_encode([
                    'A' => 500,
                    'B' => 700,
                    'C' => 1000
                ]),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Premium Rate',
                'rate_per_km' => 15.00,
                'rate_per_minute' => 2.00,
                'rate_by_car_class' => json_encode([
                    'A' => 600,
                    'B' => 800,
                    'C' => 1200
                ]),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
