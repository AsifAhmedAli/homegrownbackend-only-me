<?php

namespace App\Repositories\Paypal\Subscription;

use App\PaypalPlan;
use App\Repositories\Paypal\PaypalBaseService;
use App\Utils\Constants\Paypal;
use App\Utils\Helpers\Helper;

class PaypalPlanService extends PaypalBaseService
{
  
  public function __construct()
  {
    parent::__construct();
  }
  public function verifySubscription($transactionId){
    $this->setMethod(Paypal::REQ_GET_METHOD);
    $this->setAPIURL(Paypal::CHECKOUT_API_ENDPOINT.$transactionId);
    return $this->process();
  }
  public function sync()
  {
    $plans = $this->getAllPlans();
    if (isset($plans) && !empty($plans)) {
      foreach ($plans as $plan) {
        $planDetail = $this->getPlanDetail($plan->id);
        $this->createOrUpdate($planDetail);
      }
              PaypalPlan::whereNotIn('plan_id', $plans->pluck('id')->toArray())->delete();
    }
  }
  
  public function getAllPlans()
  {
    $this->setAPIURL(Paypal::PLAN_API_ENDPOINT);
    $this->setMethod('get');
    $response = $this->process();
    if (isset($response->plans) && !empty($response->plans))
    {
      return collect($response->plans);
    }else{
      return NULL;
    }
    
    
    
  }
  
  private function getPlanDetail($plan_id)
  {
    $this->setAPIURL(Paypal::PLAN_API_ENDPOINT . '/' . $plan_id);
    $this->setMethod('get');
    return $this->process();
  }
  
  /**
   * @param PaypalPlan $planItem
   * @return MyPlan
   */
  private function createOrUpdate($planItem)
  {
    $plan = PaypalPlan::wherePlanId($planItem->id)->first();
    if (Helper::empty($plan)) {
      $plan = new PaypalPlan();
    }
    $plan->plan_id    = $planItem->id;
    $plan->product_id = $planItem->product_id;
    $plan->name       = $planItem->name;
    $plan->state      = $planItem->status;
    if (isset($planItem->description) && !empty($planItem->description)) {
      $plan->description = $planItem->description;
    }
    $plan->usage_type            = $planItem->usage_type;
    $plan->created_date          = $planItem->create_time;
    $plan->updated_date          = $planItem->update_time;
    $plan->missed_cycles         = $planItem->payment_preferences->payment_failure_threshold;
    $plan->auto_bill_outstanding = $planItem->payment_preferences->auto_bill_outstanding;
    $plan->setup_fee             = $planItem->payment_preferences->setup_fee->value;
    $plan->save();
    foreach ($planItem->billing_cycles as $billing_cycle) {
      $plan->amount           = $billing_cycle->pricing_scheme->fixed_price->value;
      $plan->frequency        = $billing_cycle->frequency->interval_unit;
    $plan->frequency_interval = $billing_cycle->frequency->interval_count;
    $plan->tenure_type = $billing_cycle->tenure_type;
    $plan->save();
    }
    
    return $plan;
  }
  

}
