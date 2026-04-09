<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BloodRequestFulfilledOwnerMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $bloodRequest;

    public function __construct($bloodRequest)
    {
        $this->bloodRequest = $bloodRequest;
    }

    public function build()
    {
        return $this->subject('Your Blood Request has been Fulfilled')
            ->view('emails.blood-request-fulfilled-owner-mail');
    }
}