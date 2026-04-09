<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DonationRequestAdminMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $donationRequest;

    /**
     * Create a new message instance.
     */
    public function __construct($donationRequest)
    {
        $this->donationRequest = $donationRequest;
    }

    public function build()
    {
        return $this->subject('New Donation Request')
            ->view('emails.donation-request-admin-mail');
    }
}
