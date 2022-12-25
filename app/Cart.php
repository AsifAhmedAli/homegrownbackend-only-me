<?php

namespace App;

use App\Hydro\HydroProduct;
use App\Repositories\Coupon\CouponService;
use App\Repositories\Tax\TaxService;
use App\Utils\Helpers\Helper;
use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use App\Utils\Traits\Search;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Exception;

/**
 * App\Cart
 *
 * @property int $id
 * @property string|null $session_id
 * @property int|null $user_id
 * @property float $tax
 * @property float $shipping_charges
 * @property int $allow_free_shipping
 * @property float $total_price
 * @property string|null $coupon_code
 * @property int|null $coupon_id
 * @property float $discount
 * @property string|null $contact_information_first_name Contact Information
 * @property string|null $contact_information_last_name Contact Information
 * @property string|null $contact_information_email Contact Information
 * @property string|null $contact_information_phone Contact Information
 * @property string|null $shipping_address_first_name Shipping Address
 * @property string|null $shipping_address_last_name Shipping Address
 * @property string|null $shipping_address_address1 Shipping Address
 * @property string|null $shipping_address_address2 Shipping Address
 * @property string|null $shipping_address_state Billing Address
 * @property string|null $shipping_address_state_type Billing Address
 * @property string|null $shipping_address_city Billing Address
 * @property string|null $shipping_address_zip Billing Address
 * @property string|null $shipping_address_phone Billing Address
 * @property string|null $shipping_address_email Billing Address
 * @property int $is_different_billing
 * @property string|null $billing_address_first_name Billing Address
 * @property string|null $billing_address_last_name Billing Address
 * @property string|null $billing_address_address1 Billing Address
 * @property string|null $billing_address_address2 Billing Address
 * @property string|null $billing_address_state Billing Address
 * @property string|null $billing_address_state_type Billing Address
 * @property string|null $billing_address_city Billing Address
 * @property string|null $billing_address_zip Billing Address
 * @property string|null $billing_address_phone Billing Address
 * @property string|null $billing_address_email Billing Address
 * @property string|null $payment_nonce
 * @property string|null $card_holder_name Payment Information
 * @property string|null $expiration_month Payment Information
 * @property string|null $expiration_year Payment Information
 * @property string|null $bin Payment Information
 * @property string|null $card_type Payment Information
 * @property string|null $type Payment Information
 * @property string|null $saved_payment_method_token Payment Information
 * @property string|null $last_four Payment Information
 * @property string|null $last_two Payment Information
 * @property string|null $description Payment Information
 * @property string|null $email Payment Information
 * @property string|null $first_name Payment Information
 * @property string|null $last_name Payment Information
 * @property string|null $payer_id Payment Information
 * @property string|null $country_code Payment Information
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Cart active()
 * @method static \Illuminate\Database\Eloquent\Builder|Cart default()
 * @method static \Illuminate\Database\Eloquent\Builder|Cart newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cart newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cart ofCart($cartID)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart ofProduct($productID)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart ofUser($userID)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereAllowFreeShipping($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereBillingAddressAddress1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereBillingAddressAddress2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereBillingAddressCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereBillingAddressEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereBillingAddressFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereBillingAddressLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereBillingAddressPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereBillingAddressState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereBillingAddressStateType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereBillingAddressZip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereBin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereCardHolderName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereCardType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereContactInformationEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereContactInformationFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereContactInformationLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereContactInformationPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereCouponCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereCouponId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereExpirationMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereExpirationYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereIsDifferentBilling($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereLastFour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereLastTwo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart wherePayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart wherePaymentNonce($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereSavedPaymentMethodToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereSessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereShippingAddressAddress1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereShippingAddressAddress2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereShippingAddressCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereShippingAddressEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereShippingAddressFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereShippingAddressLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereShippingAddressPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereShippingAddressState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereShippingAddressStateType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereShippingAddressZip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereShippingCharges($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereUserId($value)
 * @mixin Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\CartProduct[] $products
 * @property-read int|null $products_count
 * @property-read mixed $sub_total
 * @property-read int $total_qty
 * @property-read string $customer_name
 */
