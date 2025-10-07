<?php

declare(strict_types=1);

namespace Modules\Core\Casters;

use Illuminate\Http\Response;
use Modules\Core\Exceptions\ApiException;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\Creation\CreationContext;
use Spatie\LaravelData\Support\DataProperty;

final class ModelFromValueCaster implements Cast
{
    private string $modelClass;

    private string $lookupColumn;

    private array $where;

    public function __construct(
        string $modelClass,
        string $lookupColumn = 'id',
        array $where = []
    ) {
        $this->modelClass = $modelClass;
        $this->lookupColumn = $lookupColumn;
        $this->where = $where;
    }

    public function cast(
        DataProperty $property,
        mixed $value,
        array $properties,
        CreationContext $context
    ): ?\Illuminate\Database\Eloquent\Model {
        if (is_null($value) || ! is_scalar($value)) {
            throw new ApiException(code: Response::HTTP_NOT_FOUND);
        }

        $query = $this->modelClass::query()->where($this->lookupColumn, $value);

        foreach ($this->where as $column => $filterValue) {
            $query->where($column, $filterValue);
        }

        return $query->firstOrFail();
    }
}
