<?php

namespace Modules\Users\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Core\Models\PasswordResetToken;
use Modules\Users\Events\UserResetPasswordEvent;

class RemoveUserResetPasswordTokenListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(UserResetPasswordEvent $event): void
    {
        PasswordResetToken::query()
            ->where('email', $event->user->email)
            ->delete();
    }
}
