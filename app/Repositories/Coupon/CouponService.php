<?php


  namespace App\Repositories\Coupon;


  use App\Cart;
  use App\Contracts\Models\CouponCollection;
  use App\Coupon;
  use App\Hydro\HydroCategory;
  use App\Pipes\Coupon\CartExistsPipe;
  use App\Pipes\Coupon\CouponAlreadyAppliedPipe;
  use App\Pipes\Coupon\CouponExistsPipe;
  use App\Pipes\Coupon\CouponMinimumSpendPipe;
  use App\Pipes\Coupon\ValidCouponPipe;
  use App\Utils\Helpers\Helper;
  use Illuminate\Pipeline\Pipeline;

  class CouponService
  {
    public $couponCollection;
    public $discount;

    private $pipes = [
      CartExistsPipe::class,
      CouponExistsPipe::class,
      CouponAlreadyAppliedPipe::class,
      ValidCouponPipe::class,
      CouponMinimumSpendPipe::class
    ];

    /**
     * @param string|null $sessionID
     * @param string|null $code
     * @param bool $applyOnly
     */
    public function apply($sessionID, $code, $applyOnly = false)
    {
      $coupon = Coupon::findByCode($code);
      $cart = Cart::findBySessionID($sessionID);

      $this->couponCollection = new CouponCollection($coupon, $cart, $applyOnly);

      resolve(Pipeline::class)
        ->send($this->couponCollection)
        ->through($this->pipes)
        ->then(function (CouponCollection $couponCollection) {
          $this->calculate($couponCollection->cart, $couponCollection->coupon);
          Cart::applyCoupon($couponCollection->cart, $couponCollection->coupon, $this->discount);
        });
    }

    public function calculate(Cart $cart, Coupon $coupon)
    {
      $discount = (float)0;
      Cart::resetCoupon($cart);

      if ($coupon->isCategoryDiscount()) {
        $couponCategories = $coupon->categories()->pluck('hydro_id')->toArray();
        $couponCategories = HydroCategory::whereIn('hydro_id', $couponCategories)->orWhereIn('hydro_parent_id', $couponCategories)->pluck('hydro_id')->toArray();

        foreach ($cart->products as $cartProduct) {
          $product = $cartProduct->product;
          if(!Helper::empty($product)) {
            if (in_array($product->categoryid, $couponCategories)) {
              $discount += $this->calculateProductDiscount($cartProduct->quantity, $cartProduct->price, $coupon);
            }
          }
        }
      } else if($coupon->isProductDiscount()) {
        $couponProducts = $coupon->products()->pluck('id')->toArray();

        foreach ($cart->products as $cartProduct) {
          $productID = $cartProduct->hydro_product_id;
          if(in_array($productID, $couponProducts)) {
            $discount += $this->calculateProductDiscount($cartProduct->quantity, $cartProduct->price, $coupon);
          }
        }
      } else if($coupon->isKitDiscount()) {
          $couponProducts = $coupon->kits()->pluck('id')->toArray();

          foreach ($cart->products as $cartProduct) {
              $kitID = $cartProduct->kit_id;
              if(in_array($kitID, $couponProducts)) {
                  $discount += $this->calculateProductDiscount($cartProduct->quantity, $cartProduct->price, $coupon);
              }
          }
      }  else if($coupon->isSiteWide()) {
        $discount = $this->calculateProductDiscount(1, $cart->sub_total, $coupon);
      }

      $totalPrice = $cart->products->sum('price') * $cart->products->sum('quantity');
      if($totalPrice > $discount) {
          $this->discount = $discount;
      }

    }

    private function calculateProductDiscount(int $qty, $price, Coupon $coupon)
    {
      $discount = 0;

      if($coupon->isPercent()) {
        $percent = $coupon->amount / 100;
        $discount = $price * $qty * $percent;
      } else {
        if($price >= $coupon->amount) {
          $discount = $coupon->amount * $qty;
        }
      }

      return $discount;
    }

    public function remove(Cart $cart)
    {
      Cart::resetCoupon($cart);
    }
  }
