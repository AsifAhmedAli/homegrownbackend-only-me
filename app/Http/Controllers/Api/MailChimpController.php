<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Utils\Api\ApiHelper;
use Illuminate\Http\Request;
use Newsletter;

class MailChimpController extends Controller
{
    public function subscribeNewsLetter(Request $request)
    {
        $email = $request->email;
        if (isset($email) && !empty($email)) {
            if (ApiHelper::isHGP()) {
                /*for HGP Project*/
                $listName = \Config::get('newsletter.defaultListName');
            }
            else {
                /*for GX project*/
                $listName = \Config::get('newsletter.gxListName');
            }

            if (Newsletter::isSubscribed($email, $listName)) {
                $message = 'Already Subscribed.';
            } else {
                Newsletter::subscribe($email, [], $listName);
                $message = 'You have been subscribed successfully.';
            }
            return successResponse($message);
        } else {
            return errorResponse(__('Email is Required.'));
        }

    }
}
