<?php

namespace Modules\Cinemas\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Attributes\UseResource;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Cinemas\Casts\AsCinemaAddress;
use Modules\Cinemas\Database\Factories\CinemaFactory;
use Modules\Cities\Models\City;

// use Modules\Cinemas\Transformers\CinemaTransformer;

// #[UseResource(CinemaTransformer::class)]
#[UseFactory(CinemaFactory::class)]
class Cinema extends Model
{
    /** @use HasFactory<CinemaFactory> */
    use HasFactory, HasUuids, SoftDeletes;

    /**
     * cast fields
     */
    protected function casts(): array
    {
        return [
            'address' => AsCinemaAddress::class,
        ];
    }

    /** attributes */

    /**
     * @return Attribute<\Propaganistas\LaravelPhone\PhoneNumber, void>
     */
    public function phone(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $phone = phone($value);

                if (!$phone->isValid()) {
                    throw new \InvalidArgumentException('Invalid phone number');
                }

                return $phone;
            },
        );
    }

    /** RELATIONS */

    /**
     * @return BelongsTo<City, $this>
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * @return BelongsTo<Cinema, $this>
     */
    public function parentCinema(): BelongsTo
    {
        return $this->belongsTo(self::class);
    }

    /**
     * @return HasMany<Cinema, $this>
     */
    public function cinemas(): HasMany
    {
        return $this->hasMany(self::class);
    }
}
