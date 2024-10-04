<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $admin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => bcrypt('123456'),
            'phone' => '0755366089',
            'address' => 'Nairobi, Kenya',
            'avatar' => 'superadmin.png',
            'role' => 'admin'
        ]);

        $admin->assignRole($admin->role);
    }
}
