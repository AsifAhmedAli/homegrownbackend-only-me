<?php

namespace App\Http\Controllers\Api;

use App\Cart;
use App\Http\Controllers\Controller;
use App\Mail\AdminEmail;
use App\Mail\OrderConfirmation;
use App\Models\UserKit;
use App\Models\UserSubscription;
use App\Order;
use App\Repositories\Hydro\HydroOrderRepository;
use App\Repositories\Tax\TaxService;
use App\Transaction;
use App\User;
use App\Utils\Api\ApiHelper;
use App\Utils\Api\ApiResponse;
use App\Utils\Constants\Constant;
use App\Utils\Helpers\CartHelper;
use App\Utils\Helpers\Helper;
use App\Utils\Helpers\PaymentHelper;
use Auth;
use Braintree\PaymentMethod;
use Braintree\PaymentMethodNonce;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Mail;

class OrderController extends Controller
{
    //
    public $label;
    public  $description;
    private $auth;
    private $perPage = 10;

    public function __construct()
    {
        parent::__construct();
        $this->label       = setting('stripe_label');
        $this->description = setting('stripe_description');

        \Stripe\Stripe::setApiKey(setting('stripe_secret_key'));
        PaymentHelper::initBraintree();
    }

  /**
   * @param string $sessionID
   * @return JsonResponse
   * @throws Exception
   */
  public function placeOrder(string $sessionID)
  {
    $this->auth = Auth::user()->id;

    $cart = Cart::with('products')->whereSessionId($sessionID)->first();

    if ($cart) {
      $response  = [];
      $messages = CartHelper::verifyProductsAvailableQuantity($cart);
      if (count($messages)) {
        return ApiResponse::failure(['messages' => $messages], 420);
      }
      $order = Order::saveOrder($cart);
      $response = $this->processPayment();
      if (!$response['status']) {
        $code = $response['code'];
        unset($response['code']);
        unset($response['status']);
        Order::whereId($order->id)->forceDelete();
      }else {
        $transactionID = $order->order_number;
        Transaction::saveTransaction($order->id, $transactionID, $order->payment_method);
        $taxService = new TaxService($cart);
        if(env('APP_ENV', 'local') != 'local') {
          $taxService->calculate(true);
        }
        $hydroOrderService = new HydroOrderRepository($order);
        $order = $hydroOrderService->send();
        $this->createAccount($cart, $order);
        $response['status']      = true;
        $response['message']     = 'Thank you for your order.';
        $response['orderNumber'] = $order->order_number;
        $response['orderID']     = encrypt($order->order_number);
        $data = array('name'=>"Invoice",'order'=>$order);
        Mail::to($order->customer_email)->send(new OrderConfirmation($order));/*customer email*/
       Helper::sendEmailToAdmin(Constant::HGP); /*admin email*/
        $response['cart'] = ApiHelper::findCartById($cart->id);
        Cart::clear($cart->id);
        $code = 200;
      }
      return response()->json(
        $response,
        $code
      );
    } else {
      return ApiResponse::cart(422);
    }
  }

