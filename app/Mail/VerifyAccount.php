<?php

namespace App\Mail;

use App\Utils\Constants\Constant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyAccount extends Mailable
{
    use Queueable, SerializesModels;

    private $firstName;
    public  $heading;
    private $provider;
    public  $token;
    public  $email;
    public $web_url;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $token, $provider = Constant::HGP)
    {
        $this->firstName = $user->firstName;
        $this->provider  = $provider;
        $this->token = $token;
        $this->email = $user->email;
        if ($this->provider == Constant::HGP) {
            $company = setting('site.company_name');
            $this->heading      = __('generic.mail.hgp.registration.heading', ['name' => $company]);
            $this->description1 = __('generic.mail.hgp.registration.body_description_1');
            $this->description2 = __('generic.mail.hgp.registration.body_description_2');
            $this->web_url = __('generic.mail.hgp.WEB_URL');
        } else {
            $company = setting('gx.company_name');
            $this->heading      = __('generic.mail.gx.registration.heading', ['name' => $company]);
            $this->description1 = __('generic.mail.gx.registration.body_description_1');
            $this->description2 = __('generic.mail.gx.registration.body_description_2');
            $this->web_url = __('generic.mail.gx.WEB_URL');
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
            return $this->subject(__('generic.mail.hgp.verify_account.subject'))
                ->view("emails.registration.verify_account", [
                    'logo' => setting('site.logo') ?? NULL,
                ]);
        } else {
            return $this->from(__('generic.mail.gx.from'))
                ->subject(__('generic.mail.gx.verify_account.subject'))
                ->view("emails.gx.registration.verify_account", [
                    'logo' => setting('gx.logo') ?? NULL,
                ]);
        }
    }
}
