<?php
  
  use Illuminate\Support\Facades\Route;
  
Route::prefix('customer')->group(function() {
  Route::get('save-all', 'StripeController@saveAllCustomers');
  Route::get('get', 'StripeController@getCustomer');
  Route::get('save', 'StripeController@saveCustomer');
  Route::get('update', 'StripeController@updateCustomer');
});

Route::prefix('payment-method')->group(function() {
  Route::get('update', 'StripeController@showPaymentMethodForm');
  Route::get('get', 'StripeController@getPaymentMethods');
//    Route::get('delete', 'StripeController@deleteAllPaymentMethods');
  Route::get('default', 'StripeController@getDefaultPaymentMethod');
  
  Route::prefix('{paymentMethod}')->group(function () {
    Route::get('add', 'StripeController@addPaymentMethod');
    Route::get('get', 'StripeController@getPaymentMethod');
    Route::get('delete', 'StripeController@deletePaymentMethod');
  });
});

Route::prefix('subscription')->group(function() {
  Route::get('create', 'StripeController@createSubscription');
});
