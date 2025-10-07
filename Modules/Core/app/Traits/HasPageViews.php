<?php

declare(strict_types=1);

namespace Modules\Core\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Modules\PageViews\Models\PageView;

trait HasPageViews
{
    /**
     * views
     *
     * @return MorphMany<PageView, $this>
     */
    public function views(): MorphMany
    {
        return $this->morphMany(PageView::class, 'viewable');
    }

    /**
     * latest view
     *
     * @return MorphOne<PageView, $this>
     */
    public function latestView(): MorphOne
    {
        return $this->morphOne(PageView::class, 'viewable')->latestOfMany();
    }

    /**
     * views count
     *
     * @return Attribute<int, void>
     */
    public function viewsCount(): Attribute
    {
        return Attribute::make(fn () => $this->views()->count())->shouldCache();
    }

    /**
     * is viewed by current user
     *
     * @return Attribute<bool, void>
     */
    public function isViewedByCurrent(): Attribute
    {
        return Attribute::make(
            fn () => $this->views()
                ->where('viewerable_id', user()->id)
                ->where('viewerable_type', get_class(user()))
                ->exists()
        )->shouldCache();
    }
}
