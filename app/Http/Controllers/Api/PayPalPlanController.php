<?php
  
  namespace App\Http\Controllers\Api;
  
  use App\Http\Controllers\Controller;
  use App\PaypalPlan;
  use App\Repositories\Paypal\Subscription\PaypalPlanService;
  use App\Utils\Api\ApiResponse;
  use App\Utils\Constants\Paypal;

  class PayPalPlanController extends Controller
  {
    /**
     * @var PaypalPlanService
     */
    private $paypalPlanService;
  
    public function __construct()
    {
      $this->paypalPlanService = new PaypalPlanService();
    }
    public function getAllActivePlans(){
      $plans = PaypalPlan::status(Paypal::PLAN_ACTIVE_STATE)->get();
      return ApiResponse::successResponse('Paypal Plan list', $plans);
    }
  }
