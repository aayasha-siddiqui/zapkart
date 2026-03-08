<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $type;
    public $data;

    public function __construct($type, $data = [])
    {
        $this->type = $type;
        $this->data = $data;
    }

    public function build()
    {
        return $this->subject($this->getSubject())
                    ->view('emails.admin-notification');
    }

    private function getSubject()
    {
        return match ($this->type) {
            'seller_request'   => '🧑‍💼 New Seller Request',
            'partner_request'  => '🚚 New Delivery Partner Request',
            'supplier_product' => '📦 Supplier Product Added',
            'order'            => '🛒 New Order (Seller Product)',
            default            => 'Admin Notification',
        };
    }
}

