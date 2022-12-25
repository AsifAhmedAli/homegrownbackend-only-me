<?php
  
  
  namespace App\Pipes\Coupon;
  
  
  use App\Contracts\CouponPipeInterface;
  use App\Contracts\Models\CouponCollection;
  use Closure;

  class CouponMinimumSpendPipe implements CouponPipeInterface
  {
    public function handle(CouponCollection $couponCollection, Closure $next)
    {
      if($couponCollection->coupon->notSpentTheRequiredAmount($couponCollection->cart))
      {
        $couponCollection->throw("Minimum Spent should be $" . $couponCollection->coupon->minimum_spent);
      }
      
      return $next($couponCollection);
    }
  }
