<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ServiceProviderWelcome extends Mailable
{
    use Queueable, SerializesModels;

    public $provider;
    public $plainPassword;

    public function __construct($provider, $plainPassword)
    {
        $this->provider = $provider;
        $this->plainPassword = $plainPassword;
    }

    public function build()
    {
        return $this->subject('Welcome to RentConnect')
                    ->view('emails.serviceprovider_welcome');
    }
}