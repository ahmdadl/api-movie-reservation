<?php

namespace Modules\Cities\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Cities\Models\City;

class GetCitiesListController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(): JsonResponse
    {
        $cities = City::query()->active()->get();

        return api()->records($cities->toResourceCollection());
    }
}
