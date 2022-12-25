<?php

namespace App\Mail;

use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendTrackingNumberEmail extends Mailable
{
    use Queueable, SerializesModels;
    
    private $order;
    public $trackingNumbers;
  
    /**
     * Create a new message instance.
     *
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->trackingNumbers = $this->order->tracking_info->pluck('tracking')->toArray();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Order Tracking Number')->view('emails.orders.tracking');
    }
}
