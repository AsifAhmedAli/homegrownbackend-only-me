<?php

namespace App\Utils\Helpers;


use App\Cart;
use App\Gx\GrowLog;
use App\Gx\Ticket;
use App\Gx\TicketMessage;
use App\Hydro\HydroProduct;
use App\Hydro\HydroProductRestriction;
use App\Mail\AdminEmail;
use App\Mail\ForgotPassword;
use App\Mail\SendNewTicketMessageNotifiction;
use App\Mail\SendNewTicketNotifiction;
use App\Mail\SendReplyTicketMessageNotifiction;
use App\MailChimp\MailChimpRepo;
use App\Role;
use App\State;
use App\User;
use App\Utils\Constants\Constant;
use Braintree_Configuration;
use DB;
use File;
use Gate;
use Illuminate\Database\Eloquent\Builder;
use Mail;
use Str;
use TCG\Voyager\Models\DataRow;

class Helper
{
    /**
     * @param $value
     * @param null $default
     * @return string|null
     */
    public static function getValue($value, $default = null)
    {
        if (self::empty($value)) {
            $value = $default;
        }
        return $value;
    }

    /**
     * @param array $errors
     * @return mixed|string|null
     */
    public static function resolveValidationError(array $errors) {
        $message = null;
        foreach ($errors as $key => $error) {
            if (!is_null($message)) {
                break;
            }
            $message = isset($error[0])? $error[0] : 'Something went wrong';
        }

        return $message;
    }

    /**
     * @param $data
     * @return bool
     */
    public static function empty($data)
    {
        return empty($data) || is_null($data) || $data == '';
    }

    /**
     * @param array $arr
     * @param $index
     * @param null $default
     * @return mixed|null
     */
    public static function arrayIndex($arr, $index, $default = null)
    {
        return isset($arr[$index]) ? $arr[$index] : $default;
    }

    /**
     * @param object $object
     * @param array $ignore
     * @return bool
     */
    public static function unique(object $object, $ignore = []): bool
    {
        $unique = self::checkUnique($object, $ignore);
        if ($unique->count()) {
            $response = false;
        } else {
            $response = true;
        }
        return $response;
    }

    /**
     * @param object $object
     * @param array $ignore
     * @return mixed
     */
    public static function getUnique(object $object, $ignore = [])
    {
        $unique = self::checkUnique($object, $ignore);

        return $unique->first();
    }

    /**
     * @param object $object
     * @param array $ignore
     * @return mixed
     */
    private static function checkUnique(object $object, array $ignore = [])
    {
        $model = get_class($object);
        $ignore = array_merge($ignore, [$object->getKeyName()]);
        if (defined("{$model}::CREATED_AT")) {
            $ignore[] = $object::CREATED_AT;
        }
        if (defined("{$model}::UPDATED_AT")) {
            $ignore[] = $object::UPDATED_AT;
        }
        $already = $model::select('*');
        foreach ($object->getAttributes() as $key => $value) {
            if (!in_array($key, $ignore)) {
                $already = $already->where($key, $value);
            }
        }
        if (isset($object->{$object->getKeyName()})) {
            $already = $already->where($object->getKeyName(), '!=', $object->{$object->getKeyName()});
        }

        return $already;
    }

    /**
     * @param $index
     * @return mixed|null
     */
    public static function resolveSorting($index)
    {
        $sortingOptions = HydroProduct::SORTING_OPTIONS;

        return self::arrayIndex($sortingOptions, $index, HydroProduct::DEFAULT_SORTING);
    }

    /**
     * @param array $errors
     * @return array
     */
    public static function resolveValidationErrors(array $errors)
    {
        foreach ($errors as $key => $error) {
            $message = self::arrayIndex($error, 0);
            if (!self::empty($message)) {
                $errors[$key] = self::arrayIndex($error, 0);
            }
        }

        return $errors;
    }

