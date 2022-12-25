<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AssignGrowMasterToCustomer extends Mailable
{
    use Queueable, SerializesModels;


  public $heading;
  public $firstName;
  public $body;
  public $body2;

    /**
     * Create a new message instance.
     *
     * @param $growmasterFullName
     * @param $user
     */
    public function __construct($growmasterFullName, $user)
    {
      $company = setting('gx.company_name');
      $this->firstName      = $user->first_name ?? '' .' '.$user->last_name ?? '';
      $this->heading      = __('generic.mail.gx.growmaster_assign.heading', ['name' => $company]);
      $this->body = __('generic.mail.gx.growmaster_assign.body',['growmaster'=>$growmasterFullName]);
      $this->body2 = __('generic.mail.gx.growmaster_assign.body2',['growmaster'=>$growmasterFullName]);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      return $this->subject(__('generic.mail.gx.growmaster_assign.subject'))
        ->from(__('generic.mail.gx.from'))
        ->view("emails.gx.admin.growmaster_to_customer", [
          'logo' => setting('gx.logo') ?? NULL,
        ]);
    }
}
