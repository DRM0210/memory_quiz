<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            ['role_id' => 1, 'name' => 'Admin', 'email' => 'admin@gmail.com', 'password' => bcrypt('password'), 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 2, 'name' => 'Vendor', 'email' => 'vendor@gmail.com', 'password' => bcrypt('password'), 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 3, 'name' => 'User', 'email' => 'user@gmail.com', 'password' => bcrypt('password'), 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
