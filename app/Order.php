<?php

namespace App;

use App\Events\ChangeKitTrackingNumber;
use App\Models\CartKitProduct;
use App\Models\OrderKitProduct;
use App\Models\UserKit;
use App\Utils\Api\ApiHelper;
use App\Utils\Constants\Constant;
use App\Utils\Constants\PaymentMethods;
use App\Utils\Helpers\Helper;
use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use App\Utils\Traits\Search;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Self_;
use TCG\Voyager\Actions\DeleteAction;
use TCG\Voyager\Actions\EditAction;
use TCG\Voyager\Actions\RestoreAction;

/**
 * App\Order
 *
 * @property int $id
 * @property string|null $tracking_number
 * @property int|null $customer_id
 * @property string|null $customer_email
 * @property string|null $customer_phone
 * @property string|null $customer_first_name
 * @property string|null $customer_last_name
 * @property string|null $billing_first_name
 * @property string|null $billing_last_name
 * @property string|null $billing_address_1
 * @property string|null $billing_address_2
 * @property string|null $billing_city
 * @property string|null $billing_state
 * @property string|null $billing_zip
 * @property string|null $billing_country
 * @property string|null $shipping_first_name
 * @property string|null $shipping_last_name
 * @property string|null $shipping_address_1
 * @property string|null $shipping_address_2
 * @property string|null $shipping_city
 * @property string|null $shipping_state
 * @property string|null $shipping_zip
 * @property string|null $shipping_country
 * @property string|null $sub_total
 * @property string|null $shipping_method
 * @property string|null $shipping_cost
 * @property int|null $coupon_id
 * @property float|null $discount
 * @property float|null $total
 * @property string|null $payment_method
 * @property string|null $currency
 * @property string|null $currency_rate
 * @property string|null $locale
 * @property string|null $status
 * @property string|null $guest_email
 * @property string|null $note
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property float|null $tax
 * @property float|null $shipping_charges
 * @property string|null $allow_free_shipping
 * @property string|null $coupon_code
 * @property string|null $contact_information_first_name
 * @property string|null $contact_information_last_name
 * @property string|null $contact_information_email
 * @property string|null $contact_information_phone
 * @property string|null $is_different_billing
 * @property string|null $billing_address_company
 * @property string|null $billing_address_country_id
 * @property string|null $billing_address_state_type
 * @property string|null $billing_address_phone
 * @property string|null $billing_address_email
 * @property string|null $shipping_address_company
 * @property string|null $shipping_address_country_id
 * @property string|null $shipping_address_state_type
 * @property string|null $shipping_address_phone
 * @property string|null $shipping_address_email
 * @property string|null $card_holder_name
 * @property string|null $expiration_month
 * @property string|null $expiration_year
 * @property string|null $bin
 * @property string|null $card_type
 * @property string|null $type
 * @property string|null $saved_payment_method_token
 * @property string|null $last_four
 * @property string|null $last_two
 * @property string|null $description
 * @property string|null $email
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $payer_id
 * @property string|null $country_code
 * @property string|null $order_number
 * @property string|null  hydro_doc_ref
 * @property-read \App\Coupon|null $coupon
 * @property-read Collection|\App\OrderProduct[] $products
 * @property-read int|null $products_count
 * @method static Builder|Order active()
 * @method static Builder|Order default()
 * @method static Builder|Order newModelQuery()
 * @method static Builder|Order newQuery()
 * @method static Builder|Order ofCart($cartID)
 * @method static Builder|Order ofProduct($productID)
 * @method static Builder|Order ofUser($userID)
 * @method static Builder|Order hydro($right = true)
 * @method static Builder|Order query()
 * @method static Builder|Order whereAllowFreeShipping($value)
 * @method static Builder|Order whereBillingAddress1($value)
 * @method static Builder|Order whereBillingAddress2($value)
 * @method static Builder|Order whereBillingAddressCompany($value)
 * @method static Builder|Order whereBillingAddressCountryId($value)
 * @method static Builder|Order whereBillingAddressEmail($value)
 * @method static Builder|Order whereBillingAddressPhone($value)
 * @method static Builder|Order whereBillingAddressStateType($value)
 * @method static Builder|Order whereBillingCity($value)
 * @method static Builder|Order whereBillingCountry($value)
 * @method static Builder|Order whereBillingFirstName($value)
 * @method static Builder|Order whereBillingLastName($value)
 * @method static Builder|Order whereBillingState($value)
 * @method static Builder|Order whereBillingZip($value)
 * @method static Builder|Order whereBin($value)
 * @method static Builder|Order whereCardHolderName($value)
 * @method static Builder|Order whereCardType($value)
 * @method static Builder|Order whereContactInformationEmail($value)
 * @method static Builder|Order whereContactInformationFirstName($value)
 * @method static Builder|Order whereContactInformationLastName($value)
 * @method static Builder|Order whereContactInformationPhone($value)
 * @method static Builder|Order whereCountryCode($value)
 * @method static Builder|Order whereCouponCode($value)
 * @method static Builder|Order whereCouponId($value)
 * @method static Builder|Order whereCreatedAt($value)
 * @method static Builder|Order whereCurrency($value)
 * @method static Builder|Order whereCurrencyRate($value)
 * @method static Builder|Order whereCustomerEmail($value)
 * @method static Builder|Order whereCustomerFirstName($value)
 * @method static Builder|Order whereCustomerId($value)
 * @method static Builder|Order whereCustomerLastName($value)
 * @method static Builder|Order whereCustomerPhone($value)
 * @method static Builder|Order whereDeletedAt($value)
 * @method static Builder|Order whereDescription($value)
 * @method static Builder|Order whereDiscount($value)
 * @method static Builder|Order whereEmail($value)
 * @method static Builder|Order whereExpirationMonth($value)
 * @method static Builder|Order whereExpirationYear($value)
 * @method static Builder|Order whereFirstName($value)
 * @method static Builder|Order whereGuestEmail($value)
 * @method static Builder|Order whereId($value)
 * @method static Builder|Order whereIsDifferentBilling($value)
 * @method static Builder|Order whereLastFour($value)
 * @method static Builder|Order whereLastName($value)
 * @method static Builder|Order whereLastTwo($value)
 * @method static Builder|Order whereLocale($value)
 * @method static Builder|Order whereNote($value)
 * @method static Builder|Order whereOrderNumber($value)
 * @method static Builder|Order wherePayerId($value)
 * @method static Builder|Order wherePaymentMethod($value)
 * @method static Builder|Order whereSavedPaymentMethodToken($value)
 * @method static Builder|Order whereShippingAddress1($value)
 * @method static Builder|Order whereShippingAddress2($value)
 * @method static Builder|Order whereShippingAddressCompany($value)
 * @method static Builder|Order whereShippingAddressCountryId($value)
 * @method static Builder|Order whereShippingAddressEmail($value)
 * @method static Builder|Order whereShippingAddressPhone($value)
 * @method static Builder|Order whereShippingAddressStateType($value)
 * @method static Builder|Order whereShippingCharges($value)
 * @method static Builder|Order whereShippingCity($value)
 * @method static Builder|Order whereShippingCost($value)
 * @method static Builder|Order whereShippingCountry($value)
 * @method static Builder|Order whereShippingFirstName($value)
 * @method static Builder|Order whereShippingLastName($value)
 * @method static Builder|Order whereShippingMethod($value)
 * @method static Builder|Order whereShippingState($value)
 * @method static Builder|Order whereShippingZip($value)
 * @method static Builder|Order whereStatus($value)
 * @method static Builder|Order whereSubTotal($value)
 * @method static Builder|Order whereTax($value)
 * @method static Builder|Order whereTotal($value)
 * @method static Builder|Order whereTrackingNumber($value)
 * @method static Builder|Order whereType($value)
 * @method static Builder|Order whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Order extends Model
{
    use CommonRelations, CommonScopes, Search;

    const   CANCELED = 'canceled';
    const   COMPLETED = 'completed';
    const   ON_HOLD = 'on_hold';
    const   PENDING = 'pending';
    const   PENDING_PAYMENT = 'pending_payment';
    const   PROCESSING = 'processing';
    const   REFUNDED = 'refunded';

    public const EXCLUDE_ACTIONS = [EditAction::class, DeleteAction::class, RestoreAction::class];
    public const CAN_ADD_NEW = false;
    public const CAN_BULK_DELETE = true;

    protected $casts = [
        'tax' => 'float',
        'total' => 'float',
        'discount' => 'float',
        'shipping_charges' => 'float',
    ];

    public static function saveOrder(Cart $cart): self
    {
        Cart::reApplyCoupon($cart);
        $order = new self();
        $clientOrder = request('order');
        $order->order_number = Helper::arrayIndex($clientOrder, 'id');

        /**************************** Basic Info Starts ***************************/
        $order->customer_id = $cart->user_id;
        $customer = User::find($order->customer_id);
        if ($customer) {
            $order->customer_first_name = $customer->first_name;
            $order->customer_last_name = $customer->last_name;
            $order->customer_email = $customer->email;
            $order->customer_phone = $customer->phone_number;
        } else {
            $order->customer_first_name = $cart->billing_address_first_name;
            $order->customer_last_name = $cart->billing_address_last_name;
            $order->customer_email = $cart->billing_address_email;
            $order->customer_phone = $cart->billing_address_phone;
        }
        $order->guest_email = $cart->guest_email;
        $order->status = self::PROCESSING;
        $order->locale = 'en';
        /**************************** Basic Info Ends ***************************/

        /**************************** Amount Info Starts ***************************/
        $order->sub_total = $cart->sub_total;
        $order->tax = $cart->tax;
        $order->shipping_method = $cart->shipping_method;
        $order->shipping_charges = $cart->shipping_charges;
        $order->shipping_cost = $cart->shipping_charges;
        $order->allow_free_shipping = $cart->allow_free_shipping;
        $order->total = $cart->total_price;
        $order->coupon_id = $cart->coupon_id;
        $order->coupon_code = $cart->coupon_code;
        $order->discount = $cart->discount;
        $order->currency = 'us';
        $order->currency_rate = '0';
        /***************************** Amount Info Ends ****************************/

        /**************************** Contact Info Info Starts ***************************/
        $order->contact_information_first_name = $cart->contact_information_first_name;
        $order->contact_information_last_name = $cart->contact_information_last_name;
        $order->contact_information_email = $cart->contact_information_email;
        $order->contact_information_phone = $cart->contact_information_phone;
        $order->is_different_billing = $cart->is_different_billing;
        /**************************** Contact Info Info Ends ****************************/

        /****************************** Billing Info Starts *****************************/
        $order->billing_first_name = $cart->billing_address_first_name;
        $order->billing_last_name = $cart->billing_address_last_name;
