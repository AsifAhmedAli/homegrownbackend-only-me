<?php


namespace App\Repositories\UserSubscriptions;


use App\Mail\GX\SubscriptionConfirmationToAdmin;
use App\Mail\GX\UserSubscriptionMail;
use App\Models\UserKit;
use App\Models\UserSubscription;
use App\PaypalPlan;
use App\Repositories\Paypal\Subscription\PaypalPlanService;
use App\User;
use App\Utils\Constants\Common;
use Illuminate\Support\Facades\Auth;

class UserSubscriptionRepository
{
  protected $model;
  /**
   * @var User
   */
  private $user;
  private $subscriptionName;
  
  public function __construct(UserSubscription $model, PaypalPlanService $paypalPlanService)
  {
    $this->model             = $model;
    $this->paypalPlanService = $paypalPlanService;


  }

  /**
   * @param $request
   * @return UserSubscription|null
   */
  public function subscribe($request)
  {
    $this->setUser(Auth::user());
    $transaction_id = $request->input('transaction_id', NULL);
//    $transaction    = $this->paypalPlanService->verifySubscription($transaction_id);
//    if ($transaction && $transaction->status == Paypal::COMPLETED_STATUS)

      $plan = PaypalPlan::find($request->paypal_plan_id);
      if (! is_null($plan)) {
         $price = $plan->amount;
         $name = $plan->name;
      } else {
          $price = "";
          $name = "";
      }
          $response = $this->model->create([
            'user_id'        => $this->getUserId(),
            'paypal_plan_id' => $request->paypal_plan_id,
            'status'         => $request->input('status', 'new'),
            'name'           => $name,
            'price'          => $price,
            'transaction_id' => $transaction_id,
            'paypal_order_id' => request('order_id'),
            'renewed_from'   => $request->input('renewed_from', NULL),
          ]);
          $this->subscriptionName = $name;
          $this->subscriptionConfirmation();
    return $response;
  }

  protected function setUser(User $user)
  {
    $this->user = $user;
  }

  protected function getUser()
  {
    return $this->user;
  }

  protected function getUserId(){
    return $this->user->id;
  }
  protected function getUserFullName() {
    return ucwords($this->user->first_name .' '.$this->user->last_name);
  }

  private function subscriptionConfirmation()
  {
//    $this->subscriptionConfirmationToUser();
    $this->subscriptionConfirmationToAdmin();
  }

  private function getKitName()
  {
    $kitUser = UserKit::select('kit_id')->with([
      'kit' => function ($q) {
        $q->select('id', 'name');
      }
    ])->whereUserId($this->getUserId())->status(Common::STATUS_COLUMN, true)->first();
    if (isset($kitUser->kit) && !empty($kitUser->kit)) {
      return $kitUser->kit->name;
    } else {
      return '';
    }
  }

  private function subscriptionConfirmationToUser()
  {
    \Mail::to($this->user->email)->send(new UserSubscriptionMail($this->getUserFullName(), $this->getKitName()));
  }

  private function subscriptionConfirmationToAdmin()
  {
    \Mail::to(setting('gx.email'))->send(new SubscriptionConfirmationToAdmin($this->getUserFullName(), $this->subscriptionName));
  }

  public function hasSubscribed()
  {
    return $this->model->whereUserId(Auth::id())->where('status', '<>', 'expired')->exists();
  }
}
