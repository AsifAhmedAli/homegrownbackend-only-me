<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GiveawayThankyou extends Mailable
{
    use Queueable, SerializesModels;
    public $body;
    public $name;
    // public $settings;
    // public $sentToAdmin;
    // public $provider;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $body)
    {
        $this->name = $name;
        $this->body = $body;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(__('Thank you'))->view('emails.giveAway.giveAwayThankyoumail');
    }
}
