<?php
  
  
  namespace App\Repositories\Stripe;
  
  
  use App\Exceptions\Response\ErrorResponseException;
  use Illuminate\Support\Collection;
  use Laravel\Cashier\PaymentMethod;
  use Stripe\Exception\InvalidRequestException;
  use Stripe\SetupIntent;

  class StripePaymentMethods extends StripeSubscription
  {
    /**
     * StripePaymentMethods constructor.
     */
    public function __construct()
    {
      parent::__construct();
    }
  
    /**
     * @param $paymentMethodID
     * @return \Stripe\PaymentMethod
     * @throws ErrorResponseException
     */
    public function addPaymentMethod($paymentMethodID)
    {
      try {
        $paymentMethod = $this->getUser()->addPaymentMethod($paymentMethodID);
      } catch (InvalidRequestException $exception) {
        $this->throw($exception->getMessage());
        $paymentMethod = null;
      }
    
      $this->syncDefaultPaymentMethodFromStripe();
      if (!$this->hasDefaultPaymentMethod()) {
        $this->getUser()->updateDefaultPaymentMethod($paymentMethodID);
      }
    
      return $paymentMethod->asStripePaymentMethod();
    }
  
    /**
     * @return Collection|PaymentMethod[]
     */
    public function getPaymentMethods()
    {
      $methods = $this->getUser()->paymentMethods();
    
      $methods = $methods->map(function (PaymentMethod $item) {
        return $item->asStripePaymentMethod();
      });
    
      return $methods;
    }
  
    /**
     * @return void
     */
    public function syncDefaultPaymentMethodFromStripe()
    {
      $this->getUser()->updateDefaultPaymentMethodFromStripe();
    }
  
    /**
     * @param $paymentMethodID
     * @return \Stripe\PaymentMethod
     * @throws ErrorResponseException
     */
    public function deletePaymentMethod($paymentMethodID)
    {
      $paymentMethod = $this->findPaymentMethod($paymentMethodID);
    
      $defaultPaymentMethod = $this->getDefaultPaymentMethod();
    
      if (!is_null($defaultPaymentMethod)) {
        if ($paymentMethod->asStripePaymentMethod()->id == $defaultPaymentMethod->asStripePaymentMethod()->id) {
          if ($this->isSubscribed()) {
            $this->throw(self::paymentMethodCannotBeDeleted());
          }
        }
      }
    
      return $paymentMethod->delete();
    }
  
    /**
     * @return void
     */
    public function deleteAllPaymentMethods()
    {
      $this->getUser()->deletePaymentMethods();
    }
  
    /**
     * @return SetupIntent
     */
    public function intent()
    {
      return $this->getUser()->createSetupIntent();
    }
  }
