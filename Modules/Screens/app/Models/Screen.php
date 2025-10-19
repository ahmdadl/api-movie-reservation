<?php

namespace Modules\Screens\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Attributes\UseResource;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Cinemas\Models\Cinema;
use Modules\Core\Models\Scopes\HasActiveState;
use Modules\Core\Models\Scopes\HasSortOrderAttribute;
use Modules\Screens\Database\Factories\ScreenFactory;
use Modules\Screens\Transformers\ScreenTransformer;
use Modules\Seats\Models\Seat;

#[UseFactory(ScreenFactory::class)]
#[UseResource(ScreenTransformer::class)]
class Screen extends Model
{
    /** @use HasFactory<ScreenFactory> */
    use HasFactory, HasUuids, HasActiveState, HasSortOrderAttribute;

    /**
     * @return BelongsTo<Cinema, $this>
     */
    public function cinema(): BelongsTo
    {
        return $this->belongsTo(Cinema::class);
    }

    /**
     * @return HasMany<Seat, $this>
     */
    public function seats(): HasMany
    {
        return $this->hasMany(Seat::class);
    }
}
