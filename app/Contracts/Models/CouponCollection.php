<?php
  
  
  namespace App\Contracts\Models;
  
  
  use App\Cart;
  use App\Coupon;
  use App\Exceptions\Response\ErrorResponseException;

  class CouponCollection
  {
    public $coupon;
    public $cart;
    public $applyOnly;
  
    /**
     * CouponCollection constructor.
     * @param Coupon $coupon
     * @param Cart $cart
     * @param bool $applyOnly
     */
    public function __construct($coupon, $cart, bool $applyOnly)
    {
      $this->coupon = $coupon;
      $this->cart = $cart;
      $this->applyOnly = $applyOnly;
    }
  
    /**
     * @param string $message
     * @param bool $resetCoupon
     * @throws ErrorResponseException
     */
    public function throw(string $message = '', $resetCoupon = true)
    {
      if($this->cart && $resetCoupon) {
        Cart::resetCoupon($this->cart);
      }
      if (!$this->applyOnly) {
        throw new ErrorResponseException($message);
      }
    }
  }
