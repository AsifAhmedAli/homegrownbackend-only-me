<?php

namespace App\Mail;

use App\Kit;
use App\Models\UserKit;
use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TrackingKitMail extends Mailable
{
    use Queueable, SerializesModels;
    public $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
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
        return $this->from(__('generic.mail.hgp.from'))
            ->subject(__('generic.mail.hgp.user_kit_status.subject'))
            ->view('emails.kit.tracking-number');
    }
}
