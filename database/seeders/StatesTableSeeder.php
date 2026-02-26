<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatesTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    DB::table('states')->insert([
      ['name' => 'Andhra Pradesh', 'seeder_count' => 500],
      ['name' => 'Arunachal Pradesh', 'seeder_count' => 50],
      ['name' => 'Assam', 'seeder_count' => 200],
      ['name' => 'Bihar', 'seeder_count' => 300],
      ['name' => 'Chhattisgarh', 'seeder_count' => 150],
      ['name' => 'Goa', 'seeder_count' => 50],
      ['name' => 'Gujarat', 'seeder_count' => 400],
      ['name' => 'Haryana', 'seeder_count' => 200],
      ['name' => 'Himachal Pradesh', 'seeder_count' => 100],
      ['name' => 'Jharkhand', 'seeder_count' => 150],
      ['name' => 'Karnataka', 'seeder_count' => 450],
      ['name' => 'Kerala', 'seeder_count' => 300],
      ['name' => 'Madhya Pradesh', 'seeder_count' => 350],
      ['name' => 'Maharashtra', 'seeder_count' => 600],
      ['name' => 'Manipur', 'seeder_count' => 50],
      ['name' => 'Meghalaya', 'seeder_count' => 50],
      ['name' => 'Mizoram', 'seeder_count' => 50],
      ['name' => 'Nagaland', 'seeder_count' => 50],
      ['name' => 'Odisha', 'seeder_count' => 250],
      ['name' => 'Punjab', 'seeder_count' => 200],
      ['name' => 'Rajasthan', 'seeder_count' => 400],
      ['name' => 'Sikkim', 'seeder_count' => 50],
      ['name' => 'Tamil Nadu', 'seeder_count' => 500],
      ['name' => 'Telangana', 'seeder_count' => 300],
      ['name' => 'Tripura', 'seeder_count' => 50],
      ['name' => 'Uttar Pradesh', 'seeder_count' => 600],
      ['name' => 'Uttarakhand', 'seeder_count' => 100],
      ['name' => 'West Bengal', 'seeder_count' => 400],
    ]);
  }
}
