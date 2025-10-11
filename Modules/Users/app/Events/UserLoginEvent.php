<?php

namespace Modules\Users\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Users\Models\User;

final class UserLoginEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    public private(set) User $guest;
    public private(set) User $user;

    /**
     * Create a new event instance.
     */
    public function __construct(
        private string $guestId,
        private string $userId,
    ) {
        $this->guest = User::findOrFail($this->guestId);
        $this->user = User::findOrFail($this->userId);
    }
}
