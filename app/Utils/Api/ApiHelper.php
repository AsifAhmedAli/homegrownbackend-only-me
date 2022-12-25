<?php


namespace App\Utils\Api;

use App\Cart;
use App\Faq;
use App\Gx\GrowLog;
use App\Models\UserPurchasedKit;
use App\Models\UserSubscription;
use App\User;
use App\UserRoles;
use App\Utils\Constants\Constant;
use Illuminate\Database\Eloquent\Model;
use Mail;
use phpDocumentor\Reflection\DocBlock\Tags\Author;

class ApiHelper
{
  /**
   * @return GrowLog|Model|Eloquent
   */
  private static function baseQuery()
  {
    return GrowLog::ofUser(auth()->id());
  }
  public static function hasActiveLog(){
    return self::baseQuery()->where('is_active', 1)->exists();
  }
  public static function hasSubscription()
  {
    return UserSubscription::where("user_id", auth()->id())->exists();
  }

  public static function getLoggedInUser()
  {
    return auth()->user();
  }

  public static function gxFaqs()
  {
    return Faq::select('id', 'slug', 'question', 'answer', 'is_active')->ofType(Faq::GX)->active()->get();
  }

  public static function isHGP()
  {
    $provider = request('provider', Constant::HGP);

    return $provider === Constant::HGP;
  }

  /**
   * @param string $column
   * @param string $table
   * @param string $default
   * @return string
   */
  public static function resolveSortColumn($column, $table, $default = 'id')
  {
    $columns = \Schema::getColumnListing($table);
    if (in_array($column, $columns)) {
      return $column;
    } else {
      return $default;
    }
  }
  /**
   * @param $direction
   * @return string
   */
  public static function resolveDirection($direction) {
    if (in_array($direction, ['asc', 'desc'])) {
      return $direction;
    }
    return 'desc';
  }
  /**
   * @param $column
   * @param string $table
   * @param string $default
   * @return string
   */
  public static function resolveSearchColumn($column, $table, $default = 'id') {
    $columns = \Schema::getColumnListing($table);
    if (in_array($column, $columns)) {
      return $column;
    } else {
      return $default;
    }
  }
    public static function reApplyCoupon(Cart $cart)
    {
        if ($cart && $cart->hasCoupon()) {
            $coupon = $cart->getCoupon();
            if ($coupon) {
                Cart::reApplyCoupon($cart);
            } else {
                Cart::resetCoupon($cart);
            }
        }
    }

    public static function resolveValue($value, $default)
    {
        if (!self::empty($value)) {
            return $value;
        }
        return $default;
    }

    public static function empty($data)
    {
        return is_null($data) || empty($data);
    }

    public static function findCartById($cartID)
    {
        $cart = Cart::find($cartID);
        if ($cart) {
            //    self::reApplyCoupon($cart);
        }
        $cart = Cart::with([
            'products' => function ($q) {
                $q->latest('updated_at', 'desc');
            },
            'products.product',
            'products.kit'
        ])->find($cartID);

        if ($cart) {
            self::validateCartProducts($cart);
        }

        if ($cart && !$cart->hasProducts()) {
            Cart::clear($cart->id);
            $cart = null;
        }
        if ($cart) {
           // self::proceedToMailChimp($cart);
        }

        return $cart;
    }

    private static function validateCartProducts(Cart $cart)
    {
        foreach ($cart->products as $cartProduct) {
            Cart::validateProduct($cartProduct);
        }
    }

    public static function createAccount($firstName, $lastName, $email, $phone, $password, $auth)
    {
        if (!User::where('email', $email)->exists()) {
            $user = new User();
            $user->first_name = $firstName;
            $user->last_name = $lastName;
            $user->email = $email;
            $user->phone_number = $phone;
            $user->password = bcrypt($password);
            $user->save();
            $userRole = new UserRoles();
            $userRole->user_id = $user->id;
            $userRole->role_id = '3';
            $userRole->save();
            $data = array('name'=>"Invoice",'user'=>$user);
            Mail::send('mail/welcome', $data, function($message,$email) {
                $message->to($email, 'Welcome Email')->subject('Welcome');
                $message->from('majid@topdot.pk','Topdot');
            });
            return $user;
        }

        return null;
    }

