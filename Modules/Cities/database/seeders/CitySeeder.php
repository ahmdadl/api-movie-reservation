<?php

namespace Modules\Cities\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Cities\Models\City;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usCities = [
            [
                'title' => 'New York City',
                'state' => 'NY',
            ],
            [
                'title' => 'Los Angeles',
                'state' => 'CA',
            ],
            [
                'title' => 'Chicago',
                'state' => 'IL',
            ],
            [
                'title' => 'Houston',
                'state' => 'TX',
            ],
            [
                'title' => 'Phoenix',
                'state' => 'AZ',
            ],
            [
                'title' => 'Philadelphia',
                'state' => 'PA',
            ],
            [
                'title' => 'San Antonio',
                'state' => 'TX',
            ],
            [
                'title' => 'San Diego',
                'state' => 'CA',
            ],
            [
                'title' => 'Dallas',
                'state' => 'TX',
            ],
            [
                'title' => 'Jacksonville',
                'state' => 'FL',
            ],
            [
                'title' => 'Fort Worth',
                'state' => 'TX',
            ],
            [
                'title' => 'San Jose',
                'state' => 'CA',
            ],
            [
                'title' => 'Austin',
                'state' => 'TX',
            ],
            [
                'title' => 'Charlotte',
                'state' => 'NC',
            ],
            [
                'title' => 'Columbus',
                'state' => 'OH',
            ],
            [
                'title' => 'Indianapolis',
                'state' => 'IN',
            ],
            [
                'title' => 'San Francisco',
                'state' => 'CA',
            ],
            [
                'title' => 'Seattle',
                'state' => 'WA',
            ],
            [
                'title' => 'Denver',
                'state' => 'CO',
            ],
            [
                'title' => 'Oklahoma City',
                'state' => 'OK',
            ],
            [
                'title' => 'Nashville',
                'state' => 'TN',
            ],
            [
                'title' => 'Washington',
                'state' => 'DC',
            ],
            [
                'title' => 'Las Vegas',
                'state' => 'NV',
            ],
            [
                'title' => 'Boston',
                'state' => 'MA',
            ],
            [
                'title' => 'Portland',
                'state' => 'OR',
            ],
        ];

        City::query()->delete();
        foreach ($usCities as $city) {
            City::query()->create($city);
        }
    }
}
