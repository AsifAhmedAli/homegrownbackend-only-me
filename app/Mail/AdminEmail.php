<?php

namespace App\Mail;

use App\Order;
use App\Utils\Constants\Constant;
use App\Utils\Helpers\Helper;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $provider;

    public function __construct($provider)
    {
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
            $view = "emails.orders.admin.gx.new_order";
            $company = setting('gx.company_name');
            $logo = setting('gx.logo');
        } else {
            $view = "emails.orders.admin.new_order";
            $company = setting('site.company_name');
            $logo = setting('site.logo');
        }

        return $this->subject(__('generic.mail.invoice_subject',
            ['name' => "Admin", 'company' => $company]))
            ->view($view, [
                'logo' => $logo ?? NULL,
            ]);
    }
}