class Cart extends Model
{
  use CommonRelations, CommonScopes, Search;
  protected $appends = ['sub_total', 'total_qty'];

  /**
   * @param string $sessionID
   * @return Cart
   */
  public static function findBySessionID(string $sessionID)
  {
    return static::whereSessionId($sessionID)->first();
  }

  /**
   * @param $userID
   * @return mixed
   */
  public static function findByUserID($userID)
  {
    return static::ofUser($userID)->first();
  }

  /**
   * @param int $cartID
   * @param int $productID
   * @return mixed
   */
  public static function findProducts(int $cartID, int $productID)
  {
    return CartProduct::ofCart($cartID)->ofProduct($productID);
  }

  /**
   * @param int $cartID
   * @param HydroProduct|Kit $product
   * @param int $quantity
   */
  public static function addProductToCart(int $cartID, $product, int $quantity)
  {

    if (self::cartProduct($cartID, $product)->exists()) {
        $cartProduct = self::cartProduct($cartID, $product)->first();
        $cartProduct->quantity += $quantity;
    } else {
        $cartProduct = new CartProduct;
        $cartProduct->cart_id = $cartID;

        if ($product instanceof Kit) {
            $cartProduct->kit_id = $product->id;
        } else {
            $cartProduct->hydro_product_id = $product->id;
        }
        $cartProduct->quantity = $quantity;
    }
      $cartProduct->price = optional($product->price)->retailPrice ?? $product->price;

      $cartProduct->save();
  }

  /**
   * @param int $cartID
   * @param $product
   * @return mixed
   */
  public static function cartProduct(int $cartID, $product)
  {
      if ($product instanceof Kit) {
          return CartProduct::where(["cart_id" => $cartID, "kit_id" => $product->id]);
      } else {
          return CartProduct::ofCart($cartID)->ofProduct($product->id);
      }

  }

  /**
   * @return HasMany
   */
  public function products()
  {
    return $this->hasMany(CartProduct::class);
  }

  /**
   * @param $cartID
   * @return self|null|Builder
   * @throws Exception
   */
  public static function findCartById($cartID)
  {
    $cart = self::find($cartID);
    if ($cart) {
      self::reApplyCoupon($cart);
    }
    $cart = self::with([
      'products' => function(HasMany $q) {
        $q->latest('updated_at');
      },
      'products.product.image:product_recid,url',
        'products.kit'
    ])->find($cartID);

    if ($cart) {
      self::validateCartProducts($cart);
    }

    if ($cart && !$cart->hasProducts()) {
      Cart::clear($cart->id);
      $cart = null;
    }

    if($cart) {
      Helper::proceedToMailChimp($cart);
    }

    return $cart;
  }

  public static function reApplyCoupon(self $cart)
  {
    if ($cart && $cart->hasCoupon()) {
      $coupon = $cart->getCoupon();
      if($coupon) {
        $service = new CouponService;
        $service->apply($cart->session_id, $coupon->code, true);
      } else {
        Cart::resetCoupon($cart);
      }
    }
  }

  public function hasCoupon(): bool
  {
    return !Helper::empty($this->coupon_code) && !Helper::empty($this->coupon_id);
  }

  public function getCoupon()
  {
    return Coupon::findByCode($this->coupon_code);
  }

  /**
   * @return bool
   */
  public function hasProducts()
  {
    return CartProduct::ofCart($this->id)->count() > 0;
  }

  public function hasBilling()
  {
    return !Helper::empty($this->billing_address_first_name);
  }

  public function hasShipping()
  {
    return !Helper::empty($this->shipping_address_first_name);
  }

  public function hasBillingOrShipping()
  {
    return $this->hasBilling() || $this->hasShipping();
  }

  /**
   * @param $cartID
   * @return bool
   * @throws Exception
   */
  public static function clear($cartID)
  {
    $cart = self::find($cartID);
    if($cart) {
      Helper::proceedToMailChimp($cart, true);
    }
    self::whereId($cartID)->delete();

    return true;
  }

