<?php

namespace App\Mail;

use App\Kit;
use App\Models\UserKit;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PurchaseKitEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $userKit;
    public $first_name;


    public function __construct(Kit $userKit, $first_name)
    {
       $this->userKit = $userKit;
       $this->first_name = $first_name ?? "";
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Thank you for purchasing kit')->view('emails.kit.purchase');
    }
}
