<?php
  
  
  namespace App\Repositories\Braintree;
  
  
  use App\User;
  use Braintree\Customer;
  use Braintree\Exception\NotFound;
  use Braintree\Result\Error;
  use Braintree\Result\Successful;
  use Braintree_Customer;
  use Exception;

  class BraintreeCustomerService extends BraintreeBaseService
  {
    private $user;
  
    /**
     * BraintreeCustomerService constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
      parent::__construct();
      $this->user = $user;
    }
  
    /**
     * @return Error|Successful
     */
    public function save()
    {
      return Braintree_Customer::create([
        'id' => $this->user->id,
        'firstName' => $this->user->first_name,
        'lastName' => $this->user->last_name,
        'email' => $this->user->email,
      ]);
    }
  
    /**
     * @return Customer|null
     */
    public function find()
    {
      $customer = null;
      try {
        $customer = Braintree_Customer::find($this->user->id);
      } catch (Exception $e) {
        if ($e instanceof NotFound) {
          $this->save();
          try {
            $customer = Braintree_Customer::find($user->id);
          } catch (Exception $e) {
            // Customer not found
          }
        }
      }
      return $customer;
    }
  }
