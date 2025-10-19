<?php

namespace Modules\Seats\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Screens\Models\Screen;
use Modules\Seats\Enums\SeatType;
use Modules\Seats\Models\Seat;

/**
 * @extends Factory<Seat>
 *
 * @mixin Factory<Seat>
 */
class SeatFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Seat::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'screen_id' => fn() => Screen::factory(),
            'type' => SeatType::NORMAL,
            'row' => fake()->numberBetween(1, 10),
            'column' => fake()->numberBetween(1, 10),
            'is_active' => true,
            'sort_order' => fake()->numberBetween(1, 100),
        ];
    }
}
