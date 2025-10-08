<?php

declare(strict_types=1);

namespace Modules\Core\Mixins;

use Closure;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ColumnDefinition;

/**
 * @codeCoverageIgnore
 */
final class BlueprintMixins
{
    /**
     * Add meta tags columns to the table.
     *
     * @return Closure(Blueprint): void
     */
    public function metaTags(): Closure
    {
        return function (): void {
            $this->json('meta_title')->nullable();
            $this->json('meta_description')->nullable();
            $this->text('meta_keywords')->nullable();
        };
    }

    /**
     * Add an 'is_active' boolean column to indicate active state.
     *
     * @return Closure(Blueprint): ColumnDefinition
     */
    public function activeState(): Closure
    {
        return fn (): ColumnDefinition => $this->boolean('is_active')
            ->default(true)
            ->index();
    }

    /**
     * Add a 'sort_order' integer column with default value 1.
     *
     * @return Closure(Blueprint): ColumnDefinition
     */
    public function sortOrder(): Closure
    {
        return fn (): ColumnDefinition => $this->integer(
            'sort_order',
            false,
        )->default(1);
    }

    /**
     * Add a 'id' column as ulid
     *
     * @return Closure(Blueprint): ColumnDefinition
     */
    public function uid(): Closure
    {
        return fn (): ColumnDefinition => $this->uuid('id')->primary();
    }
}
