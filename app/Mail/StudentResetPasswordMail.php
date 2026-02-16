<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class StudentResetPasswordMail extends Mailable
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function build()
    {
        return $this->subject('Reset Your RentConnect Password')
                    ->view('emails.student-reset');
    }
}