    public static function initBraintree()
    {
        $env = env('BRAINTREE_ENV');
        if ($env == 'sandbox') {
            $merchantID = env('BRAINTREE_SANDBOX_MERCHANT_ID');
            $privateKey = env('BRAINTREE_SANDBOX_PRIVATE_KEY');
            $publicKey = env('BRAINTREE_SANDBOX_PUBLIC_KEY');
        } else {
            $merchantID = env('BRAINTREE_PRODUCTION_MERCHANT_ID');
            $privateKey = env('BRAINTREE_PRODUCTION_PRIVATE_KEY');
            $publicKey = env('BRAINTREE_PRODUCTION_PUBLIC_KEY');
        }
        Braintree_Configuration::environment($env);
        Braintree_Configuration::merchantId($merchantID);
        Braintree_Configuration::publicKey($publicKey);
        Braintree_Configuration::privateKey($privateKey);
    }

    public static function addCustomerToBrainTree($user)
    {
        self::initBraintree();
        return \Braintree_Customer::create([
            'id' => optional($user)->id,
            'firstName' => optional($user)->name,
            'lastName' => optional($user)->last_name,
            'email' => optional($user)->email
        ]);
    }

    public static function addPaymentMethodToBrainTree($user, $nonce)
    {
        self::initBraintree();
        $customer = self::getBrainTreeCustomer($user);
        if (!is_null($customer)) {
            $paymentMethodCreation = \Braintree_PaymentMethod::create([
                'customerId' => $user->id,
                'paymentMethodNonce' => $nonce,
                'options' => [
                    'verifyCard' => true
                ]
            ]);
        } else {
            $paymentMethodCreation = null;
        }
        return $paymentMethodCreation;
    }

    public static function getBrainTreeCustomer($user)
    {
//      self::initBraintree();
        $customer = null;
        try {
            $customer = \Braintree_Customer::find($user->id);
        } catch (\Exception $e) {
            if ($e instanceof \Braintree\Exception\NotFound) {
                Helper::addCustomerToBrainTree($user);
                try {
                    $customer = \Braintree_Customer::find($user->id);
                } catch (\Exception $e) {
                    // Customer not found
                }
            }
        }
        return $customer;
    }

    public static function deletePaymentMethod($token, $user)
    {
        self::initBraintree();
        try {
            $payment = \Braintree_PaymentMethod::find($token);
            $response['status'] = true;
            if ($payment->customerId == $user->id) {
                try {
                    $deleteResponse = \Braintree_PaymentMethod::delete($token);
                    $response['status'] = $deleteResponse->success;
                } catch (\Exception $e) {
                    $response['status'] = false;
                }
            } else {
                $response['status'] = false;
            }
        } catch (\Exception $e) {
            if ($e instanceof \Braintree\Exception\NotFound) {
                $response['status'] = false;
            } else {
                $response['status'] = false;
            }
        }
        return $response;
    }

    public static function makeDefaultPaymentMethod($token, $user)
    {
        self::initBraintree();
        try {
            $payment = \Braintree_PaymentMethod::find($token);
            $response['status'] = true;
            if ($payment->customerId == $user->id) {
                try {
                    $statusUpdated = \Braintree_PaymentMethod::update($token, [
                        'options' => [
                            'makeDefault' => true
                        ]
                    ]);
                    $response['status'] = $statusUpdated->success;
                } catch (\Exception $e) {
                    $response['status'] = false;
                }
            } else {
                $response['status'] = false;
            }
        } catch (\Exception $e) {
            if ($e instanceof \Braintree\Exception\NotFound) {
                $response['status'] = false;
            } else {
                $response['status'] = false;
            }
        }
        return $response;
    }

    /**
     * @param string $path
     * @return string
     */
    public static function url($path = '')
    {
        return env('WEB_URL') . "/{$path}";
    }

    public static function verifyRestrictions(Cart $cart, $state)
    {
      $data               = [];
      $restrictedKits     = [];
      $restrictedProducts = [];
      foreach ($cart->products as $cartProduct) {
        $isRestricted = HydroProductRestriction::whereHydroProductId($cartProduct->hydro_product_id)->where('state', $state)->exists();
        if ($isRestricted) {
          $restrictedProducts[] = $cartProduct->hydro_product_id;
        }

        /*check if kit then check state restriction*/
       /* if (isset($cartProduct->kit) && !is_null($cartProduct->kit)){
          $isStateRestricted = State::where('iso2', $state)->illegal()->first();
          if ($isStateRestricted) {
            $restrictedKits[] = $cartProduct->kit->id;
            }
        }*/
      }
        $data['restrictedProducts'] = $restrictedProducts;
        $data['restrictedKits'] = $restrictedKits;
        return $data;
    }

