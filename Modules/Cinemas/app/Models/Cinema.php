<?php

namespace Modules\Cinemas\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Attributes\UseResource;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
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
        return [];
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
