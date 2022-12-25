<?php
  
  
  namespace App\Repositories\Braintree\Subscription;

  use App\Repositories\Braintree\BraintreeBaseService;
  use App\Utils\Helpers\Helper;
  use Braintree\Plan;
  use App\Models\Subscription\Plan as MyPlan;
  use Braintree\ResourceCollection;
  use Illuminate\Support\Collection;

  class BraintreePlanService extends BraintreeBaseService
  {
    public const EXCLUDE_PLANS = ['Registration Subscription'];
  
    /**
     * BraintreePlanService constructor.
     */
    public function __construct()
    {
      parent::__construct();
      $this->sync($this->all());
    }
  
    /**
     * @return MyPlan[]
     */
    public function get()
    {
      $plans = $this->all();
      return $this->sync($plans);
    }
  
    /**
     * @return Collection
     */
    private function all()
    {
      $plans = collect(Plan::all());
      return $plans->whereNotIn('name', self::EXCLUDE_PLANS);
    }
  
    /**
     * @param Collection $plans
     * @return MyPlan[]
     */
    private function sync($plans)
    {
      foreach ($plans as $item) {
        $this->createOrUpdate($item);
      }
      MyPlan::whereNotIn('plan_id', $plans->pluck('id')->toArray())->delete();
      
      return MyPlan::get();
    }
  
    /**
     * @param Plan $planItem
     * @return MyPlan
     */
    private function createOrUpdate(Plan $planItem)
    {
      $plan = MyPlan::wherePlanId($planItem->id)->first();
      if(Helper::empty($plan)) {
        $plan = new MyPlan();
      }
      $plan->plan_id = $planItem->id;
      $plan->name = $planItem->name;
      $plan->merchant_id = $planItem->merchantId;
      $plan->billing_day_of_month = $planItem->billingDayOfMonth;
      $plan->billing_frequency = $planItem->billingFrequency;
      $plan->currency_iso_code = $planItem->currencyIsoCode;
      $plan->description = $planItem->description;
      $plan->number_of_billing_cycles = $planItem->numberOfBillingCycles;
      $plan->price = $planItem->price;
      $plan->trial_duration = $planItem->trialDuration;
      $plan->trial_duration_unit = $planItem->trialDurationUnit;
      $plan->trial_period = $planItem->trialPeriod;
      $plan->created_date = $planItem->createdAt;
      $plan->updated_date = $planItem->updatedAt;
      $plan->save();
      
      return $plan;
    }
  
    /**
     * @param $planID
     * @return ResourceCollection
     */
    public function subscriptions($planID)
    {
      $service = new BraintreeSubscriptionService($planID);
      
      return $service->getByPlan();
    }
  }
