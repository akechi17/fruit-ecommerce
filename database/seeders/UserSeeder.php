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
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'password' => bcrypt('admin'),
            'email_verified_at' => now()
        ]);
    }
}