  /**
   * @param Cart|Builder $cart
   * @throws Exception
   */
  private static function validateCartProducts(self $cart)
  {
    foreach ($cart->products as $cartProduct) {
      self::validateProduct($cartProduct);
    }
  }

  /**
   * @param $cartProduct
   * @return bool
   * @throws Exception
   */
  public static function validateProduct(CartProduct $cartProduct): bool
  {

    $response = false;
    if ($cartProduct) {

        if (!is_null($cartProduct->kit_id) && $cartProduct->kit_id != '') {
            $product = Kit::find($cartProduct->kit_id);
            if ($product) {
                $response = true;
            }
        } else {
            $product = HydroProduct::find($cartProduct->hydro_product_id);
            if ($product) {
                if ($cartProduct->quantity <= $product->qty) {
                    $response = true;
                }
            }
        }

    }

    if(!$response) {
      CartProduct::whereId($cartProduct->id)->delete();
    }

    return $response;
  }

  /**
   * @return mixed
   */
  public function getSubTotalAttribute()
  {
    return $this->products->sum('total_price');
  }

  /**
   * @return float
   */
  public function getTotalPriceAttribute()
  {
    return (float)$this->sub_total + (float)$this->attributes['tax'] + (float)$this->shipping_charges - (float)$this->attributes['discount'] ;
  }

  /**
   * @throws Exception
   */
  public function getTaxAttribute()
  {
    $taxService = new TaxService($this);
    $taxService->calculate();

    return $taxService->getTax();
  }

  public function getCustomerNameAttribute()
  {
    $name = Helper::concatenate('ucwords', Helper::getValue($this->shipping_address_first_name, $this->billing_address_first_name), Helper::getValue($this->shipping_address_last_name, $this->billing_address_last_name));

    if($this->user_id) {
      $user = User::find($this->user_id);
      if($user) {
        $userName = Helper::concatenate('ucwords', $user->first_name, $user->last_name);
        $name = Helper::getValue($userName, $name);
      }
    }

    return $name;
  }

  /**
   * @return int
   */
  public function getTotalQtyAttribute()
  {
    return $this->products->sum('quantity');
  }

  /**
   * @param CartProduct $cartProduct
   * @param HydroProduct|Kit $product
   * @param int $quantity
   */
  public static function updateCartProductQty(CartProduct $cartProduct, $product, int $quantity)
  {
    $cartProduct->quantity = $quantity;
    $cartProduct->price = optional($product->price)->retailPrice ?? $product->price;
    $cartProduct->save();
  }

  /**
   * @param int $cartProductID
   * @return bool
   * @throws Exception
   */
  public static function removeCartProduct(int $cartProductID): bool
  {
    CartProduct::whereId($cartProductID)->delete();

    return true;
  }

  /**
   * @param self $cart
   */
  public static function resetShipping(self $cart)
  {
    $cart->shipping_address_first_name = null;
    $cart->shipping_address_last_name = null;
    $cart->shipping_address_phone = null;
    $cart->shipping_address_email = null;
    $cart->shipping_address_address1 = null;
    $cart->shipping_address_address2 = null;
    $cart->shipping_address_state = null;
    $cart->shipping_address_state_type = null;
    $cart->shipping_address_city = null;
    $cart->shipping_address_zip = null;
    $cart->save();
  }

  /**
   * @param self $cart
   * @param Coupon $coupon
   * @param float $discount
   * @return Cart
   */
  public static function applyCoupon(self $cart, Coupon $coupon, $discount)
  {
    if ($discount < 1) {
      self::resetCoupon($cart);
      return $cart;
    }
    $cart->coupon_code = $coupon->code;
    $cart->coupon_id = $coupon->id;
    $cart->discount = $discount;
    $cart->save();

    return $cart;
  }

  public static function resetCoupon(Cart $cart)
  {
      $cart->coupon_code = null;
      $cart->coupon_id = null;
      $cart->discount = 0;
      $cart->allow_free_shipping = false;
      $cart->save();

      return $cart;
  }
}
