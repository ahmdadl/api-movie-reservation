<?php

declare(strict_types=1);

namespace Modules\Users\Actions;

use Modules\Users\Emails\UserRegisteredMail;
use Modules\Users\Enums\UserRole;
use Modules\Users\Events\UserRegisteredEvent;
use Modules\Users\Models\User;

final class RegisterUserAction
{
    /**
     * @return array{User, string}
     */
    public function handle(array $data): array
    {
        $guest = user();

        $guest->update([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => $data['password'],
            'role' => UserRole::USER,
        ]);

        $user = $guest->fresh();

        sendMail($user->email, new UserRegisteredMail($user->id));

        $accessToken = $user->createToken('auth')->plainTextToken;

        return [$user, $accessToken];
    }
}
