<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SMSNotification extends Mailable
{
    use Queueable, SerializesModels;
  use Queueable, SerializesModels;
  public  $receiver;
  public  $settings;
  
    /**
     * Create a new message instance.
     *
     * @return void
     */
  public function __construct($receiver, $settings)
  {
    $this->receiver = $receiver;
    $this->settings = $settings;
  }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.sms.notification_to_receiver')->subject('You Received A New Message');
    }
}
