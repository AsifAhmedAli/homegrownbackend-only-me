<?php
  
  
  namespace App\Observers;
  
  
  use App\Models\User;
  use App\PaypalPlan;
  use App\Repositories\Paypal\Subscription\PaypalPlanService;
  use App\Utils\Constants\Paypal;

  class PaypalPlanObserver
  {
    /**
     * Handle the User "created" event.
     *
     * @param PaypalPlan $plan
     * @return void
     */
    public function created(PaypalPlan $plan)
    {
    
    }
    
    private function getPlanById($id){
      return PaypalPlan::find($id);
    }
    
    /**
     * Handle the User "updated" event.
     *
     * @param PaypalPlan $plan
     * @return void
     */
    public function updated(PaypalPlan $plan)
    {
    }
    
    /**
     * Handle the User "deleted" event.
     *
     * @param PaypalPlan $plan
     * @return void
     */
    public function deleting(PaypalPlan $plan)
    {
    
    }
    
    
  }
