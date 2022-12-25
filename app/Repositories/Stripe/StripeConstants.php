<?php
  
  
  namespace App\Repositories\Stripe;
  
  
  class StripeConstants
  {
    public const DEFAULT_SUBSCRIPTION_NAME = 'default';
    public const DEFAULT_SUBSCRIPTION_PLAN = 'price_1GzKVZK6v6Ke2UD5rU4FO3pR';
    
    public const PLAN_DAY = 'day';
    public const PLAN_WEEK = 'week';
    public const PLAN_MONTH = 'month';
    public const PLAN_YEAR = 'year';
  
    public const PLAN_DAILY = 'Daily';
    public const PLAN_WEEKLY = 'Weekly';
    public const PLAN_MONTHLY = 'Monthly';
    public const PLAN_YEARLY = 'Yearly';
    
    public const PLAN_INTERVALS = [
      self::PLAN_DAY => self::PLAN_DAILY,
      self::PLAN_WEEK => self::PLAN_WEEKLY,
      self::PLAN_MONTH => self::PLAN_MONTHLY,
      self::PLAN_YEAR => self::PLAN_YEARLY,
    ];
  
    /**
     * @return string
     */
    public static function noPaymentFoundForSubscription(): string
    {
      return __('No Payment method found for Subscription');
    }
  
    /**
     * @return string
     */
    public static function paymentMethodNotFound(): string
    {
      return __('Payment Method not found against given ID');
    }
  
    /**
     * @return string
     */
    public static function paymentMethodsDeleted(): string
    {
      return __('All Payment Methods deleted Successfully');
    }
  
    /**
     * @return string
     */
    public static function paymentMethodDeleted(): string
    {
      return __('Payment Method deleted Successfully');
    }
  
    /**
     * @return string
     */
    public static function noDefaultPaymentMethodFound(): string
    {
      return __('No Default Payment Method found');
    }
  
    /**
     * @return string
     */
    public static function paymentMethodCannotBeDeleted(): string
    {
      return __('You cannot delete this Payment Method because you have an Active Subscription');
    }
  
    /**
     * @return string
     */
    public static function userNotFound(): string
    {
      return __('User does not exist on Stripe');
    }
  
    /**
     * @param null $planName
     * @return string
     */
    public static function alreadySubscribedToPlan($planName = null): string
    {
      if (is_null($planName)) {
        return __('You are already Subscribed');
      } else {
        return __('You are already Subscribed' . " to Plan {$planName}");
      }
    }
  }
