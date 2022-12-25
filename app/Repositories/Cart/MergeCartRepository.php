<?php
  
  
  namespace App\Repositories\Cart;
  
  use App\Cart;
  use App\CartProduct;
  use App\User;
  use App\Utils\Helpers\Helper;
  use Exception;

  class MergeCartRepository
  {
    /**
     * @param User $user
     * @param string $serverSessionID
     * @param callable $response
     * @return mixed|null
     */
    public static function afterLogin(User $user, string $serverSessionID, callable $response)
    {
      $sessionID = null;
      try {
        $resolveCartResponse = self::mergeCarts(request('sessionID', null), $user->id, $serverSessionID);
        $cartID              = $resolveCartResponse['cartID'];
        if ($resolveCartResponse['sessionUpdated']) {
          $sessionID = $serverSessionID;
        }
      } catch (Exception $e) {
        $cartID = null;
      }
      $response($sessionID);
    
      return $cartID;
    }
  
    /**
     * @param $sessionID
     * @param $userID
     * @param null $serverSessionID
     * @return array
     * @throws Exception
     */
    public static function mergeCarts($sessionID, $userID, $serverSessionID = null): array
    {
      $response['sessionUpdated'] = false;
      $cartID = null;
      $sessionCart = Cart::findBySessionID($sessionID);
      $userCart = Cart::findByUserID($userID);
    
      if ($sessionCart && $userCart) {
        $cartID = $sessionCart->id;
        if($sessionCart->id != $userCart->id)
        {
          self::transformOneCartToAnother($userCart, $sessionCart, $sessionID, $userID);
        }
      }
      else if($sessionCart) {
        $cart = Cart::find($sessionCart->id);
        if($cart) {
          if (Helper::empty($cart->user_id)) {
            $cart->user_id = $userID;
            $cart->save();
          } else {
            if ($cart->user_id != $userID) {
              $cart = self::duplicateCart($cart, $userID, $serverSessionID);
              $response['sessionUpdated'] = true;
            }
          }
          $cartID = $cart->id;
        }
      }
      else if($userCart) {
        $cart = Cart::find($userCart->id);
        if ($cart) {
          $cart->session_id = $sessionID;
          $cart->save();
          $cartID = $cart->id;
        }
      }
    
      $response['cartID'] = $cartID;
      return $response;
    }
  
    /**
     * @param Cart $cart
     * @param int|null $userID
     * @param string $serverSessionID
     * @return Cart
     */
    private static function duplicateCart(Cart $cart, $userID, $serverSessionID)
    {
      $newCart = $cart->replicate();
      $newCart->user_id = $userID;
      $newCart->session_id = $serverSessionID;
      $newCart->save();
      $cartProducts = CartProduct::ofCart($cart->id)->get();
    
      foreach ($cartProducts as $cartProduct) {
        $cp_copy = $cartProduct->replicate();
        $cp_copy->cart_id = $newCart->id;
        $cp_copy->save();
      }
    
      return $newCart;
    }
  
    /**
     * @param Cart $from
     * @param Cart $to
     * @param string $sessionID
     * @param int $userID
     * @throws Exception
     */
    private static function transformOneCartToAnother(Cart $from, Cart $to, string $sessionID, int $userID)
    {
      self::donateCartProducts($from, $to);
      self::donateCartData($from, $to);
      Cart::clear($from->id);
      $cart = Cart::find($to->id);
      if ($cart) {
        $cart->session_id = $sessionID;
        $cart->user_id    = $userID;
        $cart->save();
      }
    }
  
    /**
     * @param Cart $donor
     * @param Cart $receiver
     * @throws Exception
     */
    private static function donateCartProducts(Cart $donor, Cart $receiver)
    {
      foreach ($donor->products as $cartProduct) {
  
        //        if (Cart::cartProduct($receiver->id, $cartProduct->hydro_product_id)->exists()) {
        if (Cart::cartProduct($receiver->id, $cartProduct)->exists()) {
          CartProduct::whereId($cartProduct->id)->delete();
        }
      }
      CartProduct::ofCart($donor->id)->update([
        'cart_id' => $receiver->id
      ]);
    }
  
    /**
     * @param $donor
     * @param $receiver
     */
    private static function donateCartData($donor, $receiver)
    {
      $cart = Cart::find($receiver->id);
      $cart->contact_information_first_name = self::donateCartColumn($donor, $receiver, 'contact_information_first_name');
      $cart->contact_information_last_name = self::donateCartColumn($donor, $receiver, 'contact_information_last_name');
      $cart->contact_information_email = self::donateCartColumn($donor, $receiver, 'contact_information_email');
      $cart->contact_information_phone = self::donateCartColumn($donor, $receiver, 'contact_information_phone');
      $cart->shipping_address_first_name = self::donateCartColumn($donor, $receiver, 'shipping_address_first_name');
      $cart->shipping_address_last_name = self::donateCartColumn($donor, $receiver, 'shipping_address_last_name');
      $cart->shipping_address_address1 = self::donateCartColumn($donor, $receiver, 'shipping_address_address1');
      $cart->shipping_address_address2 = self::donateCartColumn($donor, $receiver, 'shipping_address_address2');
      $cart->shipping_address_state = self::donateCartColumn($donor, $receiver, 'shipping_address_state');
      $cart->shipping_address_state_type = self::donateCartColumn($donor, $receiver, 'shipping_address_state_type');
      $cart->shipping_address_city = self::donateCartColumn($donor, $receiver, 'shipping_address_city');
      $cart->shipping_address_zip = self::donateCartColumn($donor, $receiver, 'shipping_address_zip');
      $cart->shipping_address_phone = self::donateCartColumn($donor, $receiver, 'shipping_address_phone');
      $cart->shipping_address_email = self::donateCartColumn($donor, $receiver, 'shipping_address_email');
      $cart->is_different_billing = self::donateCartColumn($donor, $receiver, 'is_different_billing');
      $cart->billing_address_first_name = self::donateCartColumn($donor, $receiver, 'billing_address_first_name');
      $cart->billing_address_last_name = self::donateCartColumn($donor, $receiver, 'billing_address_last_name');
      $cart->billing_address_address1 = self::donateCartColumn($donor, $receiver, 'billing_address_address1');
      $cart->billing_address_address2 = self::donateCartColumn($donor, $receiver, 'billing_address_address2');
      $cart->billing_address_state = self::donateCartColumn($donor, $receiver, 'billing_address_state');
      $cart->billing_address_state_type = self::donateCartColumn($donor, $receiver, 'billing_address_state_type');
      $cart->billing_address_city = self::donateCartColumn($donor, $receiver, 'billing_address_city');
      $cart->billing_address_zip = self::donateCartColumn($donor, $receiver, 'billing_address_zip');
      $cart->billing_address_phone = self::donateCartColumn($donor, $receiver, 'billing_address_phone');
      $cart->billing_address_email = self::donateCartColumn($donor, $receiver, 'billing_address_email');
      $cart->save();
    }
  
    /**
     * @param $donor
     * @param $receiver
     * @param $column
     * @return string|null
     */
    private static function donateCartColumn($donor, $receiver, $column)
    {
      return Helper::getValue(optional($receiver)->{$column}, optional($donor)->{$column});
    }
  }
