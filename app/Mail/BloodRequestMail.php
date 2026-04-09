<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BloodRequestMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $bloodRequest, $hospital;

    /**
     * Create a new message instance.
     */
    public function __construct($bloodRequest, $hospital)
    {
        $this->bloodRequest = $bloodRequest;
        $this->hospital = $hospital;
    }

    public function build()
    {
        return $this->subject('New Blood Request')
            ->view('emails.blood-request-mail');
    }
}
