<?php

namespace App\Http\Controllers\Api;

use App\Cart;
use App\Exceptions\Response\ErrorResponseException;
use App\Http\Controllers\Controller;
use App\Repositories\Coupon\CouponService;
use App\Utils\Api\ApiResponse;
use App\Utils\Constants\Messages;
use App\Utils\Helpers\Helper;
use Exception;
use Illuminate\Http\JsonResponse;

class CouponController extends Controller
{
  private $couponService;

  public function __construct(CouponService $couponService)
  {
    parent::__construct();
    $this->couponService = $couponService;
  }

  /**
   * @param string $sessionID
   * @return JsonResponse
   * @throws Exception
   */
  public function apply(string $sessionID)
  {
    $code = request('coupon');
    $this->couponService->apply($sessionID, $code);

    $response['cart'] = Cart::findCartById(optional(optional(optional($this->couponService)->couponCollection)->cart)->id);
    if (Helper::empty($response['cart'])) {
      return ApiResponse::cart(422, Messages::CART_CLEARED);
    }
    if ($this->couponService->discount > 1) {
      $response['message'] = Messages::COUPON_APPLIED;
    } else {
      $response['message'] = Messages::COUPON_NOT_APPLIED;
      throw new ErrorResponseException($response['message']);
    }
    return ApiResponse::success($response);
  }

  /**
   * @param CouponService $couponService
   * @param string $sessionID
   * @return JsonResponse
   * @throws Exception
   */
  public function remove(CouponService $couponService, string $sessionID)
  {
    $cart = Cart::findBySessionID($sessionID);

    if ($cart) {
      $couponService->remove($cart);
      $response['cart'] = Cart::findCartById($cart->id);
      if (Helper::empty($response['cart'])) {
        return ApiResponse::cart(422, Messages::CART_CLEARED);
      }

      $response['message'] = Messages::COUPON_REMOVED;
      return ApiResponse::success($response);
    } else {
      return ApiResponse::cart(422);
    }
  }
}
