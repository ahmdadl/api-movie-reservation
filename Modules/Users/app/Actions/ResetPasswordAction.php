<?php

declare(strict_types=1);

namespace Modules\Users\Actions;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Modules\Core\Exceptions\ApiException;
use Modules\Core\Models\PasswordResetToken;
use Modules\Users\Events\PasswordResetEvent;
use Modules\Users\Events\UserResetPasswordEvent;
use Modules\Users\Models\User;

final class ResetPasswordAction
{
    public function handle(array $data): void
    {
        $reset = PasswordResetToken::query()->email($data['email'])->first();

        if (
            !$reset ||
            !PasswordResetToken::verifyToken($data['email'], $data['token'])
        ) {
            throw new ApiException('Invalid token');
        }

        if ($reset->created_at->lt(now()->subMinutes(15))) {
            throw new ApiException('Token expired');
        }

        $user = User::query()
            ->user()
            ->where('email', $data['email'])
            ->firstOrFail();

        if (!$user->is_active) {
            throw new ApiException('User is not active');
        }

        $user->update([
            'password' => bcrypt($data['password']),
            'remember_token' => Str::random(60),
        ]);

        event(new UserResetPasswordEvent($user->id));
    }
}
