<?php

namespace Modules\Users\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Users\Models\User;

class UserRegisteredMail extends Mailable
{
    use Queueable, SerializesModels;

    public private(set) User $user;

    /**
     * Create a new message instance.
     */
    public function __construct(public readonly string $userId)
    {
        $this->user = User::findOrFail($this->userId);
    }

    /**
     * Build the message.
     */
    public function build(): self
    {
        return $this->subject('User Registered Successfully')->html(
            "<h1>User Registered Successfully</h1>
            <p>Dear {$this->user->first_name},</p>
            <p>Thank you for registering on our platform.</p>
            <p>Best regards,</p>
            <p>Our Team</p>",
        );
    }
}
