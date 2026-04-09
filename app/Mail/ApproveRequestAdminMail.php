<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApproveRequestAdminMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $donationRequest;

    public function __construct($donationRequest)
    {
        $this->donationRequest = $donationRequest;
    }

    public function build()
    {
        return $this->subject('You have approved a Blood Donation Request')
            ->view('emails.approve-request-admin-mail');
    }
}