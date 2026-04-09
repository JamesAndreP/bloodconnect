<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BloodRequestOwnerMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $bloodRequest;

    /**
     * Create a new message instance.
     */
    public function __construct($bloodRequest)
    {
        $this->bloodRequest = $bloodRequest;
    }

    public function build()
    {
        return $this->subject('Your Blood Request has been submitted')
            ->view('emails.blood-request-owner-mail');
    }
}
