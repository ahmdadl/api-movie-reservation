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
                'city' => 'New York City',
                'state' => 'NY',
            ],
            [
                'city' => 'Los Angeles',
                'state' => 'CA',
            ],
            [
                'city' => 'Chicago',
                'state' => 'IL',
            ],
            [
                'city' => 'Houston',
                'state' => 'TX',
            ],
            [
                'city' => 'Phoenix',
                'state' => 'AZ',
            ],
            [
                'city' => 'Philadelphia',
                'state' => 'PA',
            ],
            [
                'city' => 'San Antonio',
                'state' => 'TX',
            ],
            [
                'city' => 'San Diego',
                'state' => 'CA',
            ],
            [
                'city' => 'Dallas',
                'state' => 'TX',
            ],
            [
                'city' => 'Jacksonville',
                'state' => 'FL',
            ],
            [
                'city' => 'Fort Worth',
                'state' => 'TX',
            ],
            [
                'city' => 'San Jose',
                'state' => 'CA',
            ],
            [
                'city' => 'Austin',
                'state' => 'TX',
            ],
            [
                'city' => 'Charlotte',
                'state' => 'NC',
            ],
            [
                'city' => 'Columbus',
                'state' => 'OH',
            ],
            [
                'city' => 'Indianapolis',
                'state' => 'IN',
            ],
            [
                'city' => 'San Francisco',
                'state' => 'CA',
            ],
            [
                'city' => 'Seattle',
                'state' => 'WA',
            ],
            [
                'city' => 'Denver',
                'state' => 'CO',
            ],
            [
                'city' => 'Oklahoma City',
                'state' => 'OK',
            ],
            [
                'city' => 'Nashville',
                'state' => 'TN',
            ],
            [
                'city' => 'Washington',
                'state' => 'DC',
            ],
            [
                'city' => 'Las Vegas',
                'state' => 'NV',
            ],
            [
                'city' => 'Boston',
                'state' => 'MA',
            ],
            [
                'city' => 'Portland',
                'state' => 'OR',
            ],
        ];

        City::query()->delete();
        City::query()->insert($usCities);
    }
}