    /**
     * @param string $sessionID
     * @return JsonResponse
     * @throws Exception
     */
    public function placeOrderOld(string $sessionID)
    {
        $this->auth = Auth::user()->id;

        $cart = Cart::with('products')->whereSessionId($sessionID)->first();
        if ($cart) {
            $response  = [];
            $messages = CartHelper::verifyProductsAvailableQuantity($cart);
            if (count($messages)) {
                return ApiResponse::failure(['messages' => $messages], 420);
            }
            $order = Order::saveOrder($cart);
            $response = $this->processPayment();
            if (!$response['status']) {
                $code = $response['code'];
                unset($response['code']);
                unset($response['status']);
                Order::whereId($order->id)->forceDelete();
            }else {
                $result = $response['result'];
                unset($response['result']);
                $transactionID         = optional($result->transaction)->id;
                Transaction::saveTransaction($order->id, $transactionID, $order->type);
                $taxService = new TaxService($cart);
                if(env('APP_ENV', 'local') != 'local') {
                  $taxService->calculate(true);
                }
                $hydroOrderService = new HydroOrderRepository($order);
                $order = $hydroOrderService->send();
                $this->createAccount($cart, $order);
                $response['status']      = true;
                $response['message']     = 'Thank you for your order.';
                $response['orderNumber'] = $order->order_number;
                $response['orderID']     = encrypt($order->order_number);
                $data = array('name'=>"Invoice",'order'=>$order);
                Mail::to($order->customer_email)->send(new OrderConfirmation($order));
                $response['cart'] = ApiHelper::findCartById($cart->id);
                Cart::clear($cart->id);
                $code = 200;
            }
            return response()->json(
                $response,
              $code
            );
        } else {
            return ApiResponse::cart(422);
        }
    }
    public function processPayment() {
      $data['status'] = true;
      return $data;
    }
    public function processPaymentOld(Cart $cart, Order $order)
    {
        $nonce = $cart->payment_nonce;
        try {
            $request = [];
            if ($order->user) {
                PaymentHelper::addCustomerToBrainTree($order->user);
                $request['customerId'] = $order->customer_id;
            }
            $request = array_merge($request, [
                'amount' => number_format($order->total, 2),
                'orderId' => $order->order_number,
                'shipping' => [
                    'firstName' => $order->shipping_first_name,
                    'lastName' => $order->shipping_last_name,
                    'streetAddress' => $order->shipping_address_1,
                    'locality' => $order->shipping_city,
                    'region' => $order->shipping_state,
                    'postalCode' => $order->shipping_zip,
                    'countryCodeAlpha2' => 'us',
                ],
                'billing' => [
                    'firstName' => $order->billing_first_name,
                    'lastName' => $order->billing_last_name,
                    'streetAddress' => $order->billing_address_1,
                    'locality' => $order->billing_city,
                    'region' => $order->billing_state,
                    'postalCode' => $order->billing_zip,
                    'countryCodeAlpha2' => 'us',
                ],
            ]);
            if ($cart->type == 'SavedCard') {
                $paymentMethod = PaymentMethod::find($cart->saved_payment_method_token);
                if ($order->customer_id == $paymentMethod->customerId) {
                    $request['paymentMethodToken'] = $cart->saved_payment_method_token;
                } else {
                    $data['status'] = false;
                    $data['message'] = 'Payment Method not found!';
                    $data['reason'] = 'Error';
                    $data['code'] = 402;
                    return $data;
                }
            } else {
                PaymentMethodNonce::find($nonce);
                $request['paymentMethodNonce'] = $nonce;
            }
            $status = \Braintree_Transaction::sale($request);
            if ($status->success) {
                $data['status'] = true;
                $data['result'] = $status;
            } else {
                $data['status'] = false;
                $data['message'] = $status->message;
                $data['reason'] = 'ValidationError';
                $data['code'] = 402;
            }
        } catch (Exception $e) {
            if ($e instanceof \Braintree\Exception\NotFound) {
                $data['status'] = false;
                $data['message'] = 'Nonce Not Found';
                $data['reason'] = 'NonceNotFound';
                $data['code'] = 402;
            } else {
                $data['status'] = false;
                $data['message'] = $e->getMessage();
                $data['reason'] = 'Error';
                $data['code'] = 402;
            }
        }
        return $data;
    }
    public function createAccount(Cart $cart, Order $order)
    {
        if ($cart->create_account && ApiHelper::empty($order->customer_id)) {
            $user = ApiHelper::createAccount(
                $order->billing_first_name,
                $order->billing_last_name,
                $order->billing_address_email,
                $order->billing_address_phone,
                ApiHelper::generateStrongPassword(6, false, 'lud'),
                Auth::user()->id
            );
            if ($user) {

                $order->customer_id = $user->id;
                $order->customer_first_name = $user->first_name;
                $order->customer_last_name  = $user->last_name;
                $order->customer_email      = $user->email;
                $order->customer_phone      = $user->phone_number;
                $order->save();
            }
        }
    }

  public function getMyOrders()
  {
    $searchColumn = ApiHelper::resolveSearchColumn(request('searchBy', null), 'orders', null);
    $orders = $this->myOrdersBaseQuery()->when($searchColumn && request('term'), function ($q) use ($searchColumn) {
      $q->where($searchColumn, 'like', '%' . request('term') . '%');
    });
//    if (ApiHelper::isHGP()) {
//      $orders = $orders->provider();
//    } else {
//      $orders = $orders->provider(Constant::GX);
//    }
    if ($orders->count()) {
      $column = ApiHelper::resolveSortColumn(request('attribute', 'id'), 'orders', 'order_number');
      $response['orders'] = $orders->orderBy($column, ApiHelper::resolveDirection(request('direction', 'desc')))->paginate(10);
      $code               = 200;
    } else {
      $response['message'] = null;
      $code                = 400;
    }
    return response()->json($response, $code);
  }
  public function getOrderDetail($orderNumber)
  {
    $order = $this->myOrdersBaseQuery()->with([
      'products', 'products.product', 'products.kit'
    ])->whereOrderNumber($orderNumber)->first();

    if ($order) {
      $response['order'] = $order;
      $code = 200;
    } else {
      $response['message'] = 'Order not found';
      $code = 404;
    }

    return response()->json($response, $code);
  }
  /**
   * @return mixed
   */
  private function myOrdersBaseQuery(): Builder
  {
    return Order::whereCustomerId($this->getUser()->id);
  }
  private function getUser() : User {
    return Auth::user();
  }

