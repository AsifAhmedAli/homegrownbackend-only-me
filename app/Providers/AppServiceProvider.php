<?php

namespace App\Providers;

use App\Utils\Constants\Constant;
use App\Utils\Constants\Paypal;
use App\Utils\Helpers\Helper;
use DB;
use Exception;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;
use Laravel\Passport\Passport;
use Schema;
use Validator;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    Cashier::keepPastDueSubscriptionsActive();

    $this->app->bind('helper', function () {
      return new Helper;
    });
  }

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    if (env('APP_ENV') !== 'local') {
      URL::forceScheme('https');
    }

    Schema::defaultStringLength(191);
    Validator::extend('max_month_role', function ($attribute, $value, $parameters, $validator) {
      if ((request('frequency') == Paypal::FREQUENCY_MONTH) && ($value > Paypal::MAX_FREQUENCY_INTERVAL_OF_MONTH)) {
        return false;
      } else {
        return true;
      }
    });
    Validator::replacer('max_month_role', function ($message, $attribute, $rule, $parameters) {
      return "The plan duration must be between 1 and 12.";
    });

    Validator::extend('max_frequency_interval_role', function ($attribute, $value, $parameters, $validator) {
      if ((request('frequency') == Paypal::FREQUENCY_YEAR) && ($value > Paypal::MAX_FREQUENCY_INTERVAL_OF_YEAR)) {
        return false;
      } else {
        return true;
      }
    });
    Validator::replacer('max_frequency_interval_role', function ($message, $attribute, $rule, $parameters) {
      return "The plan duration for year must be 1.";
    });


    Validator::extend('distinct_provider', function ($attribute, $value, $parameters, $validator) {
      $table = Helper::arrayIndex($parameters, 0, null);
      if (is_null($table)) {
        throw new Exception('No Table Provided');
      }
      $providerIndex = array_search('provider', $parameters);
      if ($providerIndex) {
        $providerColumn = Helper::arrayIndex($parameters, $providerIndex);
      } else {
        $providerColumn = 'provider';
      }
      $provider = request($providerColumn, Constant::HGP);
      $idIndex = array_search('id', $parameters);
      $id = null;
      if ($idIndex) {
        $id = Helper::arrayIndex($parameters, $idIndex + 1, null);
      }
      return !DB::table($table)->where($attribute, $value)->where($providerColumn, $provider)->when($id, function ($q) use ($id) {
        $q->where('id', '!=', $id);
      })->exists();
    });

    Validator::replacer('distinct_provider', function ($message, $attribute, $rule, $parameters) {
      return "The {$attribute} already exists.";
    });
  }
}
