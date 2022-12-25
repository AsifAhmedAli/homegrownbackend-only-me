<?php
  
  
  namespace App\Repositories\Stripe;
  
  
  use App\Exceptions\Response\ErrorResponseException;
  use Laravel\Cashier\Exceptions\PaymentActionRequired;
  use Laravel\Cashier\Exceptions\PaymentFailure;
  use Stripe\Exception\InvalidRequestException;
  use Stripe\PaymentMethod;

  class StripeSubscription extends StripeConstants
  {
    use StripeCommonMethods;
    
    private $name;
    private $plan;
    private $paymentMethod;
    private $customerOptions     = [];
    private $subscriptionOptions = [];
  
    /**
     * StripeSubscription constructor.
     */
    public function __construct()
    {
    }
  
    /**
     * @param string $name
     */
    public function setSubscriptionName(string $name)
    {
      $this->name = $name;
    }
  
    /**
     * @return string
     */
    public function getSubscriptionName(): string
    {
      return $this->name;
    }
  
    /**
     * @param string $plan
     */
    public function setSubscriptionPlan(string $plan)
    {
      $this->plan = $plan;
    }
  
    /**
     * @return string
     */
    public function getSubscriptionPlan(): string
    {
      return $this->plan;
    }
    
    /**
     * @param PaymentMethod|null $method
     * @throws ErrorResponseException
     */
    public function setPaymentMethod($method = null)
    {
     if (is_null($method)) {
       $this->paymentMethod = $this->getDefaultPaymentMethod();
       if (!is_null($this->paymentMethod)) {
         $this->paymentMethod = $this->paymentMethod->asStripePaymentMethod();
       }
     } else {
       $this->paymentMethod = $method;
     }
     
     if (is_null($this->paymentMethod)) {
       $this->throw(self::noPaymentFoundForSubscription());
     }
    }
  
    /**
     * @throws PaymentActionRequired
     * @throws PaymentFailure
     * @throws ErrorResponseException
     */
    public function createSubscription()
    {
      try {
        $subscription = $this->getUser()->newSubscription($this->name, $this->plan)->create(
          $this->paymentMethod,
          $this->customerOptions,
          $this->subscriptionOptions
        );
      } catch (InvalidRequestException $exception) {
        $this->throw($exception->getMessage());
        $subscription = null;
      }
      
      return $subscription;
    }
  
    /**
     * @return bool
     */
    public function isSubscribedToPlan()
    {
      return $this->getUser()->subscribed(
        $this->name,
        $this->plan
      );
    }
  
    /**
     * @return bool
     */
    public function isSubscribed()
    {
      return $this->getUser()->subscribed(
        $this->name
      );
    }
  }
