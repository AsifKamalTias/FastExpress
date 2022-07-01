<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClientForgotPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $sub;
    public $passwordResetCode;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($passwordResetCode)
    {
        $this->sub = 'FastExpress Password Reset';
        $this->passwordResetCode = $passwordResetCode;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.client-password-reset')->with('passwordResetCode', $this->passwordResetCode)->subject($this->sub);
    }
}
