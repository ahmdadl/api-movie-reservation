<?php

declare(strict_types=1);

namespace Modules\Users\ValueObjects;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

final class UserTotals implements CastsAttributes
{
    public function __construct(
        public int $bookings = 0,
        public float $spent = 0,
        public int $movies = 0,
        public int $cinemas = 0,
    ) {}

    /**
     * Helper to create a Totals instance easily.
     */
    public static function make(
        int $bookings = 0,
        float $spent = 0,
        int $movies = 0,
        int $cinemas = 0,
    ): self {
        return new self($bookings, $spent, $movies, $cinemas);
    }

    /**
     * Convert the stored value (JSON) into a UserTotals instance.
     */
    public function get($model, string $key, $value, array $attributes): self
    {
        $data = json_decode($value ?: '{}', true);

        return new self(
            bookings: $data['bookings'] ?? 0,
            spent: $data['spent'] ?? 0,
            movies: $data['movies'] ?? 0,
            cinemas: $data['cinemas'] ?? 0,
        );
    }

    /**
     * Convert the Totals object back into JSON for storage.
     */
    public function set($model, string $key, $value, array $attributes): string
    {
        if ($value instanceof self) {
            $value = [
                'bookings' => $value->bookings,
                'spent' => $value->spent,
                'movies' => $value->movies,
                'cinemas' => $value->cinemas,
            ];
        }

        return json_encode($value);
    }

    public function toArray(): array
    {
        return [
            'bookings' => $this->bookings,
            'spent' => $this->spent,
            'movies' => $this->movies,
            'cinemas' => $this->cinemas,
        ];
    }
}
