<?php

declare(strict_types=1);

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Cities\Database\Seeders\CitySeeder;
use Modules\Users\Database\Seeders\UserSeeder;

final class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        new UserSeeder()->run();
        new CitySeeder()->run();
    }
}
