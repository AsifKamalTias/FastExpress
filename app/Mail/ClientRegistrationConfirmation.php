<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClientRegistrationConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $sub;
    public $regConfirmationCode;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($regConfirmationCode)
    {
        $this->sub = 'FastExpress Registration Confirmation';
        $this->regConfirmationCode = $regConfirmationCode;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.client-registration-confirmation')->with('regConfirmationCode', $this->regConfirmationCode)->subject($this->sub);
    }
}
