<?php
  
  
  namespace App\Repositories\Stripe;
  
  
  use App\Exceptions\Response\ErrorResponseException;
  use App\Utils\Traits\SetterGetter;
  use App\Utils\Traits\ThrowTrait;
  use Laravel\Cashier\PaymentMethod;
  use Stripe\BankAccount;
  use Stripe\Card;

  trait StripeCommonMethods
  {
    use SetterGetter, ThrowTrait;
    
    /**
     * @return PaymentMethod|BankAccount|Card|null
     */
    public function getDefaultPaymentMethod()
    {
      return $this->getUser()->defaultPaymentMethod();
    }
  
    /**
     * @return bool
     */
    public function hasDefaultPaymentMethod()
    {
      return $this->getUser()->hasDefaultPaymentMethod();
    }
  
    /**
     * @param $paymentMethodID
     * @return PaymentMethod|null
     * @throws ErrorResponseException
     */
    public function findPaymentMethod($paymentMethodID)
    {
      $paymentMethod = $this->getUser()->findPaymentMethod($paymentMethodID);
    
      if (is_null($paymentMethod)) {
        $this->throw(StripeConstants::paymentMethodNotFound());
      }
    
      return $paymentMethod;
    }
  }
