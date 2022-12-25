<?php


namespace App\Utils\Helpers;


use App\Order;
use Braintree_Configuration;
use Braintree_PaymentMethod;

class PaymentHelper
{
    public static function updateOrderCardTypeAndNumber($orderId, $cardType, $cartNumber)
    {
        $order = Order::find($orderId);
        $order->card_type = $cardType;
        $order->card_number = $cartNumber;
        return $order->save();
    }

    public static function initBraintree()
    {
        $env = config('services.braintree.env');
        $merchantID = config("services.braintree.braintree_{$env}_merchant_id");
        $privateKey = config("services.braintree.braintree_{$env}_private_key");
        $publicKey = config("services.braintree.braintree_{$env}_public_key");
        Braintree_Configuration::environment($env);
        Braintree_Configuration::merchantId($merchantID);
        Braintree_Configuration::publicKey($publicKey);
        Braintree_Configuration::privateKey($privateKey);
    }

    public static function addCustomerToBrainTree($user)
    {
        self::initBraintree();
        return \Braintree_Customer::create([
            'id' => optional($user)->id,
            'firstName' => optional($user)->first_name,
            'lastName' => optional($user)->last_name,
            'email' => optional($user)->email,
        ]);
    }

    public static function addPaymentMethodToBrainTree($user, $nonce)
    {
        self::initBraintree();
        $customer = self::getBrainTreeCustomer($user);
        if (!is_null($customer)) {
            $paymentMethodCreation = Braintree_PaymentMethod::create([
                'customerId' => $user->id,
                'paymentMethodNonce' => $nonce,
                'options' => [
                    'verifyCard' => true,
                ],
            ]);
        } else {
            $paymentMethodCreation = null;
        }
        return $paymentMethodCreation;
    }

    public static function getBrainTreeCustomer($user)
    {
        self::initBraintree();
        $customer = null;
        try {
            $customer = \Braintree_Customer::find($user->id);
        } catch (\Exception $e) {
            if ($e instanceof \Braintree\Exception\NotFound) {
                self::addCustomerToBrainTree($user);
                try {
                    $customer = \Braintree_Customer::find($user->id);
                } catch (\Exception $e) {
                    // Customer not found
                }
            }
        }
        return $customer;
    }

    public static function deletePaymentMethod($token, $user)
    {
        self::initBraintree();
        try {
            $payment = Braintree_PaymentMethod::find($token);
            $response['status'] = true;
            if ($payment->customerId == $user->id) {
                try {
                    $deleteResponse = Braintree_PaymentMethod::delete($token);
                    $response['status'] = $deleteResponse->success;
                } catch (\Exception $e) {
                    $response['status'] = false;
                }
            } else {
                $response['status'] = false;
            }
        } catch (\Exception $e) {
            if ($e instanceof \Braintree\Exception\NotFound) {
                $response['status'] = false;
            } else {
                $response['status'] = false;
            }
        }
        return $response;
    }

    public static function makeDefaultPaymentMethod($token, $user)
    {
        self::initBraintree();
        try {
            $payment = Braintree_PaymentMethod::find($token);
            $response['status'] = true;
            if ($payment->customerId == $user->id) {
                try {
                    $statusUpdated = Braintree_PaymentMethod::update($token, [
                        'options' => [
                            'makeDefault' => true,
                        ],
                    ]);
                    $response['status'] = $statusUpdated->success;
                } catch (\Exception $e) {
                    $response['status'] = false;
                }
            } else {
                $response['status'] = false;
            }
        } catch (\Exception $e) {
            if ($e instanceof \Braintree\Exception\NotFound) {
                $response['status'] = false;
            } else {
                $response['status'] = false;
            }
        }
        return $response;
    }
}
