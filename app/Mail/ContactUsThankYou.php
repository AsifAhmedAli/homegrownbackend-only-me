<?php

namespace App\Mail;

use App\Utils\Constants\Constant;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactUsThankYou extends Mailable
{
    use Queueable, SerializesModels;

    public $settings;
    public $provider;
    public $body;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($settings, $provider = Constant::HGP)
    {
        $this->settings = $settings;
        $this->provider = $provider;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->provider == Constant::HGP) {
            $this->body = __('generic.mail.hgp.thankyou.body');
            return $this->view('emails.contact.thank-you')
                ->subject(__('generic.mail.hgp.thankyou.subject'));
        }

        $this->body = __('generic.mail.gx.thankyou.body');
        return $this
            ->from(__('generic.mail.gx.from'))
            ->view('emails.gx.contact.thank-you')
            ->subject(setting('gx.new_contact_us_user_subject'));
    }
}
