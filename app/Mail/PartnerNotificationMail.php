<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class PartnerNotificationMail extends Mailable
{
    public $type;
    public $partner;
    public $order;

    public function __construct($type, $partner, $order = null)
    {
        $this->type = $type;     // approved | rejected | new_order
        $this->partner = $partner;
        $this->order = $order;
    }

    public function build()
    {
        $subject = match ($this->type) {
            'approved'  => 'Delivery Partner Request Approved',
            'rejected'  => 'Delivery Partner Request Rejected',
            'new_order' => 'New Delivery Order Available',
            default     => 'Partner Notification'
        };

        return $this->subject($subject)
            ->view('emails.partner-notification');
    }
}
