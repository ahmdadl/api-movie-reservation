<?php

declare(strict_types=1);

namespace Modules\Users\Actions;

use Modules\Users\Models\User;

final class GuestLoginAction
{
    /**
     * @return array{User, string}
     */
    public function handle(): array
    {
        /** @var User $user */
        $user = User::factory()
            ->guest()
            ->createOne([
                'first_name' => 'Guest',
                'last_name' => 'User',
                'email' => null,
            ]);

        $accessToken = $user->createToken('guest-token')->plainTextToken;

        return [$user, $accessToken];
    }
}
