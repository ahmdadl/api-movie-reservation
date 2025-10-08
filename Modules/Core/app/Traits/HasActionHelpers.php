<?php

declare(strict_types=1);

namespace Modules\Core\Traits;

/**
 * @codeCoverageIgnore
 */
trait HasActionHelpers
{
    /**
     * get dependency injection instance
     */
    public static function new(): static
    {
        return app(static::class);
    }
}
