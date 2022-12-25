<?php

namespace App\Http\Controllers\Api;

use App\Gx\KitReview;
use App\Kit;
use App\Mail\PurchaseKitEmail;
use App\Models\KitComparison;
use App\Models\UserKit;
use App\Models\UserPurchasedKit;
use App\Repositories\Paypal\Subscription\PaypalPlanService;
use App\Utils\Api\ApiHelper;
use App\Utils\Api\ApiResponse;
use App\Utils\Constants\Constant;
use App\Utils\Constants\ValidationMessage;
use App\Utils\Constants\ValidationRule;
use App\Utils\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Mail;

class KitController extends ApiBaseController
{
  private $service;
  public function __construct(PaypalPlanService $planService)
  {
    parent::__construct();
    $this->service = $planService;
  }

  /** My Kits
     * @method index
     * return active user kits
     *
     * */

    public function index() {
        $result = Kit::with('reviews')->active()->where('size', '5x5')->get();
        if($result){
            foreach($result as $kit) {
                $kit->kit_features = explode(',',$kit->features ?? "");
                unset($kit->features);
            }
        }
        return ApiResponse::successResponse(__('generic.kit.detail'), $result);
    }


    /** My Kits
     * @method myKits
     * return active user purchased kits
     *
     * */
    public function myKits()
    {
      $res = UserPurchasedKit::with('kit')
                    ->whereUserId(Auth::id())
                    ->distinct()
//                    ->status(Common::STATUS_COLUMN, 1)
                    ->get(['kit_id']);

      if (!$res)
          return ApiResponse::errorResponse(__('generic.kit.not_exist'));

      return ApiResponse::successResponse(__('generic.kit.detail'), $res);

    }

    public function purchase(Request $request, $kitID)
    {
      $rules = ValidationRule::kitBillingShipping();
      $messages = ValidationMessage::messages(ValidationMessage::CartBillingShipping());

      try {
        $this->validate($request, $rules, $messages);
      } catch (ValidationException $e) {
        $response['message'] = Helper::resolveValidationError($e->errors());
        return ApiResponse::failure($response, 420);
      }
//      $verify = $this->service->verifySubscription($request->get('transactionID'));
//      if($verify && $verify->status === 'COMPLETED') {
      if(true) {
        $kit = Kit::findOrFail($kitID);
        $userKit                          = new UserKit;
        $userKit->kit_id                  = $kit->id;
        $userKit->kit_name                = $kit->name;
        $userKit->paid_status             = 1; /*added new column*/
        $userKit->kit_description         = $kit->description;
        $userKit->kit_price               = $kit->price;
        $userKit->kit_features            = $kit->features;
        $userKit->kit_size                = $kit->size;
        $userKit->user_id                 = $this->getUserID();
        $userKit->billing_street_address  = $request->get('billingStreetAddress');
        $userKit->billing_city            = $request->get('billingCity');
        $userKit->billing_state           = $request->get('billingState');
        $userKit->billing_zip_code        = $request->get('billingZip');
        $userKit->billing_email           = $request->get('billingEmail');
        $userKit->billing_phone           = $request->get('billingPhone');
        $userKit->is_different_billing = $request->get('isDifferentBilling', false);
        $userKit->shipping_street_address = Helper::getValue($request->get('shippingStreetAddress'), $userKit->billing_street_address);
        $userKit->shipping_city           = Helper::getValue($request->get('shippingCity'), $userKit->billing_city);
        $userKit->shipping_state          = Helper::getValue($request->get('shippingState'), $userKit->billing_state);
        $userKit->shipping_zip_code = Helper::getValue($request->get('shippingZip'), $userKit->billing_zip_code);
        $userKit->shipping_email = Helper::getValue($request->get('shippingEmail'), $userKit->billing_email);
        $userKit->shipping_phone = Helper::getValue($request->get('shippingPhone'), $userKit->billing_phone);
        $userKit->status = 0;
        $userKit->transaction_id = $request->get('transactionID');
        $userKit->save();

        ApiHelper::addUserPurchasedKits($userKit->kit_id, $userKit->user_id);

        \Log::info("Kit purchase email debug: ".json_encode($userKit->user));
        Mail::to($userKit->user)->send(new PurchaseKitEmail($kit, $userKit->user->first_name));
        Helper::sendEmailToAdmin(Constant::GX); /*admin email*/

        $response['message']     = 'Kit purchased Successfully';
        $response['orderNumber'] = $userKit->transaction_id ? $userKit->transaction_id : null;
        return ApiResponse::success($response);
      } else {
        return ApiResponse::failure('Invalid Transaction');
      }
    }

    public function detail($id) {

        $kit_detail = Kit::with("reviews", "products")->active()->find($id);
        if (! is_null($kit_detail)) {
            $kit_detail->kit_features = explode(',',$kit_detail->features ?? "");
            unset($kit_detail->features);
            return ApiResponse::successResponse(__('generic.kit.detail'), $kit_detail);
        }

        return ApiResponse::errorResponse(__('generic.error'), null,404);
    }

    public function getKitSize($name, $size) {

        $kit_detail = Kit::with("reviews", "products")->where(['size' => $size, 'name' => $name])->active()->first();
        if (! is_null($kit_detail)) {
            $kit_detail->kit_features = explode(',',$kit_detail->features ?? "");
            unset($kit_detail->features);
            return ApiResponse::successResponse(__('generic.kit.detail'), $kit_detail);
        }

        return ApiResponse::errorResponse('Kit does not exist.', null, 200);
    }

    public function addReview(Request $request) {

        $response = [];
        $rules = ValidationRule::kitReview();

        $messages = ValidationMessage::kitReview();

        try {
            $this->validate($request, $rules, $messages);
        } catch (ValidationException $e) {
            return ApiResponse::validation($e->errors());
        }

        $image = NULL;
        if($request->has('image') && $request->filled('image')){
            $image = ApiHelper::uploadBase64Image($request->image, 'reviews');
        }

        $kit_review = new KitReview();
        $kit_review->kit_id = $request->kit_id;
        $kit_review->reviewer_name = auth()->user()->name ?? "";
        $kit_review->rating = $request->rating;
        $kit_review->comment = $request->comment;
        $kit_review->image = $image;

        $save = $kit_review->save();
        $response["review"] = $kit_review;
        $response["message"] = __('generic.success');
        if ($save) {

            return ApiResponse::success($response);
        }

        return ApiResponse::failure(__('generic.error'));
    }

    public function getKitProducts($cart_id, $kit_id) {
        $response['products'] = DB::table('cart_kit_products')->where([
            'cart_id' => $cart_id,
            'kit_id' => $kit_id,
        ])->get();

        return ApiResponse::success($response);
    }

    public function compare() {
        $response['compare'] = KitComparison::first();
        return ApiResponse::success($response);
    }
}
