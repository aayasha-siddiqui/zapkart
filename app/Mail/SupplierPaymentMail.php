<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SupplierPaymentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $supplier;
    public $products;
    public $totalAmount;

    public function __construct($supplier, $products, $totalAmount)
    {
        $this->supplier    = $supplier;
        $this->products    = $products;
        $this->totalAmount = $totalAmount;
    }

    public function build()
    {
        return $this->subject('Payment Successful - Products Purchased')
                    ->view('emails.supplier-payment');
    }
}
