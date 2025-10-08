<?php

declare(strict_types=1);

namespace Modules\Core\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * @codeCoverageIgnore
 */
trait PaginateIfRequestedScope
{
    /**
     * initialize trait
     */
    public function initializePaginateIfRequestedScope(): void
    {
        //
    }

    /**
     * Scope a query to only include is_active records.
     *
     * @param  Builder<Model>  $query
     */
    public function scopePaginateIfRequested(
        Builder $query,
    ): LengthAwarePaginator|Collection {
        if (request()->has('paginate')) {
            return $query->paginate(request()->integer('perPage', 15));
        }

        return $query->get();
    }
}
