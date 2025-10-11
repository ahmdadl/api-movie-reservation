<?php

namespace Modules\Users\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Users\Events\UserLoginEvent;

class MergeGuestToLoggedUserListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserLoginEvent $event): void
    {
        $guest = $event->guest;
        $user = $event->user;

        $guest->delete();
    }
}
