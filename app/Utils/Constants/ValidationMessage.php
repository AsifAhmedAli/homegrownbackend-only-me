<?php


namespace App\Utils\Constants;


class ValidationMessage
{
    /**
     * @return string
     */
    public static function getRequired()
    {
        return ':attribute is Required.';
    }

    public static function getUnique()
    {
        return ':attribute must be unique.';
    }

    /**
     * @return string
     */
    public static function getValidationErrorOccurred()
    {
        return 'Validation Errors Occurred';
    }

    /**
     * @return string
     */
    public static function getValidEmail()
    {
        return ':attribute must be a valid email address.';
    }

    /**
     * @param array $extra
     * @return array
     */
    public static function messages(array $extra = [])
    {
        $commonRules = [
            'firstName.required' => self::getRequired(),
            'lastName.required' => self::getRequired(),
            'name.required' => self::getRequired(),
            'email.required' => self::getRequired(),
            'email.email' => self::getValidEmail(),
            'phone.required' => self::getRequired(),
            'password.required' => self::getRequired(),
        ];

        return array_merge($commonRules, $extra);
    }

    /**
     * @return array
     */
    public static function CartBillingShipping()
    {
        return [
            'billingEmail.required' => self::getRequired(),
            'billingEmail.email' => self::getValidEmail(),
            'billingFirstName.required' => self::getRequired(),
            'billingLastName.required' => self::getRequired(),
            'billingPhone.required' => self::getRequired(),
            'billingAddress1.required' => self::getRequired(),
            'billingStreetAddress.required' => self::getRequired(),
            'billingCountry.required' => self::getRequired(),
            'billingState.required' => self::getRequired(),
            'billingCity.required' => self::getRequired(),
            'billingZip.required' => self::getRequired(),
            'shippingEmail.required_if' => self::getRequired(),
            'shippingEmail.email' => self::getValidEmail(),
            'shippingFirstName.required_if' => self::getRequired(),
            'shippingLastName.required_if' => self::getRequired(),
            'shippingPhone.required_if' => self::getRequired(),
            'shippingAddress1.required_if' => self::getRequired(),
            'shippingStreetAddress.required_if' => self::getRequired(),
            'shippingCountry.required_if' => self::getRequired(),
            'shippingState.required_if' => self::getRequired(),
            'shippingCity.required_if' => self::getRequired(),
            'shippingZip.required_if' => self::getRequired(),
        ];
    }

    public static function storeAddressBook(array $extra = [])
    {
        $commonRules = [
            'nickname.required' => self::getRequired(),
            'nickname.unique' => 'Nickname must be unique.',
            'first_name.required' => self::getRequired(),
            'last_name.required' => self::getRequired(),
            'email.required' => self::getRequired(),
            'email.email' => self::getValidEmail(),
//            'country.required' => self::getRequired(),
            'state.required' => self::getRequired(),
            'city.required' => self::getRequired(),
            'street.required' => self::getRequired(),
            'phone_no.required' => self::getRequired(),
            'postal_code.required' => self::getRequired(),


        ];

        return array_merge($commonRules, $extra);
    }
    public static function changePlanStatus(array $extra = [])
    {
        $commonRules = [
            'status.required' => self::getRequired(),
        ];

        return array_merge($commonRules, $extra);
    }
    public static function paypalSubscription(array $extra = [])
    {
        $commonRules = [
            'planId.required' => self::getRequired(),
        ];

        return array_merge($commonRules, $extra);
    }
    public static function createPaypalPlan(array $extra = [])
    {
        $commonRules = [
            'name.required' => self::getRequired(),
            'description.required' => self::getRequired(),
            'frequency.required' => self::getRequired(),
            'frequency_interval.required' => self::getRequired(),

            'amount.required' => self::getRequired(),
            'currency.required' => self::getRequired(),


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
            'first_name.required' => self::getRequired(),
            'last_name.required' => self::getRequired(),
            'phone_number.required' => self::getRequired(),
            'state.required' => self::getRequired(),
            'city.required' => self::getRequired(),
            'street_address_1.required' => self::getRequired(),
            'zip_code.required' => self::getRequired(),
        ];

        return array_merge($commonRules, $extra);
    }

    /**
     * @param array $extra
     * @return array
     */
    public static function addPaymentMethod(array $extra = [])
    {
        $commonRules = [
            'nonce.required' => self::getRequired(),
        ];

        return array_merge($commonRules, $extra);
    }

    public static function paymentMethodToken(array $extra = [])
    {
        $commonRules = [
            'paymentMethodToken.required' => self::getRequired(),
        ];

        return array_merge($commonRules, $extra);
    }

    public static function growLog(array $extra = [])
    {
      $commonRules = [
        'plantName.required' => self::getRequired(),
        'stage.required' => self::getRequired(),
        'startedAt.required' => self::getRequired(),
        'expectedDaysWeeks.required' => self::getRequired(),
        'expectedDays.required' => self::getRequired(),
        'lighting.required' => self::getRequired(),
        'cycleLight.required' => self::getRequired(),
        'lightingType.required' => self::getRequired(),
        'wattage.required' => self::getRequired(),
        'mediaType.required' => self::getRequired(),
        'strain.required' => self::getRequired(),
      ];

      return array_merge($commonRules, $extra);
    }

    public static function growLogDetail(array $extra = [])
    {
      $commonRules = [
        'log_id.required' => self::getRequired(),
        'week.required' => self::getRequired(),
      ];

      return array_merge($commonRules, $extra);
    }


    public static function kitReview(array $extra = [])
    {
      $commonRules = [
        'kit_id.required' => self::getRequired(),
        'rating.required' => self::getRequired(),
        'comment.required' => self::getRequired(),
      ];

      return array_merge($commonRules, $extra);
    }
  
  
    public static function ticket(array $extra = [])
    {
      $commonRules = [
        'title.required' => self::getRequired(),
        'priority.required' => self::getRequired(),
        'description.required' => self::getRequired(),
        'message.required' => self::getRequired(),
      ];
      
      return array_merge($commonRules, $extra);
    }
}
