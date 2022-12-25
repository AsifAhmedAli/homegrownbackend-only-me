<?php
  
  
  namespace App\Repositories\Stripe;
  
  
  use App\Exceptions\Response\ErrorResponseException;
  use Laravel\Cashier\Exceptions\CustomerAlreadyCreated;
  use Stripe\Customer;
  use Stripe\Exception\UnexpectedValueException;

  class StripeRepository extends StripePaymentMethods
  {
    private $options = [];
  
    /**
     * StripeRepository constructor.
     */
    public function __construct()
    {
      parent::__construct();
      // Init Options $this->options
    }
  
    /**
     * save customer to Stripe
     * @return Customer|null
     * @throws ErrorResponseException
     */
    public function save()
    {
      try {
        $stripeCustomer = $this->getUser()->createAsStripeCustomer($this->options);
      } catch (CustomerAlreadyCreated $exception) {
        $this->throw($exception->getMessage());
        $stripeCustomer = null;
      }
      
      return $stripeCustomer;
    }
  
    /**
     * @return Customer|null
     * @throws ErrorResponseException
     */
    public function update()
    {
      try {
        $stripeCustomer = $this->getUser()->updateStripeCustomer($this->options);
      } catch (UnexpectedValueException $exception) {
        $this->throw(self::userNotFound());
        $stripeCustomer = null;
      }
      
      return $stripeCustomer;
    }
  
    /**
     * get customer from Stripe
     * @return Customer
     */
    public function get(): Customer
    {
      return $this->getUser()->createOrGetStripeCustomer($this->options);
    }
  }
