<?php

namespace App\Mail;

use App\Utils\Constants\Constant;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationConfirmationEmail extends Mailable
{
  use Queueable, SerializesModels;

  public $firstName;
  public  $heading;
  public  $description1;
  public  $description2;
  public $phrase;
  private $provider;
    /**
     * @var array|\Illuminate\Contracts\Translation\Translator|string|null
     */


    /**
   * Create a new instance.
   *
   * @param string $firstName
   * @param null $password
   */
  public function __construct($firstName, $password = null, $provider = Constant::HGP)
  {
    $this->firstName = $firstName;
    $this->provider  = $provider;
    if ($this->provider == Constant::HGP) {
      $company = __('generic.mail.hgp.registration.company_name');
      $this->heading      = __('generic.mail.hgp.registration.body_description', ['name' => $company]);
      $this->description1 = __('generic.mail.hgp.registration.body_description_1');
      $this->description2 = __('generic.mail.hgp.registration.body_description_2');
      $this->phrase = __('generic.mail.hgp.registration.phrase');
    } else {
      $company = setting('gx.company_name');
      $this->heading      = __('generic.mail.gx.registration.body_description', ['name' => $company]);
      $this->description1 = __('generic.mail.gx.registration.body_description_1');
      $this->description2 = __('generic.mail.gx.registration.body_description_2');
      $this->phrase = __('generic.mail.gx.registration.phrase');
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
            return $this->subject(__('generic.mail.hgp.registration.subject'))
                ->view("emails.registration.registration_confirmation", [
                    'logo' => setting('site.logo') ?? NULL,
                ]);
        } else {
            return $this->from(__('generic.mail.gx.from'))->subject(setting('gx.registration_email_subject'))
                ->view("emails.gx.registration.registration_confirmation", [
                    'logo' => setting('gx.logo') ?? NULL,
                ]);
        }
    }

}