    public static function generateStrongPassword(int $length = 15, bool $add_dashes = false, string $available_sets = 'luds')
    {
        $sets = array();
        if (strpos($available_sets, 'l') !== false)
            $sets[] = 'abcdefhjkmnprstuvwxyz';
        if (strpos($available_sets, 'u') !== false)
            $sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
        if (strpos($available_sets, 'd') !== false)
            $sets[] = '23456789';
        if (strpos($available_sets, 's') !== false)
            $sets[] = '!@#$%&*?';
        $all = '';
        $password = '';
        foreach ($sets as $set) {
            $password .= $set[self::tweak_array_rand(str_split($set))];
            $all .= $set;
        }
        $all = str_split($all);
        for ($i = 0; $i < $length - count($sets); $i++)
            $password .= $all[self::tweak_array_rand($all)];
        $password = str_shuffle($password);
        if (!$add_dashes)
            return $password;
        $dash_len = floor(sqrt($length));
        $dash_str = '';
        while (strlen($password) > $dash_len) {
            $dash_str .= substr($password, 0, $dash_len) . '-';
            $password = substr($password, $dash_len);
        }
        $dash_str .= $password;
        return $dash_str;
    }

    public static function tweak_array_rand(array $array)
    {
        if (function_exists('random_int')) {
            return random_int(0, count($array) - 1);
        } elseif (function_exists('mt_rand')) {
            return mt_rand(0, count($array) - 1);
        } else {
            return array_rand($array);
        }
    }
    public static function activePaymentMethods()
    {
        $methods = array_keys(Helper::paymentMethods());
        return Setting::whereIn('key', $methods)->get();

    }

    public static function uploadBase64Image_old($image, $directory = "grow-log-details", $old_image = null) {

        $inner_dr = date("FY");
        $image = preg_replace('/^data:image\/\w+;base64,/', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = $directory.'/'.$inner_dr.'/'.str_random(20).'.'.'png';

        if (!file_exists(storage_path('app/public/'.$directory))) {
            mkdir(storage_path('app/public/'.$directory), 0777,true);
        }
        if (!file_exists(storage_path('app/public/'.$directory.'/'.$inner_dr))) {
            mkdir(storage_path('app/public/'.$directory.'/'.$inner_dr), 0777,true);
        }

        if (! is_null($old_image)) {/*this old image is with directory name like (logs_detail)*/
            \File::delete(storage_path("app/public").'/'.$old_image);
        }
        \File::put(storage_path('app/public/'.$imageName), base64_decode($image));

        return $imageName;
    }

    public static function uploadBase64Image($url, $directory = "grow-log-details", $old_image = null) {
        $inner_dr = date("FY");
        $base64_str = substr($url, strpos($url, ",") + 1);
        $image = base64_decode($base64_str);
        $imageName = $directory.'/'.$inner_dr.'/'.str_random(20).'.'.'png';

        if (!file_exists(storage_path('app/public/'.$directory))) {
            mkdir(storage_path('app/public/'.$directory), 0777,true);
        }
        if (!file_exists(storage_path('app/public/'.$directory.'/'.$inner_dr))) {
            mkdir(storage_path('app/public/'.$directory.'/'.$inner_dr), 0777,true);
        }
/*        if (! is_null($old_image) && !empty($old_image)) {
            unlink(storage_path("app/public").'/'.  $old_image);
        }*/
        \Storage::disk('public')->put($imageName, $image);
        return $imageName;
    }

    public static function weekBetweenDates($first_date, $second_date)
    {
        $first = \DateTime::createFromFormat('m/d/Y', date("m/d/Y", strtotime($first_date)));
        $second = \DateTime::createFromFormat('m/d/Y', date("m/d/Y", strtotime($second_date)));
        if($first_date > $second_date) {
            return self::weekBetweenDates($second_date, $first_date);
        }

        if ($first_date == $second_date) { /*if start and end date same then consider 1 week*/
            return 1;
        }

        return (int)ceil($first->diff($second)->days/7);
    }

    public static function growLogExpectedDaysWeek($grow_log) {
        $weeks = $days = 0;
        if (! is_null($grow_log)) {
            $weeksInDecimal = ($grow_log->expected_days / 7);
            $weeks =  ceil($weeksInDecimal);
            $days = $grow_log->expected_days - (floor($weeksInDecimal) * 7);
        }

        return [$weeks, $days];
    }

    public static function addUserPurchasedKits($kit_id, $user_id) {

      if (! is_null($kit_id)) {
          $kits = UserPurchasedKit::create([
              'kit_id' => $kit_id,
              'user_id' => $user_id,
          ]);
          return $kits;
      }
        return false;
    }

    public static function uploadGrowLogImages($images) {
        $imagesArray = [];
        foreach ($images as $image) {
            if(!$image['existing']) {
                $imageName = ApiHelper::uploadBase64Image($image['base64'], "grow-log-details");
            } else {
                $imageName = $image['base64'];
            }
            $imagesArray[] = array(
                'isFeatured' => $image['isFeatured'],
                'download_link' => $imageName,
                'existing' => $image['existing']
            );
        }

        return $imagesArray;
    }


}
