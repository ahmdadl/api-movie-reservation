<?php

declare(strict_types=1);

namespace Modules\Users\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Modules\Users\ValueObjects\UserTotals;
use Modules\Users\Enums\UserRole;

final class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Users\Models\User::class;

    /**
     * The current password being used by the factory.
     */
    private static ?string $password = null;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => (self::$password ??= Hash::make('password')),
            'remember_token' => Str::random(10),
            'role' => UserRole::USER->value,
            'totals' => UserTotals::make()->toArray(),
            'phone' => fake()->phoneNumber(),
            'is_active' => true,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): self
    {
        return $this->state(
            fn(array $attributes): array => [
                'email_verified_at' => null,
            ],
        );
    }

    public function admin(): self
    {
        return $this->state(
            fn(array $attributes): array => [
                'role' => UserRole::ADMIN->value,
            ],
        );
    }

    public function guest(): self
    {
        return $this->state(
            fn(array $attributes): array => [
                'role' => UserRole::GUEST->value,
            ],
        );
    }
}
