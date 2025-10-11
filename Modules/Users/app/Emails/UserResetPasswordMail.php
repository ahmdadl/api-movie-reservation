<?php

namespace Modules\Users\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Users\Models\User;

class UserResetPasswordMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public private(set) User $user;

    /**
     * Create a new message instance.
     */
    public function __construct(public readonly string $userId)
    {
        $this->user = User::query()->findOrFail($this->userId);
    }

    /**
     * Build the message.
     */
    public function build(): self
    {
        return $this->subject('Your password has been reset')->html(
            <<<HTML
            <h1>Your password has been reset</h1>
            <p>Dear {$this->user->first_name} {$this->user->last_name},</p>
            <p>Your password has been reset successfully.</p>
            <p>Thank you for using our service.</p>
            <p>Best regards</p>
            HTML,
        );
    }
}
