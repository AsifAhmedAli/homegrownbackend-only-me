<?php
  
  
  namespace App\Repositories\Braintree;
  
  
  use Braintree_Configuration;

  class BraintreeBaseService
  {
    public function __construct()
    {
      $this->init();
    }
    
    protected function init()
    {
      $env = config('services.braintree.env');
      $merchantID = config("services.braintree.braintree_{$env}_merchant_id");
      $publicKey = config("services.braintree.braintree_{$env}_public_key");
      $privateKey = config("services.braintree.braintree_{$env}_private_key");
      Braintree_Configuration::environment($env);
      Braintree_Configuration::merchantId($merchantID);
      Braintree_Configuration::publicKey($publicKey);
      Braintree_Configuration::privateKey($privateKey);
    }
  }
