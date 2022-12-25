<?php

namespace App;

use App\Models\UserKit;
use App\Models\UserSubscription;
use App\Scopes\ByMeScope;
use App\Utils\Constants\Constant;
use App\Utils\Helpers\Helper;
use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Cashier\Billable;

/**
 * App\User
 *
 * @method static self find(int $int)
 * @method static $this customers()
 * @method static self[] get()
 * @method static $this nonStripe()
 * @property int $id
 * @property int|null $role_id
 * @property string $name
 * @property string $email
 * @property string $status
 * @property string|null $avatar
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property string|null $settings
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property string|null $stripe_id
 * @property string|null $card_brand
 * @property string|null $card_last_four
 * @property Carbon|null $trial_ends_at
 * @property Carbon|null $added_to_mailchimp_at
 * @property mixed $locale
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \TCG\Voyager\Models\Role|null $role
 * @property-read \Illuminate\Database\Eloquent\Collection|\TCG\Voyager\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Cashier\Subscription[] $subscriptions
 * @property-read int|null $subscriptions_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User stripe()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCardBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCardLastFour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSettings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereStripeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereTrialEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $phone_number
 * @method static Builder|User wherePhoneNumber($value)
 * @property string $first_name
 * @property string $last_name
 * @property string|null $city
 * @property string|null $street_address_1
 * @property string|null $zip_code
 * @property string|null $state
 * @method static Builder|User whereAddedToMailchimpAt($value)
 * @method static Builder|User whereCity($value)
 * @method static Builder|User whereCompanyName($value)
 * @method static Builder|User whereFirstName($value)
 * @method static Builder|User whereLastName($value)
 * @method static Builder|User whereState($value)
 * @method static Builder|User whereStreetAddress1($value)
 * @method static Builder|User whereZipCode($value)
 */


class User extends \TCG\Voyager\Models\User
{
    use Notifiable;
    use Billable;
    use CommonScopes;
    use CommonRelations;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Statuses.
     */
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const ADMIN_ID = 2;

    /**
     * List of statuses.
     *
     * @var array
     */
    public static $statuses = [self::STATUS_ACTIVE, self::STATUS_INACTIVE];
    public function getNameAttribute()
    {
      return $this->attributes['first_name'] . ' ' . $this->attributes['last_name'];
    }

    public function getCustomerCountAttribute()
    {
       return $this->children()->count();
    }

    public function creator()
    {
        return $this->belongsTo(self::class, 'created_by');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'created_by');
    }

    /*save user */
    public static function saveUser($request)
    {
        $user = new User();
        $user->name = $request->first_name . ' ' . $request->last_name;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        return $user->save();
    }

    /*edit user */

    public static function updateUser($request, $id)
    {
        $user = User::find($id);
        $user->name = $request->first_name . ' ' . $request->last_name;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->state = $request->state;
        $user->street_address_1 = $request->street_address_1;
        $user->phone_number = $request->phone_number;
        $user->zip_code = $request->zip_code;
        $user->city = $request->city;
      //  $user->email = $request->email;
    //    $user->password = bcrypt($request->password);
        return $user->save();
    }

    /**
     * Scope a query to only include active pages.
     *
     * @param  $query  \Illuminate\Database\Eloquent\Builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', static::STATUS_ACTIVE);
    }

    /**
     * @param Builder $builder
     */
    public function scopeCustomers(Builder $builder)
    {

    }

    public function scopeNonStripe(Builder $builder)
    {
        $builder->whereNull('stripe_id');
    }

    public function scopeStripe(Builder $builder)
    {
        $builder->whereNotNull('stripe_id');
    }


    public static function updateProfile($request, $userId){
        return User::whereId($userId)
            ->update([
                'first_name'=> $request->first_name,
                'last_name' => $request->last_name,
                'phone_number' => $request->phone_number ?? NULL,
                'state' => $request->state,
                'city' => $request->city ?? NULL,
                'street_address_1' => $request->street_address_1 ?? NULL,
                'zip_code' => $request->zip_code ?? NULL,
                'avatar'    => $request->avatar
            ]);
    }

    public function scopeAdmin(Builder $builder)
    {
      $builder->where('role_id', Role::ADMIN_ROLE);
    }

    public function scopeAdmins(Builder $builder)
    {
      $builder->whereIn('role_id', Role::adminRoles());
    }

    public function scopeCustomer(Builder $builder)
    {
      $builder->where('role_id', Role::NORMAL_USER_ROLE);
    }

    public function scopeGxCustomer(Builder $builder)
    {
      $builder->customer()->gx();
    }

    public function scopeHgpCustomer(Builder $builder)
    {
      $builder->customer()->hgp();
    }

    public function scopeRetailer(Builder $builder)
    {
      $builder->where('role_id', Role::RETAILER_ROLE)->gx();
    }

    public function scopeGrowMasters(Builder $builder)
    {
        $builder->where('role_id', Role::GROW_MASTER_ROLE);
    }

    public function scopeDeveloper(Builder $builder, bool $include = true)
    {
      $operator = $include ? '=' : '!=';
      $builder->where('role_id', $operator, Role::DEVELOPER_ROLE);
    }

    public function isDeveloper()
    {
      return $this->role_id == Role::DEVELOPER_ROLE;
    }

    public function isAdmin()
    {
      return $this->role_id == Role::ADMIN_ROLE;
      //      return in_array($this->role_id, Role::getAdminRoles());
    }

    public function isRetailer()
    {
      return $this->role_id == Role::RETAILER_ROLE;
    }

    public function getIsAdminAttribute()
    {
        return $this->isAdmin();
    }

    public function getIsDeveloperAttribute()
    {
      return $this->isDeveloper();
    }

    public function scopeGrowMaster(Builder $builder)
    {
      $builder->whereIn('role_id', Role::growOperators());
    }

    public function isGrowOperator()
    {
      return in_array($this->role_id, Role::growOperators());
    }

    public function scopeByMe(Builder $builder, $id = null)
    {
      if(Helper::isRetailer()) {
        $builder->whereCreatedBy(auth()->id());
      } else {
        if(Helper::isGrowOperator()) {
          $builder->toMe();
        } elseif($id) {
          $builder->whereCreatedBy($id);
        }
      }
    }

    public function kits()
    {
      return $this->hasMany(UserKit::class);
    }

    public function subscriptions()
    {
      return $this->hasMany(UserSubscription::class);
    }

    public function user_state()
    {
        return $this->belongsTo(State::class,'state','iso2');
    }

    public function order()
    {
        return $this->hasOne(Order::class, 'customer_id')
                    ->where('status', '<>', 'pending')
                    ->where('status', '<>', 'cancelled');
    }

    public function assigned() {
        return $this->belongsTo(self::class, 'assigned_to');
    }
}
