<?php

namespace Modules\Uploads\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

/**
 * @implements CastsAttributes<string, string>
 */
class UploadableMultiplePathsCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(
        Model $model,
        string $key,
        mixed $value,
        array $attributes
    ): array {
        // return is_array($value) ? $value : json_decode($value ?? '[]', true);
        return !empty($value) && $value !== "null"
            ? array_map(fn($x) => uploads_url($x), json_decode($value, true))
            : [];
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
        return json_encode($value);
    }
}
