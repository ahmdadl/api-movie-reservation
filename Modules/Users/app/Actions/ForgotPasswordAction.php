<?php

declare(strict_types=1);

namespace Modules\Users\Actions;

use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Core\Models\PasswordResetToken;
use Modules\Users\Emails\UserForgetPasswordMail;
use Modules\Users\Events\PasswordResetLinkSentEvent;
use Modules\Users\Models\User;

final class ForgotPasswordAction
{
    public function handle(string $email): void
    {
        $user = User::query()
            ->active()
            ->user()
            ->where('email', $email)
            ->firstOrFail();

        $token = PasswordResetToken::createToken($user->email);

        sendMail(
            $user->email,
            new UserForgetPasswordMail($user->id, $token->token),
        );
    }
}
