<?php

declare(strict_types=1);

namespace Modules\Users\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Users\Actions\GuestLoginAction;
use Modules\Users\Actions\UserLoginAction;
use Modules\Users\Http\Requests\UserLoginRequest;

final class AuthController
{
    /**
     * login guests
     */
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

    /**
     * login users
     */
    public function loginUser(
        UserLoginRequest $request,
        UserLoginAction $action,
    ): JsonResponse {
        [$user, $accessToken] = $action->handle(
            $request->input('email'),
            $request->input('password'),
        );

        return api()->record(
            $user->toResource()->additional([
                'accessToken' => $accessToken,
            ]),
        );
    }
}
