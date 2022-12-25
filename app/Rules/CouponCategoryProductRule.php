<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CouponCategoryProductRule implements Rule
{
    protected $message = 'Something went wrong';
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
    
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (request('type') == 'fixed_product' || request('type') == 'percent_product') {
         if (request('coupon_belongstomany_product_relationship') && count(request('coupon_belongstomany_product_relationship', [])) > 0) {
           return true;
         } else {
           $this->message = 'You need to select at least one Product';
           return false;
         }
        } else if (request('type') == 'fixed_category' || request('type') == 'percent_category') {
          if (request('coupon_belongstomany_category_relationship') && count(request('coupon_belongstomany_category_relationship', [])) > 0) {
            return true;
          } else {
            $this->message = 'You need to select at least one Category';
            return false;
          }
        }
        
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}
