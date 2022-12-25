<?php
return [
  /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    | FIX PLAN
    | if you would like to set specific numbers of cycles in plan then you need to set plan type to 'fixed'
    | and set setCycles in payment definition

    | CREATE PLAN THAN NEVER EXPIRE
    | set plan type of INFINITE and remove setCycles from payment definition
    */

  'env' => env('PAYPAL_MODE', 'production'),

  'sandbox_client_id'   => env('PAYPAL_SANDBOX_CLIENT_ID', 'AWlXT4EbdsCYGQnbyTQNT4Lgj1qJVEhH3bN4yyLIN2TqMuDkpQUj6rU77WEjy0DWS-6HV6iqUyh2SDwG'),
  'sandbox_secret_id'   => env('PAYPAL_SANDBOX_SECRET_ID', 'ELWZqn4EohOnc_o0Tg_SpqnhBoVdMbHVmxcX_9QL-u-01dTIUrkrzE1KktYIXVWdy1d5S3xHvBXf-D_Y'),
  'sandbox_api_baseURL' => env('PAYPAL_SANDBOX_API_BASEURL', 'https://api.sandbox.paypal.com/v1/'),

  'production_client_id'   => env('PAYPAL_PRODUCTION_CLIENT_ID', 'AdwBsb--P-qo-PTDutq7FsdmD_Z0GK5-hNil4I4WEX3tu8bGIHuPmfG3oJKVLGtHfudq9k2jI_MwxgY6'),
  'production_secret_id'   => env('PAYPAL_PRODUCTION_SECRET_ID', 'EA7vlj01vGcOk1j6WpYZNi4Wjdg53eOWHvf0Wp2dIkI_oW8-fYsOXZVK9HcHxCfbtD_O14O8pfiefBKA'),
  'production_api_baseURL' => env('PAYPAL_PRODUCTION_API_BASEURL', 'https://api.paypal.com/v1/'),
  'grant_type'             => env('PAYPAL_GRANT_TYPE', 'client_credentials'),
  'plan'                   => [
    'type' => 'INFINITE'
  ],
  'paymentDefinition'      => [
    'type'                     => 'REGULAR',
    'defaultFrequency'         => env('PAYPAL_DEFAULT_FREQUENCY', 'MONTH'),
    'defaultFrequencyInterval' => env('PAYPAL_DEFAULT_FREQUENCY_INTERVAL', 6),
    'autoBillOutstanding' => env('PAYPAL_AUTO_BILLING', true),
  ],
  'amount'                 => [
    'currency' => env('PAYPAL_DEFAULT_CURRENCY', 'USD'),
  ],
  'setup_fee'                 => [
    'value' => env('PAYPAL_SETUP_FEE_VALUE', 0.01),
  ],
];
