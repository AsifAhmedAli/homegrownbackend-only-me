<?php


namespace App\Utils\Constants;


use Illuminate\Validation\Rule;

class ValidationRule
{
    /**
     * @param array $extra
     * @return array
     */
    private static function email(array $extra = [])
    {
        $commonRules = ['bail', 'required', 'email'];
        return array_merge($commonRules, $extra);
    }

    /**
     * @param array $extra
     * @return array
     */
    private static function required(array $extra = [])
    {
        $commonRules = ['required'];
        return array_merge($commonRules, $extra);
    }

    /**
     * @param array $extra
     * @return array
     */
    public static function CartContactInfo(array $extra = [])
    {
        $commonRules = [
            'firstName' => self::required(),
            'lastName' => self::required(),
            'email' => self::email(),
            'phone' => self::required(),
        ];
        return array_merge($commonRules, $extra);
    }

    /**
     * @param array $extra
     * @return array
     */
    private static function optionalEmail(array $extra = ['bail'])
    {
        $commonRules = ['sometimes', 'nullable', 'email'];
        return array_merge($commonRules, $extra);
    }

    /**
     * @param array $extra
     * @return array
     */
    private static function CartShippingBillingRequiredIf(array $extra = [])
    {
        $commonRules = ['required_if:isDifferentBilling,1'];
        return array_merge($commonRules, $extra);
    }

    /**
     * @param array $extra
     * @return array
     */
    public static function CartShippingBillingInfo(array $extra = [])
    {
        $commonRules = [
          'billingFirstName' => self::required(),
          'billingLastName' => self::required(),
          'billingEmail' => self::email(),
          'billingPhone'      => self::required(),
          'billingAddress1'   => self::required(),
          'billingAddress2'   => [],
          'billingCountry'    => [],
          'billingState'      => self::required(),
          'billingCity'       => self::required(),
          'billingZip'        => self::required(),
          'shippingFirstName' => self::CartShippingBillingRequiredIf(),
          'shippingLastName'  => self::CartShippingBillingRequiredIf(),
          'shippingEmail'     => self::CartShippingBillingRequiredIf(self::optionalEmail()),
          'shippingPhone'     => self::CartShippingBillingRequiredIf(),
          'shippingAddress1'  => self::CartShippingBillingRequiredIf(),
          'shippingAddress2'  => [],
          'shippingCountry'   => [],
          'shippingState'     => self::CartShippingBillingRequiredIf(),
          'shippingCity'      => self::CartShippingBillingRequiredIf(),
          'shippingZip'       => self::CartShippingBillingRequiredIf(),
        ];
      return array_merge($commonRules, $extra);
    }

    /**
     * @param array $extra
     * @return array
     */
    public static function kitBillingShipping(array $extra = [])
    {
      $commonRules = [
        'transactionID'      => self::required(),
        'billingEmail' => self::email(),
        'billingPhone'      => self::required(),
        'billingStreetAddress'   => self::required(),
        'billingState'      => self::required(),
        'billingCity'       => self::required(),
        'billingZip'        => self::required(),
        'shippingEmail'     => self::CartShippingBillingRequiredIf(self::optionalEmail()),
        'shippingPhone'     => self::CartShippingBillingRequiredIf(),
        'shippingStreetAddress'  => self::CartShippingBillingRequiredIf(),
        'shippingState'     => self::CartShippingBillingRequiredIf(),
        'shippingCity'      => self::CartShippingBillingRequiredIf(),
        'shippingZip'       => self::CartShippingBillingRequiredIf(),
      ];
      return array_merge($commonRules, $extra);
    }

