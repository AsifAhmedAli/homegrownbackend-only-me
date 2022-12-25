<?php
  
  
  namespace App\Repositories\Braintree;
  
  
  use App\User;
  use Braintree_PaymentMethod;
  use Exception;

  class BraintreePaymentMethodService extends BraintreeBaseService
  {
    private $user;
    private $customerService;
    
    public function __construct(User $user)
    {
      parent::__construct();
      $this->user = $user;
      $this->customerService = new BraintreeCustomerService($this->user);
    }
  
    /**
     * @param $nonce
     * @return mixed|null
     */
    public function save($nonce)
    {
      $customer = $this->customerService->find();
      if (!is_null($customer)) {
        $paymentMethodCreation = Braintree_PaymentMethod::create([
          'customerId' => $this->user->id,
          'paymentMethodNonce' => $nonce,
          'options' => [
            'verifyCard' => true,
          ],
        ]);
      } else {
        $paymentMethodCreation = null;
      }
      return $paymentMethodCreation;
    }
  
    public function delete($token)
    {
      try {
        $payment = Braintree_PaymentMethod::find($token);
        if ($payment->customerId == $this->user->id) {
          try {
            $deleteResponse = Braintree_PaymentMethod::delete($token);
            $response = $deleteResponse->success;
          } catch (Exception $e) {
            $response = false;
          }
        } else {
          $response = false;
        }
      } catch (Exception $e) {
        $response = false;
      }
      return $response;
    }
  
    /**
     * @param $token
     * @return mixed
     */
    public function makeDefault($token)
    {
      try {
        $payment = Braintree_PaymentMethod::find($token);
        if ($payment->customerId == $this->user->id) {
          try {
            $statusUpdated = Braintree_PaymentMethod::update($token, [
              'options' => [
                'makeDefault' => true,
              ],
            ]);
            $response = $statusUpdated->success;
          } catch (Exception $e) {
            $response = false;
          }
        } else {
          $response = false;
        }
      } catch (Exception $e) {
        $response = false;
      }
      return $response;
    }
  }
