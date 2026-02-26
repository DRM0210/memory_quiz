<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\State;
use Illuminate\Database\Seeder;

class StateCitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $states = [
            ['name' => 'Rajasthan', 'status' => 1],
            ['name' => 'Maharashtra', 'status' => 1],
            ['name' => 'Karnataka', 'status' => 1],
            ['name' => 'Tamil Nadu', 'status' => 1],
            ['name' => 'Gujarat', 'status' => 1],
        ];

        $citiesByState = [
            'Rajasthan' => ['Kota', 'Jaipur', 'Udaipur', 'Jodhpur'],
            'Maharashtra' => ['Mumbai', 'Pune', 'Nagpur', 'Nashik'],
            'Karnataka' => ['Bengaluru', 'Mysuru', 'Mangaluru', 'Hubballi'],
            'Tamil Nadu' => ['Chennai', 'Coimbatore', 'Madurai', 'Tiruchirappalli'],
            'Gujarat' => ['Ahmedabad', 'Surat', 'Vadodara', 'Rajkot'],
        ];

        foreach ($states as $stateRow) {
            $state = State::firstOrCreate(
                ['name' => $stateRow['name']],
                ['status' => $stateRow['status']]
            );
            $cityNames = $citiesByState[$stateRow['name']] ?? [];
            foreach ($cityNames as $cityName) {
                City::firstOrCreate(
                    ['state_id' => $state->id, 'city_name' => $cityName],
                    ['status' => 1]
                );
            }
        }
    }
}
