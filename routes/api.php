<?php

use App\Http\Controllers\Api\GrowLogController;
use App\Http\Controllers\Api\GrowLogDetailController;
use App\Http\Controllers\Api\KitController;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Api\TicketController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::get('test', function() {

    $text = 'text';
    echo $text;
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
/*auth routes*/

Route::post('auth/login', 'AuthController@login');
Route::get('logout', 'AuthController@logout')->middleware(['jwt.auth', 'api']);
Route::post('forgot_password', 'Api\AuthController@forgot_password')->name('forgot_password');
Route::post('password/reset', 'Api\AuthController@reset_password')->name('reset_password');
Route::get('password/reset/validate-code/{token}', 'Api\AuthController@validateResetToken');
Route::post('auth/payment-method/token/get', 'Api\BraintreePaymentController@getToken');
Route::get('kits/all', [KitController::class, 'index']);

Route::middleware('jwt.auth')->namespace('Api')->group(function () {

    Route::post('auth/review', 'ProductReviewController@store');
    Route::group(['prefix' => 'auth'], function () {

        Route::prefix('grow-logs')->group(function () {
            Route::get('get', [GrowLogController::class, 'index']);
            Route::post('add', [GrowLogController::class, 'add']);
            Route::put('{id}/deactivate', [GrowLogController::class, 'deActivate']);
            Route::put('{id}/complete', [GrowLogController::class, 'complete']);
            Route::post('{id}/get', [GrowLogController::class, 'show']);
            Route::post('{id}/update', [GrowLogController::class, 'update']);
            Route::get('expected-weeks/{id}', [GrowLogController::class, 'growLogExpectedWeeks']);
        });

        Route::prefix('grow-logs-detail')->group(function () {
            Route::post('add', [GrowLogDetailController::class, 'add']);
            Route::get('{id}/edit', [GrowLogDetailController::class, 'edit']);
            Route::post('{id}/update', [GrowLogDetailController::class, 'update']);
            Route::get('detail/{grow_log_id}/{week}/{day?}', [GrowLogDetailController::class, 'getGrowLogDetail']);
        });

        /*orders*/
        Route::group(['prefix' => 'my-orders'], function () {
            Route::post('get', 'OrderController@getMyOrders');
            Route::post('{oderNumber}/get', 'OrderController@getOrderDetail');
        });
        /*payment methods*/
        Route::prefix('payment-method')->group(function () {
            Route::post('add', 'BraintreePaymentController@addPaymentMethod');
            Route::post('get', 'BraintreePaymentController@getPaymentMethods');
            Route::post('delete', 'BraintreePaymentController@deletePaymentMethod');
            Route::post('makeDefault', 'BraintreePaymentController@makeDefaultPaymentMethod');
            Route::post('{sessionID}/nonce/add', 'BraintreePaymentController@attachPaymentNonce');
        });

        Route::put('change_password', 'AuthController@changePassword');
        Route::get('user/get', 'AuthController@getLoggedInUserDetail');
        Route::put('update_profile/{id}', 'UserController@updateProfile');
        Route::prefix('wishlist')->group(function () {
            Route::post('{product_id}/add', 'WishlistController@addToWishList');
            Route::get('all', 'WishlistController@myWishlist');
            Route::post('{product_id}/delete', 'WishlistController@deleteProductFromWishlist');
            Route::post('user/wishlist/{product_id}', 'WishlistController@deleteProductFromWishlistUserPanel');
        });
        Route::group(['prefix' => 'address'], function () {
            Route::post('add', 'AddressBookController@store');
            Route::get('all', 'AddressBookController@allAddressBook');
            Route::get('default', 'AddressBookController@getAllDefaultAddresses');
            Route::get('{id}/get', 'AddressBookController@getAddressById');
            Route::delete('{id}/delete', 'AddressBookController@deleteAddressById');
            Route::put('{id}/update', 'AddressBookController@update');
            Route::put('mark-address-default', 'AddressBookController@markAddressDefault');
            Route::post('get', 'AddressBookController@getAddressBooks');
        });

        Route::prefix('grow-trackers')->group(function () {
            Route::get('/', 'GrowTrackerController@index');
        });

        Route::prefix('kits')->group(function () {
            $controller = KitController::class;
            Route::get('my-kits', [$controller, 'myKits']);
            Route::post('review/add', [$controller, 'addReview']);
        });

        Route::group(['prefix' => 'kit'], function () {
            Route::post('{kitID}/purchase', [KitController::class, 'purchase']);
        });

        Route::post('user-memberships/subscribe', 'UserSubscriptionsController@subscribe');
        Route::get('user-memberships/get', 'UserSubscriptionsController@mySubscriptions');

        Route::post('kits', 'OrderController@getKits');
        Route::post('subscriptions', 'OrderController@getSubscriptions');
        Route::get('user-kit-detail/{id}', 'OrderController@getKitDetail');
        Route::get('subscription-detail/{id}', 'OrderController@getSubscriptionDetail');
        Route::prefix('ticket')->group(function () {
            Route::post('generate', [TicketController::class, 'create']);
            Route::get('get', [TicketController::class, 'get']);
            Route::get('{ticketID}/get', [TicketController::class, 'find']);
            Route::post('{ticketID}/send', [TicketController::class, 'send']);
        });
    });

    // checkout
    Route::group(['prefix' => 'order'], function () {
        Route::post('{sessionID}/place', 'OrderController@placeOrder');
    });


});

Route::group(['namespace' => 'Api'], function () {
    Route::get('states/legal', [SettingsController::class, 'legalStates']);
    Route::prefix('plans')->group(function () {
        Route::get('get', 'SubscriptionController@getPlans');
        Route::middleware('jwt.auth')->post('{id}/subscribe', 'SubscriptionController@subscribe');
    });

    Route::prefix('settings')->group(function () {
        Route::get('get', 'SettingsController@index');
    });

    Route::prefix('cart')->group(function () {
        Route::any('{sessionID}/add', 'CartController@add');
        Route::post('{sessionID}/quantity/update', 'CartController@updateQty');
        Route::post('{sessionID}/remove', 'CartController@remove');
        Route::post('{sessionID}/clear', 'CartController@clear');
        Route::post('{sessionID}/guest/login', 'CartController@guestLogin');
        Route::post('{sessionID}/contact-info/update', 'CartController@updateContactInformation');
        Route::post('{sessionID}/shipping-billing/update', 'CartController@updateShippingBillingInfo');
        Route::post('{sessionID}/coupon/apply', 'CouponController@apply');
        Route::post('{sessionID}/coupon/remove', 'CouponController@remove');
        Route::get('{sessionID}/{state}/verify/shipping', 'CartController@verifyShipping');
        Route::post('{sessionID}/shipping/calculate', 'ShippingController@calculator');
        Route::post('{sessionID}/payment-nonce/add', 'BraintreePaymentController@attachPaymentNonce');
    });

    Route::get('kits/detail/{kit_id}', [KitController::class, 'detail']);
    Route::get('kits/detail/{name}/{size}', [KitController::class, 'getKitSize']);
    Route::get('kits/products/{cart_id}/{kit_id}', [KitController::class, 'getKitProducts']);
    Route::get('kits/compare', [KitController::class, 'compare']);

    Route::prefix('products')->group(function () {
       // Route::get('get', 'HydroProductController@index');
        Route::get('get', 'HydroProductController@optimized');
        Route::get('getCategories', 'HydroProductController@getCategories');
        Route::get('{sku}/get', 'HydroProductController@find');
    });
    /*login route*/
    Route::post('auth/login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::post('account/verify', 'AuthController@verifyAccount');
    Route::post('braintreePaymentCheck', 'AuthController@braintreePaymentCheck');
    Route::post('mailchimp/subscribe', 'MailChimpController@subscribeNewsLetter');

    /*user management routes */
    Route::group(['prefix' => 'user'], function () {

        /*logged in user routes*/
        Route::get('', 'UserController@getLoggedInUser')->middleware(['auth:api', 'api']);
        Route::put('change_password', 'UserController@changePassword')->middleware(['auth:api', 'api']);

        /*user routes*/
        Route::post('check_email', 'UserController@checkEmail');
        Route::get('{id}/get', 'UserController@show');
        Route::post('/create', 'UserController@store');
    });

    /*contact inquire routes*/
    Route::post('contact-us', 'ContactUs@store');

    /*pages routes*/
    Route::prefix('page')->group(function () {
        Route::get('how-it-work', 'PageController@howItWork');
        Route::get('features', 'PageController@getGXFeaturePage');
        Route::post('faqs-search-from-how-it-work/', 'PageController@searchHowItWordFaqs');
        Route::get('about-us', 'PageController@aboutUs');
        Route::get('{slug}/get', 'PageController@show');
        Route::get('gx-about-us', 'GxAboutUsController@index');

    });
    Route::get('homepage', 'PageController@getHomePageContent');
    Route::get('gx', 'PageController@getGXHomePageContent');
    Route::get('gx-pricing', 'PageController@getGxPricingPage');

    /*blog routes*/
    Route::group(['prefix' => 'blog'], function () {
        Route::get('category/get', 'BlogController@getCategory');
        Route::get('get', 'BlogController@index');
        Route::get('{slug}/show', 'BlogController@show');
    });

    /*faq routes*/
    Route::group(['prefix' => 'faqs'], function () {
        Route::get('gx/pricing', 'FaqController@gxFaqs');
        Route::get('{projectType}', 'FaqController@faqs');
        Route::get('by-category/{categorySlug}/{projectType}', 'FaqController@getFaqsByCategory');
        Route::post('search', 'FaqController@search');
    });

    /*
    |--------------------------------------------------------------------------
    | CHAT Routes
    |--------------------------------------------------------------------------
     */

    Route::group(['prefix' => 'auth/chat', 'middleware' => 'jwt.auth'], function() {
        Route::get('messages/get', [\App\Http\Controllers\Api\ChatController::class, 'getAll']);
        Route::post('message/send', [\App\Http\Controllers\Api\ChatController::class, 'sendMessage']);
        Route::get('message/{chat_id}/read-messages', [\App\Http\Controllers\Voyager\VoyagerChatController::class, 'readMessage']);
    });

    /*
    |--------------------------------------------------------------------------
    | PayPal Routes
    |--------------------------------------------------------------------------
     */

    Route::group(['prefix' => 'paypal'], function () {

        /* payment */
        Route::group(['prefix' => 'payment'], function () {
            Route::post('', 'PaypalPaymentController@payment');
            Route::get('detail/{paymentId}', 'PaypalPaymentController@payment');
        });
        Route::get('access-token', 'PayPalPlanController@getAccessToken');
        /* plan */
        Route::group(['prefix' => 'plan'], function () {
            Route::post('create', 'PayPalPlanController@createPlan');
            Route::get('all', 'PayPalPlanController@getAllActivePlans');
        });

        /* subscription */
        Route::group(['prefix' => 'subscription'], function () {
            Route::post('create', 'PaypalSubscriptionController@subscribe');
        });

        /* agreement */
        Route::group(['prefix' => 'agreement'], function () {
            Route::post('{planId}', 'PayPalPlanController@createAgreement');
            Route::post('execute', 'PayPalPlanController@executeAgreement');
        });


    });


    include('email-routes.php');
});