    /**
     * @param Cart|Builder $cart
     * @param bool $reset
     * @return bool
     */
    public static function proceedToMailChimp(Cart $cart, bool $reset = false)
    {
        try {
            if (config('services.mailchimp.mode') === 'active') {
                $mc = new MailChimpRepo($cart);
                if ($reset) {
                    $mc->deleteWholeCart();
                } else {
                    self::addToMailChimpCart($cart, $mc);
                }
                return true;
            }
        } catch (\Exception $exception) {
            return false;
        }
        return false;
    }

    /**
     * @param Cart $cart
     * @param MailChimpRepo $mailChimpRepo
     */
    private static function addToMailChimpCart(Cart $cart, MailChimpRepo $mailChimpRepo)
    {
        $email = self::getCartEmail($cart);
        if($email) {
            $mailChimpRepo->addToCart();
        } else {
            $mailChimpRepo->resetMailChimpCart();
        }
    }

    /**
     * @param Cart $cart
     * @return mixed|string|null
     */
    public static function getCartEmail(Cart $cart)
    {
        $email = null;
        if ($cart->user_id) {
            $customer = User::find($cart->user_id);
            if ($customer) {
                $email = $customer->email;
            }
        } else {
            $email = $cart->billing_address_email;
        }

        return $email;
    }

    //Add Icon to the relevant file type
    static function getImageIcon($filename)
    {
        $extension = explode('.', $filename)[1];
        $img = NULL;
        switch ($extension) {
            case 'pdf' :
                $img = '/images/pdf-icon.png';
                break;
            case 'png':
            case 'jpg':
            case 'jpeg':
            case 'gif':
                $img = '/images/image-icon.png';
                break;
            case 'xlsx':
            case 'csv':
                $img = '/images/excel-icon.png';
                break;
            default:
                $img = '';
        }

        return $img;
    }

    public static function showFormField($row, $dataTypeContent)
    {
        $show = true;
        if(!self::empty(optional(optional($row)->details)->show)) {
            $show = $dataTypeContent->{$row->details->show};
        }

        if(!self::empty(optional(optional($row)->details)->source)) {
            $show = request('source', 'users') == optional(optional($row)->details)->source;
        }

        return $show;
    }

    public static function allowedFieldByUser($row)
    {
        if(self::empty(optional(optional($row)->details)->user)) {
            return true;
        }

        $rules = explode(',', $row->details->user);

        $isAllowed = false;

        foreach ($rules as $rule) {
            $isAllowed = auth()->user()->{$rule};
            if($isAllowed) {
                break;
            }
        }

        return $isAllowed;
    }

    public static function showFieldByRole(DataRow $dataRow)
    {
        if(self::empty(optional(optional($dataRow)->details)->role)) {
            return true;
        }

        $roles = explode(',', $dataRow->details->role);
        $roles[] = Role::DEVELOPER_ROLE;

        return in_array(auth()->user()->role_id, $roles);
    }

    /**
     * @param $transform
     * @param mixed ...$strings
     * @return string
     */
    public static function concatenate($transform, ...$strings)
    {
        $str =  strtolower(self::implode(' ', $strings));
        if(!is_null($transform) && function_exists($transform)){
            return($transform($str));
        }else{
            return $str;
        }
    }

    public static function reportTypes()
    {
        return [
            'sales_report' => 'Sales Report',
            'coupons_report' => 'Coupons Report',
            'customers_order_report' => 'Customers Order Report',
            'returning_customer' => 'Returning Customer Report',
        ];
    }

    public static function reportType($index)
    {
        return self::arrayIndex(self::reportTypes(), $index, 'Reports');
    }

    public static function reportGroups()
    {
        return [
            'days' => 'Days',
            'weeks' => 'Weeks',
            'months' => 'Months',
            'years' => 'Years',
        ];
    }

    public static function reportStatuses()
    {
        return [
            'shipped' => 'Shipped',
            'completed' => 'Completed',
            'processing' => 'Processing',
        ];
    }

    public static function makeDataSet($data) {
        $dataSet = [];
        foreach ($data as $key => $value) {
            $object = new \stdClass();
            $object->x = \Carbon\Carbon::createFromDate($value['month'])->format('F Y');
            $object->y = $value['count'];
            $dataSet[] = $object;
        }

        return $dataSet;
    }

