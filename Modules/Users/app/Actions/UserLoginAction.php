<?php

declare(strict_types=1);

namespace Modules\Users\Actions;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Modules\Users\Enums\UserRole;
use Modules\Users\Events\UserLoginEvent;
use Modules\Users\Models\User;

final class UserLoginAction
{
    /**
     * @return array{User, string}
     */
    public function handle(string $email, string $password): array
    {
        $guest = user();

        if (
            !Auth::guard('web')->once([
                'email' => $email,
                'password' => $password,
                'role' => UserRole::USER->value,
            ])
        ) {
            throw ValidationException::withMessages([
                'email' => [__('users::t.email_or_password_is_incorrect')],
            ]);
        }

        // after login
        $user = user();

        if (!$user->is_active) {
            throw ValidationException::withMessages([
                'email' => [__('users::t.your_account_is_not_active')],
            ]);
        }

        event(new UserLoginEvent($guest->id, $user->id));

        return [$user, $user->createToken('user-token')->plainTextToken];
    }
}