  public function getKits() {

      $response = [];
      $query = UserKit::whereUserId(auth()->id());

      $searchColumn = ApiHelper::resolveSearchColumn(request('searchBy', null), 'user_kits', null);
      $kits = $query->select("*", "kit_name as item", "kit_price as price")->when($searchColumn && request('term'), function ($q) use ($searchColumn) {
          $q->where($searchColumn, 'like', '%' . request('term') . '%');
      });

      if ($kits->count() > 0) {
          $column = ApiHelper::resolveSortColumn(request('attribute', 'id'), 'user_kits', 'id');
          $kits = $kits->orderBy($column, ApiHelper::resolveDirection(request('direction', 'desc')))->paginate($this->perPage);

          $response["kits"] = $kits;
      } else {
          $response["kits"] = $kits->paginate($this->perPage);
      }

      return ApiResponse::success($response);
  }

  public function getSubscriptions() {

      $response = [];
      $query = UserSubscription::whereUserId(auth()->id());

      $searchColumn = ApiHelper::resolveSearchColumn(request('searchBy', null), 'user_subscriptions', null);
      $subscriptions = $query->select("*", "name as item")->when($searchColumn && request('term'), function ($q) use ($searchColumn) {
          $q->where($searchColumn, 'like', '%' . request('term') . '%');
      });

      if ($subscriptions->count() > 0) {
          $column = ApiHelper::resolveSortColumn(request('attribute', 'id'), 'user_subscriptions', 'id');
          $subscriptions = $subscriptions->orderBy($column, ApiHelper::resolveDirection(request('direction', 'desc')))->paginate($this->perPage);

          $response["subscriptions"] = $subscriptions;
      } else {
          $response["subscriptions"] = $subscriptions->paginate($this->perPage);
      }

      return ApiResponse::success($response);
  }

  public function getKitDetail($kit_id) {

      $response = [];
      $kit = UserKit::with(["user", "kit"])->find($kit_id);

      if (! is_null($kit)) {
          $user_kit = new \stdClass();

          $user_kit->id          = $kit_id;
          $user_kit->item          = $kit->kit->name ?? "";
          $user_kit->price       =       $kit->kit->price ?? 0;
          $user_kit->user_name   =       ucwords($kit->user->name) ?? "";
          $user_kit->order_id    =       $kit->transaction_id ?? "";
          $user_kit->paid_status =       $kit->paid_status ?? "0";
          $user_kit->status      =       $kit->status ?? "0";

          $user_kit->billing_address_only       =       $kit->billing_street_address ?? "";
          $user_kit->billing_address            =       (@$kit->billing_city != "" ? $kit->billing_city : "")." ". (@$kit->billing_state != "" ? $kit->billing_state."," : "")." US " .(@$kit->billing_zip_code != "" ? $kit->billing_zip_code : "");
          $user_kit->billing_email              =       $kit->billing_email ?? "";
          $user_kit->billing_phone              =       $kit->billing_phone ?? "";

          $user_kit->shipping_address_only      =       $kit->shipping_street_address ?? "";
          $user_kit->shipping_address           =       (@$kit->shipping_city != "" ? $kit->shipping_city : "") ." ". (@$kit->shipping_state != "" ? $kit->shipping_state."," : ""). " US " .(@$kit->shipping_zip_code != "" ? $kit->shipping_zip_code : "");
          $user_kit->shipping_email             =       $kit->shipping_email ?? "";
          $user_kit->shipping_phone             =       $kit->shipping_phone ?? "";

          $user_kit->created_at                 =       $kit->created_at ?? "";

          $response["kit"] = $user_kit;
          $code = 200;
      } else {
          $response["kit"] = [];
          $code = 400;
      }

      return ApiResponse::success($response);
  }

  public function getSubscriptionDetail($subscription_id) {

      $response = [];
      $subscription = UserSubscription::with("plan")->find($subscription_id);

      if (! is_null($subscription)) {
          $user_subscription = new \stdClass();

          $user_subscription->id                  =   $subscription_id;
          $user_subscription->item                  =   $subscription->plan->name ?? "";
          $user_subscription->price                 =   $subscription->plan->amount ?? 0;
          $user_subscription->paid_status           =   $subscription->paid_status ?? "";
          $user_subscription->billing_no        =   $subscription->transaction_id;
          $user_subscription->created_at        =   date("d-m-Y", strtotime($subscription->created_at));
          $user_subscription->payment_method        =   "PayPal";
          $user_subscription->subscription_valid    =   $this->getExpiryDate(strtolower($subscription->plan->frequency), $subscription->created_at);

          $response["subscription"] = $user_subscription;
          $code = 200;
      } else {
          $response["subscription"] = [];
          $code = 400;
      }

      return ApiResponse::success($response);
  }

  private function getExpiryDate($frequency, $start_date) {

      if ($frequency == "month") {
          $expiry_date = date("m-d-Y", strtotime($start_date . "+1 month"));

      } else if ($frequency == "year") {
          $expiry_date = date('m-d-Y', strtotime($start_date . " +1 year") );
      }

      return $expiry_date ?? "00-00-00";
  }

}
