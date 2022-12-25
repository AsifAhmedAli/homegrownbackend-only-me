<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'braintree' => [
        'env' => 'sandbox',
        'braintree_sandbox_merchant_id' => env('BRAINTREE_SANDBOX_MERCHANT_ID','w2t33ttwkdm7kwpm'),
        'braintree_sandbox_private_key' => env('BRAINTREE_SANDBOX_PRIVATE_KEY','be0ed1fa6a81f9ffbd76f2de5ce1f74e'),
        'braintree_sandbox_public_key' => env('BRAINTREE_SANDBOX_PUBLIC_KEY','cpk6ybhxtbhr755g'),
        'braintree_production_merchant_id' => env('BRAINTREE_PRODUCTION_MERCHANT_ID'),
        'braintree_production_private_key' => env('BRAINTREE_PRODUCTION_PRIVATE_KEY'),
        'braintree_production_public_key' => env('BRAINTREE_PRODUCTION_PUBLIC_KEY'),
    ],
    'mailchimp' => [
      'list_id' => env('MAILCHIMP_LIST_ID', '45b4bef111'),
      'store_id' => env('MAILCHIMP_STORE_ID', 'HGP-ABANDONED2'),
      'abandoned_id' => env('MAILCHIMP_ABANDONED_ID', '4960721ce9'),
      'mode' => env('ABANDONED_CART_MODE', 'disabled'),
    ],
    'avalara' => [
      'env' => env('AVALARA_ENV', 'sandbox'),
      'email' => env('AVALARA_EMAIL'),
      'password' => env('AVALARA_PASSWORD'),
      'mode' => env('AVALARA_MODE', 'disabled'),
    ],
    'hydrofarm' => [
      'env' => env('HYDROFARM_ENV', 'sandbox'),
      'production_url' => env('HYDROFARM_PRODUCTION_URL', 'https://api.hydrofarm.com/api'),
      'production_access_token_url' => env('HYDROFARM_PRODUCTION_ACCESS_TOKEN_URL', 'https://oauth.hydrofarm.com/connect/token'),
      'production_client_id' => env('HYDROFARM_PRODUCTION_CLIENT_ID', '7336-14029-42cb0607-4803-4bc1-8a8f-b2a1da9dfc9b'),
      'production_client_secret' => env('HYDROFARM_PRODUCTION_CLIENT_SECRET', '2aeaa968-a821-4057-b633-cda5a517071e'),
      'sandbox_url' => env('HYDROFARM_SANDBOX_URL', 'https://dev-api.hydrofarm.com/api'),
      'sandbox_access_token_url' => env('HYDROFARM_SANDBOX_ACCESS_TOKEN_URL', 'https://dev-oauth.hydrofarm.com/connect/token'),
      'sandbox_client_id' => env('HYDROFARM_SANDBOX_CLIENT_ID', '7336-14029-42cb0607-4803-4bc1-8a8f-b2a1da9dfc9b'),
      'sandbox_client_secret' => env('HYDROFARM_SANDBOX_CLIENT_SECRET', 'aa67de17-3b1e-460d-8fa6-8f538431903a'),
      'grant_type' => 'Client Credentials',
    ],
    'socket_url' => env('SOCKET_URL', 'https://gx.dotlogicstest.com'),
    'daily_api_token' => env('DAILY_CO_API_TOKEN', 'c6e2f1ca6f4f2ae0f2e27d6ff80ed9b0fa4d8f3b9b356ab6e9953da21ead775c')

];
