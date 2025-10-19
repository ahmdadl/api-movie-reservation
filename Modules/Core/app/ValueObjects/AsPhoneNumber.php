<?php

namespace Modules\Core\ValueObjects;

use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Propaganistas\LaravelPhone\PhoneNumber;

class AsPhoneNumber implements Castable
{
    /**
     * Get the caster class to use when casting from / to this cast target.
     *
     * @param  array<string, mixed>  $arguments
     */
    public static function castUsing(array $arguments): CastsAttributes
    {
        return new class implements CastsAttributes {
            public function get(
                Model $model,
                string $key,
                mixed $value,
                array $attributes,
            ): PhoneNumber {
                return new PhoneNumber($attributes['phone']);
            }

            public function set(
                Model $model,
                string $key,
                mixed $value,
                array $attributes,
            ): array {
                return [
                    'phone' => phone($value)->formatE164(),
                ];
            }
        };
    }
}