  /**
   * @param array $extra
   * @return array
   */
  public static function storeAAddressBook(array $extra = [], $id = null)
  {
    $commonRules = [
      'nickname'          => self::required([\Illuminate\Validation\Rule::unique('address_books')->ignore($id)->where('user_id', \Auth::id())]),
      'first_name'        => self::required(),
      'last_name'         => self::required(),
      'email'             => self::required(self::email()),
      //            'country' => self::required(),
      'state'             => self::required(),
      'city'              => self::required(),
            'street' => self::required(),
            'phone_no' => self::required(),
            'postal_code' => self::required()
        ];
        return array_merge($commonRules, $extra);
    }

     /**
     * @param array $extra
     * @return array
     */
    public static function changePlanStatus(array $extra = [], $id = null)
    {
      $commonRules = [
        'status'        => self::required(),
          ];
          return array_merge($commonRules, $extra);
      }

      /**
     * @param array $extra
     * @return array
     */
    public static function createPaypalPlan(array $extra = [], $id = null)
    {
      $commonRules = [
        'name'        => self::required(),
        'description'         => self::required(),
        'frequency'             => self::required(),
        'frequency_interval'             => self::required(),
        'amount'             => self::required(),
        'currency'             => self::required(),
          ];
          return array_merge($commonRules, $extra);
      }/**
     * @param array $extra
     * @return array
     */
    public static function paypalSubscription(array $extra = [], $id = null)
    {
      $commonRules = [
        'planId'        => self::required(),
          ];
          return array_merge($commonRules, $extra);
      }

    /**
     * @param array $extra
     * @return array
     */
    public static function updateUserProfile(array $extra = [])
    {
        $commonRules = [
            'first_name' => self::required(),
            'last_name' => self::required(),
            'phone_number' => self::required(),
            'state' => self::required(),
            'city' => self::required(),
            'street_address_1' => self::required(),
            'zip_code' => self::required(),
        ];
        return array_merge($commonRules, $extra);
    }
    //payment methods Brain-tree

    /**
     * @param array $extra
     * @return array
     */
    public static function addPaymentMethod(array $extra = [])
    {
        $commonRules = [
            'nonce' => self::required()
        ];
        return array_merge($commonRules, $extra);
    }

    /**
     * @param array $extra
     * @return array
     */
    public static function paymentMethodToken(array $extra = [])
    {
        $commonRules = [
            'paymentMethodToken' => self::required()
        ];
        return array_merge($commonRules, $extra);
    }

    /**
     * @param array $extra
     * @return array
     */
    public static function growLog(array $extra = [])
    {
      $commonRules = [
        'plantName' => self::required(),
        'stage' => [self::required(), Rule::in(['Clone', 'Seed'])],
        'startedAt' => [self::required(), 'date'],
        'expectedDaysWeeks' => [self::required(), 'integer'],
        'expectedDays' => [self::required(), 'integer'],
        'lighting' => ['sometimes', 'nullable', Rule::in(['Indoor', 'Greenhouse', 'Outdoor', 'GreenHouse'])],
        'cycleLight' => [],
        'lightingType' => ['sometimes', 'nullable', Rule::exists('lighting_types', 'id')],
        'wattage' => [],
        'mediaType' => ['sometimes', 'nullable', Rule::exists('media_types', 'id')],
        'strain' => ['sometimes', 'nullable', Rule::exists('strains', 'id')],
      ];

      return array_merge($commonRules, $extra);
    }

    /**
     * @param array $extra
     * @return array
     */
    public static function growLogDetail(array $extra = [])
    {
      $commonRules = [
        'log_id' => self::required(),
        'week' => self::required(),
      ];

      return array_merge($commonRules, $extra);
    }

    public static function kitReview(array $extra = [])
    {
        $commonRules = [
            'kit_id' => self::required(),
            'rating' => self::required(),
            'comment' => self::required(),
        ];

        return array_merge($commonRules, $extra);
    }
    
    public static function ticket(array $extra = [])
    {
      $commonRules = [
        'title' => self::required(),
        'priority' => self::required(),
        'description' => self::required(),
      ];
  
      return array_merge($commonRules, $extra);
    }

}
