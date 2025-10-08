<?php

declare(strict_types=1);

namespace Modules\Core\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @codeCoverageIgnore
 */
final class ApiException extends Exception
{
    /**
     * Render the exception as an HTTP response.
     */
    public function render(Request $request): JsonResponse|false
    {
        if ($request->wantsJson()) {
            if ($this->getCode() === 404) {
                return api()->notFound();
            }

            return api()->error(
                $this->getMessage(),
                $this->getCode() > 199 ? $this->getCode() : 400,
            );
        }

        return false;
    }
}
