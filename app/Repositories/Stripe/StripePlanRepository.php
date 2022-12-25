<?php
  
  
  namespace App\Repositories\Stripe;
  
  
  use App\Exceptions\Response\ErrorResponseException;
  use App\Stripe\StripePlan;
  use App\Stripe\StripeProduct;
  use App\Utils\Traits\ThrowTrait;
  use Stripe\Exception\ApiErrorException;

  class StripePlanRepository extends StripeBase
  {
    use ThrowTrait;
    
    private $name;
    private $amount;
    private $currency;
    private $interval;
    private $product;
    
    public function __construct()
    {
      parent::__construct();
    }
  
    /**
     * @param string $name
     * @param int|float|double $amount
     * @param string $currency
     * @param string $interval
     * @param int $productID
     */
    public function setValues(string $name, $amount, string $currency, string $interval, int $productID)
    {
      $this->setPlanName($name);
      $this->setPlanAmount($amount);
      $this->setPlanCurrency($currency);
      $this->setPlanInterval($interval);
      $this->setPlanProduct($this->resolveProduct($productID));
    }
    
    private function resolveProduct(int $productID)
    {
      return StripeProduct::findOrFail($productID);
    }
  
    /**
     * @param string $name
     */
    public function setPlanName(string $name)
    {
      $this->name = $name;
    }
  
    /**
     * @param $amount
     */
    public function setPlanAmount($amount)
    {
      $this->amount = $amount;
    }
  
    /**
     * @param string $currency
     */
    public function setPlanCurrency(string $currency)
    {
      $this->currency = $currency;
    }
  
    /**
     * @param string $interval
     */
    public function setPlanInterval(string $interval)
    {
      $this->interval = $interval;
    }
  
    /**
     * @param StripeProduct $product
     */
    public function setPlanProduct(StripeProduct $product)
    {
      $this->product = $product;
    }
  
    /**
     * @return StripeProduct
     */
    private function getPlanProduct(): StripeProduct
    {
      return $this->product;
    }
  
    /**
     * @return StripePlan
     * @throws ErrorResponseException
     */
    public function createPlan()
    {
      $response = null;
      try {
        $response = $this->stripe->plans->create([
          'nickname' => $this->name,
          'amount'   => $this->amount,
          'currency' => $this->currency,
          'interval' => $this->interval,
          'product'  => $this->getPlanProduct()->stripe_id,
        ]);
      } catch (ApiErrorException $e) {
        $this->throw($e->getMessage());
      }
      
      $plan = new StripePlan;
      $plan->stripe_product_id = $this->getPlanProduct()->id;
      $plan->stripe_id = $response->id;
      $plan->object = $response->object;
      $plan->active = $response->active;
      $plan->aggregate_usage = $response->aggregate_usage;
      $plan->amount = $response->amount;
      $plan->amount_decimal = $response->amount_decimal;
      $plan->billing_scheme = $response->billing_scheme;
      $plan->currency = $response->currency;
      $plan->interval = $response->interval;
      $plan->interval_count = $response->interval_count;
      $plan->livemode = $response->livemode;
      $plan->nickname = $response->nickname;
      $plan->product = $response->product;
      $plan->usage_type = $response->usage_type;
      $plan->trial_period_days = $response->trial_period_days;
      $plan->save();
      
      return $plan;
    }
  }
