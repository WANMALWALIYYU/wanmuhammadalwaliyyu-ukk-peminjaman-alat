<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetVerification extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $name;

    /**
     * Create a new message instance.
     */
    public function __construct($token, $name)
    {
        $this->token = $token;
        $this->name = $name;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Verifikasi Perubahan Password')
                    ->view('emails.password-verification');
    }
}
