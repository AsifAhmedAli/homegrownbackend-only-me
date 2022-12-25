<?php

namespace App\Mail;

use App\Utils\Constants\API;
use App\Utils\Constants\Constant;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Welcome extends Mailable
{
  use Queueable, SerializesModels;

  private $fullName;
  public  $heading;
  public  $text;
  private $provider;

  /**
   * Create a new instance.
   *
   * @param string $fullName
   * @param null $password
   */
  public function __construct($fullName, $firstName = null, $password = null, $provider = Constant::HGP)
  {
    $fullName = ucwords($fullName);
      $firstName = ucwords($firstName);
    $this->fullName = $fullName;
    $this->provider  = $provider;
    if ($this->provider == Constant::HGP) {
        $this->heading = __('generic.mail.hgp.welcome.heading', ['name' => $fullName]);
        $this->text = __('generic.mail.hgp.welcome.body');

    } else {
      $this->heading = __('generic.mail.gx.welcome.heading', ['name' => $firstName]);
        $this->text = __('generic.mail.gx.welcome.body');
    }
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    if ($this->provider == Constant::HGP) {
      return $this->subject(__('generic.mail.hgp.welcome.subject'))
        ->view("emails.registration.welcome", [
          'logo' => setting('site.logo') ?? NULL,
        ]);
    } else {
      return $this->from('info@gx.com')->subject(setting('gx.welcome_email_subject'))
        ->view("emails.gx.registration.welcome", [
          'logo' => setting('gx.logo') ?? NULL,
        ]);
    }
  }

}
