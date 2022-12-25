<?php

namespace App\Http\Controllers\Voyager;


use App\Repositories\Braintree\Subscription\BraintreePlanService;

class VoyagerPlanController extends VoyagerController
{
  public function __construct(BraintreePlanService $braintreePlanService)
  {
  }
}
