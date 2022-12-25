<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProductSoldConfirmation extends Mailable
{
    use Queueable, SerializesModels;
    public  $order;
    public  $settings;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order, $settings )
    {
        $this->order = $order;
        $this->settings = $settings;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.product.product_sold_confirmation')->subject('Your Order Placed Successfully');
    }
}
