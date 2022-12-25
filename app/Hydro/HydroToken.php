<?php

namespace App\Hydro;

use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\HydroToken
 *
 * @property int $id
 * @property string $env
 * @property string $access_token
 * @property string $expires_in
 * @property string $token_type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|\App\Hydro\HydroToken newModelQuery()
 * @method static Builder|\App\Hydro\HydroToken newQuery()
 * @method static Builder|\App\Hydro\HydroToken ofCart($cartID)
 * @method static Builder|\App\Hydro\HydroToken ofProduct($productID)
 * @method static Builder|\App\Hydro\HydroToken ofUser($userID)
 * @method static Builder|\App\Hydro\HydroToken query()
 * @method static Builder|\App\Hydro\HydroToken whereAccessToken($value)
 * @method static Builder|\App\Hydro\HydroToken whereCreatedAt($value)
 * @method static Builder|\App\Hydro\HydroToken whereExpiresIn($value)
 * @method static Builder|\App\Hydro\HydroToken whereId($value)
 * @method static Builder|\App\Hydro\HydroToken whereTokenType($value)
 * @method static Builder|\App\Hydro\HydroToken whereUpdatedAt($value)
 * @method static Builder|HydroToken active()
 * @method static Builder|HydroToken default()
 * @mixin \Eloquent
 */

class HydroToken extends Model
{
    use CommonRelations, CommonScopes;
  
  /**
   * @param string $env
   * @return Builder|Model|object|self
   */
    public static function current(string $env)
    {
      return static::where('env', $env)->latest('id')->first();
    }
}
