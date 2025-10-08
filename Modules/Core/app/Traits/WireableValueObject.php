<?php

declare(strict_types=1);

namespace Modules\Core\Traits;

/**
 * @codeCoverageIgnore
 */
trait WireableValueObject
{
    /**
     * get from livewire wireable
     */
    public static function fromLivewire(mixed $value): static
    {
        // @phpstan-ignore-next-line
        return static::fromArray($value);
    }

    /**
     * turn to livewire wireable
     */
    public function toLivewire(): array
    {
        return static::toArray();
    }
}
