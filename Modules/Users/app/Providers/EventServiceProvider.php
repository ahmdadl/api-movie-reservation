<?php

declare(strict_types=1);

namespace Modules\Users\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Users\Events\UserResetPasswordEvent;

final class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array<string, array<int, string>>
     */
    protected $listen = [
        \Modules\Users\Events\UserLoginEvent::class => [
            \Modules\Users\Listeners\MergeGuestToLoggedUserListener::class,
        ],
        UserResetPasswordEvent::class => [
            \Modules\Users\Listeners\RemoveUserResetPasswordTokenListener::class,
            \Modules\Users\Listeners\SendUserResetPasswordMailListener::class,
        ],
    ];

    /**
     * Indicates if events should be discovered.
     *
     * @var bool
     */
    protected static $shouldDiscoverEvents = true;

    /**
     * Configure the proper event listeners for email verification.
     */
    protected function configureEmailVerification(): void {}
}
