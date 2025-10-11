<?php

namespace Modules\Cities\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Cities\Models\City;

/**
 * @extends Factory<City>
 *
 * @mixin Factory<City>
 */
class CityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = City::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence,
            'is_active' => true,
        ];
    }
}
