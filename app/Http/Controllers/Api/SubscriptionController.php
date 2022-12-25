<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscription\Plan;
use App\Repositories\Braintree\BraintreeCustomerService;
use App\Repositories\Braintree\Subscription\BraintreePlanService;
use App\Repositories\Braintree\Subscription\BraintreeSubscriptionService;
use App\User;
use Braintree\Exception\NotFound;
use Braintree\PaymentMethod;
use Braintree\PaymentMethodNonce;
use Exception;

class SubscriptionController extends Controller
{
  private $plan;
  private $planService;
  private $user;
  
  public function __construct(Plan $plan, BraintreePlanService $planService)
  {
    $this->plan = $plan;
    $this->planService = $planService;
    $this->user = auth()->guard('api')->user();
  }
  
  public function getPlans()
  {
    $response['annual_plans'] = $this->plan->select('plan_id', 'name', 'description', 'web_description', 'price')->annual()->get();
    $response['monthly_plans'] = $this->plan->select('plan_id', 'name', 'description', 'web_description', 'price')->annual(false)->get();
    
    return response()->json($response);
  }
  
  public function subscribe($planID)
  {
    $service = new BraintreeSubscriptionService($planID);
    $nonce = request('payment_nonce', null);
    $payment_token = request('payment_token', null);
    try {
      $user = User::find($this->user->id);
      $customerService = new BraintreeCustomerService($user);
      $customerService->save();
    } catch (Exception $exception) {}
    
    try {
      if($nonce) {
        PaymentMethodNonce::find($nonce);
        $service->setPaymentMethodNonce($nonce);
      } else if($payment_token) {
        $paymentMethod = PaymentMethod::find($payment_token);
        if($paymentMethod->email == $this->user->email) {
          $service->setPaymentMethodToken($payment_token);
        } else {
          $this->throw('You cannot process the Payment!');
        }
      }
    } catch (NotFound $exception) {
      $this->throw($exception->getMessage());
    }
    $response = $service->save();
    if($response->success) {
      $data['response'] = $response;
      $code = 200;
    } else {
      $data['message'] = $response->message;
      $code = 422;
    }
    return response()->json($data, $code);
  }
}