    public static function getMonthlyReport($data) {
        $returning_report = [];
        foreach($data as $item) {
            if(array_key_exists($item->month, $returning_report)) {
                $returning_report[$item->month]['count'] = $returning_report[$item->month]['count'] + 1;
            } else {
                $returning_report[$item->month] = array('count' => 1, 'month' => $item->monthly);

            }
        }

        return $returning_report;
    }

    public static function editAddUserRole()
    {
        $source = request('source', 'users');

        $role_id = Role::NORMAL_USER_ROLE;

        if($source == 'admins') {
            $role_id = Role::ADMIN_ROLE;
        }
        if($source == 'retailers') {
            $role_id = Role::RETAILER_ROLE;
        }

        return $role_id;
    }

    public static function editAddUserProvider()
    {
        $source = request('source', 'users');

        $provider = Constant::HGP;

        if($source == 'customers' || $source == 'retailers') {
            $provider = Constant::GX;
        }

        return $provider;
    }

    public static function browseUserTitle(bool $single = false)
    {
        $title = 'Admins';

        $source = request('source') ?? request()->segment(2);

        if($source === 'users') {
            $title = 'HGP Customers';
        }
        if($source === 'customers') {
            $title = 'GX Customers';
        }
        if($source === 'retailers') {
            $title = 'Retailers';
        }

        if($single) {
            $title = str_singular($title);
        }
        return $title;
    }

    public static function checkCreateUserPermissions()
    {
        $source = request('source', 'users');

        if($source === 'admins') {
            abort_if(Gate::denies('create-admin'), 403);
        }

        if($source === 'customers') {
            abort_if(Gate::denies('create-gx-customer'), 403);
        }

        if($source === 'users') {
            abort_if(Gate::denies('create-hgp-customer'), 403);
        }

        if($source === 'retailers') {
            abort_if(Gate::denies('create-retailer'), 403);
        }
    }

    public static function checkUpdateUserPermissions()
    {
        $source = request('source', 'users');

        if($source === 'admins') {
            abort_if(Gate::denies('update-admin'), 403);
        }

        if($source === 'customers') {
            abort_if(Gate::denies('update-gx-customer'), 403);
        }

        if($source === 'users') {
            abort_if(Gate::denies('update-hgp-customer'), 403);
        }

        if($source === 'retailers') {
            abort_if(Gate::denies('update-retailer'), 403);
        }
    }

    public static function checkReadUserPermissions()
    {
        $source = request('source', 'users');

        if($source === 'admins') {
            abort_if(Gate::denies('view-admins'), 403);
        }

        if($source === 'customers') {
            abort_if(Gate::denies('view-gx-customers'), 403);
        }

        if($source === 'users') {
            abort_if(Gate::denies('view-hgp-customers'), 403);
        }

        if($source === 'retailers') {
            abort_if(Gate::denies('view-retailers'), 403);
        }
    }

