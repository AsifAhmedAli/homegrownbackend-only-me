<?php

namespace App\Mail;

use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->order->load('products');

        return $this->subject(__('generic.mail.invoice_subject', ['name' => "{$this->order->billing_first_name} {$this->order->billing_last_name}", 'company' => setting('site.company_name')]))
            ->view("emails.orders.new_order", [
                'logo' => setting('site.logo') ?? NULL,
            ]);
    }
}
