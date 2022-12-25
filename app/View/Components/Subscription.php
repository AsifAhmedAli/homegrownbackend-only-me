<?php

namespace App\View\Components;

use App\Repositories\Braintree\Subscription\BraintreeSubscriptionService;
use Carbon\Carbon;
use Illuminate\View\Component;
use Illuminate\View\View;

class Subscription extends Component
{
  public $subscription;
  public $isCanceled = false;
  public $customer;
  
  /**
   * Create a new component instance.
   *
   * @param \Braintree\Subscription $subscription
   */
    public function __construct(\Braintree\Subscription $subscription)
    {
        $this->subscription = $subscription;
        $this->subscription->firstBillingDate = Carbon::parse($this->subscription->firstBillingDate)->format('Y-m-d');
        $this->subscription->nextBillingDate = Carbon::parse($this->subscription->nextBillingDate)->format('Y-m-d');
        $this->customer = BraintreeSubscriptionService::getCustomerBySubscription($subscription);
        $this->isCanceled = strtolower($subscription->status) == 'canceled';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('components.subscription');
    }
}
