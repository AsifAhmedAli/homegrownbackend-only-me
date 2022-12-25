<?php

namespace App\Http\Controllers;

use App\Gx\GrowLog;
use App\Kit;
use App\Models\UserKit;
use App\Models\UserSubscription;
use App\Order;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function reports() {

        $data = [];
        $data["kits"]                   =   $this->getKitsTotal();
        $data["harvests"]               =   $this->getHarvested();
        $data["retailers"]              =   $this->getTotalRetailers();
        $data["customers_having_orders"]    =   $this->getCustomersHavingOrders();
        $data["customers"]              =   $this->getCustomers();
        $data["kits_gross"]             =   $this->getKitsGross();
        $data["gross_revenue"]          =   $this->getGrossRevenue();
        $data["grow_masters"]           =   $this->getGrowMasters();
        $data["subscriptions"]          =   $this->getSubscriptions();
        $data["subscriptions_gross"]    =   $this->getSubscriptionsGross();
        $data['yearly']                 = $this->getSubscriptionCountByName('Yearly');
        $data['monthly']                 = $this->getSubscriptionCountByName('Monthly');

//        return $data;
        return \Voyager::view('voyager::index', $data);
    }

    private function getKitsTotal() {

        $kits = Kit::with(["user_kits" => function($query) {
            $query->filterByDate()->select([
                'kit_id', DB::raw('sum(kit_price) AS total')
            ])->where("paid_status",1)->groupBy('kit_id');
        }])->active();

        $kits = $kits->get();

        $kitReport = $kits->map(function ($kit) {
           $kit_report = new \stdClass();
           $kit_report->name = $kit->name ?? "";
           $user_kits = $kit->user_kits->first();
           if (! is_null($user_kits)) {
               $kit_report->total = $user_kits->toArray()["total"] ?? 0;
           } else {
               $kit_report->total = 0;
           }
           return $kit_report;
        });

        return $kitReport;
    }

    private function getSubscriptions() {

        $user_subscriptions = UserSubscription::with('plan:id,frequency')
            ->filterByDate()
            ->get(['paypal_plan_id','price'])
            ->groupBy('plan.frequency');

        $user_subscriptions = $user_subscriptions->map(function ($subscription, $key) {
            return $subscription->sum('price');
        });

       return $user_subscriptions;
    }

    private function getSubscriptionCountByName($subscriptions)
    {
        $subscriptions = UserSubscription::filterByDate()->whereName($subscriptions)->count();
        return $subscriptions;
    }

    private function getKitsGross() {

        $user_kits = UserKit::where("paid_status", 1)->filterByDate()->sum('kit_price');

        if ($user_kits) {
            return $user_kits;
        }
        return 0;
    }


    private function getGrossRevenue() {

        $user_kits = UserKit::where("paid_status", 1)->filterByDate()->sum('kit_price');
        $orders = Order::whereStatus('completed')->filterByDate()->sum('total');
        $total = $user_kits + $orders;

        return $total;
    }

    private function getSubscriptionsGross() {

        $user_subscriptions = UserSubscription::where("paid_status",1)->filterByDate()->sum('price');

        if ($user_subscriptions) {
            return $user_subscriptions;
        }
        return 0;
    }

    private function getTotalRetailers() {

        return User::retailer()->filterByDate()->count();


    }

    private function getGrowMasters() {

        return User::growMaster()->filterByDate()->count();

    }

    private function getHarvested() {

        return GrowLog::filterByDate()->status('status', 1)->count();

    }

    private function getCustomers() {

        $customers = User::with("user_state")
            ->whereDoesntHave('order')
            ->customer()
            ->filterByDate()
            ->select('state', DB::raw('count(id) as total'))
            ->groupBy('state')
            ->get()->pluck('total','user_state.name');

        return $customers;
    }

    private function getCustomersHavingOrders() {

        $customers = User::with("user_state")
            ->whereHas('order')
            ->filterByDate()
            ->select('state', DB::raw('count(id) as total'))
            ->groupBy('state')
            ->get()->pluck('total','user_state.name');

        return $customers;
    }

}
