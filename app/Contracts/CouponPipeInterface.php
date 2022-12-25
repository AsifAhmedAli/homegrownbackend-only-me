<?php
  
  
  namespace App\Contracts;
  
  
  use App\Contracts\Models\CouponCollection;
  use Closure;

  interface CouponPipeInterface
  {
    public function handle(CouponCollection $couponCollection, Closure $next);
  }
