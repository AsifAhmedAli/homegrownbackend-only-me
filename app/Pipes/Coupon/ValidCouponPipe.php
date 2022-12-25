<?php
  
  
  namespace App\Pipes\Coupon;
  
  
  use App\Contracts\CouponPipeInterface;
  use App\Contracts\Models\CouponCollection;
  use App\Exceptions\Response\ErrorResponseException;
  use App\Utils\Constants\Messages;
  use Closure;

  class ValidCouponPipe implements CouponPipeInterface
  {
    /**
     * @param CouponCollection $couponCollection
     * @param Closure $next
     * @return mixed|void
     * @throws ErrorResponseException
     */
    public function handle(CouponCollection $couponCollection, Closure $next)
    {
      if ($couponCollection->coupon->valid()) {
        return $next($couponCollection);
      }
      
      $couponCollection->throw(Messages::INVALID_COUPON);
    }
  }