//        $order->billing_address_company           = $cart->billing_address_company;
        $order->billing_address_1 = $cart->billing_address_address1;
        $order->billing_address_2 = $cart->billing_address_address2;
//        $order->billing_address_country_id        = $cart->billing_address_country_id;
        $order->billing_state = $cart->billing_address_state;
        $order->billing_address_state_type = $cart->billing_address_state_type;
        $order->billing_city = $cart->billing_address_city;
        $order->billing_zip = $cart->billing_address_zip;
        $order->billing_address_phone = $cart->billing_address_phone;
        $order->billing_address_email = $cart->billing_address_email;
        $order->billing_country = Constant::DEFAULT_COUNTRY;
        /****************************** Billing Info Ends ******************************/

        /****************************** Shipping Info Starts *****************************/
        $order->shipping_first_name = ApiHelper::resolveValue($cart->shipping_address_first_name, $order->billing_first_name);
        $order->shipping_last_name = ApiHelper::resolveValue($cart->shipping_address_last_name, $order->billing_last_name);
        $order->shipping_address_company = ApiHelper::resolveValue($cart->shipping_address_company, $order->billing_address_company);
        $order->shipping_address_1 = ApiHelper::resolveValue($cart->shipping_address_address1, $order->billing_address_1);
        $order->shipping_address_2 = ApiHelper::resolveValue($cart->shipping_address_address2, $order->billing_address_2);
        $order->shipping_address_country_id = ApiHelper::resolveValue($cart->shipping_address_country_id, $order->billing_address_country_id);
        $order->shipping_state = ApiHelper::resolveValue($cart->shipping_address_state, $order->billing_state);
        $order->shipping_address_state_type = ApiHelper::resolveValue($cart->shipping_address_state_type, $order->billing_address_state_type);
        $order->shipping_city = ApiHelper::resolveValue($cart->shipping_address_city, $order->billing_city);
        $order->shipping_zip = ApiHelper::resolveValue($cart->shipping_address_zip, $order->billing_zip);
        $order->shipping_address_phone = ApiHelper::resolveValue($cart->shipping_address_phone, $order->billing_address_phone);
        $order->shipping_address_email = ApiHelper::resolveValue($cart->shipping_address_email, $order->billing_address_email);
        $order->shipping_country = Constant::DEFAULT_COUNTRY;
        /****************************** Shipping Info Ends ******************************/

        /****************************** Payment Info Starts *****************************/
        $payer = Helper::arrayIndex($clientOrder, 'payer');
        $name = Helper::arrayIndex($payer, 'name');
        $address = Helper::arrayIndex($payer, 'address');

        $order->payment_method = 'PayPal';
