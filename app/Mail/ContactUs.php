<?php

namespace App\Mail;

use App\Utils\Constants\Constant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactUs extends Mailable
{
    use Queueable, SerializesModels;

    public $query;
    public $settings;
    public $sentToAdmin;
    public $provider;
    public $body;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($query, $settings, $provider = Constant::HGP, $sentToAdmin = false)
    {
        $this->query = $query;
        $this->settings = $settings;
        $this->sentToAdmin = $sentToAdmin;
        $this->provider = $provider;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->provider == Constant::GX) {
            $this->body = __('generic.mail.gx.admin_contact.body');
            return
                $this->from(__('generic.mail.gx.from'))
                    ->subject(setting('gx.new_contact_us_query_subject'))
                    ->view('emails.gx.contact.contact-us');
        }
        $this->body = __('generic.mail.hgp.admin_contact.body');
        return $this->subject(__('generic.mail.hgp.admin_contact.subject'))
            ->view('emails.contact.contact-us');
    }
}
