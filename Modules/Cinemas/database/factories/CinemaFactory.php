<?php

namespace Modules\Cinemas\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Cinemas\Models\Cinema;
use Modules\Cinemas\ValueObjects\CinemaAddress;
use Modules\Cities\Database\Factories\CityFactory;
use Modules\Cities\Models\City;

/**
 * @extends Factory<Cinema>
 *
 * @mixin Factory<Cinema>
 */
class CinemaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Cinema::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'city_id' => fn() => City::factory(),
            'title' => fake()->company(),
            'address' => CinemaAddress::defaults(),
            'phone' => fn() => fake()->phoneNumber(),
            'email' => fn() => fake()->unique()->safeEmail(),
            'is_active' => true,
        ];
    }
}
