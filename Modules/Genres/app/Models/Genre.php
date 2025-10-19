<?php

namespace Modules\Genres\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Attributes\UseResource;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Models\Scopes\HasActiveState;
use Spatie\Translatable\HasTranslations;
use Modules\Genres\Database\Factories\GenreFactory;
// use Modules\Genres\Transformers\GenreTransformer;

// #[UseResource(GenreTransformer::class)]
#[UseFactory(GenreFactory::class)]
class Genre extends Model
{
    /** @use HasFactory<GenreFactory> */
    use HasFactory, HasUuids, SoftDeletes, HasActiveState;

    /**
     * cast fields
     */
    // protected function casts(): array
    // {
    //     return [];
    // }

    //
}
