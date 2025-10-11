<?php

declare(strict_types=1);

namespace Modules\Users\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Users\Actions\ForgotPasswordAction;
use Modules\Users\Actions\GuestLoginAction;
use Modules\Users\Actions\RegisterUserAction;
use Modules\Users\Actions\ResetPasswordAction;
use Modules\Users\Actions\UserLoginAction;
use Modules\Users\Http\Requests\ForgotPasswordRequest;
use Modules\Users\Http\Requests\RegisterUserRequest;
use Modules\Users\Http\Requests\ResetPasswordRequest;
use Modules\Users\Http\Requests\UserLoginRequest;
use Modules\Users\Models\User;

final class AuthController
{
    /**
     * Register a new user
     */
    public function register(
        RegisterUserRequest $request,
        RegisterUserAction $action,
    ): JsonResponse {
        [$user, $accessToken] = $action->handle($request->validated());

        return api()->record(
            $user->toResource()->additional([
                'accessToken' => $accessToken,
            ]),
        );
    }

    /**
     * Login guests
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
     * Login users
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

    /**
     * Send password reset link
     */
    public function forgotPassword(
        ForgotPasswordRequest $request,
        ForgotPasswordAction $action,
    ): JsonResponse {
        $action->handle($request->input('email'));

        return api()->success(null, 'Password reset link sent to your email');
    }

    /**
     * Reset password
     */
    public function resetPassword(
        ResetPasswordRequest $request,
        ResetPasswordAction $action,
    ): JsonResponse {
        $success = $action->handle($request->validated());

        if (!$success) {
            return api()->error('Invalid or expired token', 422, []);
        }

        return api()->success(null, 'Password has been reset successfully');
    }
}
