<?php

namespace App\Observers;

use App\ContactQuery;
use App\Mail\ContactMail;
use App\Mail\ContactUs;
use App\Mail\ContactUsEmailToAdmin;
use App\Mail\ContactUsThankYou;
use App\Utils\Constants\Constant;
use Illuminate\Support\Facades\Mail;

class ContactObserver
{
    /**
     * Handle the contact query "created" event.
     *
     * @param ContactQuery $contactQuery
     * @return void
     */
    public function created(ContactQuery $contactQuery)
    {
      $provider = request()->provider ?? Constant::HGP;
      if ($provider == Constant::GX) {
        $settings = getGXSiteSettings();
      } else {
        $settings = getSiteSettings();
      }
      $this->contactUsEmailToUser($contactQuery->email, $settings);
      $this->contactUsEmailToAdmin($contactQuery, $settings);
    }

    function contactUsEmailToAdmin($contact_us, $settings)
    {
        $provider = request()->provider ?? Constant::HGP;
        $adminEmail = getAdminEmail();
        Mail::to($adminEmail)->send(new ContactUs($contact_us, $settings, $provider, true));
    }

    function contactUsEmailToUser($userEmail, $settings)
    {
        $provider = request()->provider ?? Constant::HGP;
        Mail::to($userEmail)->send(new ContactUsThankYou($settings, $provider));
    }

}
