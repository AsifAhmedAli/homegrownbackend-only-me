<?php

namespace App\Mail;

use App\Models\UserSubscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserSubscriptionEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $subscription;
    public $first_name;

  /**
   * Create a new message instance.
   *
   * @param UserSubscription $userSubscription
   */
    public function __construct(UserSubscription $userSubscription)
    {
        $this->subscription = $userSubscription;
        $this->first_name = $userSubscription->user->first_name ?? "";
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      return $this
          ->from(__('generic.mail.gx.from'))
          ->subject('Thank you for purchasing subscription')->view('emails.gx.user-subscription');
    }
}
