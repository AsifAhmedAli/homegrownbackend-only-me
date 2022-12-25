<?php

namespace App\Http\Controllers\Voyager;

use App\Exceptions\Response\ErrorResponseException;
use App\Models\Subscription\Plan;
use App\Repositories\Braintree\Subscription\BraintreePlanService;
use App\Repositories\Braintree\Subscription\BraintreeSubscriptionService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VoyagerPlanSubscriptionController extends VoyagerController
{
  /**
   * @param $id
   * @param BraintreePlanService $planService
   * @return Factory|View
   */
  public function planSubscriptions(BraintreePlanService $planService, $id)
  {
    $data['plan'] = Plan::findByPlan($id);
    $data['subscriptions'] = $planService->subscriptions($id);
    
    return view('voyager::plans.subscriptions', $data);
  }
  
  /**
   * @param BraintreeSubscriptionService $subscriptionService
   * @param $subscriptionID
   * @return RedirectResponse
   * @throws ErrorResponseException
   */
  public function cancel(BraintreeSubscriptionService $subscriptionService, $subscriptionID)
  {
    $subscriptionService->cancel($subscriptionID);
    session()->flash('success_message', 'Subscription Canceled Successfully');
    
    return back();
  }
}