    public static function resetPassword($email, string $type = 'reset')
    {
        $token = Str::random(32);

        $user = User::where('email', $email)->first();

        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'expired_at' => now()->addDay(),
            'type' => $type
        ]);

        $user->reset_token = $token;
        $provider = request('provider', Constant::HGP);
        if ($provider == Constant::HGP) {
            $settings   = getSiteSettings();
            $user->link = env('WEB_URL') . '/reset-password/' . $user->reset_token . "?type={$type}";
        } else {
            $user->link = env('WEB_URL_GX') . '/reset-password/' . $user->reset_token . "?type={$type}";
            $settings   = getGXSiteSettings();
        }

        Mail::to($email)->send(new ForgotPassword($user, $settings, $provider, $type));
    }

    public static function implode($glue, $array)
    {
        if((float)phpversion() >= 7.4) {
            return implode($glue, $array);
        } else {
            return implode($array, $glue);
        }
    }

    public static function getTagsValues($tags)
    {
        $tags = json_decode($tags);
        $tags = $tags ?? [];
        $tags = array_map(function($value) {
            return (array)$value;
        }, $tags);
        $tags = array_flatten($tags);

        return self::implode(',', $tags);
    }

    /**
     * @return bool
     */
    public static function isAdmin($admin = null)
    {
        if ( is_null($admin)) {

            return in_array(auth()->user()->role_id, Role::mainAdminRoles());
        }

        return in_array(@$admin->role_id, Role::mainAdminRoles());
    }

    public static function getAdmin()
    {
        return setting('admin.admin_email');
    }

    /**
     * @return bool
     */
    public static function isRetailer()
    {
        return auth()->user()->isRetailer();
    }

    /**
     * @return bool
     */
    public static function isGrowOperator()
    {
        return auth()->user()->isGrowOperator();
    }

    public static function assign_to($id) {
        $grow_log = GrowLog::select("assigned_to")->find($id);
        if (! is_null($grow_log)) {
            return $grow_log->assigned_to;
        }

        return false;
    }

    public static function getGrowOperator($userID)
    {
      $user = User::find($userID);

      if ($user) {
        return $user->assignee;
      }

      return null;
    }

    public static function sendNewTicketEmail(Ticket $ticket, TicketMessage $ticketMessage)
    {
      $operator = self::getGrowOperator($ticket->user_id);

      if ($operator) {
        Mail::to($operator)->send(new SendNewTicketNotifiction($ticket, $ticketMessage));
      }
    }

    public static function sendNewTicketMessageEmail(Ticket $ticket, TicketMessage $ticketMessage)
    {
      $operator = self::getGrowOperator($ticket->user_id);

      if ($operator) {
        Mail::to($operator)->send(new SendNewTicketMessageNotifiction($ticket, $ticketMessage));
      }
    }

    public static function sendTicketReplyEmail(Ticket $ticket, TicketMessage $ticketMessage)
    {
      Mail::to($ticket->user)->send(new SendReplyTicketMessageNotifiction($ticket, $ticketMessage));
    }

    /**
     * @param $base64
     * @param string $path
     * @return string
     */
    public static function createImageFromBase64($base64, $path = 'products')
    {
      $type = self::getTypeFromBase64($base64);
      $ext = self::resolveExtension($type);
      $image = $base64;
      $image = str_replace("data:${type};base64,", '', $image);
      $image = str_replace(' ', '+', $image);
      $imageName = Str::random(10).time().'.'.$ext;
      $imageName = "{$path}/{$imageName}";
      File::put(storage_path(). "/app/public/{$imageName}", base64_decode($image));

      return $imageName;
    }

    public static function resolveExtension($type)
    {
      $default = self::arrayIndex(explode('/', $type), 1, 'png');
      $mime = self::arrayIndex(Constant::Mimes, $type, Constant::Mimes['default']);
      return self::arrayIndex($mime, 'extension', $default);
    }

    public static function getTypeFromBase64($base64)
    {
      $pos  = strpos($base64, ';');
      return self::arrayIndex(explode(':', substr($base64, 0, $pos)), 1, 'image/png');
    }

    public static function ordinal($number) {
      $ends = array('th','st','nd','rd','th','th','th','th','th','th');
      if ((($number % 100) >= 11) && (($number%100) <= 13))
        return $number. 'th';
      else
        return $number. $ends[$number % 10];
    }

    public static function addNoneOptionToDropDown($values)
    {
        $nonOption = [
            'id' => '0',
            'text' => 'None'
        ];
        array_unshift($values, $nonOption);

        return $values;
    }

    public static function isActiveLog($log_id) {

        $log = GrowLog::active()->find($log_id);

        return !is_null($log);
    }

    public static function sendEmailToAdmin($provider) {
        if ($provider == Constant::HGP) {
            $email = setting('admin.admin_email');
        } else {
            $email = setting('gx.email');
        }
        if (! is_null($email)) {
            Mail::to($email)->send(new AdminEmail($provider));
        }
    }

    public static function registerGrowMasterInDailyCo($room) {
        $response = \Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.daily_api_token')
            ])
            ->post('https://api.daily.co/v1/rooms', [
                'name' => $room
            ]);

        return $response->body();

    }

    public static function removeGrowMasterInDailyCo($room) {
        $room = 'GrowMaster-' . $room;
        $response = \Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.daily_api_token')
        ])
            ->delete('https://api.daily.co/v1/rooms/' . $room);

        return $response->body();

    }
}
