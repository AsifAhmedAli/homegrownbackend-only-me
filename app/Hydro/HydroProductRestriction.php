<?php

namespace App\Hydro;

use App\Utils\Traits\CommonHydro;
use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Hydro\HydroProductRestriction
 *
 * @property int $id
 * @property int $hydro_product_id
 * @property int $product_recid
 * @property string|null $country
 * @property string|null $state
 * @property string|null $stateName
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductRestriction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductRestriction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductRestriction ofCart($cartID)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductRestriction ofProduct($productID)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductRestriction ofUser($userID)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductRestriction query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductRestriction whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductRestriction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductRestriction whereHydroProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductRestriction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductRestriction whereProductRecid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductRestriction whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductRestriction whereStateName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hydro\HydroProductRestriction whereUpdatedAt($value)
 * @property-read HydroProduct $product
 * @method static \Illuminate\Database\Eloquent\Builder|HydroProductRestriction active()
 * @method static \Illuminate\Database\Eloquent\Builder|HydroProductRestriction default()
 * @mixin \Eloquent
 */
class HydroProductRestriction extends Model
{
    use CommonRelations, CommonScopes, CommonHydro;
}
