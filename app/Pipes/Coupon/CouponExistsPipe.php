<?php
  
  
  namespace App\Pipes\Coupon;
  
  
  use App\Contracts\CouponPipeInterface;
  use App\Contracts\Models\CouponCollection;
  use App\Exceptions\Response\ErrorResponseException;
  use App\Utils\Constants\Messages;
  use App\Utils\Helpers\Helper;
  use Closure;

  class CouponExistsPipe implements CouponPipeInterface
  {
    /**
     * @param CouponCollection $couponCollection
     * @param Closure $next
     * @return mixed
     * @throws ErrorResponseException
     */
    public function handle(CouponCollection $couponCollection, Closure $next)
    {
      if (Helper::empty($couponCollection->coupon)) {
        $couponCollection->throw(Messages::INVALID_COUPON);
      }
      
      return $next($couponCollection);
    }
  }
