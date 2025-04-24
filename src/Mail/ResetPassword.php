<?php

namespace Motor\Backend\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class ResetPassword
 */
class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $token;

    public $user;

    /**
     * ResetPassword constructor.
     */
    public function __construct($token, $user)
    {
        $this->token = $token;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->to($this->user->email);

        return $this->markdown('motor-backend::emails.reset-password');
    }
}
