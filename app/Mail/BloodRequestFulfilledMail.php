<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BloodRequestFulfilledMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $bloodRequest;

    public function __construct($bloodRequest)
    {
        $this->bloodRequest = $bloodRequest;
    }

    public function build()
    {
        return $this->subject('Blood Request Fulfilled')
            ->view('emails.blood-request-fulfilled-mail');
    }
}