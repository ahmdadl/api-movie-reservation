<?php

namespace Modules\Genres\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Genres\Models\Genre;

/**
 * @extends Factory<Genre>
 *
 * @mixin Factory<Genre>
 */
class GenreFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Genre::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => fake()->words(2, true),
            'is_active' => true,
        ];
    }
}
