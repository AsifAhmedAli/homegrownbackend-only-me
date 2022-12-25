<?php
  
  
  namespace App\Repositories\Braintree\Subscription;
  
  
  use App\Exceptions\Response\ErrorResponseException;
  use App\Repositories\Braintree\BraintreeBaseService;
  use App\User;
  use App\Utils\Helpers\Helper;
  use App\Utils\Traits\ThrowTrait;
  use Braintree\Exception\NotFound;
  use Braintree\ResourceCollection;
  use Braintree\Result\Error;
  use Braintree\Result\Successful;
  use Braintree\Subscription;
  use Braintree\SubscriptionSearch;
  use Braintree\Transaction\CustomerDetails;
  use Illuminate\Database\Eloquent\Builder;
  use Illuminate\Database\Eloquent\Model;
  use Illuminate\Support\Optional;

  class BraintreeSubscriptionService extends BraintreeBaseService
  {
    use ThrowTrait;
    private $planID;
    private $paymentMethodToken = null;
    private $paymentMethodNonce = null;
  
    /**
     * BraintreeSubscriptionService constructor.
     * @param $planID
     */
    public function __construct($planID = null)
    {
      parent::__construct();
      $this->setPlanID($planID);
    }
  
    /**
     * @param $planID
     * @return BraintreeSubscriptionService
     */
    public function setPlanID($planID)
    {
      $this->planID = $planID;
      
      return $this;
    }
  
    /**
     * @param $token
     * @return BraintreeSubscriptionService
     */
    public function setPaymentMethodToken($token)
    {
      $this->paymentMethodToken = $token;
      
      return $this;
    }
  
    /**
     * @param $nonce
     * @return BraintreeSubscriptionService
     */
    public function setPaymentMethodNonce($nonce)
    {
      $this->paymentMethodNonce = $nonce;
      
      return $this;
    }
  
    /**
     * @param $id
     * @return Subscription|void
     * @throws ErrorResponseException
     */
    public function find($id)
    {
      try {
        return Subscription::find($id);
      } catch (NotFound $exception) {
        $this->throw('Subscription Not Found');
      }
    }
  
    /**
     * @param $id
     * @return Error|Successful
     * @throws ErrorResponseException
     */
    public function cancel($id)
    {
      $subscription = $this->find($id);
      
      return Subscription::cancel($subscription->id);
    }
  
    /**
     * @return Error|Successful
     */
    public function save()
    {
      return Subscription::create($this->getAttributes());
    }
  
    /**
     * @return array
     */
    public function getAttributes()
    {
      $params['planId'] = $this->planID;
      if($this->paymentMethodToken) {
        $params['paymentMethodToken'] = $this->paymentMethodToken;
      }else if($this->paymentMethodNonce) {
        $params['paymentMethodNonce'] = $this->paymentMethodNonce;
      }
      
      return $params;
    }
  
    /**
     * @return ResourceCollection
     */
    public function getByPlan()
    {
      return Subscription::search([
        SubscriptionSearch::planId()->is($this->planID)
      ]);
    }
  
  
    /**
     * @param Subscription $subscription
     * @param bool $fromDB
     * @return User|Builder|Model|object|null|CustomerDetails|Optional
     */
    public static function getCustomerBySubscription(Subscription $subscription, bool $fromDB = false)
    {
      $customer = null;
      $transaction = Helper::arrayIndex($subscription->transactions, 0);
      if($transaction) {
        $customer = (object)$transaction->customer;
        if($fromDB) {
          $customer = User::whereEmail($customer->email)->first();
        }
      }
      
      return optional($customer);
    }
  }
