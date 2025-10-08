<?php

declare(strict_types=1);

namespace Modules\Core\Utils;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource; // Must be used for JsonResource::collection()
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * @codeCoverageIgnore
 */
final class ApiResponse
{
    /**
     * Return a success JSON response.
     *
     * @param  mixed  $data  The data payload. Can be array, object, resource collection, etc.
     */
    public function success(
        mixed $data = null, // Changed from untyped $data to mixed
        ?string $message = null,
        int $statusCode = 200,
    ): JsonResponse {
        return response()->json(
            [
                'success' => true,
                'message' => $message ?? __('core::t.success'),
                'data' => $data,
            ],
            $statusCode,
        );
    }

    /**
     * Return an error JSON response.
     *
     * @param  array<string, array<string>>  $errors
     */
    public function error(
        ?string $message = null,
        int $statusCode = 400,
        array $errors = [],
    ): JsonResponse {
        return response()->json(
            [
                'success' => false,
                'message' => $message ?? __('core::t.error'),
                'errors' => $errors,
            ],
            $statusCode,
        );
    }

    /**
     * send response with pagination if requested
     *
     * @param  class-string<JsonResource>  $jsonResource
     */
    public function paginatedIfRequested(
        LengthAwarePaginator|Collection $paginator,
        string $jsonResource,
        ?string $message = null,
    ): JsonResponse {
        // Use the global request() helper and ensure it's loaded in the test environment.
        if (request()->has('paginate')) {
            // Static analysis may struggle here if $paginator is a Collection.
            // A runtime check ensures safety, but the type hint should prioritize
            // LengthAwarePaginator if 'paginate' is expected to be present.
            // For 100% type coverage, we rely on the condition to guarantee the correct type.
            if (! $paginator instanceof LengthAwarePaginator) {
                // This scenario indicates a logic flaw where paginate=true is passed
                // but the wrong type is provided. You may want to throw an exception here.
                return $this->error(
                    'Cannot paginate a non-paginator object.',
                    500,
                );
            }

            return $this->paginate($paginator, $jsonResource, $message);
        }

        // If 'paginate' is not requested, we treat the input as a simple collection of records.
        /** @var Collection|LengthAwarePaginator $paginator */
        return $this->records($jsonResource::collection($paginator), $message);
    }

    /**
     * Return a paginated JSON response.
     *
     * @template TModel of \Illuminate\Database\Eloquent\Model
     *
     * @param  LengthAwarePaginator<TModel>  $paginator
     * @param  class-string<JsonResource>  $jsonResource
     */
    public function paginate(
        LengthAwarePaginator $paginator,
        string $jsonResource,
        ?string $message = null,
    ): JsonResponse {
        return $this->success(
            [
                'records' => $jsonResource::collection($paginator),
                'paginationInfo' => (object) [
                    'current_page' => $paginator->currentPage(),
                    'per_page' => $paginator->perPage(),
                    'total' => $paginator->total(),
                    'last_page' => $paginator->lastPage(),
                    'from' => $paginator->firstItem(),
                    'to' => $paginator->lastItem(),
                    'has_more_pages' => $paginator->hasMorePages(),
                ],
            ],
            $message,
        );
    }

    /**
     * Return a success JSON response with no data.
     */
    public function noContent(
        ?string $message = null,
        int $statusCode = 204,
    ): JsonResponse {
        return $this->success(
            // NOTE: The data here is an array ['success' => true].
            // In a 204 No Content response, the body should technically be empty,
            // but many Laravel setups return this structure. We'll keep the logic.
            ['success' => true],
            $message ?? __('core::t.empty_success'),
            $statusCode,
        );
    }

    /**
     * Return a validation error JSON response.
     *
     * @param  array<string, array<string>>  $errors  An array where keys are fields and values are error messages.
     */
    public function validationError(
        array $errors,
        ?string $message = null,
    ): JsonResponse {
        return $this->error(
            $message ?? __('core::t.validation_error'),
            422,
            $errors,
        );
    }

    public function notFound(?string $message = null): JsonResponse
    {
        return $this->error($message ?? __('core::t.not_found'), 404);
    }

    public function unauthorized(?string $message = null): JsonResponse
    {
        return $this->error($message ?? __('core::t.unauthorized'), 401);
    }

    public function forbidden(?string $message = null): JsonResponse
    {
        return $this->error($message ?? __('core::t.forbidden'), 403);
    }

    public function serverError(?string $message = null): JsonResponse
    {
        return $this->error($message ?? __('core::t.server_error'), 500);
    }

    /**
     * Return a record JSON response.
     *
     * @param  mixed  $record  The single record object (e.g., a Model or JsonResource).
     */
    public function record(mixed $record, ?string $message = null): JsonResponse
    {
        return $this->success(compact('record'), $message);
    }

    /**
     * Return a records JSON response.
     *
     * @param  mixed  $records  The collection of records (e.g., Collection or ResourceCollection).
     */
    public function records(
        mixed $records,
        ?string $message = null,
    ): JsonResponse {
        return $this->success(compact('records'), $message);
    }
}
