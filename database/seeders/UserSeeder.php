<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $adminData = [
            'name' => 'MetroBerry Admin',
            'email' => 'admin@metroberry.co.ke',
            'password' => bcrypt('123456'),
            'phone' => '0708373982',
            'address' => 'Nairobi, Kenya',
            'role' => 'admin',
        ];

        $admin = User::create($adminData);

        $admin->assignRole('admin');
    }
}