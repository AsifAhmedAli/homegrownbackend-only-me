<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Hydro\HydroProduct;
use App\Models\Wishlist;
use App\Utils\Api\ApiResponse;
use Illuminate\Http\Request;

class WishlistController extends Controller
{

    public function addToWishList($hyrdo_product_id)
    {
        try {
            $userId = \Auth::user()->id;
            if ($this->isProductAlreadyAddedToWishlist($userId, $hyrdo_product_id)) {
                $response['message'] = 'Product already added in wishlist.';
                return ApiResponse::success($response);
            }
            $wishlist             = new WishList();
            $wishlist->user_id    = $userId;
            $wishlist->hydro_product_id = $hyrdo_product_id;
            $wishlist->save();
            $response['product'] = HydroProduct::withCount([
                'isFavorite' => function ($q) {
                    $q->whereUserId(\Auth::guard('api')->user()->id);
                }
            ])->find($hyrdo_product_id);
            $response['message'] = 'Product added to wishlist.';
            return ApiResponse::success($response);
        } catch (\Exception $e) {
            return ApiResponse::errorResponse(__('generic.error'), $e->getMessage());
        }
    }

    private function isProductAlreadyAddedToWishlist($userId, $productId)
    {
        return Wishlist::where('user_id', $userId)->where('hydro_product_id', $productId)->exists();
    }

    public function myWishlist()
    {
        $wishlist = WishList::with('product')->whereUserId(\Auth::user()->id)->orderBy('created_at', 'desc')->paginate();
        return ApiResponse::successResponse(__('My wishlists data.'), $wishlist);
    }

    public function deleteProductFromWishlist($product_id)
    {
        try {
            $user_id = \Auth::user()->id;
            WishList::whereUserId($user_id)->whereHydroProductId($product_id)->delete();
           /* $response['product'] = HydroProduct::withCount([
                'isFavorite' => function ($q) {
                    $q->whereUserId(\Auth::guard('api')->user()->id);
                }
            ])->find($product_id);
            $response['message'] = __('Product successfully removed from wishlist.');
           return ApiResponse::success($response);*/
            $wishlist = WishList::with('product')->whereUserId(\Auth::user()->id)->orderBy('created_at', 'desc')->paginate();
            return ApiResponse::successResponse(__('Product successfully removed from wishlist.'), $wishlist);
        } catch (\Exception $e) {
            return ApiResponse::errorResponse(__('generic.error'), $e->getMessage());
        }
    }

    public function deleteProductFromWishlistUserPanel($product_id)
    {
        try {
            $user_id = \Auth::user()->id;
            WishList::whereUserId($user_id)->whereHydroProductId($product_id)->delete();
            $wishlist = WishList::with('product')->whereUserId(\Auth::user()->id)->orderBy('created_at', 'desc')->paginate();
            return ApiResponse::successResponse(__('Product removed from wishlist.'), $wishlist);
        } catch (\Exception $e) {
            return ApiResponse::errorResponse(__('generic.error'), $e->getMessage());
        }
    }
}
