<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class StudentResetPasswordMail extends Mailable
{
    public $token;
    public $email;

    public function __construct($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    
    public function build()
    {
        return $this->subject('Reset Your RentConnect Password')
                    ->view('emails.student-reset')
                    ->with([
                        'token' => $this->token,
                        'student_email' => $this->email,
                    ]);
    } 
}
