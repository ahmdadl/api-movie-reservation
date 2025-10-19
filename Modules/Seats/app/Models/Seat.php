<?php

namespace Modules\Seats\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Attributes\UseResource;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Core\Models\Scopes\HasActiveState;
use Modules\Core\Models\Scopes\HasSortOrderAttribute;
use Modules\Screens\Models\Screen;
use Modules\Seats\Database\Factories\SeatFactory;
use Modules\Seats\Transformers\SeatTransformer;
use Modules\Seats\Enums\SeatType;

#[UseResource(SeatTransformer::class)]
#[UseFactory(SeatFactory::class)]
class Seat extends Model
{
    /** @use HasFactory<SeatFactory> */
    use HasFactory, HasUuids, HasActiveState, HasSortOrderAttribute;

    /**
     * cast fields
     */
    protected function casts(): array
    {
        return [
            'type' => SeatType::class,
            'row' => 'integer',
            'column' => 'integer',
        ];
    }

    /**
     * @return BelongsTo<Screen, $this>
     */
    public function screen(): BelongsTo
    {
        return $this->belongsTo(Screen::class);
    }
}
