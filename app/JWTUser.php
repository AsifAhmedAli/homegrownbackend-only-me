<?php

namespace App;

use App\Mail\Registration;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\JWTUser
 *
 * @property int $id
 * @property int|null $role_id
 * @property string $name
 * @property string $email
 * @property string $status
 * @property string|null $avatar
 * @property string|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property string|null $settings
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property string|null $stripe_id
 * @property string|null $card_brand
 * @property string|null $card_last_four
 * @property string|null $trial_ends_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\JWTUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\JWTUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\JWTUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\JWTUser whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\JWTUser whereCardBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\JWTUser whereCardLastFour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\JWTUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\JWTUser whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\JWTUser whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\JWTUser whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\JWTUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\JWTUser whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\JWTUser wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\JWTUser whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\JWTUser whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\JWTUser whereSettings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\JWTUser whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\JWTUser whereStripeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\JWTUser whereTrialEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\JWTUser whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $phone_number
 * @method static \Illuminate\Database\Eloquent\Builder|JWTUser wherePhoneNumber($value)
 * @property string $first_name
 * @property string $last_name
 * @property string|null $added_to_mailchimp_at
 * @property string|null $city
 * @property string|null $street_address_1
 * @property string|null $zip_code
 * @property string|null $state
 * @method static \Illuminate\Database\Eloquent\Builder|JWTUser whereAddedToMailchimpAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JWTUser whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JWTUser whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JWTUser whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JWTUser whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JWTUser whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JWTUser whereStreetAddress1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JWTUser whereZipCode($value)
 */
class JWTUser extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $perPage = 10;

    protected $table = 'users';

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            'id' => $this->id
        ];
    }
}