//        $order->card_holder_name = $cart->card_holder_name;
//        $order->expiration_month = $cart->expiration_month;
//        $order->expiration_year = $cart->expiration_year;
//        $order->bin = $cart->bin;
//        $order->card_type = $cart->card_type;
        $order->type = $order->payment_method;
//        $order->saved_payment_method_token = $cart->saved_payment_method_token;
//        $order->last_four = $cart->last_four;
//        $order->last_two = $cart->last_two;
//        $order->description = $cart->description;
        $order->email = Helper::arrayIndex($payer, 'email_address');
        $order->first_name = Helper::arrayIndex($name, 'given_name');
        $order->last_name = Helper::arrayIndex($name, 'surname');
        $order->payer_id = Helper::arrayIndex($payer, 'payer_id');
        $order->country_code = Helper::arrayIndex($address, 'country_code');
        /****************************** Payment Info Ends ******************************/

        $order->save();
//        $order->order_number = (int)$order->id + 10000;
//        $order->save();

        if ($order->hasCoupon()) {
            $order->coupon->decrement('usage_limit');
        }

        self::saveOrderProducts($order, $cart);
        self::saveOrderKits($order, $cart);
        self::saveOrderKitProducts($cart, $order->id);

        return $order;
    }

    public static function saveOrderProducts(self $order, Cart $cart)
    {
        foreach ($cart->products as $product) {

            if ($product) {
                $orderProduct = new OrderProduct;
                $orderProduct->order_id = $order->id;
                $orderProduct->hydro_product_id = $product->hydro_product_id ?? null;
                $orderProduct->kit_id = $product->kit_id ?? null;
                $orderProduct->qty = $product->quantity;
                $orderProduct->unit_price = $product->price;
                $orderProduct->line_total = $product->price * $product->quantity;
                $orderProduct->save();
            }
        }
    }

    public static function saveOrderKitProducts($cart, $order_id) {
        $cartProducts = CartKitProduct::where('cart_id', $cart->id)->get();
        if ($cartProducts->count()) {
            foreach ($cartProducts as $product) {
                $orderProduct = new OrderKitProduct();
                $orderProduct->order_id = $order_id;
                $orderProduct->kit_id = $product->kit_id;
                $orderProduct->product_id = $product->product_id;
                $orderProduct->name = $product->name;
                $orderProduct->sku = $product->sku;
                $orderProduct->quantity = $product->quantity;
                $orderProduct->save();
            }
        }

        return true;
    }

    private static function saveOrderKits(self $order, Cart $cart) {

        foreach ($cart->products as $product) {

            if ($product) {

                $kit = self::getKit($product->kit_id);
                if (! is_null($kit)) {

                    $userKit = new UserKit();
                    $userKit->kit_id = $kit->id ?? null;
                    $userKit->user_id = auth()->id();
                    $userKit->kit_name = $kit->name;
                    $userKit->kit_price = $kit->price;
                    $userKit->paid_status = 1;
                    $userKit->kit_description = $kit->description;
                    $userKit->kit_features = $kit->features;
                    $userKit->kit_size = $kit->size;
                    $userKit->billing_street_address = $order->billing_address_1;
                    $userKit->billing_city = $order->billing_city;
                    $userKit->billing_state =  $order->billing_state;
                    $userKit->billing_zip_code = $order->billing_zip;
                    $userKit->billing_email = $order->billing_address_email;
                    $userKit->billing_phone = $order->billing_address_phone;
                    $userKit->is_different_billing = "";
                    $userKit->shipping_street_address =  $order->shipping_address_1;
                    $userKit->shipping_city = $order->shipping_city;
                    $userKit->shipping_state = $order->shipping_state;
                    $userKit->shipping_zip_code = $order->shipping_zip;
                    $userKit->shipping_email = $order->shipping_address_email;
                    $userKit->shipping_phone = $order->shipping_address_phone;
                    $userKit->status = 1;

                    $userKit->save();

                    ApiHelper::addUserPurchasedKits(@$userKit->kit_id, auth()->id());
                }
            }
        }
    }

    private static function getKit($id) {
        return Kit::find($id);
    }

    private static function getProduct(CartProduct $cartProduct)
    {
        return Product::find($cartProduct->product_id);
    }

    public function hasCoupon(): bool
    {
        return !Helper::empty($this->coupon_code) && !Helper::empty($this->coupon_id);
    }

    public function products()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function user()
    {
      return $this->belongsTo(User::class, 'customer_id', 'id');
    }

    public function getTypeAttribute($value)
    {
        if ($value === 'SavedCard') {
            return 'Credit Card';
        } else {
            return $value;
        }
    }

    public function scopeHydro($query, $right = true)
    {
      if($right) {
        $query->whereNotNull('hydro_doc_ref');
      } else {
        $query->whereNull('hydro_doc_ref')->orWhere('hydro_doc_ref', '');
      }
    }

    public function tracking_info()
    {
      return $this->hasMany(OrderTrackingInformation::class);
    }

    /**
     * @return Collection|static[]
     */
    public static function disTracked()
    {
      return static::hydro()->has('tracking_info', '=', 0)->get();
    }

    public function getTrackingNumberAttribute()
    {
      $tracking = $this->tracking_info()->pluck('tracking')->toArray();

      return Helper::implode(', ', $tracking);
    }

    public function changeStatus($status) {

        if($this->kit_status > $status) {
            return false;
        }
        $this->kit_status = $status;
        $this->save();

        return true;
    }

    public function changeTrackingNumber($number) {
        if($this->kit_tracking_number != $number) {

            $this->kit_tracking_number = $number;
            $this->save();
            event(new ChangeKitTrackingNumber($this));
            return true;
        }

        return false;
    }


}
