<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApproveRescheduleMail extends Mailable implements ShouldQueue
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
        return $this->subject('Blood Donation Reschedule Approved')
            ->view('emails.approve-reschedule-mail');
    }
}