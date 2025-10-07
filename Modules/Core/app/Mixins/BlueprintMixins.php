<?php

declare(strict_types=1);

namespace Modules\Core\Mixins;

use Closure;

final class BlueprintMixins
{
    /**
     * Add meta tags columns to the table.
     *
     * @return Closure
     */
    public function metaTags()
    {
        return function () {
            $this->json('meta_title')->nullable();
            $this->json('meta_description')->nullable();
            $this->text('meta_keywords')->nullable();
        };
    }

    /**
     * Add an 'is_active' boolean column to indicate active state.
     *
     * @return Closure
     */
    public function activeState()
    {
        return fn () => $this->boolean('is_active')->default(true)->index();
    }

    /**
     * Add a 'sort_order' integer column with default value 1.
     *
     * @return Closure
     */
    public function sortOrder()
    {
        return fn () => $this->integer('sort_order', false)->default(1);
    }

    /**
     * Add a 'id' column as ulid
     *
     * @return Closure
     */
    public function uid()
    {
        return fn () => $this->ulid('id')->unique()->primary();
    }
}
