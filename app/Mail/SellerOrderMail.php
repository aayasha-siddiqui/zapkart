<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;

class SellerOrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $seller;
    public $items;
    public $order;

    public function __construct($seller, $items, $order)
    {
        $this->seller = $seller;
        $this->items  = $items;
        $this->order  = $order;
    }

    public function build()
    {
        return $this->subject('New Order Received for Your Products')
                    ->view('emails.seller-order');
    }
}
