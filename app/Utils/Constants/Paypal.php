<?php
  
  
  namespace App\Utils\Constants;
  
  
  class Paypal
  {
    const PLAN_ACTIVE_STATE = 'ACTIVE';
    const PLAN_INACTIVE_STATE = 'INACTIVE';
    const PLAN_CREATED_STATE = 'CREATED';
    const FREQUENCY_MONTH = 'MONTH';
    const FREQUENCY_YEAR = 'YEAR';
    const MAX_FREQUENCY_INTERVAL_OF_MONTH = 12;
    const MAX_FREQUENCY_INTERVAL_OF_YEAR = 1;
    const PLAN_API_ENDPOINT = 'billing/plans';
    const PRODUCT_API_ENDPOINT = 'catalogs/products';
    const CHECKOUT_API_ENDPOINT = 'checkout/orders/';
    const AUTH_API_ENDPOINT = 'oauth2/token';
    const PLAN_REQUEST = 'plan';
    const PRODUCT_REQUEST = 'product';
    const REQ_GET_METHOD = 'get';
    const REQ_POST_METHOD = 'post';
    const COMPLETED_STATUS = 'COMPLETED';
  }
