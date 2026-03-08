<?php

namespace App\Mail;

use App\Models\DeliveryPartner;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PartnerApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $partner;

    public function __construct(DeliveryPartner $partner)
    {
        $this->partner = $partner;
    }

    public function build()
    {
        return $this->subject('Your Delivery Partner Request Approved')
            ->view('emails.partner-approved');
    }
}
