<?php

namespace Modules\Users\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Users\Emails\UserResetPasswordMail;
use Modules\Users\Events\UserResetPasswordEvent;

class SendUserResetPasswordMailListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(UserResetPasswordEvent $event): void
    {
        sendMail(
            $event->user->email,
            new UserResetPasswordMail($event->user->id),
        );
    }
}
