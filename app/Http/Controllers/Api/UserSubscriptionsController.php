<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserSubscriptionRequest;
use App\Mail\UserSubscriptionEmail;
use App\Repositories\UserSubscriptions\UserSubscriptionRepository;
use App\Utils\Api\ApiResponse;
use Mail;

class UserSubscriptionsController extends Controller
{
    protected $userSubscriptionRepository;

    public function __construct(UserSubscriptionRepository $userSubscriptionRepository)
    {
        $this->userSubscriptionRepository = $userSubscriptionRepository;
    }

    public function subscribe(UserSubscriptionRequest $request)
    {
        $response = $this->userSubscriptionRepository->subscribe($request);
        if ($response){
          Mail::to($response->user->email)->send(new UserSubscriptionEmail($response));
          return ApiResponse::successResponse(__('generic.subscribed_successfully'), $response);
        }else{
          return ApiResponse::errorResponse(__('generic.invalid_transaction_id'), $response);
        }
    }

    public function mySubscriptions() {

        $response = $this->userSubscriptionRepository->hasSubscribed();
        if ($response){
            return ApiResponse::errorResponse(__('generic.already_subscribed'), $response);
        }else{
            return ApiResponse::successResponse(__('generic.no_subscription_found'), $response);
        }
    }
}
