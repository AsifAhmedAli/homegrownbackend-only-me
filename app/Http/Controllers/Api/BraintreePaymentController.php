<?php

namespace App\Http\Controllers\Api;

use App\Cart;
use App\Http\Controllers\Controller;
use App\Utils\Api\ApiHelper;
use App\Utils\Api\ApiResponse;
use App\Utils\Constants\ValidationMessage;
use App\Utils\Constants\ValidationRule;
use App\Utils\Helpers\CartHelper;
use App\Utils\Helpers\PaymentHelper;
use Auth;
use Braintree\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BraintreePaymentController extends ApiBaseController
{
    public $user = null;

    public function __construct()
    {
        parent::__construct();
        PaymentHelper::initBraintree();
    }

    public function addPaymentMethod(Request $request)
    {
        $this->user = Auth::user();
        $rules = ValidationRule::addPaymentMethod();
        $messages = ValidationMessage::addPaymentMethod();
        try {
            $this->validate($request, $rules, $messages);
        } catch (ValidationException $e) {
          return ApiResponse::validation($e->errors());
        }
        try {
            if ($this->user) {
                $nonce = request('nonce');
                $paymentMethod = PaymentHelper::addPaymentMethodToBrainTree($this->user, $nonce);
                if (optional($paymentMethod)->success) {
                    $message = __('generic.payment.method_saved');
                    $code = 200;
                } else {
                    $message = $paymentMethod->message;
                    $code = 400;
                }
            } else {
                $message = __('generic.user.not_found');
                $code = 401;
            }
            return ApiResponse::successResponse($message, $code);

        } catch (\Exception $e) {
            return ApiResponse::errorResponse($e->getMessage());
        }
    }

    public function getPaymentMethods()
    {
        $this->user = Auth::user();
        if ($this->user) {
            $customer = PaymentHelper::getBrainTreeCustomer($this->user);
            if (!is_null($customer)) {
                $response['customer'] = $customer;
                $code = 200;
            } else {
                $response['message'] = null;
                $code = 400;
            }
        } else {
            $response['message'] = __('user.not_found');
            $code = 401;
        }
        return response()->json($response, $code);
    }

    public function deletePaymentMethod(Request $request)
    {
        $this->user = Auth::user();
        $rules = ValidationRule::paymentMethodToken();
        $messages = ValidationMessage::paymentMethodToken();
        try {
            $this->validate($request, $rules, $messages);
        } catch (ValidationException $e) {
            return ApiResponse::validation($e->errors());
        }
        if ($this->user) {
            $deleteResponse = PaymentHelper::deletePaymentMethod(request('paymentMethodToken'), $this->user);
            if ($deleteResponse['status']) {
                $response['message'] = __('generic.payment.method_deleted');
                $response['customer'] = PaymentHelper::getBrainTreeCustomer($this->user);
                $code = 200;
            } else {
                $response['message'] = __('generic.payment.error_in_delete_method');
                $code = 404;
            }
        } else {
            $response['message'] = __('generic.user.not_found');
            $code = 401;
        }
        return response()->json($response, $code);
    }

    public function makeDefaultPaymentMethod(Request $request)
    {
        $this->user = Auth::user();
        $rules = ValidationRule::paymentMethodToken();
        $messages = ValidationMessage::paymentMethodToken();
        try {
            $this->validate($request, $rules, $messages);
        } catch (ValidationException $e) {
            return ApiResponse::validation($e->errors());
        }
        if ($this->user) {
            $deleteResponse = PaymentHelper::makeDefaultPaymentMethod(request('paymentMethodToken'), $this->user);
            if ($deleteResponse['status']) {
                $response['message'] = __('generic.payment.method_marked_as_default');
                $response['customer'] = PaymentHelper::getBrainTreeCustomer($this->user);
                $code = 200;
            } else {
                $response['message'] = __('generic.error_in_delete_method');
                $code = 404;
            }
        } else {
            $response['message'] = __('generic.user.not_found');
            $code = 401;
        }
        return response()->json($response, $code);
    }

    public function index()
    {
        $response['paymentMethods'] = ApiHelper::activePaymentMethods();
        $response['message'] = Message::PAYMENT_METHODS;
        return ApiResponse::success($response);
    }

    public function getToken()
    {
        $this->user = Auth::guard('api')->user();
        try {
            $response['token'] = \Braintree_ClientToken::generate();

            $user = $this->user;
            if ($user) {
                $response['customer'] = PaymentHelper::getBrainTreeCustomer($user);
                $code = 200;
            } else {
                $code = 200;
                $response['message'] = 'User not found!';
            }
            return response()->json($response, $code);
        } catch (\Exception $e) {
            return ApiResponse::errorResponse(__('generic.error'), $e->getMessage());
        }
    }

    public function attachPaymentNonce(string $sessionID)
    {
        $this->user = Auth::user();
        $cart = Cart::findBySessionID($sessionID);
        if ($cart) {
            $messages = CartHelper::verifyProductsAvailableQuantity($cart);
            if (count($messages)) {
                return response()->json(['messages' => $messages], 420);
            }
            try {
                $paymentMethod = new \stdClass();
                if (request('type') == 'SavedCard') {
                    $paymentMethod = PaymentMethod::find(request('paymentToken'));
                    if ($cart->user_id != (integer)$paymentMethod->customerId) {
                        $response['message'] = 'Payment Method Not found!';
                        $code = 402;
                        return response()->json($response, $code);
                    }
                }
                $cart = Cart::find($cart->id);
              if($this->getUserID()) {
                $cart->user_id = $this->getUserID();
              }
                $cart->payment_nonce = request('nonce');
                $cart->card_holder_name = request('cardHolderName', optional($paymentMethod)->cardholderName);
                $cart->expiration_month = request('expirationMonth', optional($paymentMethod)->expirationMonth);
                $cart->expiration_year = request('expirationYear', optional($paymentMethod)->expirationYear);
                $cart->bin = request('bin', optional($paymentMethod)->bin);
                $cart->card_type = request('cardType', optional($paymentMethod)->cardType);
                $cart->type = request('type', null);
                $cart->saved_payment_method_token = request('paymentToken', null);
                $cart->last_four = request('lastFour', optional($paymentMethod)->last4);
                $cart->last_two = request('lastTwo', null);
                $cart->description = request('description', null);
                $cart->email = request('email', null);
                $cart->first_name = request('firstName', null);
                $cart->last_name = request('lastName', null);
                $cart->payer_id = request('payerId', null);
                $cart->country_code = request('countryCode', null);
                $cart->save();
                $response['cart'] = ApiHelper::findCartById($cart->id);
                $response['message'] = 'Nonce Linked';
                $code = 200;
            } catch (\Exception $e) {
                if ($e instanceof \Braintree\Exception\NotFound) {
                    $response['message'] = 'Payment Method Not found!';
                    $code = 402;
                } else {
                    $response['message'] = $e->getMessage();
                    $code = 402;
                }
            }
            return response()->json($response, $code);
        } else {
            return ApiResponse::cart(422);
        }
    }
}
