<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Paypal\Subscription\PaypalSubscriptionService;
use App\Utils\Api\ApiResponse;
use App\Utils\Constants\ValidationMessage;
use App\Utils\Constants\ValidationRule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PaypalSubscriptionController extends Controller
{
  /**
   * @var PaypalSubscriptionService
   */
  private $paypalSubscriptionService;
  
  public function __construct(PaypalSubscriptionService $paypalSubscriptionService) {
    $this->paypalSubscriptionService = $paypalSubscriptionService;
  }
  
  /**
   * subscribe plan.
   *
   * @return JsonResponse
   */
  public function subscribe(Request $request)
  {
    $rules    = ValidationRule::paypalSubscription();
    $messages = ValidationMessage::paypalSubscription();
    try {
      $this->validate($request, $rules, $messages);
    } catch (ValidationException $e) {
      return errorResponse(__('generic.validation_errors'), $e->errors());
    }
    $data = $this->paypalSubscriptionService->subscribe($request->planId);
    return ApiResponse::successResponse('Subscribed', $data);
  }
}
