<?php

namespace App;

use App\Utils\Constants\Constant;
use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use App\Utils\Traits\Search;
use Illuminate\Database\Eloquent\Model;

/**
 * App\AddressBook
 *
 * @property int $id
 * @property string $nickname
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $street
 * @property string|null $country
 * @property string $city
 * @property string $state
 * @property string $phone_no
 * @property string $postal_code
 * @property int|null $is_same_shipping
 * @property int $default
 * @property int $user_id
 * @property int $default_billing
 * @property int $default_shipping
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|AddressBook active()
 * @method static \Illuminate\Database\Eloquent\Builder|AddressBook default()
 * @method static \Illuminate\Database\Eloquent\Builder|AddressBook myAddresses()
 * @method static \Illuminate\Database\Eloquent\Builder|AddressBook newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AddressBook newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AddressBook ofCart($cartID)
 * @method static \Illuminate\Database\Eloquent\Builder|AddressBook ofProduct($productID)
 * @method static \Illuminate\Database\Eloquent\Builder|AddressBook ofUser($userID)
 * @method static \Illuminate\Database\Eloquent\Builder|AddressBook query()
 * @method static \Illuminate\Database\Eloquent\Builder|AddressBook whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AddressBook whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AddressBook whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AddressBook whereDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AddressBook whereDefaultBilling($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AddressBook whereDefaultShipping($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AddressBook whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AddressBook whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AddressBook whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AddressBook whereIsSameShipping($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AddressBook whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AddressBook whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AddressBook wherePhoneNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AddressBook wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AddressBook whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AddressBook whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AddressBook whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AddressBook whereUserId($value)
 * @mixin \Eloquent
 */
class AddressBook extends Model
{
    use CommonRelations, CommonScopes, Search;

    protected $fillable = ['provider','nickname', 'first_name', 'last_name', 'email', 'street', 'country', 'city', 'state', 'phone_no', 'postal_code', 'is_same_shipping', 'default', 'user_id', 'default_billing', 'default_shipping'];

    public function scopeMyAddresses($query)
    {
        $query->whereUserId(\Auth::user()->id);
    }
    
    public function scopeOfProject($query, $provider)
    {
        $query->whereProvider($provider);
    }

    public static function store($request, $userId)
    {
      
        return AddressBook::create([
          'provider'           => request('provider', 'hgp'),
          'nickname'           => $request->nickname,
          'first_name'         => $request->first_name,
          'last_name'          => $request->last_name,
          'email'              => $request->email,
          'street'             => $request->street,
          'country'            => $request->country,
          'city'               => $request->city,
          'state'              => $request->state,
          'phone_no'           => $request->phone_no,
          'postal_code'        => $request->postal_code,
          'is_same_shipping'   => $request->is_same_shipping ? 1 : 0,
          'default'            => $request->default ? 1 : 0,
            'user_id' => $userId,
            'default_billing' => $request->default_billing ? 1 : 0,
            'default_shipping' => $request->default_shipping ? 1 : 0
        ]);

    }

    public static function updatedAddressBook($request, $id)
    {
        $address = AddressBook::find($id);
        if ($request->has('nickname') && !empty($request->nickname)) {
            $address->nickname = $request->nickname;
        }
        if ($request->has('first_name') && !empty($request->first_name)) {
            $address->first_name = $request->first_name;
        }

        if ($request->has('last_name') && !empty($request->last_name)) {
            $address->last_name = $request->last_name;
        }

        if ($request->has('email') && !empty($request->email)) {
            $address->email = $request->email;
        }

        if ($request->has('country') && !empty($request->country)) {
            $address->country = $request->country;
        }

        if ($request->has('city') && !empty($request->city)) {
            $address->city = $request->city;
        }

        if ($request->has('state') && !empty($request->state)) {
            $address->state = $request->state;
        }
        if ($request->has('phone_no') && !empty($request->phone_no)) {
            $address->phone_no = $request->phone_no;
        }
        if ($request->has('postal_code') && !empty($request->postal_code)) {
            $address->postal_code = $request->postal_code;
        }

        if ($request->has('street') && !empty($request->street)) {
            $address->street = $request->street;
        }

        if ($request->has('default') && !empty($request->default)) {
            $address->default = $request->default;
        }
        
        return $address->save();

    }
    public static function markAddressDefault($request)
    {
        $value = $request->value;
        $id = $request->id;
        /*if checkbox is checked*/
        if ($value){
          AddressBook::where([
            ['user_id', '=',\Auth::user()->id],
            ['provider', '=', $request->provider]])->update([
            'default'=> 0
          ]);
          
        }
        return  AddressBook::whereId($id)->update([
        'default'=> $value
      ]);
      

    }
}
