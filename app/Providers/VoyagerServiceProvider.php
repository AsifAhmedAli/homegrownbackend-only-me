<?php

namespace App\Providers;

use App\Actions\AssignCustomerToAction;
use App\Actions\AssignGrowLogToGrowOperatorAction;
use App\Actions\CustomersAction;
use App\Actions\FeedbackAction;
use App\Actions\GrowLogFeedbackAction;
use App\Actions\GrowLogDetailFeedbackAction;
use App\Actions\GrowLogDetailAction;
use App\Actions\ReplyToSupportTicket;
use App\Actions\ViewPlanSubscription;
use App\Actions\ViewPurchasedKitsAction;
use App\Actions\ViewPurchasedSubscriptionsAction;
use App\Menu;
use App\Models\Message;
use App\Observers\ChatMessageObserver;
use App\Observers\PaypalPlanObserver;
use App\Observers\UserObserver;
use App\PaypalPlan;
use App\User;
use App\Utils\Fields\AmountField;
use App\Utils\Fields\CouponTypeFormField;
use App\Utils\Fields\GrowLogImagesField;
use App\Utils\Fields\TagField;
use App\Utils\Fields\VideoField;
use Gate;
use Illuminate\Support\ServiceProvider;
use Voyager;

class VoyagerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::define('view-reports', function ($user) {
          return $user->hasPermission('view_reports');
        });
        Gate::define('view-admins', function ($user) {
          return $user->hasPermission('view_admins');
        });
        Gate::define('view-retailers', function ($user) {
          return $user->hasPermission('view_retailers');
        });
        Gate::define('view-hgp-customers', function ($user) {
          return $user->hasPermission('view_hgp_customers');
        });
        Gate::define('view-gx-customers', function ($user) {
          return $user->hasPermission('view_gx_customers');
        });
        Gate::define('create-admin', function ($user) {
          return $user->hasPermission('create_admin');
        });
        Gate::define('create-retailer', function ($user) {
          return $user->hasPermission('create_retailer');
        });
        Gate::define('create-hgp-customer', function ($user) {
          return $user->hasPermission('create_hgp_customer');
        });
        Gate::define('create-gx-customer', function ($user) {
          return $user->hasPermission('create_gx_customer');
        });
        Gate::define('update-admin', function ($user) {
          return $user->hasPermission('update_admin');
        });
        Gate::define('update-retailer', function ($user) {
          return $user->hasPermission('update_retailer');
        });
        Gate::define('update-hgp-customer', function ($user) {
          return $user->hasPermission('update_hgp_customer');
        });
        Gate::define('update-gx-customer', function ($user) {
          return $user->hasPermission('update_gx_customer');
        });
        Voyager::addAction(ViewPlanSubscription::class);
        Voyager::addAction(CustomersAction::class);
        Voyager::useModel('Menu', Menu::class);
        User::observe(UserObserver::class);
        Voyager::addFormField(TagField::class);
        Voyager::addFormField(VideoField::class);
        Voyager::addFormField(GrowLogImagesField::class);
        PaypalPlan::observe(PaypalPlanObserver::class);
//        Voyager::addAction(AssignGrowLogToGrowOperatorAction::class);
        Voyager::addAction(AssignCustomerToAction::class);
        Voyager::addAction(GrowLogFeedbackAction::class);
        Voyager::addAction(GrowLogDetailAction::class);
        Voyager::addAction(ViewPurchasedKitsAction::class);
        Voyager::addAction(ViewPurchasedSubscriptionsAction::class);
        Voyager::addAction(GrowLogDetailFeedbackAction::class);
//        Voyager::addAction(FeedbackAction::class);
        Voyager::addAction(ReplyToSupportTicket::class);
        Message::observe(ChatMessageObserver::class);


    }
}
