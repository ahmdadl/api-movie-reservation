<?php

namespace Modules\Cities\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Attributes\UseResource;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Cities\Database\Factories\CityFactory;
use Modules\Cities\Transformers\CityTransformer;
use Modules\Core\Models\Scopes\HasActiveState;

#[UseResource(CityTransformer::class)]
#[UseFactory(CityFactory::class)]
class City extends Model
{
    /** @use HasFactory<CityFactory> */
    use HasFactory, HasUuids, HasActiveState, SoftDeletes;
}
