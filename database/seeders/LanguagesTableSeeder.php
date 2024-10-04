<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguagesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('languages')->insert([
            ['id' => 1, 'code' => 'ar', 'full_name' => 'Arabic', 'created_at' => '2024-06-08 05:56:25', 'updated_at' => '2024-06-08 05:56:25'],
            ['id' => 2, 'code' => 'zh', 'full_name' => 'Chinese', 'created_at' => '2024-06-08 05:56:25', 'updated_at' => '2024-06-08 05:56:25'],
            ['id' => 3, 'code' => 'da', 'full_name' => 'Danish', 'created_at' => '2024-06-08 05:56:25', 'updated_at' => '2024-06-08 05:56:25'],
            ['id' => 4, 'code' => 'de', 'full_name' => 'German', 'created_at' => '2024-06-08 05:56:25', 'updated_at' => '2024-06-08 05:56:25'],
            ['id' => 5, 'code' => 'en', 'full_name' => 'English', 'created_at' => '2024-06-08 05:56:25', 'updated_at' => '2024-06-08 05:56:25'],
            ['id' => 6, 'code' => 'es', 'full_name' => 'Spanish', 'created_at' => '2024-06-08 05:56:25', 'updated_at' => '2024-06-08 05:56:25'],
            ['id' => 7, 'code' => 'fr', 'full_name' => 'French', 'created_at' => '2024-06-08 05:56:25', 'updated_at' => '2024-06-08 05:56:25'],
            ['id' => 8, 'code' => 'he', 'full_name' => 'Hebrew', 'created_at' => '2024-06-08 05:56:25', 'updated_at' => '2024-06-08 05:56:25'],
            ['id' => 9, 'code' => 'it', 'full_name' => 'Italian', 'created_at' => '2024-06-08 05:56:25', 'updated_at' => '2024-06-08 05:56:25'],
            ['id' => 10, 'code' => 'ja', 'full_name' => 'Japanese', 'created_at' => '2024-06-08 05:56:25', 'updated_at' => '2024-06-08 05:56:25'],
            ['id' => 11, 'code' => 'nl', 'full_name' => 'Dutch', 'created_at' => '2024-06-08 05:56:25', 'updated_at' => '2024-06-08 05:56:25'],
            ['id' => 12, 'code' => 'pl', 'full_name' => 'Polish', 'created_at' => '2024-06-08 05:56:25', 'updated_at' => '2024-06-08 05:56:25'],
            ['id' => 13, 'code' => 'pt', 'full_name' => 'Portuguese', 'created_at' => '2024-06-08 05:56:25', 'updated_at' => '2024-06-08 05:56:25'],
            ['id' => 14, 'code' => 'ru', 'full_name' => 'Russian', 'created_at' => '2024-06-08 05:56:25', 'updated_at' => '2024-06-08 05:56:25'],
            ['id' => 15, 'code' => 'tr', 'full_name' => 'Turkish', 'created_at' => '2024-06-08 05:56:25', 'updated_at' => '2024-06-08 05:56:25'],
            ['id' => 16, 'code' => 'pt-br', 'full_name' => 'Portuguese (Brazil)', 'created_at' => '2024-06-08 05:56:25', 'updated_at' => '2024-06-08 05:56:25'],
        ]);
    }
}
