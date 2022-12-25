<?php
  
  
  namespace App\Pipes\Coupon;
  
  
  use App\Contracts\CouponPipeInterface;
  use App\Contracts\Models\CouponCollection;
  use App\Exceptions\Response\ErrorResponseException;
  use App\Utils\Constants\Messages;
  use App\Utils\Helpers\Helper;
  use Closure;

  class CouponAlreadyAppliedPipe implements CouponPipeInterface
  {
    /**
     * @param CouponCollection $couponCollection
     * @param Closure $next
     * @return mixed|void
     * @throws ErrorResponseException
     */
    public function handle(CouponCollection $couponCollection, Closure $next)
    {
      if (Helper::empty($couponCollection->cart->coupon_code)) {
        return $next($couponCollection);
      }
  
      if($couponCollection->cart->coupon_code != $couponCollection->coupon->code) {
        return $next($couponCollection);
      }
      
      if($couponCollection->applyOnly) {
        return $next($couponCollection);
      } else {
        $couponCollection->throw(Messages::COUPON_ALREADY_APPLIED, false);
      }
    }
  }
