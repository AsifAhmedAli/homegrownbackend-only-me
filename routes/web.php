<?php

use App\Http\Controllers\Voyager\VoyagerGrowLogController;
use App\Http\Controllers\Voyager\VoyagerGrowLogDetailController;
use App\Http\Controllers\Voyager\VoyagerTicketController;
use App\Http\Controllers\Voyager\VoyagerUserController;
use App\Http\Controllers\Voyager\VoyagerUserKitController;
use App\Http\Controllers\Voyager\VoyagerUserSubscriptionController;
use App\Http\Controllers\Voyager\VoyagerGrowLogDetailFeedbackController;
use App\Utils\Helpers\Helper;
use UniSharp\LaravelFilemanager\Lfm;
use App\Http\Controllers\DashboardController;

Route::get('testing', function () {
    Artisan::call('tickets:close');
});
// Route::get('/storage-link', function () {
    // $target_folder = storage_path('app/public');  
    // $link_folder = env('APP_URL').'storage';
    // symlink($target_folder, $link_folder);
// });

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/login');
Route::redirect('/login', '/admin/login');

/*lfm routes*/
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    Lfm::routes();
});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
    Route::get('/', function () {
        if (auth()->check()) {
            if (!auth()->user()->hasPermission('browse_admin')) {
                session()->flash('error', 'You are not authorized to access the dashboard');
                auth()->logout();
                return redirect()->away(Helper::url('/'));
            } else {
                //return Voyager::view('voyager::index');
                return (new DashboardController)->reports();
            }
        }
        return redirect('/login');
    })->name('voyager.dashboard');
    Route::post('login', ['uses' => 'Auth\LoginController@postLogin', 'as' => 'postlogin']);
    Route::name('admin.')->namespace('Voyager')->group(function () {
        Route::get('my-kits/{user_id}', [VoyagerUserKitController::class, 'index'])->name('user-kits');
        Route::get('my-subscriptions/{user_id}', [VoyagerUserSubscriptionController::class, 'index'])->name('user-subscriptions');
        Route::get('admins', 'VoyagerUserController@index')->name('users')->middleware('can:view-admins');
        Route::get('customers', 'VoyagerUserController@index')->name('users.customers');
        Route::get('retailers', 'VoyagerUserController@index')->name('users.retailers')->middleware('can:view-retailers');
        Route::get('reports', 'VoyagerReportsController@index')->name('reports')->middleware('can:view-reports');
        Route::get('plans/{id}/subscriptions', 'VoyagerPlanSubscriptionController@planSubscriptions')->name('plan.subscription');
        Route::get('subscription/{id}/cancel', 'VoyagerPlanSubscriptionController@cancel')->name('subscription.cancel');
        Route::get('grow-log/{growLog}/assign', [VoyagerGrowLogController::class, 'assign'])->name('grow-log.assign');
        Route::post('grow-log/{growLog}/assign', [VoyagerGrowLogController::class, 'postAssign'])->name('grow-log.post.assign');

        Route::get('grow-log/{growLog}/feedback', [VoyagerGrowLogController::class, 'giveFeedback'])->name('grow-log.feedback');

        Route::get('grow-log-detail/{growLogDetail}/feedback', [VoyagerGrowLogDetailController::class, 'giveFeedback'])->name('grow-log-detail.feedback');
        Route::post('grow-log-detail/{growLogDetail}/feedback', [VoyagerGrowLogDetailController::class, 'postFeedback'])->name('grow-log-detail.post.feedback');

        Route::get('/logs/grow-log-details', [VoyagerGrowLogDetailController::class, 'index'])->name('grow-log-details.logs');

        Route::get('view/grow-log-feedback', [VoyagerGrowLogDetailFeedbackController::class, 'index'])->name('grow-log-feedback.view');

        Route::post('grow-log/{growLog}/feedback', [VoyagerGrowLogController::class, 'postFeedback'])->name('grow-log.post.feedback');
        Route::get('user/search/grow-operator', [VoyagerUserController::class, 'searchGrowOperator'])->name('user.grow-operator.search');
        Route::get('user/{user}/assign', [VoyagerUserController::class, 'assign'])->name('user.assign');
        Route::post('user/{user}/assign', [VoyagerUserController::class, 'postAssign'])->name('user.post.assign');
        Route::get('ticket/{ticket}/reply', [VoyagerTicketController::class, 'reply'])->name('ticket.reply');

    });

    Route::post('media/remove', 'MediaController@remove')->name('media.remove');
    Route::prefix('ajax')->name('ajax.')->group(function () {
        Route::get('attributes/get', 'HelperController@getAttributes')->name('attributes');
        Route::get('values/get', 'HelperController@getAttributeValues')->name('attributes.values');
    });
    /*admin change password routes*/
    /*show change password form*/
    Route::get('change_password', 'UserController@changeAdminPassword')->name('change_password');

    /*update change password route*/
    Route::post('change_password', 'UserController@changeAdminPassword')->name('change_password');

    /*forgot password*/
    // forgot password
    Route::get('forgot_password', 'UserController@forgot_password')->name('forgot_password');
    Route::post('forgot_password', 'UserController@forgot_password')->name('forgot_password');

    Route::group(['prefix' => 'chat'], function() {
        $chatController = \App\Http\Controllers\Voyager\VoyagerChatController::class;
        Route::get('messages/{chat_id}/get', [$chatController, 'all']);
        Route::post('message/{chat_id}/add', [$chatController, 'sendMessage']);
        Route::get('message/{chat_id}/read-messages', [$chatController, 'readMessage']);
        Route::get('notifications/get', [$chatController, 'getNotifications']);
    });
});

/*show reset password view */
Route::get('password/reset/{token}', 'UserController@showResetForm')->name('reset_password');

/*update reset password request*/
Route::post('password/reset', 'UserController@reset_password')->name('reset_password');

//  Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
