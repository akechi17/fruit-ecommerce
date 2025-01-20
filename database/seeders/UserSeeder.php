<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
Use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Owner',
            'email' => 'owner@gmail.com',
            'role' => 'owner',
            'password' => bcrypt('owner'),
            'email_verified_at' => now()
        ]);
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'password' => bcrypt('admin'),
            'email_verified_at' => now()
        ]);
        User::create([
            'name' => 'Manager',
            'email' => 'manager@gmail.com',
            'role' => 'manager',
            'password' => bcrypt('manager'),
            'email_verified_at' => now()
        ]);
        User::create([
            'name' => 'Kurir',
            'email' => 'kurir@gmail.com',
            'role' => 'kurir',
            'password' => bcrypt('kurir'),
            'email_verified_at' => now()
        ]);
    }
}
