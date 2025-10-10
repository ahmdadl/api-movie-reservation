<?php

declare(strict_types=1);

namespace Modules\Uploads\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

/**
 * @implements CastsAttributes<string, string>
 */
final class UploadablePathCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     * @param  string  $value
     */
    public function get(
        Model $model,
        string $key,
        mixed $value,
        array $attributes
    ): string {
        return ! empty($value) ? uploads_url($value) : '';
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(
        Model $model,
        string $key,
        mixed $value,
        array $attributes
    ): string {
        return $value ?? '';
    }
}
