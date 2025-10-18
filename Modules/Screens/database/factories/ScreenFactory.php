<?php

namespace Modules\Screens\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Cinemas\Models\Cinema;
use Modules\Screens\Models\Screen;

/**
 * @extends Factory<Screen>
 *
 * @mixin Factory<Screen>
 */
class ScreenFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Screen::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'cinema_id' => fn() => Cinema::factory(),
            'title' => fake()->words(2, true),
            'total_seats' => fake()->numberBetween(25, 40),
            'is_active' => true,
            'sort_order' => fake()->numberBetween(1, 100),
        ];
    }
}
