<?php
  
  namespace App\Repositories\Paypal\Subscription;
  use App\Exceptions\Response\ErrorResponseException;
  use App\Exceptions\Response\JsonResponseException;
  use App\Repositories\Paypal\PaypalBaseService;
  use App\Utils\Api\ApiResponse;
  use Illuminate\Support\Facades\Config;
  use PayPal\Api\Agreement;
  use PayPal\Api\Payer;
  use PayPal\Api\Plan;
  use PayPal\Api\ShippingAddress;
  use PayPal\Auth\OAuthTokenCredential;
  use PayPal\Rest\ApiContext;
  use Exception;
  class PaypalSubscriptionService extends PaypalBaseService
  {
    public function __construct()
    {
      parent::__construct();
    }
    public function subscribe($planId) {
      $agreement = new Agreement();
  
      $agreement->setName('Base Agreement')
        ->setDescription('Basic Agreement')
        ->setStartDate('2030-01-01T00:00:00Z');
  
      $plan = new Plan();
      $plan->setId($planId);
      $agreement->setPlan($plan);
  
      $payer = new Payer();
      $payer->setPaymentMethod('paypal');
      $agreement->setPayer($payer);
  
      $shippingAddress = new ShippingAddress();
      $shippingAddress->setLine1('111 First Street')
        ->setCity('Saratoga')
        ->setState('CA')
        ->setPostalCode('95070')
        ->setCountryCode('US');
      $agreement->setShippingAddress($shippingAddress);
  
      $request = clone $agreement;
      try {
        $agreement = $agreement->create($this->apiContext);
        $approvalUrl = $agreement->getApprovalLink();
      } catch (Exception $ex) {
        $data['request'] = $request;
        $data['ex'] = $ex->getData();
        throw new JsonResponseException($data);
      }
      $data['agreement']  = json_decode($agreement);
      $data['message'] = 'Agreement';
      $data['approvalUrl'] = $approvalUrl;
      return $data;
    }
  }
