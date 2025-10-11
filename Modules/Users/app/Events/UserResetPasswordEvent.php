<?php

namespace Modules\Users\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Modules\Users\Models\User;

class UserResetPasswordEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    public private(set) User $user;

    /**
     * Create a new event instance.
     */
    public function __construct(public readonly string $userId)
    {
        $this->user = User::query()->findOrFail($this->userId);
    }
}
