<?php

namespace Modules\Users\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Users\Actions\GuestLoginAction;

class AuthController
{
    public function loginGuest(
        Request $request,
        GuestLoginAction $action,
    ): JsonResponse {
        [$user, $accessToken] = $action->handle();

        return api()->record(
            $user->toResource()->additional([
                'accessToken' => $accessToken,
            ]),
        );
    }
}
