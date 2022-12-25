<?php
  
  
  namespace App\Repositories\Stripe;
  
  
  use Stripe\StripeClient;

  class StripeBase extends StripeConstants
  {
    protected $stripe;
    public function __construct()
    {
      $this->stripe = new StripeClient(env('STRIPE_SECRET'));
    }
  }
