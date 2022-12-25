<?php


namespace App\Traits;

use App\Gx\GrowLog;
use App\Models\UserSubscription;
use App\Utils\Api\ApiHelper;
use App\Utils\Api\ApiResponse;
use Illuminate\Http\Request;
use Modules\Support\Eloquent\Model;

Trait HasCrudActions
{

    private $month_expiry_days = 7;
    private $year_expiry_days = 30;
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = null;
        if ($request->has('isPaginate')) {
            $data["trackers"] =  $this->getModel()
                ->query()
                ->paginate();
        } else {
            $data["trackers"] = $this->getModel()->get();
        }

        $data["weeks"] = $this->getLogWeeks();
        $data["expected_weeks"] = $this->expectedDaysWeek();
        $data["expiry_subscriptions"] = $this->checkSubscriptionsExpiry();
        $data["hasSubscription"] = ApiHelper::hasSubscription();
        $obj = new ApiHelper();
        $data["activeLog"] = $obj->hasActiveLog();
        $data["message"] = __('generic.data');

        return ApiResponse::success($data);
    }
    

    /**
     * Get a new instance of the model.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function getModel()
    {
        return new $this->model;
    }

    /**
     * Get Grow logs weeks from its log detail
     * @return int
     */
    private function getLogWeeks() {

        $weeks = 0;
        $grow_logs_data = GrowLog::with("log_details")->where("user_id", auth()->id())->get()->pluck("log_details")->flatten();
        if (! empty($grow_logs_data)) {

            $grow_logs = collect($grow_logs_data);
           $logs = $grow_logs->sort();

           if (! is_null($logs->first()) && ! is_null($logs->last())) {
               $first_date = $logs->first()->toArray();
               $last_date = $logs->last()->toArray();
               $weeks = ApiHelper::weekBetweenDates($first_date["created_at"], $last_date["created_at"]);

           }/*end if*/

        }/*end if*/

        return $weeks;
    }

    /**
     * check user's subscription expiry days for month and years
     * @return array|object
     */
    private function checkSubscriptionsExpiry() {

        $is_expiry = [];
        $subscription_plan = UserSubscription::with('plan')->where("user_id", auth()->id())->first();

        if (! is_null($subscription_plan)) {
            $subscription = $subscription_plan->plan;

            $current_date = time();
            if (strtolower($subscription->frequency) == "month") {
                $month_date = date("d-m-Y", strtotime("+1 month", strtotime($subscription->created_date)));
                $date_diff = strtotime($month_date) - $current_date;

                $days = (int)round($date_diff / (60 * 60 * 24));
                if ($days <= $this->month_expiry_days) {
                    $is_expiry["type"] = strtolower($subscription->frequency);
                    $is_expiry["message"] = "Expired in {$days} days";
                }
            } else if (strtolower($subscription->frequency) == "year") {
                $year_date = date('d-m-Y', strtotime($subscription->created_date . " +1 year") );
                $date_diff = strtotime($year_date) - $current_date;

                $days = (int)round($date_diff / (60 * 60 * 24));
                if ($days <= $this->year_expiry_days) {
                    $is_expiry["type"] = strtolower($subscription->frequency);
                    $is_expiry["message"] = "Expired in {$days} days";
                }
            }

        }

        return !empty($is_expiry) ? $is_expiry : (object)null;
    }

    /**
     * Convert logs expected days into weeks
     * @return int
     */
    private function expectedDaysWeek() {
        $grow_log = GrowLog::where("user_id",auth()->id())->active()->first(["expected_days"]);
        return ApiHelper::growLogExpectedDaysWeek($grow_log);
    }

}
