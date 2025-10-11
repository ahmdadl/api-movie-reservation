<?php

namespace Modules\Users\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Users\Models\User;

final class UserForgetPasswordMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public private(set) User $user;

    /**
     * Create a new message instance.
     */
    public function __construct(public readonly string $userId, public readonly string $passwordResetCode)
    {
        $this->user = User::findOrFail($this->userId);
    }

    /**
     * Build the message.
     */
    public function build(): self
    {
        return $this->subject('Your password reset Code')->html(
            "<h1>Your password reset Code</h1>
            <p>Dear {$this->user->first_name},</p>
            <p>Here is your password reset code: {$this->passwordResetCode}</p>
            <p>Thank you for registering on our platform.</p>
            <p>Best regards,</p>
            <p>Our Team</p>",
        );
    }
}
