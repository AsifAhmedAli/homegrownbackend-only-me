<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\Response\ErrorResponseException;
use App\Http\Controllers\Controller;
use App\Repositories\Stripe\StripeConstants;
use App\Repositories\Stripe\StripeRepository;
use App\User;
use App\Utils\Api\ApiResponse;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Laravel\Cashier\Exceptions\PaymentActionRequired;
use Laravel\Cashier\Exceptions\PaymentFailure;
use Stripe\Customer;

class StripeController extends Controller
{
  private $stripe;
  
  /**
   * StripeController constructor.
   * @param StripeRepository $stripeRepository
   */
  public function __construct(StripeRepository $stripeRepository)
  {
    $this->stripe = $stripeRepository;
    $user = User::find(3);
    $this->stripe->setUser($user);
  }
  
  /**
   * @return void
   */
  public function saveAllCustomers()
  {
    $customers = User::nonStripe()->customers();
    
    foreach ($customers->cursor() as $customer)
    {
      $this->stripe->setUser($customer);
      // $this->stripe->get(); //Either use this line rather than below try-catch
      try {
        $this->stripe->save();
      } catch (ErrorResponseException $exception) {

      }
    }
  }
  
  /**
   * @return Customer
   */
  public function getCustomer()
  {
    return $this->stripe->get();
  }
  
  /**
   * @throws ErrorResponseException
   */
  public function saveCustomer()
  {
    return $this->stripe->save();
  }
  
  /**
   * @throws ErrorResponseException
   */
  public function updateCustomer()
  {
    return $this->stripe->update();
  }
  
  /**
   * @return Factory|View
   */
  public function showPaymentMethodForm()
  {
    $data['intent'] = $this->stripe->intent();
    
    return view('stripe.update-payment-method', $data);
  }
  
  /**
   * @param $paymentMethod
   * @return JsonResponse
   * @throws ErrorResponseException
   */
  public function addPaymentMethod($paymentMethod)
  {
    $data['method'] = $this->stripe->addPaymentMethod($paymentMethod);
  
    return ApiResponse::success($data);
  }
  
  /**
   * @return JsonResponse
   * @throws ErrorResponseException
   */
  public function getDefaultPaymentMethod()
  {
    $method = $this->stripe->getDefaultPaymentMethod();
    
    if (!$this->stripe->hasDefaultPaymentMethod() || is_null($method)) {
      $this->throw(StripeConstants::noDefaultPaymentMethodFound());
    }
    
    $data['method'] = $method->asStripePaymentMethod();
  
    return ApiResponse::success($data);
  }
  
  /**
   * @param $paymentMethod
   * @return JsonResponse
   * @throws ErrorResponseException
   */
  public function getPaymentMethod($paymentMethod)
  {
    $data['method'] = $this->stripe->findPaymentMethod($paymentMethod)->asStripePaymentMethod();
    
    return ApiResponse::success($data);
  }
  
  /**
   * @return void
   */
  public function setSubscriptionNameAndPlan()
  {
    $this->stripe->setSubscriptionName(StripeConstants::DEFAULT_SUBSCRIPTION_NAME);
    
    // Here we can fetch plan from Database table Stripe Plans and pass that stripe id column in below function
    $this->stripe->setSubscriptionPlan(StripeConstants::DEFAULT_SUBSCRIPTION_PLAN);
  }
  
  /**
   * @param $paymentMethod
   * @return JsonResponse
   * @throws ErrorResponseException
   */
  public function deletePaymentMethod($paymentMethod)
  {
    $this->setSubscriptionNameAndPlan();
    $this->stripe->deletePaymentMethod($paymentMethod);
    
    return ApiResponse::success(StripeConstants::paymentMethodDeleted());
  }
  
  public function deleteAllPaymentMethods()
  {
    $this->setSubscriptionNameAndPlan();
    $this->stripe->deleteAllPaymentMethods();
    
    return ApiResponse::success(StripeConstants::paymentMethodsDeleted());
  }
  
  public function getPaymentMethods()
  {
    $data['methods'] = $this->stripe->getPaymentMethods();
    
    return ApiResponse::success($data);
  }
  
  /**
   * @throws PaymentActionRequired
   * @throws PaymentFailure
   * @throws ErrorResponseException
   */
  public function createSubscription()
  {
    $this->setSubscriptionNameAndPlan();
    $this->stripe->setPaymentMethod();
    if ($this->stripe->isSubscribedToPlan()) {
      $this->throw(StripeConstants::alreadySubscribedToPlan($this->stripe->getSubscriptionPlan()));
    } else {
      return $this->stripe->createSubscription();
    }
  }
}
