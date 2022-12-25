<?php

namespace App\Utils\Helpers;

use App\CartProduct;
use App\Hydro\HydroProduct;

class CartHelper
{
    public static function resolveValue($value, $default)
    {
        if (!self::empty($value)) {
            return $value;
        }
        return $default;
    }
    public static function empty($data) {
        return is_null($data) || empty($data);
    }
    public static function verifyProductsAvailableQuantity($cart)
    {
        $messages = [];
        $cartProducts = CartProduct::ofCart($cart->id)->distinct()->whereNotNull("hydro_product_id")->pluck('hydro_product_id')->toArray();
        foreach ($cartProducts as $product) {
            $productQuantity = CartProduct::ofCart($cart->id)->wherehydroProductId($product)->sum('quantity');
            $actualProduct = HydroProduct::findOrFail($product);
            if ($actualProduct) {
                if(!$actualProduct->manage_stock || $productQuantity <= $actualProduct->qty) {

                } else {
                    $messages[] = "{$actualProduct->slug}";
                }
            } else {
                CartProduct::wherehydroProductId($product)->delete();
            }
        }
        return $messages;
    }
}
