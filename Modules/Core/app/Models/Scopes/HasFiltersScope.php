<?php

declare(strict_types=1);

namespace Modules\Core\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Modules\Core\Filters\ModelFilter;

/**
 * @codeCoverageIgnore
 */
trait HasFiltersScope
{
    /**
     * initialize trait
     */
    public function initializeHasFiltersScope(): void
    {
        //
    }

    /**
     * filter model
     *
     * @param  Builder<$this>  $query
     * @return Builder<$this>
     */
    public function scopeFilter(Builder $query, ModelFilter $filter): Builder
    {
        return $filter->apply($query);
    }
}
